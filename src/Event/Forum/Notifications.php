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
            'Model.Notifications.dispatch' => 'dispatchNotification',
            'Model.Notifications.dispatchParticipants' => 'dispatchParticipants'
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
                $result = $this->_threadReply($event);
                break;

            case 'thread.lock':
                $result = $this->_threadLock($event);
                break;

            case 'post.like':
                $result = $this->_postLike($event);
                break;

            case 'conversation.reply':
                $result = $this->_conversationReply($event);
                break;

            case 'bot':
                $result = $this->_bot($event);
                break;

            case 'badge':
                $result = $this->_badge($event);
                break;
            default:
                $result = false;
        }

        return $result;
    }

    /**
     * Dispatch notification for the participants of a conversation.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return false
     */
    public function dispatchParticipants(Event $event)
    {
        $this->ConversationsUsers = TableRegistry::get('ConversationsUsers');

        $participants = $this->ConversationsUsers
            ->find()
            ->where([
                'ConversationsUsers.conversation_id' => $event->data['conversation_id']
            ])
            ->contain([
                'Users' => function ($q) {
                    return $q->select([
                        'id'
                    ]);
                }
            ])
            ->select([
                'ConversationsUsers.id',
                'ConversationsUsers.conversation_id',
                'ConversationsUsers.user_id'
            ])
            ->toArray();

        if (empty($participants)) {
            return true;
        }

        foreach ($participants as $participant) {
            if ($participant->user_id != $event->data['sender_id']) {
                $event->data['participant'] = $participant;

                $this->newNotification($event);
            }
        }

        return true;
    }

    /**
     * Dispatch notification for the followers of a thread.
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

        if (empty($followers)) {
            return true;
        }

        foreach ($followers as $follower) {
            if ($follower->user_id != $event->data['sender_id']) {
                $event->data['follower'] = $follower;

                $this->newNotification($event);
            }
        }

        return true;
    }

    /**
     * A user has replied to a conversation.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    protected function _conversationReply(Event $event)
    {
        if (!is_integer($event->data['conversation_id'])) {
            return false;
        }

        $this->Conversations = TableRegistry::get('Conversations');
        $this->Users = TableRegistry::get('Users');

        $conversation = $this->Conversations
            ->find()
            ->where([
                'Conversations.id' => $event->data['conversation_id']
            ])
            ->select([
                'id', 'user_id', 'title', 'last_message_id'
            ])
            ->first();

        $sender = $this->Users
            ->find('medium')
            ->where([
                'Users.id' => $event->data['sender_id']
            ])
            ->first();


        //Check if this user hasn't already a notification. (Prevent for spam)
        $hasReplied = $this->Notifications
            ->find()
            ->where([
                'Notifications.foreign_key' => $conversation->id,
                'Notifications.type' => $event->data['type'],
                'Notifications.user_id' => $event->data['participant']->user->id
            ])
            ->first();

        if (!is_null($hasReplied)) {
            $hasReplied->data = serialize(['sender' => $sender, 'conversation' => $conversation]);
            $hasReplied->is_read = 0;

            $this->Notifications->save($hasReplied);
        } else {
            $data = [];
            $data['user_id'] = $event->data['participant']->user->id;
            $data['type'] = $event->data['type'];
            $data['data'] = serialize(['sender' => $sender, 'conversation' => $conversation]);
            $data['foreign_key'] = $conversation->id;

            $entity = $this->Notifications->newEntity($data);
            $this->Notifications->save($entity);
        }

        return true;
    }

    /**
     * A user has replied to a thread.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    protected function _threadReply(Event $event)
    {
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


        //Check if this user hasn't already a notification. (Prevent for spam)
        $hasReplied = $this->Notifications
            ->find()
            ->where([
                'Notifications.foreign_key' => $thread->id,
                'Notifications.type' => $event->data['type'],
                'Notifications.user_id' => $event->data['follower']->user->id
            ])
            ->first();

        if (!is_null($hasReplied)) {
            $hasReplied->data = serialize(['sender' => $sender, 'thread' => $thread]);
            $hasReplied->is_read = 0;

            $this->Notifications->save($hasReplied);
        } else {
            $data = [];
            $data['user_id'] = $event->data['follower']->user->id;
            $data['type'] = $event->data['type'];
            $data['data'] = serialize(['sender' => $sender, 'thread' => $thread]);
            $data['foreign_key'] = $thread->id;

            $entity = $this->Notifications->newEntity($data);
            $this->Notifications->save($entity);
        }

        return true;
    }

    /**
     * A user has locked a thread.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    protected function _threadLock(Event $event)
    {
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
    }

    /**
     * A user has liked a post.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    protected function _postLike(Event $event)
    {
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

        //Check if this user hasn't already a notification. (Prevent for spam)
        $hasLiked = $this->Notifications
            ->find()
            ->where([
                'Notifications.foreign_key' => $post->id,
                'Notifications.type' => $event->data['type'],
                'Notifications.user_id' => $post->user_id
            ])
            ->first();

        if (!is_null($hasLiked)) {
            $hasLiked->data = serialize(['sender' => $sender, 'post' => $post]);
            $hasLiked->is_read = 0;

            $this->Notifications->save($hasLiked);
        } else {
            $data = [];
            $data['user_id'] = $post->user_id;
            $data['type'] = $event->data['type'];
            $data['data'] = serialize(['sender' => $sender, 'post' => $post]);
            $data['foreign_key'] = $post->id;

            $entity = $this->Notifications->newEntity($data);
            $this->Notifications->save($entity);
        }

        return true;
    }

    /**
     * A user has sign up on the website.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    protected function _bot(Event $event)
    {
        $this->Users = TableRegistry::get('Users');

        $user = $this->Users
            ->find()
            ->where(['id' => $event->data['user_id']])
            ->first();

        if (is_null($user)) {
            return false;
        }

        $data = [];
        $data['user_id'] = $user->id;
        $data['type'] = $event->data['type'];
        $data['data'] = serialize(['icon' => '../img/notifications/welcome.png']);

        $entity = $this->Notifications->newEntity($data);
        $this->Notifications->save($entity);

        return true;
    }

    /**
     * A user has unlock a badge.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    protected function _badge(Event $event)
    {
        $this->Badges = TableRegistry::get('Badges');
        $this->Notifications = TableRegistry::get('Notifications');

        $badge = $this->Badges
            ->find()
            ->where(['Badges.id' => $event->data['badge']->badge_id])
            ->first();

        if (is_null($badge)) {
            return false;
        }

        $this->Users = TableRegistry::get('Users');

        $user = $this->Users
            ->find()
            ->where(['id' => $event->data['badge']->user_id])
            ->select([
                'id',
                'slug'
            ])
            ->first();

        if (is_null($user)) {
            return false;
        }

        $data = [];
        $data['user_id'] = $event->data['badge']->user_id;
        $data['type'] = $event->data['type'];
        $data['data'] = serialize(['badge' => $badge, 'user' => $user]);

        $entity = $this->Notifications->newEntity($data);
        $this->Notifications->save($entity);

        return true;
    }
}
