<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;

class GroupsController extends AppController
{

    /**
     * BeforeFilter handle.
     *
     * @param Event $event The beforeFilter event that was fired.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['view']);
    }

    /**
     * Display members by a group.
     *
     * @return void
     */
    public function view()
    {
        $this->paginate = [
            'maxLimit' => Configure::read('Group.user_per_page')
        ];

        $this->Users = $this->loadModel('Users');

        $users = $this->Users
            ->find()
            ->contain([
                'Groups'
            ])
            ->where([
                'Groups.id' => $this->request->id
            ]);

        $users = $this->paginate($users);

        $this->set(compact('users'));
    }
}
