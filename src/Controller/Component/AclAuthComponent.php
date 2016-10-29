<?php
namespace App\Controller\Component;

use Cake\Controller\Component\AuthComponent;
use Cake\Utility\Inflector;

class AclAuthComponent extends AuthComponent
{

    /**
     * Takes a list of actions in the current controller for which authentication is not required, or
     * no parameters to allow all actions.
     *
     * You can use allow with either an array or a simple string.
     *
     * `$this->Auth->allow('view');`
     * `$this->Auth->allow(['edit', 'add']);`
     * `$this->Auth->allow();` to allow all actions
     *
     * @param string|array $actions Controller action name or array of actions.
     *
     * @return void
     */
    public function allow($actions = null)
    {
        if ($actions === null) {
            $controller = $this->_registry->getController();
            $this->allowedActions = get_class_methods($controller);

            return;
        }

        $controller = Inflector::camelize($this->request['controller']);
        $action = Inflector::underscore($this->request['action']);
        if (!$this->session->read('Auth.User') ||
            (isset($this->config('allowedActionsForBanned')[$controller]) &&
            in_array($action, array_map('strtolower', $this->config('allowedActionsForBanned')[$controller])))
        ) {
            $this->allowedActions = array_merge($this->allowedActions, (array)$actions);
        }
    }
}
