<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Event\Forum\Statistics;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\I18n;

/**
 * Class GroupsController
 * @package App\Controller\Admin
 */
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
                $this->eventManager()->on(new Statistics());

                $stats = new Event('Model.Groups.update', $this);
                $this->eventManager()->dispatch($stats);

                $aro = $this->Acl->Aro->node($group)->first();
                $aro->parent_id = $this->request->data('parent');
                if ($this->Acl->Aro->save($aro)) {
                    if ($aro->parent_id) {
                        $parent = $this->Acl->Aro->node(['model' => 'Groups', 'foreign_key' => $aro->parent_id])->first();
                    } else {
                        $parent = null;
                    }
                    $this->loadComponent('AclManager');
                    if ($this->AclManager->addBasicsRules($group, $parent)) {
                        $this->Flash->info(__d('admin', 'Your group has been created successfully, but permissions can\'t be assigned pleased edit the group and set permissions !'));

                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->success(__d('admin', 'Your group has been created successfully !'));
                    return $this->redirect(['action' => 'index']);
                }
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
        $this->loadComponent('AclManager');
        $permissions = [
            'public' => [
                'Blog' => $this->AclManager->getActionsList('Blog', ['articleLike', 'articleUnlike', 'quote', 'go', 'search']),
                'Pages' => $this->AclManager->getActionsList('Pages', []),
                'Attachments' => $this->AclManager->getActionsList('Attachments', []),
                'Users' => $this->AclManager->getActionsList('Users', []),
                'Premium' => $this->AclManager->getActionsList('Premium', []),
                'Forum' => $this->AclManager->getActionsList('Forum', [], 'Forum'),
                'Threads' => $this->AclManager->getActionsList('Threads', [], 'Forum'),
                'Posts' => $this->AclManager->getActionsList('Posts', [], 'Forum'),
                'Chat' => $this->AclManager->getActionsList('Chat', [], 'Chat'),
            ],
            'Admin' => [
                'Admin' => $this->AclManager->getActionsList('Admin', [], 'Admin'),
                'Attachments' => $this->AclManager->getActionsList('Attachments', [], 'Admin'),
                'Articles' => $this->AclManager->getActionsList('Articles', [], 'Admin'),
                'Categories' => $this->AclManager->getActionsList('Categories', [], 'Admin'),
                'Groups' =>  $this->AclManager->getActionsList('Groups', [], 'Admin'),
                'Users' =>  $this->AclManager->getActionsList('Users', [], 'Admin'),
                'Forum' => $this->AclManager->getActionsList('Categories', [], 'Admin', 'Forum'),
                'Premium' => $this->AclManager->getActionsList('Premium', [],'Admin', 'Premium'),
                'Discounts' => $this->AclManager->getActionsList('Discounts', [], 'Admin', 'Premium'),
                'Offers' => $this->AclManager->getActionsList('Offers', [], 'Admin', 'Premium'),
            ]
        ];
        if (empty($group)) {
            $this->Flash->error(__d('admin', 'This group doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is('post')) {
            foreach ($this->request->data as $path => $data) {
                $node = $this->AclManager->node($path);
                if ($node) {
                    $check = $this->Acl->check($group, $path);
                    if ($data == 1 && $check == false) {
                        $this->Acl->inherit($group, $path);
                        $check = $this->Acl->check($group, $path);
                        if ($check == false) {
                            $this->Acl->allow($group, $path);
                        }
                    } elseif ($data == 0 && $check == true) {
                        $this->Acl->deny($group, $path);
                    }
                } else {
                    $this->Flash->error(__d('admin', 'Permissions can\'t be assigned, please retry !'));
                    return $this->redirect(['action' => 'index']);
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
                $this->eventManager()->on(new Statistics());

                $stats = new Event('Model.Groups.update', $this);
                $this->eventManager()->dispatch($stats);

                $this->Flash->success(__d('admin', 'This group has been updated successfully !'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__d('admin', 'The group can\'t be updated, please retry !'));
            return $this->redirect(['action' => 'index']);
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
            $this->eventManager()->on(new Statistics());

            $stats = new Event('Model.Groups.update', $this);
            $this->eventManager()->dispatch($stats);

            $this->Flash->success(__d('admin', 'This group has been deleted successfully !'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__d('admin', 'Unable to delete this group.'));

        return $this->redirect(['action' => 'index']);
    }
}
