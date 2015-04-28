<?php
namespace App\View\Cell;

use Cake\Core\Configure;
use Cake\View\Cell;

class ForumCell extends Cell
{

    /**
     * Display the suggestions.
     *
     * @return \Cake\Network\Response
     */
    public function suggestion()
    {
        $this->loadModel('Sessions');
        $this->loadModel('ForumThreads');

        $id = isset($this->request->id) ? $this->request->id : null;

        $suggestions = $this->ForumThreads
            ->find()
            ->contain([
                'FirstPosts',
                'FirstPosts.Users' => function ($q) {
                    return $q->select([
                        'id',
                        'username',
                        'slug',
                        'end_subscription'
                    ]);
                },
                'FirstPosts.Users.Groups' => function ($q) {
                    return $q->select(['id', 'name', 'css', 'is_staff', 'is_member']);
                },
            ])
            ->where([
                'ForumThreads.thread_open' => 1,
                'ForumThreads.id !=' => $id
            ])
            ->order(['ForumThreads.created' => 'DESC'])
            ->limit(3)
            ->toArray();

        $prefix = isset($this->request['prefix']) ? $this->request['prefix'] . '/' : '';
        $controller = $prefix . $this->request['controller'];
        $action = $this->request['action'];

        $online = $this->Sessions
            ->find('expires')
            ->where([
                'Sessions.controller' => $controller,
                'Sessions.action' => $action,
                'Sessions.params' => serialize($this->request->pass)
            ])
            ->count();

        $this->set(compact('suggestions', 'online'));
    }

    /**
     * Display the sidebar.
     *
     * @return \Cake\Network\Response
     */
    public function sidebar()
    {
        $this->loadModel('Sessions');
        $this->loadModel('ForumThreads');

        $staffOnline = $this->Sessions
            ->find('expires')
            ->contain([
                'Users' => function ($q) {
                    return $q->find('full');
                },
                'Users.Groups'
            ])
            ->toArray();

        foreach ($staffOnline as $key => $staff) {
            if ((isset($staff->user) && isset($staff->user->group) && $staff->user->group->is_staff == false) || !isset($staff->user)) {
                unset($staffOnline[$key]);
            }
        }

        //5 last threads created
        $lastThreads = $this->ForumThreads
            ->find()
            ->contain([
                'Users' => function ($q) {
                    return $q->find('full');
                },
                'Users.Groups'
            ])
            ->order([
                'ForumThreads.created' => 'DESC'
            ])
            ->limit(Configure::read('Forum.Sidebar.latest_threads'));

        $this->set(compact('staffOnline', 'lastThreads'));
    }
}
