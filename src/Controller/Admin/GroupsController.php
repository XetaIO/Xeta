<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Event\Forum\Statistics;
use Cake\Event\Event;
use Cake\I18n\I18n;
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

                // Inherit parent acos value
                $ParentAro = $this->Acl->Aro->find('all')->where(['model' => 'Groups', 'foreign_key' => $this->request->data['parent']])->contain(['Acos'])->first();
                $newAro = $this->Acl->Aro->find('all')->where(['model' => 'Groups', 'foreign_key' => $group->id])->first();
                $newAro->parent_id = $this->request->data['parent'];
                $this->Acl->Aro->save($newAro);
                foreach($ParentAro['acos'] as $aco ){
                    if($aco->parent_id != null){
                        $a = $this->Acl->Aco->find('all')->where(['id' => $aco['parent_id']])->first();
                         $this->Acl->inherit(['model' => 'Groups', 'foreign_key' => $group->id],  $a['alias'].'/'.$aco['alias']);
                    }else{
                       $this->Acl->inherit(['model' => 'Groups', 'foreign_key' => $group->id],  $aco['alias']);
                    }

                }
                die();
                $this->Flash->success(__d('admin', 'Your group has been created successfully !'));

                return $this->redirect(['action' => 'index']);
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

        //Check if the group is found.
        if (empty($group)) {
            $this->Flash->error(__d('admin', 'This group doesn\'t exist or has been deleted.'));

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

        $this->set(compact('group'));
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
