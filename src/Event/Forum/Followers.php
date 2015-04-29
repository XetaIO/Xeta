<?php
namespace App\Event\Forum;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

class Followers implements EventListenerInterface
{

    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Model.ForumThreadsFollowers.new' => 'newFollower'
        ];
    }

    /**
     * A user want to follow a thread.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return false
     */
    public function newFollower(Event $event)
    {
        $this->Followers = TableRegistry::get('ForumThreadsFollowers');

        if (!is_integer($event->data['user_id']) || !is_integer($event->data['thread_id'])) {
            return false;
        }

        $isFollowed = $this->Followers
            ->find()
            ->where([
                'ForumThreadsFollowers.user_id' => $event->data['user_id'],
                'ForumThreadsFollowers.thread_id' => $event->data['thread_id']
            ])
            ->first();

        if (!is_null($isFollowed)) {
            return true;
        }

        $data = [];
        $data['thread_id'] = $event->data['thread_id'];
        $data['user_id'] = $event->data['user_id'];
        $follower = $this->Followers->newEntity($data);

        if ($this->Followers->save($follower)) {
            return true;
        } else {
            return false;
        }
    }
}
