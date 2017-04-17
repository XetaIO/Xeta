<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class MaintenanceComponent extends Component
{
    /**
     * Controller object
     *
     * @var \Cake\Controller\Controller
     */
    protected $_controller;

    /**
     * The allowed routes.
     *
     * @var array
     */
    protected $_allowedRoutes = [
        'Pages.maintenance',
        'Users.login',
        'Users.logout'
    ];

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
     * Handle the maintenance mode.
     *
     * @return false|void
     */
    public function handle()
    {
        if (Configure::read('Site.maintenance') !== true) {
            return false;
        }

        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        if ($this->_controller->Auth->user()) {
            $this->Users = TableRegistry::get('Users');
            $user = $this->Users
                ->find()
                ->contain([
                    'Groups' => function ($q) {
                        return $q->select(['id', 'is_staff']);
                    }
                ])
                ->where([
                    'Users.id' => $this->_controller->Auth->user('id')
                ])
                ->first();

            if (!is_null($user) && $user->group->is_staff == true) {
                //To prevent multiple flash messages.
                $this->_controller->Flash->config(['clear' => true]);
                $this->_controller->Flash->error(__("Hello {0}, The website is under maintenance, only you and the staff groups have the access !", h($user->full_name)));
            } else {
                if (!in_array($controller . '.' . $action, $this->_allowedRoutes)) {
                    $this->_controller->redirect([
                        'controller' => 'pages',
                        'action' => 'maintenance',
                        'prefix' => false
                    ]);
                }
            }
        } else {
            if (!in_array($controller . '.' . $action, $this->_allowedRoutes)) {
                $this->_controller->redirect([
                    'controller' => 'pages',
                    'action' => 'maintenance',
                    'prefix' => false
                ]);
            }
        }
    }
}
