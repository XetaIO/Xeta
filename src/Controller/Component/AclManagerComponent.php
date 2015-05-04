<?php
namespace App\Controller\Component;

use Acl\Adapter\DbAcl;
use Acl\Controller\Component\AclComponent;
use Acl\Model\Entity\Aco;
use Acl\Model\Entity\Aro;
use App\Model\Entity\Group;
use Cake\Controller\ComponentRegistry;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use ReflectionClass;
use ReflectionMethod;
use Cake\Controller\Component;

/**
 * Class AclManagerComponent
 * @package App\Controller\Component
 */
class AclManagerComponent extends Component
{

    protected $base = 'App';
    protected $config = [];

    /**
     * @param Group $group
     * @param $alias
     * @return mixed
     */
    public static function check(Group $group, $alias)
    {
        $Acl = new DbAcl();
        return $Acl->check($group, $alias);
    }

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        $registry = new ComponentRegistry();
        $this->Acl = new AclComponent($registry, Configure::read('Acl'));
        $this->Aco = $this->Acl->Aco;
        $this->Aro = $this->Acl->Aro;

    }

    public function AcosConstructor()
    {
        $resources = $this->__getResources();
        $root = $this->checkNodeOrSave($this->base, $this->base, null);
        unset($resources[0]);
        foreach ($resources as $controllers) {
            foreach ($controllers as $controller => $actions) {
                $tmp = explode('/', $controller);
                if (!empty($tmp) && isset($tmp[1])) {
                    $path = [0 => $this->base];
                    $slash = '/';
                    $parent = [1 => $root->id];
                    for ($i = 1; $i <= count($tmp); $i++) {
                        $path[$i] = $path[$i - 1];
                        if ($i >= 1 && isset($tmp[$i - 1])) {
                            $path[$i] = $path[$i] . $slash;
                            $path[$i] = $path[$i] . $tmp[$i - 1];
                            $old = $this->checkNodeOrSave($path[$i], $tmp[$i - 1], $parent[$i]);
                            $new = $this->Aco->find()->where(['alias' => $tmp[$i - 1], 'parent_id' => $parent[$i]])->first();
                            $parent[$i + 1] = $new['id'];
                        }
                    }
                    foreach ($actions as $action) {
                        if (!empty($action)) {
                            $this->checkNodeOrSave($controller . $action, $action, end($parent));
                        }
                    }
                } else {
                    $controllerName = array_pop($tmp);
                    $path = $this->base . '/' . $controller;
                    $controllerNode = $this->checkNodeOrSave($path, $controllerName, $root->id);
                    foreach ($actions as $action) {
                        if (!empty($action)) {
                            $this->checkNodeOrSave($controller . '/' . $action, $action, $controllerNode['id']);
                        }
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public function __getResources()
    {
        $controllers = $this->__getControllers();
        $resources = [];
        foreach ($controllers as $controller) {
            $actions = $this->__getActions($controller);
            array_push($resources, $actions);
        }
        return $resources;
    }

    /**
     * @return array
     */
    private function __getControllers()
    {
        $path = App::path('Controller');
        $dir = new Folder($path[0]);
        $files = $dir->findRecursive('.*Controller\.php');
        $results = [];
        foreach ($files as $file) {
            $controller = explode('.', $file)[0];
            $controller = str_replace(App::path('Controller'), '', $controller);
            $controller = str_replace('Controller', '', $controller);

            array_push($results, $controller);

        }
        return $results;
    }

    /**
     * @param $controllerName
     * @return array
     */
    public function __getActions($controllerName)
    {
        $className = 'App\\Controller\\' . $controllerName . 'Controller';
        $class = new ReflectionClass($className);
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $controllerName = str_replace("\\", "/", $controllerName);
        $results = [$controllerName => []];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize'];

        foreach ($actions as $action) {
            if ($action->class == $className && !in_array($action->name, $ignoreList)) {
                array_push($results[$controllerName], $action->name);

            }
        }

        return $results;
    }

    private function checkNodeOrSave($path, $alias, $parentId = null)
    {
        $node = $this->Aco->node($path);
        if (!$node) {
            $data = [
                'parent_id' => $parentId,
                'model' => null,
                'alias' => $alias,
            ];
            $entity = $this->Aco->newEntity($data);
            $node = $this->Aco->save($entity);
            return $node;
        }
        return $node;
    }

    public function node($path)
    {
        $node = $this->Aco->node($path);
        return $node;
    }

    /**
     * @param Group $aro
     * @param Aro $parent
     * @return bool
     */
    public function addBasicsRules(Group $aro, Aro $parent = null)
    {
        $controllers = $this->__getResources();
        $controllers = $this->__setAlias($controllers, $this->base);
        if (!$parent) {
            $this->Acl->allow($aro, $this->base);
            return true;
        } else {
            foreach ($controllers as $controllerName => $actions) {
                $this->Acl->inherit($aro, $controllerName);
            }
        }
        return true;
    }

    /**
     * @param $actions
     * @param $base
     * @return array
     */
    private function __setAlias($actions, $base)
    {
        $results = [];
        foreach ($actions as $controller) {
            if (!empty($controller)) {
                foreach ($controller as $controllerName => $actionList) {
                    if (!empty($actionList)) {
                        foreach ($actionList as $key => $action) {
                            $results[$base . '/' . $controllerName][$key] = $base . '/' . $controllerName . '/' . $action;
                        }

                    } else {
                        $results[$base] = $base;
                    }
                }
            }
        }
        return $results;
    }

    /**
     * @param Group $group
     * @param string $alias
     * @param $data
     * @return bool
     */
    public function editRule(Group $group, $alias = '', $data)
    {
        if (empty($alias) || empty($group)) {
            return false;
        }
        if ($data === 0) {
            if ($this->Acl->check($group, $alias)) {
                $this->Acl->deny($aro, $alias);

            } else {
                $this->Acl->inherit($aro, $alias);
            }
            return true;
        } elseif ($data === 1) {
            if (!$this->Acl->check($group, $alias)) {
                $this->Acl->allow($aro, $alias);

            } else {
                $this->Acl->inherit($aro, $alias);
            }
            return true;
        }
        return false;
    }

    /**
     * Get All actions for the controller
     *
     * @param null $controller
     * @param array $excluded
     * @param null $prefix
     * @param null $subfolder
     * @return array
     */
    public function __getActionsList($controller = null, array $excluded = [], $prefix = null, $subfolder = null)
    {
        if ($prefix) {
            $prefix .= '\\';
        }
        if ($subfolder) {
            $subfolder .= '\\';
        }
        $controller = $prefix . $subfolder . $controller;
        $results = $this->__getActions($controller);

        foreach ($results as $ctrl => $action) {
            $results[$ctrl] = array_diff($action, $excluded);
        }
        return $results;
    }

} 