<?php
namespace App\Event\Forum;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

class Notifications implements EventListenerInterface
{

    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Model.Notifications.new' => 'newNotification',
            'Model.Notifications.dispatch' => 'dispatchNotification'
        ];
    }

    /**
     * We send a new notification to an user.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return false
     */
    public function newNotification(Event $event)
    {
        $this->Notifications = TableRegistry::get('Notifications');

        if (!isset($event->data['type'])) {
            return false;
        }
        $event->data['type'] = strtolower($event->data['type']);

        switch($event->data['type']) {
            case 'thread.reply':
                if (!is_integer($event->data['thread_id'])) {
                    return false;
                }

                $this->ForumThreads = TableRegistry::get('ForumThreads');
                $this->Users = TableRegistry::get('Users');

                $thread = $this->ForumThreads
                    ->find()
                    ->where([
                        'ForumThreads.id' => $event->data['thread_id']
                    ])
                    ->select([
                        'id', 'user_id', 'title', 'last_post_id'
                    ])
                    ->first();

                $sender = $this->Users
                    ->find('medium')
                    ->where([
                        'Users.id' => $event->data['sender_id']
                    ])
                    ->first();

                $data = [];
                $data['user_id'] = $event->data['follower']->user->id;
                $data['type'] = $event->data['type'];
                $data['data'] = serialize(['sender' => $sender, 'thread' => $thread]);

                $entity = $this->Notifications->newEntity($data);
                $this->Notifications->save($entity);

                return true;
                break;

            case 'thread.lock':
                if (!is_integer($event->data['thread_id'])) {
                    return false;
                }

                $this->ForumThreads = TableRegistry::get('ForumThreads');
                $this->Users = TableRegistry::get('Users');

                $thread = $this->ForumThreads
                    ->find()
                    ->where([
                        'ForumThreads.id' => $event->data['thread_id']
                    ])
                    ->select([
                        'id', 'user_id', 'title', 'last_post_id'
                    ])
                    ->first();

                //Prevent for users who lock their thread.
                if ($event->data['sender_id'] === $thread->user_id) {
                    return true;
                }

                $sender = $this->Users
                    ->find('medium')
                    ->where([
                        'Users.id' => $event->data['sender_id']
                    ])
                    ->first();

                $data = [];
                $data['user_id'] = $thread->user_id;
                $data['type'] = $event->data['type'];
                $data['data'] = serialize(['sender' => $sender, 'thread' => $thread]);

                $entity = $this->Notifications->newEntity($data);
                $this->Notifications->save($entity);

                return true;
                break;

            case 'post.like':
                if (!is_integer($event->data['post_id'])) {
                    return false;
                }

                $this->ForumPosts = TableRegistry::get('ForumPosts');
                $this->Users = TableRegistry::get('Users');

                $post = $this->ForumPosts
                    ->find()
                    ->where([
                        'ForumPosts.id' => $event->data['post_id']
                    ])
                    ->contain([
                        'ForumThreads' => function ($q) {
                            return $q->select(['id', 'title']);
                        }
                    ])
                    ->select([
                        'ForumPosts.id',
                        'ForumPosts.user_id',
                        'ForumPosts.thread_id'
                    ])
                    ->first();

                //Prevent for users who like their post.
                if ($event->data['sender_id'] === $post->user_id) {
                    return true;
                }

                $sender = $this->Users
                    ->find('medium')
                    ->where([
                        'Users.id' => $event->data['sender_id']
                    ])
                    ->first();

                $data = [];
                $data['user_id'] = $post->user_id;
                $data['type'] = $event->data['type'];
                $data['data'] = serialize(['sender' => $sender, 'post' => $post]);

                $entity = $this->Notifications->newEntity($data);
                $this->Notifications->save($entity);

                return true;
                break;
        }
    }

    /**
     * A user want to follow a thread.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return false
     */
    public function dispatchNotification(Event $event)
    {
        $this->Followers = TableRegistry::get('ForumThreadsFollowers');

        $followers = $this->Followers
            ->find()
            ->where([
                'ForumThreadsFollowers.thread_id' => $event->data['thread_id']
            ])
            ->contain([
                'ForumThreads' => function ($q) {
                    return $q->select([
                        'id', 'title', 'last_post_id'
                    ]);
                },
                'Users' => function ($q) {
                    return $q->select([
                        'id'
                    ]);
                }
            ])
            ->select([
                'ForumThreadsFollowers.id',
                'ForumThreadsFollowers.thread_id',
                'ForumThreadsFollowers.user_id'
            ])
            ->toArray();

        if (is_null($followers)) {
            return true;
        }

        foreach ($followers as $follower) {
            if ($follower->user_id != $event->data['sender_id']) {
                $event->data['follower'] = $follower;

                $result = $this->newNotification($event);
            }
        }

        return true;
    }
}
