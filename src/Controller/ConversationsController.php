<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;

class ConversationsController extends AppController
{

    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'RequestHandler'
    ];

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
            'maxLimit' => 10
        ];
        $conversations = $this->ConversationsUsers
            ->find()
            ->contain([
                'Users',
                'Conversations',
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

        if (!array_key_exists('action', $this->request->data) || !in_array($this->request->data['action'], $actionAllowed)) {
            $json = [];
            $json['error'] = '1';
            $json['message'] = __d('conversations', 'Action unknown.');

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
        }

        if (!array_key_exists('conversations', $this->request->data)) {
            $json = [];
            $json['error'] = '1';
            $json['message'] = __d('conversations', 'You have not chosen any conversations.');

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
        }

        $this->loadModel('ConversationsUsers');

        $action = $this->request->data['action'];
        $array = $this->request->data['conversations'];

        switch($action) {
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

            default:
                $json['message'] = __("Action unknown.");
                $json['error'] = '1';

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
        $conversation = $this->Conversations->newEntity($this->request->data, ['validate' => 'create']);

        if ($this->request->is('post')) {
            $users = str_replace(",", "", trim(strtolower($this->request->data['users'])));
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
                debug($conversation);
                $this->loadModel('ConversationsMessages');
                $this->loadModel('ConversationsUsers');

                $data = [];
                debug($this->request->data);
                $data['message'] = $this->request->data['message'];
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
                }

                $this->Flash->success(__d('conversations', 'Your conversation has been created successfully !'));
                $this->redirect([
                    '_name' => 'conversations-view',
                    'slug' => 'show',
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
        $this->loadModel('ConversationsUsers');

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

        $this->set(compact('conversation', 'messages', 'currentUser'));
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
        $keyword = strtolower($this->request->data['query']);

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
     * Action to rendre the maintenance page.
     *
     * @return void
     */
    public function maintenance()
    {
    }
}
