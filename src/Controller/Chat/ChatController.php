<?php
namespace App\Controller\Chat;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;

class ChatController extends AppController
{

    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'RequestHandler',
        'Chat' => [
            'className' => 'App\Controller\Component\Chat\ChatComponent'
        ],
        'Commands' => [
            'className' => 'App\Controller\Component\Chat\CommandsComponent'
        ],
        'User' => [
            'className' => 'App\Controller\Component\Chat\UserComponent'
        ]
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

        $this->Auth->allow(['index']);
    }

    /**
     * Get all messages related to the latest message, and all users online.
     *
     * @return \Cake\Network\Response The XML generated.
     *
     * @throws \Cake\Network\Exception\NotFoundException When the request is not in AJAX.
     */
    public function index()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $this->loadModel('ChatMessages');
        $this->loadModel('ChatOnline');

        $messages = $this->ChatMessages
            ->find()
            ->where([
                'ChatMessages.status' => 1,
                'ChatMessages.id >' => $this->request->query['lastMessageId']
            ])
            ->order([
                'ChatMessages.created' => 'DESC'
            ])
            ->limit(Configure::read('Chat.maxMessages'))
            ->formatResults(function ($messages) {
                return $messages->map(function ($message) {
                    $message['created'] = $message['created']->timestamp;
                    $message['modified'] = $message['modified']->timestamp;
                    $message['link'] = Router::url(['_name' => 'users-profile', 'slug' => $message['slug']]);
                    return $message;
                });
            })
            ->hydrate(false)
            ->toArray();

        $users = $this->ChatOnline
            ->find()
            ->formatResults(function ($users) {
                return $users->map(function ($user) {
                    $user['created'] = $user['created']->timestamp;
                    $user['link'] = Router::url(['_name' => 'users-profile', 'slug' => $user['slug']]);
                    return $user;
                });
            })
            ->hydrate(false);

        //Get the notice.
        $notice = $this->Chat->getNotice();

        $this->User->handleUsers();

        $xml = [
            'root' => [
                'infos' => [
                    'info' => [
                        ['notice' => $notice]
                    ]
                ],
                'messages' => [],
                'users' => []
            ]
        ];

        $xml = $this->_isConnected($xml);

        if (!empty($messages)) {
            $xml['root']['messages'] += [
                'message' => array_reverse($messages)
            ];
        }

        if (!empty($users->toArray())) {
            $users = $users->toArray();

            $timeOut = Time::now();
            $timeOut = Configure::read('Chat.usersTimeOut') > 1 ? $timeOut->subSeconds(Configure::read('Chat.usersTimeOut')) : $timeOut->subSecond(1);

            foreach ($users as $key => $user) {
                if ($timeOut > $user['modified']) {
                    unset($users[$key]);
                }
            }

            $xml['root']['users'] += [
                'user' => $users
            ];
        }

        //Get the number of online users.
        $usersCounter = count($users);
        array_push($xml['root']['infos']['info'], ['usersCounter' => $usersCounter]);

        $this->viewClass = 'Xml';
        $this->set(compact('xml'));

        //Send response in XML.
        $this->set('_serialize', 'xml');
    }

    /**
     * When an user send a shout.
     *
     * @return \Cake\Network\Response|void
     *
     * @throws \Cake\Network\Exception\NotFoundException When the request is not in AJAX.
     */
    public function shout()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $json = [];

        //The user is not connected.
        if (!$this->Auth->user()) {
            $json['error'] = true;
            $json['message'] = __d('chat', 'You need to be logged in to send a message in the chat.');

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
            return;
        }

        //Check if the user is banned.
        $banned = $this->User->isBanned();

        if ($banned['banned'] === true) {
            $json['error'] = true;

            $reason = empty($banned['reason']) ? __d('chat', ' without reason.') : __d('chat', '. Reason : {0}', $banned['reason']);
            $end = ($banned['end'] === 'forever') ? __d('chat', 'forever') : __d('chat', 'until {0}', $banned['end']->format('h:i:s d/m/Y'));

            $json['message'] = __d('chat', 'You are banned from the chat {0}{1}', $end, $reason);

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
            return;
        }

        $messageText = trim($this->request->data['message']);

        //Handle the shout Rules.
        $rules = $this->Chat->handleShoutRules($messageText);

        if ($rules['error'] === true) {
            $this->set(compact('rules'));
            $this->set('_serialize', 'rules');
            return;
        }

        //Handle the command.
        $commands = $this->Commands->init($messageText);

        if ($commands['hasCmd'] === true) {
            $this->set(compact('commands'));
            $this->set('_serialize', 'commands');
            return;
        } elseif (isset($commands['message']) && $commands['hasCmd'] === false) {
            $this->set(compact('commands'));
            $this->set('_serialize', 'commands');
            return;
        }

        $this->loadModel('ChatMessages');
        $this->loadModel('Users');

        $message = $this->ChatMessages->newEntity(['text' => $messageText]);
        $user = $this->Users
            ->find()
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'name', 'css', 'is_staff', 'is_member']);
                }
            ])
            ->select([
                'Users.id',
                'Users.end_subscription',
                'Users.username',
                'Users.slug',
                'Users.group_id'
            ])
            ->where(['Users.id' => $this->Auth->user('id')])
            ->first();

        $message->username = $user->username;
        $message->user_id = $this->Auth->user('id');
        $message->group_id = $user->group_id;
        $message->css = $user->group_css;
        $message->slug = $user->slug;

        if ($this->ChatMessages->save($message)) {
            $json['error'] = false;
        } else {
            $json['error'] = true;
            $json['message'] = __d('chat', 'Error to post your message, please try again.');
        }

        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }

    /**
     * Get the notice to edit it.
     *
     * @return void
     *
     * @throws \Cake\Network\Exception\NotFoundException When the request is not in AJAX.
     */
    public function getNotice()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $notice = $this->Chat->getNotice();

        $json = [];
        $json['notice'] = $notice;

        $this->set(compact('json'));

        //Send response in Json.
        $this->set('_serialize', 'json');
    }

    /**
     * Edit the Notice.
     *
     * @return void
     *
     * @throws \Cake\Network\Exception\NotFoundException When the request is not in AJAX.
     */
    public function editNotice()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        //Check the permissions.
        if ($this->Chat->hasPermission(['action' => 'canNotice']) === false) {
            $json['error'] = true;
            $json['message'] = __d('chat', 'You don\'t have the permission to execute this action.');

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
            return;
        }

        $json = $this->Chat->editNotice($this->request->data['notice']);

        $this->set(compact('json'));

        //Send response in Json.
        $this->set('_serialize', 'json');
    }

    /**
     * Delete a message by his id.
     *
     * @return void
     *
     * @throws \Cake\Network\Exception\NotFoundException When the request is not in AJAX.
     */
    public function delete()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $json = [];

        //Check the permissions.
        if ($this->Chat->hasPermission(['action' => 'canDelete']) === false) {
            $json['error'] = true;
            $json['message'] = __d('chat', 'You don\'t have the permission to execute this action.');

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
            return;
        }

        $this->loadModel('ChatMessages');
        $id = $this->request->data['id'];

        $message = $this->ChatMessages
            ->find()
            ->where(['ChatMessages.id' => $id])
            ->first();

        if (is_null($message)) {
            $json['error'] = true;
            $json['message'] = __d('chat', 'This message doesn\'t exist or has already been deleted.');

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
            return;
        }

        $message->status = 0;

        if ($this->ChatMessages->save($message)) {
            $json['error'] = false;
            $json['message'] = __d('chat', 'This message has been deleted successfully.');
        } else {
            $json['error'] = true;
            $json['message'] = __d('chat', 'Error to delete the message.');
        }

        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }

    /**
     * Check if the current user is connected or not.
     *
     * @param array $xml The xml array.
     *
     * @return array
     */
    protected function _isConnected($xml)
    {
        $isConnected = ($this->request->session()->read('Auth.User')) ? true : false;

        if ($this->request->query['lastMessageId'] == "0") {
            array_push($xml['root']['infos']['info'], ['isConnected' => $isConnected]);
        }

        return $xml;
    }
}
