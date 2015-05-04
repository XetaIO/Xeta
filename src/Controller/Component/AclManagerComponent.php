<?php
namespace App\Controller\Component;

use Acl\Controller\Component\AclComponent;
use Acl\Model\Entity\Aro;
use App\Model\Entity\Group;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use ReflectionClass;
use ReflectionMethod;


/**
 * Class AclManagerComponent
 * @package App\Controller\Component
 */
class AclManagerComponent extends Component
{

    /**
     * @var string
     */
    protected $base = 'App';
    /**
     * @var array
     */
    protected $config = [];

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

    /**
     * @return bool
     */
    public function acosBuilder()
    {
        $resources = $this->getResources();
        $root = $this->__checkNodeOrSave($this->base, $this->base, null);
        unset($resources[0]);
        foreach ($resources as $controllers) {
            foreach ($controllers as $controller => $actions) {
                $tmp = explode('/', $controller);
                if (!empty($tmp) && isset($tmp[1])) {
                    $path = [0 => $this->base];
                    $slash = '/';
                    $parent = [1 => $root->id];
                    $countTmp = count($tmp);
                    for ($i = 1; $i <= $countTmp; $i++) {
                        $path[$i] = $path[$i - 1];
                        if ($i >= 1 && isset($tmp[$i - 1])) {
                            $path[$i] = $path[$i] . $slash;
                            $path[$i] = $path[$i] . $tmp[$i - 1];
                            $this->__checkNodeOrSave($path[$i], $tmp[$i - 1], $parent[$i]);
                            $new = $this->Aco->find()->where(['alias' => $tmp[$i - 1], 'parent_id' => $parent[$i]])->first();
                            $parent[$i + 1] = $new['id'];
                        }
                    }
                    foreach ($actions as $action) {
                        if (!empty($action)) {
                            $this->__checkNodeOrSave($controller . $action, $action, end($parent));
                        }
                    }
                } else {
                    $controllerName = array_pop($tmp);
                    $path = $this->base . '/' . $controller;
                    $controllerNode = $this->__checkNodeOrSave($path, $controllerName, $root->id);
                    foreach ($actions as $action) {
                        if (!empty($action)) {
                            $this->__checkNodeOrSave($controller . '/' . $action, $action, $controllerNode['id']);
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getResources()
    {
        $controllers = $this->__getControllers();
        $resources = [];
        foreach ($controllers as $controller) {
            $actions = $this->getActions($controller);
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
     * @param string $controllerName
     * @return array
     */
    public function getActions($controllerName)
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

    /**
     * @param string $path
     * @param string $alias
     * @param null $parentId
     * @return mixed
     */
    private function __checkNodeOrSave($path, $alias, $parentId = null)
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

    /**
     * @param string $path
     * @return mixed
     */
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
        $controllers = $this->getResources();
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
     * @param array $actions
     * @param string $base
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
     * @param integer $data
     * @return bool
     */
    public function editRule(Group $group, $alias, $data)
    {
        if (empty($alias) || empty($group)) {
            return false;
        }
        if ($data === 0) {
            if ($this->Acl->check($group, $alias)) {
                $this->Acl->deny($group, $alias);

            } else {
                $this->Acl->inherit($group, $alias);
            }
            return true;
        } elseif ($data === 1) {
            if (!$this->Acl->check($group, $alias)) {
                $this->Acl->allow($group, $alias);

            } else {
                $this->Acl->inherit($group, $alias);
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
    public function getActionsList($controller = null, array $excluded = [], $prefix = null, $subfolder = null)
    {
        if ($prefix) {
            $prefix .= '\\';
        }
        if ($subfolder) {
            $subfolder .= '\\';
        }
        $controller = $prefix . $subfolder . $controller;
        $results = $this->getActions($controller);

        foreach ($results as $ctrl => $action) {
            $results[$ctrl] = array_diff($action, $excluded);
        }
        return $results;
    }
}
