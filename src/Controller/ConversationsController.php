<?php
namespace App\Controller;

use App\Event\Notifications;
use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;

class ConversationsController extends AppController
{

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
    }

    /**
     * BeforeFilter handle.
     *
     * @param Event $event The beforeFilter event that was fired.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->deny();

        if (Configure::read('Conversations.enabled') === false && $this->request->action != 'maintenance') {
            $this->redirect(['action' => 'maintenance']);
        } elseif (Configure::read('Conversations.enabled') === true && $this->request->action == 'maintenance') {
            $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Display all conversations for the user.
     *
     * @return void
     */
    public function index()
    {
        $this->ConversationsUsers = $this->loadModel('ConversationsUsers');

        $this->paginate = [
            'maxLimit' => Configure::read('Conversations.conversations_per_page')
        ];
        $conversations = $this->ConversationsUsers
            ->find()
            ->contain([
                'Users',
                'Conversations',
                'Conversations.Users' => function ($q) {
                    return $q->find('medium');
                },
                'Conversations.LastMessage',
                'Conversations.LastMessageUser'
            ])
            ->where([
                'ConversationsUsers.user_id' => $this->Auth->user('id'),
                'Conversations.conversation_open <>' => 2
            ])
            ->order([
                'ConversationsUsers.is_read' => 'ASC',
                'ConversationsUsers.is_star' => 'DESC',
                'Conversations.last_message_date' => 'DESC',
            ]);

        $conversations = $this->paginate($conversations);

        $this->set(compact('conversations'));
    }

    /**
     * Function to do an action when a user select a/many conversations.
     *
     * Action list :
     *      star : Conversations Important
     *      normal : Make normal conversation
     *      exit : Exit conversations
     *
     * @return void
     *
     * @throws NotFoundException
     */
    public function action()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $actionAllowed = ['star', 'normal', 'exit'];

        if (!array_key_exists('action', $this->request->getParsedBody()) || !in_array($this->request->getData('action'), $actionAllowed)) {
            $json = [];
            $json['error'] = '1';
            $json['message'] = __d('conversations', 'Action unknown.');

            $this->set(compact('json'));
            $this->set('_serialize', 'json');

            return;
        }

        if (!array_key_exists('conversations', $this->request->getParsedBody())) {
            $json = [];
            $json['error'] = '1';
            $json['message'] = __d('conversations', 'You have not chosen any conversations.');

            $this->set(compact('json'));
            $this->set('_serialize', 'json');

            return;
        }

        $this->loadModel('ConversationsUsers');

        $action = $this->request->getData('action');
        $array = $this->request->getData('conversations');

        switch ($action) {
            case "star":
                foreach ($array as $conversationId) {
                    $this->ConversationsUsers->updateAll(
                        ['is_star' => 1],
                        [
                            'conversation_id' => $conversationId,
                            'user_id' => $this->Auth->user('id')
                        ]
                    );
                }

                $json['message'] = __d('conversations', 'Your conversation(s) has been Stared.');
                $json['error'] = '0';
                $json['redirect'] = Router::url(['action' => 'index']);

                $this->set(compact('json'));

                break;

            case "normal":
                foreach ($array as $conversationId) {
                    $this->ConversationsUsers->updateAll(
                        ['is_star' => 0],
                        [
                            'conversation_id' => $conversationId,
                            'user_id' => $this->Auth->user('id')
                        ]
                    );
                }

                $json['message'] = __d('conversations', 'Your conversation(s) has been set normal.');
                $json['error'] = '0';
                $json['redirect'] = Router::url(['action' => 'index']);

                $this->set(compact('json'));
                break;

            case "exit":
                foreach ($array as $conversationId) {
                    $user = $this->ConversationsUsers
                        ->find()
                        ->contain([
                            'Conversations'
                        ])
                        ->where([
                            'ConversationsUsers.user_id' => $this->Auth->user('id'),
                            'ConversationsUsers.conversation_id' => $conversationId
                        ])
                        ->first();

                    //Check if the user is the owner of the conversation.
                    if ($user->conversation->user_id == $this->Auth->user('id')) {
                        $conversation = $this->Conversations->get($conversationId);
                        $conversation->conversation_open = 2;
                        $this->Conversations->save($conversation);
                    } else {
                        $this->ConversationsUsers->delete($user);

                        $conversation = $this->Conversations->get($conversationId);
                        $conversation->recipient_count = $user->conversation->recipient_count - 1;
                        $this->Conversations->save($conversation);
                    }
                }

                $json['message'] = __d('conversations', 'You have left your conversation(s) successfully.');
                $json['error'] = '0';
                $json['redirect'] = Router::url(['action' => 'index']);

                $this->set(compact('json'));
                break;
        }

        $this->set('_serialize', 'json');
    }

    /**
     * Create a new conversation.
     *
     * @return void
     */
    public function create()
    {
        $this->loadModel('Conversations');
        $conversation = $this->Conversations->newEntity($this->request->getParsedBody(), ['validate' => 'create']);

        if ($this->request->is('post')) {
            $users = str_replace(",", "", trim(strtolower($this->request->getData('users'))));
            $users = explode(" ", $users);

            //Check max users.
            if (!(count($users) <= Configure::read('Conversations.max_users_per_conversation'))) {
                $this->Flash->error(__d('conversations', 'You cannot invite more than {0} user(s) in this conversation.', Configure::read('Conversations.max_users_per_conversation')));
                $this->set(compact('conversation'));

                return;
            }

            $userMiniCount = false;
            $this->loadModel('Users');

            //We check if at least one user in all list exist.
            foreach ($users as $user) {
                $userCheck = $this->Users
                    ->find()
                    ->where([
                        'LOWER(Users.username)' => $user
                    ])
                    ->first();

                //If an user exist and if the user is not the own of the conversation.
                if ($userCheck && $userCheck->id != $this->Auth->user('id')) {
                    $userMiniCount = true;
                    break;
                }
            }

            if ($userMiniCount === false) {
                $this->Flash->error(__d('conversations', 'Please enter at least one valid recipient.'));
                $this->set(compact('conversation'));

                return;
            }

            $conversation->user_id = $this->Auth->user('id');
            $conversation->reply_count = 1;
            $conversation->recipient_count = 1;
            $conversation->last_message_user_id = $this->Auth->user('id');
            $conversation->last_message_date = new Time();

            if ($conversation = $this->Conversations->save($conversation)) {
                $this->loadModel('ConversationsMessages');
                $this->loadModel('ConversationsUsers');

                $data = [];
                $data['message'] = $this->request->getData('message');
                $data['conversation_id'] = $conversation->id;
                $data['user_id'] = $this->Auth->user('id');

                $entity = $this->ConversationsMessages->newEntity($data);
                $message = $this->ConversationsMessages->save($entity);

                $data = [];
                $data['conversation_id'] = $conversation->id;
                $data['user_id'] = $this->Auth->user('id');

                $entity = $this->ConversationsUsers->newEntity($data);
                $user = $this->ConversationsUsers->save($entity);

                $this->Conversations->updateAll(
                    [
                        'first_message_id' => $message->id,
                        'last_message_id' => $message->id
                    ],
                    [
                        'id' => $conversation->id
                    ]
                );

                //Save all invited users.
                foreach ($users as $user) {
                    $userExist = $this->Users
                        ->find()
                        ->where([
                            'LOWER(Users.username)' => $user
                        ])
                        ->first();

                    //If the user exist.
                    if (is_null($userExist)) {
                        break;
                    }

                    //Check if the user is not already in the conversation.
                    $conversUserCheck = $this->ConversationsUsers
                        ->find()
                        ->where([
                            'ConversationsUsers.conversation_id' => $conversation->id,
                            'ConversationsUsers.user_id' => $userExist->id
                        ])
                        ->first();

                    if (!is_null($conversUserCheck)) {
                        break;
                    }

                    $data = [];
                    $data['conversation_id'] = $conversation->id;
                    $data['user_id'] = $userExist->id;

                    $entity = $this->ConversationsUsers->newEntity($data);
                    $user = $this->ConversationsUsers->save($entity);

                    $expression = new QueryExpression('recipient_count = recipient_count + 1');
                    $this->Conversations->updateAll(
                        [$expression],
                        [
                            'id' => $conversation->id
                        ]
                    );

                    //Notifications Event.
                    $this->eventManager()->attach(new Notifications());
                    $event = new Event('Model.Notifications.dispatch', $this, [
                        'sender_id' => $this->Auth->user('id'),
                        'conversation_id' => $conversation->id,
                        'type' => 'conversation.reply'
                    ]);
                    $this->eventManager()->dispatch($event);
                }

                $this->Flash->success(__d('conversations', 'Your conversation has been created successfully !'));
                $this->redirect([
                    '_name' => 'conversations-view',
                    'slug' => $conversation->title,
                    'id' => $conversation->id
                ]);
            }
        }

        $this->set(compact('conversation'));
    }

    /**
     * Display a conversation.
     *
     * @return void|\Cake\Network\Response
     */
    public function view()
    {
        $this->loadModel('ConversationsUsers');

        $conversation = $this->ConversationsUsers
            ->find()
            ->contain([
                'Users',
                'Conversations',
                'Conversations.LastMessage',
                'Conversations.LastMessageUser'
            ])
            ->where([
                'ConversationsUsers.conversation_id' => $this->request->id,
                'ConversationsUsers.user_id' => $this->Auth->user('id'),
                'Conversations.conversation_open <>' => 2
            ])
            ->first();

        if (is_null($conversation)) {
            $this->Flash->error(__d('conversations', "This conversation doesn't exist or has been deleted."));

            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('ConversationsMessages');

        $this->paginate = [
            'maxLimit' => Configure::read('Conversations.messages_per_page')
        ];

        $messages = $this->ConversationsMessages
            ->find()
            ->contain([
                'Users' => function ($q) {
                    return $q->find('full')->formatResults(function ($users) {
                        return $users->map(function ($user) {
                            $user->online = $this->SessionsActivity->getOnlineStatus($user);

                            return $user;
                        });
                    });
                },
                'Users.Groups',
                'LastEditUsers' => function ($q) {
                    return $q->find('short');
                },
            ])
            ->where([
                'ConversationsMessages.conversation_id' => $this->request->id
            ])
            ->order([
                'ConversationsMessages.created' => 'ASC'
            ]);

        $messages = $this->paginate($messages);

        //Update "is_read" for the current user.
        $user = $this->ConversationsUsers->get($conversation->id);
        $user->is_read = 1;
        $this->ConversationsUsers->save($user);

        //Current user.
        $this->loadModel('Users');
        $currentUser = $this->Users
            ->find()
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select(['id', 'group_id'])
            ->first();

        //Build the newEntity for the comment form.
        $messageForm = $this->ConversationsMessages->newEntity();

        $this->set(compact('conversation', 'messages', 'currentUser', 'messageForm'));
    }

    /**
     * Action to search some users when adding an user in a conversation.
     *
     * @return void
     *
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function inviteMember()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }
        $keyword = strtolower($this->request->getQuery('query'));

        $this->loadModel('Users');
        $users = $this->Users
            ->find()
            ->where(function ($q) use ($keyword) {
                    return $q
                        ->like('LOWER(Users.username)', "%$keyword%");
            })
            ->limit(12)
            ->toArray();

        foreach ($users as $user) {
            $json[] = h($user->username);
        }

        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }

    /**
     * Quote a post.
     *
     * @throws \Cake\Network\Exception\NotFoundException
     *
     * @return mixed
     */
    public function quote()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $this->loadModel('ConversationsMessages');

        $message = $this->ConversationsMessages
            ->find()
            ->where([
                'ConversationsMessages.id' => $this->request->id
            ])
            ->contain([
                'Users' => function ($q) {
                        return $q->find('short');
                }
            ])
            ->first();

        $json = [];

        if (!is_null($message)) {
            $message->toArray();

            $url = Router::url(['action' => 'go', $message->id]);
            $text = __d('conversations', 'has said :');

            //Build the quote.
            $json['message'] = <<<EOT
<div>
    <div>
        <a href="{$url}">
            <strong>{$message->user->full_name} {$text}</strong>
        </a>
    </div>
    <blockquote>
        $message->message
    </blockquote>
</div><p>&nbsp;</p><p>&nbsp;</p>
EOT;

            $json['error'] = false;

            $this->set(compact('json'));
        } else {
            $json['post'] = __d('conversations', "This message doesn't exist.");
            $json['error'] = true;

            $this->set(compact('json'));
        }

        //Send response in JSON.
        $this->set('_serialize', 'json');
    }

    /**
     * Get the form to edit a message.
     *
     * @throws \Cake\Network\Exception\NotFoundException When it's not an AJAX request.
     *
     * @return void
     */
    public function getEditMessage()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $this->loadModel('ConversationsMessages');
        $this->viewBuilder()->layout(false);

        $message = $this->ConversationsMessages
            ->find()
            ->where([
                'ConversationsMessages.id' => $this->request->getData('id')
            ])
            ->first();

        $json = [
            'error' => false,
            'errorMessage' => ''
        ];

        if (is_null($message)) {
            $json['error'] = true;
            $json['errorMessage'] = __d('conversations', "This message doesn't exist or has been deleted !");

            $this->set(compact('json'));

            return;
        }

        //Current user.
        $this->loadModel('Users');
        $currentUser = $this->Users
            ->find()
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select(['id', 'group_id'])
            ->first();

        if ($message->user_id != $this->Auth->user('id') && !$currentUser->group->is_staff) {
            $json['error'] = true;
            $json['errorMessage'] = __d('conversations', "You don't have the authorization to edit this message !");

            $this->set(compact('json'));

            return;
        }

        $this->set(compact('json', 'message'));
    }

    /**
     * Edit a message.
     *
     * @param int $id Id of the message.
     *
     * @return \Cake\Network\Response
     */
    public function messageEdit($id = null)
    {
        if (!$this->request->is(['post', 'put'])) {
            throw new NotFoundException();
        }

        $this->loadModel('ConversationsMessages');

        $message = $this->ConversationsMessages
            ->find()
            ->where([
                'ConversationsMessages.id' => $id
            ])
            ->first();

        if (is_null($message)) {
            $this->Flash->error(__d('conversations', "This post doesn't exist or has been deleted !"));

            return $this->redirect($this->referer());
        }

        //Current user.
        $this->loadModel('Users');
        $currentUser = $this->Users
            ->find()
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select(['id', 'group_id'])
            ->first();

        if ($message->user_id != $this->Auth->user('id') && !$currentUser->group->is_staff) {
            $this->Flash->error(__d('conversations', "You don't have the authorization to edit this post !"));

            return $this->redirect($this->referer());
        }

        $this->ConversationsMessages->patchEntity($message, $this->request->getParsedBody());
        $message->last_edit_date = new Time();
        $message->last_edit_user_id = $this->Auth->user('id');
        $message->edit_count++;

        if ($this->ConversationsMessages->save($message)) {
            $this->Flash->success(__d('conversations', 'This message has been edited successfully !'));
        }

        return $this->redirect(['action' => 'go', $message->id]);
    }

    /**
     * Redirect an user to a conversation, page and message.
     *
     * @param int $messageId Id of the message.
     *
     * @return \Cake\Network\Response
     */
    public function go($messageId = null)
    {
        $this->loadModel('ConversationsMessages');

        $message = $this->ConversationsMessages
            ->find()
            ->contain([
                'Conversations'
            ])
            ->where([
                'ConversationsMessages.id' => $messageId
            ])
            ->first();

        if (is_null($message)) {
            $this->Flash->error(__d('conversations', "This message doesn't exist or has been deleted."));

            return $this->redirect(['controller' => 'conversations', 'action' => 'index']);
        }

        $message->toArray();

        //Count the number of messages before this message.
        $messagesBefore = $this->ConversationsMessages
            ->find()
            ->where([
                'ConversationsMessages.conversation_id' => $message->conversation_id,
                'ConversationsMessages.created <' => $message->created
            ])
            ->count();

        //Get the number of messages per page.
        $messagesPerPage = Configure::read('Conversations.messages_per_page');

        //Calculate the page.
        $page = ceil($messagesBefore / $messagesPerPage);

        $page = ($page > 1) ? $page : 1;

        //Redirect the user.
        return $this->redirect([
            '_name' => 'conversations-view',
            'slug' => $message->conversation->title,
            'id' => $message->conversation->id,
            '?' => ['page' => $page],
            '#' => 'message-' . $messageId
        ]);
    }

    /**
     * Function to kick an user from a conversation.
     *
     * @return void
     */
    public function kick()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $this->loadModel('ConversationsUsers');

        $currentUser = $this->ConversationsUsers
            ->find()
            ->contain([
                'Conversations',
                'Users' => function ($q) {
                    return $q->find('short');
                },
                'Users.Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->where([
                'ConversationsUsers.user_id' => $this->Auth->user('id'),
                'ConversationsUsers.conversation_id' => $this->request->id
            ])
            ->first();

        //Check if the current user is the owner of this conversation or if he is not a staff member.
        if ($currentUser->user_id != $currentUser->conversation->user_id && !$currentUser->user->group->is_staff) {
            $json['message'] = __d('conversations', 'You cannot kick this user from this conversation.');
            $json['error'] = true;

            $this->set(compact('json'));
            $this->set('_serialize', 'json');

            return;
        }

        $user = $this->ConversationsUsers
            ->find()
            ->contain([
                'Conversations',
                'Users' => function ($q) {
                    return $q->find('short');
                },
                'Users.Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->where([
                'ConversationsUsers.user_id' => $this->request->user_id,
                'ConversationsUsers.conversation_id' => $this->request->id
            ])
            ->first();

        //Check if the user to kick is in the conversation and if he is not owner of this conversation and if he is not a staff member.
        if (is_null($user) || $this->request->user_id == $currentUser->conversation->user_id || $user->user->group->is_staff) {
            $json['message'] = __d('conversations', 'You cannot kick this user from this conversation.');
            $json['error'] = true;

            $this->set(compact('json'));
            $this->set('_serialize', 'json');

            return;
        }

        $this->ConversationsUsers->delete($user);

        $expression = new QueryExpression('recipient_count = recipient_count - 1');
        $this->Conversations->updateAll(
            [$expression],
            [
                'id' => $this->request->id
            ]
        );

        $json['message'] = __d('conversations', 'This user has been kicked successfully.');
        $json['error'] = false;
        $json['id'] = $this->request->user_id;
        $json['recipients'] = $currentUser->conversation->recipient_count - 1;

        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }

    /**
     * Reply to a conversation.
     *
     * @return void|\Cake\Network\Response
     */
    public function reply()
    {
        $this->loadModel('ConversationsMessages');

        if ($this->request->is('post')) {
            $conversation = $this->Conversations
                ->find()
                ->where(['Conversations.id' => $this->request->id])
                ->first();

            $this->loadModel('ConversationsUsers');
            $user = $this->ConversationsUsers
                ->find()
                ->where([
                    'ConversationsUsers.conversation_id' => $this->request->id,
                    'ConversationsUsers.user_id' => $this->Auth->user('id')
                ])
                ->first();

            //Check if the conversation is found.
            if (is_null($user) || is_null($conversation) || $conversation->conversation_open == 2) {
                $this->Flash->error(__d('conversations', "This conversation doesn't exist or has been deleted !"));

                return $this->redirect($this->referer());
            }

            //Check if the conversation is open.
            if ($conversation->conversation_open == false) {
                $this->Flash->error(__d('conversations', 'This conversation is closed, you cannot reply.'));

                return $this->redirect($this->referer());
            }

            //Build the newEntity for the post form.
            $this->request = $this->request
                ->withData('conversation.last_post_date', new Time())
                ->withData('conversation.last_post_user_id', $this->Auth->user('id'))
                ->withData('user_id', $this->Auth->user('id'))
                ->withData('conversation_id', $this->request->id);

            $message = $this->ConversationsMessages->newEntity($this->request->getParsedBody(), [
                'associated' => ['Conversations'],
                'validate' => 'create'
            ]);

            //Handle validation errors (Due to the redirect)
            if (!empty($message->errors())) {
                $this->Flash->conversationsReply('Validation errors', [
                    'key' => 'ConversationsReply',
                    'params' => [
                        'errors' => $message->errors()
                    ]
                ]);

                return $this->redirect($this->referer());
            }

            if ($message->conversation->isNew() === true) {
                $message->conversation->isNew(false);
            }

            $message->conversation->accessible('id', true);
            $message->conversation->id = $this->request->id;

            if ($message = $this->ConversationsMessages->save($message)) {
                //Update the last message id for the conversation.
                $this->loadModel('Conversations');
                $conversation = $this->Conversations->get($this->request->id);
                $conversation->last_message_id = $message->id;
                $conversation->last_message_date = new Time();
                $conversation->last_message_user_id = $this->Auth->user('id');
                $this->Conversations->save($conversation);

                //Notifications Event.
                $this->eventManager()->attach(new Notifications());
                $event = new Event('Model.Notifications.dispatch', $this, [
                    'sender_id' => $this->Auth->user('id'),
                    'conversation_id' => $conversation->id,
                    'type' => 'conversation.reply'
                ]);
                $this->eventManager()->dispatch($event);

                $conversationOpen = !is_null($this->request->getData('conversation.conversation_open')) ? $this->request->getData('conversation.conversation_open') : true;

                if ($conversationOpen == false) {
                    $this->Flash->success(__d('conversations', 'Your reply has been posted successfully and the conversation has been closed !'));
                } else {
                    $this->Flash->success(__d('conversations', 'Your reply has been posted successfully !'));
                }

                //Redirect the user to the last page of the article.
                return $this->redirect([
                    'controller' => 'conversations',
                    'action' => 'go',
                    $message->id
                ]);
            }
        }

        $this->redirect($this->referer());
    }

    /**
     * Edit a conversation.
     *
     * @return \Cake\Network\Response
     */
    public function edit()
    {
        $this->loadModel('Conversations');

        if ($this->request->is('put')) {
            $conversation = $this->Conversations
                ->find()
                ->where([
                    'Conversations.id' => $this->request->id
                ])
                ->first();

            //Check if the conversation is found.
            if (is_null($conversation)) {
                $this->Flash->error(__d('conversations', "This conversation doesn't exist or has been deleted !"));

                return $this->redirect($this->referer());
            }

            //Check if the user has the permission to edit it.
            if ($this->Auth->isAuthorized() === false) {
                $this->Flash->error(__d('conversations', "You don't have the authorization to edit this conversation !"));

                return $this->redirect([
                    'controller' => 'conversations',
                    'action' => 'go',
                    $conversation->last_message_id
                ]);
            }

            $this->Conversations->patchEntity($conversation, $this->request->getParsedBody(), ['validate' => 'edit']);

            if ($this->Conversations->save($conversation)) {
                if ($conversation->conversation_open == false) {
                    $this->Flash->success(__d('conversations', 'Your conversation has been edited and closed successfully !'));
                } else {
                    $this->Flash->success(__d('conversations', 'Your conversation has been edited successfully !'));
                }

                return $this->redirect([
                    'controller' => 'conversations',
                    'action' => 'go',
                    $conversation->last_message_id
                ]);
            }
        }

        $this->redirect($this->referer());
    }

    /**
     * Function to invite user(s) in a conversation.
     *
     * @return void|\Cake\Network\Response
     */
    public function invite()
    {
        $this->loadModel('ConversationsUsers');

        $conversation = $this->ConversationsUsers
            ->find()
            ->contain([
                'Conversations',
                'Users',
                'Users.Groups'
            ])
            ->where([
                'ConversationsUsers.conversation_id' => $this->request->id,
                'ConversationsUsers.user_id' => $this->Auth->user('id')
            ])
            ->first();

        if (is_null($conversation) || $conversation->conversation->conversation_open != 1) {
            $this->Flash->error(__d('conversations', 'This conversation is closed or has been deleted !'));

            return $this->redirect($this->referer());
        }

        if (!$conversation->conversation->open_invite && $conversation->conversation->user_id != $this->Auth->user('id') && !$conversation->user->group->is_staff) {
            $this->Flash->error(__d('conversations', "You don't have the authorization to invite in this conversation !"));

            return $this->redirect($this->referer());
        }

        if ($this->request->is(['post', 'put'])) {
            $users = str_replace(",", "", trim(strtolower($this->request->getData('users'))));
            $users = explode(" ", $users);

            $maxUsersCheck = $this->ConversationsUsers
                ->find()
                ->where([
                    'ConversationsUsers.conversation_id' => $this->request->id
                ])
                ->count();

            //Check max users.
            if (count($users) + $maxUsersCheck >= Configure::read('Conversations.max_users_per_conversation')) {
                $this->Flash->error(__d('conversations', 'You cannot invite more than {0} user(s) in this conversation.', Configure::read('Conversations.max_users_per_conversation')));

                return $this->redirect($this->referer());
            }

            $this->loadModel('Users');
            $this->loadModel('Conversations');

            foreach ($users as $user) {
                $user = $this->Users
                    ->find()
                    ->where([
                        'LOWER(Users.username)' => $user
                    ])
                    ->first();

                if (!is_null($user)) {
                    $check = $this->ConversationsUsers
                        ->find()
                        ->where([
                            'ConversationsUsers.conversation_id' => $this->request->id,
                            'ConversationsUsers.user_id' => $user->id
                        ])
                        ->first();

                    if (is_null($check)) {
                        $data = [];
                        $data['conversation_id'] = $this->request->id;
                        $data['user_id'] = $user->id;

                        $entity = $this->ConversationsUsers->newEntity($data);
                        $this->ConversationsUsers->save($entity);

                        $expression = new QueryExpression('recipient_count = recipient_count + 1');
                        $this->Conversations->updateAll(
                            [$expression],
                            [
                                'id' => $this->request->id
                            ]
                        );
                    }
                }
            }

            $this->Flash->success(__d('conversations', 'Your user(s) has been added successfully.'));
        }

        return $this->redirect([
            'controller' => 'conversations',
            'action' => 'go',
            $conversation->conversation->last_message_id
        ]);
    }

    /**
     * Function to leave a conversation.
     *
     * @return void|\Cake\Network\Response
     */
    public function leave()
    {
        $this->loadModel('ConversationsUsers');

        $user = $this->ConversationsUsers
            ->find()
            ->contain([
                'Conversations'
            ])
            ->where([
                'ConversationsUsers.conversation_id' => $this->request->id,
                'ConversationsUsers.user_id' => $this->Auth->user('id')
            ])
            ->first();

        if (is_null($user)) {
            $this->Flash->error(__d('conversations', 'You are not in this conversation.'));

            return $this->redirect($this->referer());
        }

        if ($user->conversation->user_id != $this->Auth->user('id')) {
            $this->loadModel('Conversations');

            $this->ConversationsUsers->delete($user);

            $expression = new QueryExpression('recipient_count = recipient_count - 1');
            $this->Conversations->updateAll(
                [$expression],
                [
                    'id' => $this->request->id
                ]
            );

            $this->Flash->success(__d('conversations', 'You have left the conversation successfully.'));

            return $this->redirect(['controller' => 'conversations', 'action' => 'index']);
        } else {
            $this->Flash->error(__d('conversations', 'You can not leave your own conversation.'));

            return $this->redirect([
                'controller' => 'conversations',
                'action' => 'go',
                $user->conversation->last_message_id
            ]);
        }
    }

    /**
     * Search conversations.
     *
     * @return void
     */
    public function search()
    {
        $this->loadModel('ConversationsUsers');

        //Check the keyword to search. (For pagination)
        if (!empty($this->request->getData('search'))) {
            $keyword = $this->request->getData('search');
            $this->request->session()->write('Search.Conversations.Keyword', $keyword);
        } else {
            if ($this->request->session()->read('Search.Conversations.Keyword')) {
                $keyword = $this->request->session()->read('Search.Conversations.Keyword');
            } else {
                $keyword = '';
            }
        }

        //Pagination
        $this->paginate = [
            'maxLimit' => Configure::read('Conversations.conversations_per_page')
        ];

        $conversations = $this->ConversationsUsers
            ->find()
            ->contain([
                'Users',
                'Conversations',
                'Conversations.Users' => function ($q) {
                    return $q->find('medium');
                },
                'Conversations.LastMessage',
                'Conversations.LastMessageUser'
            ])
            ->where([
                'ConversationsUsers.user_id' => $this->Auth->user('id'),
                'Conversations.conversation_open <>' => 2
            ])
            ->andWhere(function ($q) use ($keyword) {
                    return $q
                        ->like('Conversations.title', "%$keyword%");
            })
            ->order([
                'ConversationsUsers.is_read' => 'ASC',
                'ConversationsUsers.is_star' => 'DESC',
                'Conversations.last_message_date' => 'DESC',
            ]);

        $conversations = $this->paginate($conversations);

        $this->set(compact('conversations', 'keyword'));
    }

    /**
     * Action to render the maintenance page.
     *
     * @return void
     */
    public function maintenance()
    {
    }
}
