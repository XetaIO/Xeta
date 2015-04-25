<?php
namespace App\Controller\Component\Chat;

use Cake\Controller\Component;
use Cake\I18n\Time;

class CommandsComponent extends Component
{

    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'Chat' => [
            'className' => 'App\Controller\Component\Chat\ChatComponent'
        ]
    ];

    /**
     * Default config.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'prefix' => '!'
    ];

    /**
     * Request object.
     *
     * @var \Cake\Network\Request
     */
    protected $_request;

    /**
     * Instance of the Session object.
     *
     * @return void
     */
    protected $_session;

    /**
     * Instance of the Controller object.
     *
     * @return void
     */
    protected $_controller;

    /**
     * All the message exploded.
     *
     * @var array
     */
    protected $_parts = [];

    /**
     * Arguments passed to the command.
     *
     * @var array
     */
    protected $_arguments;

    /**
     * The commands list.
     *
     * @var array
     */
    protected $_commands = [];

    /**
     * Initialize properties.
     *
     * @param array $config The config data.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $controller = $this->_registry->getController();
        $this->_controller = $controller;
        $this->_request = $controller->request;
        $this->_session = $controller->request->session();

        $this->_commands = [
            'prune' => [
                'params' => 0,
                'syntax' => $this->config()['prefix'] . 'prune',
                'description' => __d('chat', 'Clear all message in the chat.')
            ],
            'ban' => [
                'params' => 2,
                'syntax' => $this->config()['prefix'] . 'ban [UserID|Username] [Time] Optional : [Reason]',
                'description' => __d('chat', 'Ban an user from the chat.')
            ],
            'unban' => [
                'params' => 1,
                'syntax' => $this->config()['prefix'] . 'unban [UserID|Username]',
                'description' => __d('chat', 'Unban an user from the chat.')
            ]
        ];
    }

    /**
     * Parse the message and check if there are a command and if yes then handle it.
     *
     * @param string $message The message to parse.
     *
     * @return array
     */
    public function init($message)
    {
        $this->_parts = explode(chr(32), $message);
        $prefix = substr($this->_parts[0], 0, 1);
        $this->_parts[0] = substr(strtolower($this->_parts[0]), 1);

        //If the parts as more than 1 part, that mean this command take several arguments.
        if (count($this->_parts) > 1) {
            $arguments = explode(chr(32), $message, 2);
            $this->_arguments = explode(chr(32), $arguments[1]);
            $this->_arguments = array_map('strtolower', $this->_arguments);
        }

        $json = [];
        //Check if the prefix if equal to the prefix configuration Or if the command is defined.
        //Or if the command as enought paramters.
        if ($prefix != $this->config()['prefix'] || !isset($this->_commands[$this->_parts[0]])) {
            $json['error'] = false;
            $json['hasCmd'] = false;

            return $json;
        } elseif (count($this->_arguments) < $this->_commands[$this->_parts[0]]['params']) {
            $json['error'] = false;
            $json['hasCmd'] = false;
            $json['message'] = __d('chat', 'Not enough parameters given. Syntax : {0}', $this->_commands[$this->_parts[0]]['syntax']);

            return $json;
        }

        //Handle the command.
        $json = $this->_handleCommand($message);

        return $json;
    }

    /**
     * Handle the command.
     *
     * @param string $message The message to handle.
     *
     * @return array
     */
    protected function _handleCommand($message)
    {
        $json = [
            'hasCmd' => true
        ];

        $errorAuthorization = __d('chat', 'You don\'t have the permission to execute this command.');

        switch($this->_parts[0]) {
            case 'prune':
                if ($this->Chat->hasPermission(['action' => 'canPrune']) === false) {
                    $json['error'] = true;
                    $json['message'] = $errorAuthorization;

                    return $json;
                }

                //Delete all messages.
                $this->_controller->loadModel('ChatMessages');
                $this->_controller->ChatMessages->deleteAll(['1 = 1']);

                //Create a new message to display who has deleted all the messages.
                $this->_controller->loadModel('Users');
                $user = $this->_controller->Users
                    ->find()
                    ->contain([
                        'Groups' => function ($q) {
                            return $q->select(['id', 'name', 'css', 'is_staff', 'is_member']);
                        }
                    ])
                    ->where(['Users.id' => $this->_controller->Auth->user('id')])
                    ->select([
                        'Users.id',
                        'Users.group_id',
                        'Users.username',
                        'Users.slug',
                        'Users.end_subscription'
                    ])
                    ->first();

                $data = [
                    'text' => __d('chat', 'The chat has been cleaned by {0}.', $user->username),
                    'username' => $user->username,
                    'user_id' => $user->id,
                    'group_id' => $user->group_id,
                    'command' => 'prune',
                    'css' => $user->group_css,
                    'slug' => $user->slug
                ];

                $message = $this->_controller->ChatMessages->newEntity($data);

                if ($lastMessage = $this->_controller->ChatMessages->save($message)) {
                    $json['error'] = false;
                    $json['command'] = 'prune';
                    $json['lastMessageId'] = $lastMessage->id;
                } else {
                    $json['error'] = true;
                    $json['message'] = __d('chat', 'Error while saving the new message after deleting all messages.');
                }

                break;

            case 'ban':
                if ($this->Chat->hasPermission(['action' => 'canBan']) === false) {
                    $json['error'] = true;
                    $json['message'] = $errorAuthorization;

                    return $json;
                }

                $this->_controller->loadModel('Users');

                $userId = (int)$this->_arguments[0];

                //Build the condition to find the User.
                if ($userId != 0) {
                    $conditions = [
                        'Users.id' => $userId
                    ];
                } else {
                    $conditions = [
                        'LOWER(Users.username)' => strtolower($this->_arguments[0])
                    ];
                }

                //Find the User.
                $user = $this->_controller->Users
                    ->find('all', [
                        'conditions' => [$conditions],
                        'select' => [
                            'Users.id',
                            'Users.username'
                        ]
                    ])
                    ->first();

                if (is_null($user)) {
                    $json['error'] = true;
                    $json['hasCmd'] = true;
                    $json['message'] = __d('chat', 'The user "{0}" doesn\'t exist.', $this->_arguments[0]);
                    return $json;
                }

                //Check if the user is not already banned.
                $this->_controller->loadModel('ChatBans');
                $userBanned = $this->_controller->ChatBans
                    ->find()
                    ->where([
                        'ChatBans.user_id' => $user->id
                    ])
                    ->first();

                if (!is_null($userBanned) && ($userBanned->forever === true || $userBanned->end_date > Time::now())) {
                    $json['error'] = true;
                    $json['hasCmd'] = true;
                    $json['message'] = __d('chat', 'The user "{0}" is already banned.', $user->username);
                    return $json;
                } elseif (!is_null($userBanned)) {
                    $this->_controller->ChatBans->delete($userBanned);
                }

                $data = [
                    'banisher_id' => $this->_controller->Auth->user('id'),
                    'user_id' => $user->id
                ];

                $time = (int)$this->_arguments[1];

                //If time == 0 then it's a forever.
                if ($time === 0) {
                    $data += [
                        'forever' => 1
                    ];
                } else {
                    $now = Time::now();

                    if ($time === 1) {
                        $now->addMinute();
                    } else {
                        $now->addMinutes($time);
                    }

                    $data += [
                        'end_date' => $now
                    ];
                }

                $reason = explode(chr(32), $message, 4);

                if (isset($reason[3])) {
                    $data += [
                        'reason' => $reason[3]
                    ];
                }

                $ban = $this->_controller->ChatBans->newEntity($data);

                if ($this->_controller->ChatBans->save($ban)) {
                    $json['error'] = false;
                    $json['command'] = 'ban';
                    $json['username'] = $user->username;
                } else {
                    $json['error'] = true;
                    $json['message'] = __d('chat', 'Error while banning the user "{0}".', $user->username);
                }

                if (isset($data['forever'])) {
                    $textTime = __d('chat', 'forever');
                } else {
                    $textTime = __dn('chat', 'for {0} minute', 'for {0} minutes', $time, $time);
                }

                if (isset($data['reason'])) {
                    $textReason = $textTime . '. ' . __d('chat', 'Reason : {0}', h($data['reason']));
                } else {
                    $textReason = $textTime . ' ' . __d('chat', 'without reason.');
                }

                //Select the current user to get his information.
                $currentUser = $this->_controller->Users
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
                    ->where(['Users.id' => $this->_controller->Auth->user('id')])
                    ->first();

                //Build the notification.
                $notify = [
                    'text' => __('I have banned {0} {1}', $user->username, $textReason),
                    'username' => $currentUser->username,
                    'user_id' => $currentUser->id,
                    'command' => 'ban',
                    'group_id' => $currentUser->group_id,
                    'css' => $currentUser->group_css,
                    'slug' => $currentUser->slug
                ];

                $this->_controller->loadModel('ChatMessages');
                $message = $this->_controller->ChatMessages->newEntity($notify);

                $this->_controller->ChatMessages->save($message);

                break;

            case 'unban':
                if ($this->Chat->hasPermission(['action' => 'canUnban']) === false) {
                    $json['error'] = true;
                    $json['message'] = $errorAuthorization;

                    return $json;
                }

                $this->_controller->loadModel('Users');

                $userId = (int)$this->_arguments[0];

                //Build the condition to find the User.
                if ($userId != 0) {
                    $conditions = [
                        'Users.id' => $userId
                    ];
                } else {
                    $conditions = [
                        'LOWER(Users.username)' => strtolower($this->_arguments[0])
                    ];
                }

                //Find the User.
                $user = $this->_controller->Users
                    ->find('all', [
                        'conditions' => [$conditions],
                        'select' => [
                            'Users.id',
                            'Users.username'
                        ]
                    ])
                    ->first();

                if (is_null($user)) {
                    $json['error'] = true;
                    $json['hasCmd'] = true;
                    $json['message'] = __d('chat', 'The user "{0}" doesn\'t exist.', $this->_arguments[0]);

                    return $json;
                }

                //Select the User banned.
                $this->_controller->loadModel('ChatBans');
                $userBanned = $this->_controller->ChatBans
                    ->find()
                    ->where([
                        'ChatBans.user_id' => $user->id
                    ])
                    ->first();

                //Check if the user is banned.
                if (is_null($userBanned) || ($userBanned->end_date < Time::now() && $userBanned->forever === false)) {
                    $json['error'] = true;
                    $json['hasCmd'] = true;
                    $json['message'] = __d('chat', 'The user "{0}" is not banned.', $user->username);

                    //Clean the database.
                    if (!is_null($userBanned) && $userBanned->end_date < Time::now()) {
                        $this->_controller->ChatBans->delete($userBanned);
                    }

                    return $json;
                } elseif (!is_null($userBanned) && ($userBanned->forever === true || $userBanned->end_date > Time::now())) {
                    //The user is banned, we unban him.

                    if ($this->_controller->ChatBans->delete($userBanned)) {
                        $json['error'] = false;
                        $json['command'] = 'unban';
                        $json['username'] = $user->username;
                    } else {
                        $json['error'] = true;
                        $json['message'] = __d('chat', 'Error while unbanning the user "{0}".', $user->username);
                    }

                    //Select the current user to get his information.
                    $currentUser = $this->_controller->Users
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
                        ->where(['Users.id' => $this->_controller->Auth->user('id')])
                        ->first();

                    //Build the notification.
                    $notify = [
                        'text' => __d('chat', 'I have unbanned {0}.', $user->username),
                        'username' => $currentUser->username,
                        'user_id' => $currentUser->id,
                        'command' => 'unban',
                        'group_id' => $currentUser->group_id,
                        'css' => $currentUser->group_css,
                        'slug' => $currentUser->slug
                    ];

                    $this->_controller->loadModel('ChatMessages');
                    $message = $this->_controller->ChatMessages->newEntity($notify);

                    $this->_controller->ChatMessages->save($message);
                }
                break;
        }

        return $json;
    }
}
