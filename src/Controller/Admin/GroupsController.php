<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Event\Forum\Statistics;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class GroupsController extends AppController
{

    /**
     * Helpers.
     *
     * @var array
     */
    public $helpers = ['I18n'];

    /**
     * Display all Groups.
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'maxLimit' => 15
        ];

        $groups = $this->Groups
            ->find()
            ->order([
                'Groups.created' => 'desc'
            ]);

        $groups = $this->paginate($groups);
        $this->set(compact('groups'));
    }

    /**
     * Add a Group.
     *
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
        $this->Groups->locale(I18n::defaultLocale());
        $group = $this->Groups->newEntity($this->request->data);
        $parents = $this->Groups->find('list');
        if ($this->request->is('post')) {

            $group->setTranslations($this->request->data);
            if ($this->Groups->save($group)) {
                //Event.
                $this->eventManager()->attach(new Statistics());

                $stats = new Event('Model.Groups.update', $this);
                $this->eventManager()->dispatch($stats);

                $ParentAro = $this->Acl->Aro
                    ->find('all')
                    ->where(['model' => 'Groups', 'foreign_key' => $this->request->data['parent']])
                    ->contain(['Acos'])
                    ->first();
                $newAro = $this->Acl->Aro->find('all')->where(['model' => 'Groups', 'foreign_key' => $group->id])->first();
                $newAro->parent_id = $this->request->data['parent'];

                if($this->Acl->Aro->save($newAro)){
                    $editablePermissions = Configure::read('Editable-Permissions');
                    $basicPermissions = Configure::read('Basic-Permissions');
                    foreach($editablePermissions as $permGroup => $perm){
                        foreach($perm as $permAction => $action){
                            $this->Acl->inherit(['model' => 'Groups', 'foreign_key' => $group->id],  $action);
                        }
                    }
                    foreach($basicPermissions as $basicPerms){
                        debug($basicPerms);
                        $this->Acl->allow(['model' => 'Groups', 'foreign_key' => $group->id],  $basicPerms);
                    }
                    $this->Flash->success(__d('admin', 'Your group has been created successfully !'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__d('admin', 'Your group has been created successfully, but ACL Aro attributions failed.'));
                return $this->redirect(['action' => 'edit', $group->id]);
            }
        }

        $this->set(compact('group', 'parents'));
    }

    /**
     * Edit a Group.
     *
     * @return \Cake\Network\Response|void
     */
    public function edit()
    {
        $this->Groups->locale(I18n::defaultLocale());
        $group = $this->Groups
            ->find('translations')
            ->where([
                'Groups.id' => $this->request->id
            ])
            ->first();
        $permissions = Configure::read('Editable-Permissions');

        //Check if the group is found.
        if (empty($group)) {
            $this->Flash->error(__d('admin', 'This group doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

         if ($this->request->is('post')) {

            $this->Permissions = TableRegistry::get('Permissions');
            $result = false;

            $newAro = $this->Acl->Aro->find('all')->where(['model' => 'Groups', 'foreign_key' => $group->id])->first();
            $ParentAro = $this->Acl->Aro->find('all')->where(['model' => 'Groups', 'foreign_key' => $newAro->parent_id])->first();

            foreach($this->request->data as $K => $V){
                foreach($V as $k => $v){
                    foreach($v as $alias => $value){
                        if($value == '1'){
                            $check =  $this->Permissions->getAclLink(['model' => 'Groups','foreign_key' => $ParentAro->id], $alias);
                            if($check){
                                if(is_array($check['link']['Permissions']) && !empty($check['link']['Permissions'])){
                                    if($check['link']['Permissions'][0]['_create'] === '0' || $check['link']['Permissions'][0]['_create'] === '1'){
                                        $this->Acl->inherit(['model' => 'Groups', 'foreign_key' => $group->id], $alias);
                                    }else{
                                        $this->Acl->allow(['model' => 'Groups', 'foreign_key' => $group->id], $alias);
                                    }
                                }
                            }
                        }else{
                            $check =  $this->Permissions->getAclLink(['model' => 'Groups','foreign_key' => $ParentAro->id], $alias);
                            if($check){
                                if(is_array($check['link']['Permissions']) && !empty($check['link']['Permissions'])){
                                    if($check['link']['Permissions'][0]['_create'] === '0' || $check['link']['Permissions'][0]['_create'] === '-1'){
                                        $this->Acl->inherit(['model' => 'Groups', 'foreign_key' => $group->id], $alias);
                                    }else{
                                        $this->Acl->deny(['model' => 'Groups', 'foreign_key' => $group->id], $alias);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->Flash->success(__d('admin', 'This group has been updated successfully !'));
            return $this->redirect(['action' => 'index']);
         }

        if ($this->request->is('put')) {
            $this->Groups->patchEntity($group, $this->request->data());
            $group->setTranslations($this->request->data);

            if ($this->Groups->save($group)) {
                //Event.
                $this->eventManager()->attach(new Statistics());

                $stats = new Event('Model.Groups.update', $this);
                $this->eventManager()->dispatch($stats);

                $this->Flash->success(__d('admin', 'This group has been updated successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('group', 'permissions'));
    }

    /**
     * Delete a group.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {
        $group = $this->Groups
            ->find()
            ->where([
                'Groups.id' => $this->request->id
            ])
            ->contain([
                'Users' => function ($q) {
                    return $q->limit(1);
                }
            ])
            ->first();

        //Check if the group is found.
        if (empty($group)) {
            $this->Flash->error(__d('admin', 'This group doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        //Check if the group is assigned to one or more user(s).
        if (!empty($group->users)) {
            $this->Flash->error(__d('admin', 'This group is assigned to one or more user(s). You must change their group before to delete this group.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Groups->delete($group)) {
            //Event.
            $this->eventManager()->attach(new Statistics());

            $stats = new Event('Model.Groups.update', $this);
            $this->eventManager()->dispatch($stats);

            $this->Flash->success(__d('admin', 'This group has been deleted successfully !'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__d('admin', 'Unable to delete this group.'));

        return $this->redirect(['action' => 'index']);
    }
}
