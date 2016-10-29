<?php
namespace App\Controller\Component;

use App\Model\Entity\User;
use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class SessionsActivityComponent extends Component
{

    /**
     * Request object
     *
     * @var \Cake\Network\Request
     */
    protected $_request;

    /**
     * Instance of the Session object
     *
     * @return void
     */
    protected $_session;

    /**
     * Initialize properties.
     *
     * @param array $config The config data.
     * @return void
     */
    public function initialize(array $config)
    {
        $controller = $this->_registry->getController();
        $this->_request = $controller->request;
        $this->_session = $controller->request->session();
    }

    /**
     * Startup event to trace the user on the website.
     *
     * @param Event $event The event that was fired.
     *
     * @return void
     */
    public function startup(Event $event)
    {
        if (empty($this->_session->id())) {
            $this->_session->start();

            return;
        }
        $sessions = TableRegistry::get('Sessions');

        $prefix = isset($this->_request['prefix']) ? $this->_request['prefix'] . '/' : '';
        $controller = $prefix . $this->_request['controller'];
        $action = $this->_request['action'];
        $params = serialize($this->_request->pass);
        $expires = time() + ini_get('session.gc_maxlifetime');

        //@codingStandardsIgnoreStart
        $user_id = $this->_session->read('Auth.User.id');
        //@codingStandardIgnoreEnd
        $record = compact('controller', 'action', 'params', 'expires', 'user_id');

        $record[$sessions->primaryKey()] = $this->_session->id();
        $sessions->save(new Entity($record));
    }

    /**
     * Get the list of the users online.
     *
     * @return array
     */
    public function getOnlineUsers()
    {
        $sessions = TableRegistry::get('Sessions');

        $output = [
            'guests' => 0,
            'members' => 0,
        ];

        $records = $sessions
            ->find('expires')
            ->contain([
                'Users' => function ($q) {
                    return $q->select([
                        'id',
                        'username',
                        'slug',
                        'end_subscription'
                    ]);
                },
                'Users.Groups' => function ($q) {
                    return $q->select(['css', 'is_member']);
                },
            ])
            ->select(['Sessions.user_id', 'Sessions.expires'])
            ->toArray();

        foreach ($records as $key => $record) {
            if (is_null($record->user_id)) {
                $output['guests']++;

                unset($records[$key]);
                continue;
            } else {
                $output['members']++;
            }
        }

        //Total visitors.
        $output['total'] = $output['guests'] + $output['members'];

        //Visitor records.
        $output['records'] = $records;

        return $output;
    }

    /**
     * Determine if the given user is online or offline.
     *
     * @param App\Model\Entity\User $user The user to check.
     *
     * @return bool
     */
    public function getOnlineStatus(User $user)
    {
        if (empty($user)) {
            return false;
        }

        $sessions = TableRegistry::get('Sessions');
        $online = $sessions
            ->find('expires')
            ->select(['Sessions.expires', 'Sessions.user_id'])
            ->where([
                'Sessions.user_id' => $user->id
            ])
            ->first();

        if (!empty($online)) {
            return true;
        }

        return false;
    }

}
