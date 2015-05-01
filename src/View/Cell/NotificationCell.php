<?php
namespace App\View\Cell;

use Cake\Core\Configure;
use Cake\View\Cell;

class NotificationCell extends Cell
{
    /**
     * Display the notifications.
     *
     * @return \Cake\Network\Response
     */
    public function notifications()
    {
        $this->loadModel('Notifications');

        $notifications = $this->Notifications
            ->find()
            ->where([
                'user_id' => $this->request->session()->read('Auth.User.id')
            ])
            ->order([
                'is_read' => 'ASC',
                'created' => 'DESC'
            ])
            ->limit(Configure::read('User.max_notifications'))
            ->find('map', [
                'session' => $this->request->session()
            ])
            ->toArray();

        $statistics = [
            'read' => 0,
            'unread' => 0
        ];

        //A map function to count the read/unread notifications
        $map = function ($v) {
            if ($v->is_read == 0) {
                return 'unread';
            } else {
                return 'read';
            }
        };

        $statistics = array_merge(
            $statistics,
            array_count_values(
                array_map(
                    $map,
                    $notifications
                )
            )
        );

        $hasNewNotifs = ($statistics['unread'] >= 1) ? true : false;

        $this->set(compact('notifications', 'statistics', 'hasNewNotifs'));
    }
}
