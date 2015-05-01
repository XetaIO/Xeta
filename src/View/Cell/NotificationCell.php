<?php
namespace App\View\Cell;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Text;
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
            ->map(function ($notification) {
                $notification->data = unserialize($notification->data);

                switch ($notification->type) {
                    case 'thread.reply':
                        $username = $notification->data['sender']->username;
                        $threadTitle = Text::truncate($notification->data['thread']->title, 50, ['ellipsis' => '...', 'exact' => false]);

                        //Check if the creator of the thread is the current user.
                        if ($notification->data['thread']->user_id === $this->request->session()->read('Auth.User.id')) {
                            $notification->text = __(
                                '<strong>{0}</strong> has replied to your thread <strong>{1}</strong>.',
                                h($username),
                                h($threadTitle)
                            );
                        } else {
                            $notification->text = __(
                                '<strong>{0}</strong> has replied to the thread <strong>{1}</strong>.',
                                h($username),
                                h($threadTitle)
                            );
                        }

                        $notification->link = Router::url(['controller' => 'posts', 'action' => 'go', $notification->data['thread']->last_post_id, 'prefix' => 'forum']);
                        break;

                    case 'thread.lock':
                        $notification->text = __(
                            '<strong>{0}</strong> has locked your thread <strong>{1}</strong>.',
                            h($notification->data['sender']->username),
                            h(Text::truncate($notification->data['thread']->title, 50, ['ellipsis' => '...', 'exact' => false]))
                        );

                        $notification->link = Router::url([
                            '_name' => 'forum-threads',
                            'id' => $notification->data['thread']->id,
                            'slug' => $notification->data['thread']->title,
                            'prefix' => 'forum'
                        ]);
                        break;

                    case 'post.like':
                        $notification->text = __(
                            '<strong>{0}</strong> has liked your post in <strong>{1}</strong>.',
                            h($notification->data['sender']->username),
                            h(Text::truncate($notification->data['post']->forum_thread->title, 50, ['ellipsis' => '...', 'exact' => false]))
                        );

                        $notification->link = Router::url(['controller' => 'posts', 'action' => 'go', $notification->data['post']->id, 'prefix' => 'forum']);
                        break;
                }

                return $notification;
            })
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
