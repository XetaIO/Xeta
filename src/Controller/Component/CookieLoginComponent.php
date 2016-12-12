<?php
namespace App\Controller\Component;

use App\Event\Badges;
use App\Event\Logs;
use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

class CookieLoginComponent extends Component
{
    /**
     * Controller object
     *
     * @var \Cake\Controller\Controller
     */
    protected $_controller;

    /**
     * Initialize properties.
     *
     * @param array $config The config data.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->_controller = $this->_registry->getController();
    }

    /**
     * Handle the cookie login.
     *
     * @return false|void
     */
    public function handle()
    {
        if ($this->_controller->Auth->user() || !$this->_controller->Cookie->read('CookieAuth')) {
            return false;
        }
        $this->Users = TableRegistry::get('Users');

        $userLogin = $this->_controller->Auth->identify();

        if (!$userLogin || !$userLogin['is_deleted'] == false) {
            $this->_controller->Cookie->delete('CookieAuth');

            return false;
        }
        $this->_controller->loadComponent('TwoFactorAuth');

        //Verify if the user use 2FA and if yes, if he's authorized.
        if ($userLogin['two_factor_auth_enabled'] == true && $this->_controller->TwoFactorAuth->isAuthorized($userLogin['id']) === false) {
            $this->_controller->Cookie->delete('CookieAuth');
        } else {
            $this->_controller->Auth->setUser($userLogin);

            $user = $this->Users->newEntity($userLogin, ['accessibleFields' => ['id' => true]]);
            $user->isNew(false);
            $user->id = $userLogin['id'];

            $user->last_login = new Time();
            $user->last_login_ip = $this->request->clientIp();

            $this->Users->save($user);

            //Badges Event.
            EventManager::instance()->attach(new Badges($this->_controller));
            $badge = new Event('Model.Users.register', $this->_controller, [
                'user' => $user
            ]);
            EventManager::instance()->dispatch($badge);

            //Logs Event.
            EventManager::instance()->attach(new Logs());
            $event = new Event('Log.User', $this->_controller, [
                'user_id' => $user->id,
                'username' => $user->username,
                'user_ip' => $this->_controller->request->clientIp(),
                'user_agent' => $this->_controller->request->header('User-Agent'),
                'action' => 'user.connection.auto'
            ]);
            EventManager::instance()->dispatch($event);
        }
    }
}
