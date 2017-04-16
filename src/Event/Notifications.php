<?php
namespace App\Event;

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
            'Model.Notifications.dispatch' => 'dispatchParticipants'
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
        $type = $event->getData('type');

        if (is_null($type)) {
            return false;
        }
        $type = strtolower($type);

        switch ($type) {
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
                'ConversationsUsers.conversation_id' => $event->getData('conversation_id')
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
            if ($participant->user_id != $event->getData('sender_id')) {
                $event->setData('participant', $participant);

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
        if (!is_integer($event->getData('conversation_id'))) {
            return false;
        }

        $this->Conversations = TableRegistry::get('Conversations');
        $this->Users = TableRegistry::get('Users');

        $conversation = $this->Conversations
            ->find()
            ->where([
                'Conversations.id' => $event->getData('conversation_id')
            ])
            ->select([
                'id', 'user_id', 'title', 'last_message_id'
            ])
            ->first();

        $sender = $this->Users
            ->find('medium')
            ->where([
                'Users.id' => $event->getData('sender_id')
            ])
            ->first();

        //Check if this user hasn't already a notification. (Prevent for spam)
        $hasReplied = $this->Notifications
            ->find()
            ->where([
                'Notifications.foreign_key' => $conversation->id,
                'Notifications.type' => $event->getData('type'),
                'Notifications.user_id' => $event->getData('participant')->user->id
            ])
            ->first();

        if (!is_null($hasReplied)) {
            $hasReplied->data = serialize(['sender' => $sender, 'conversation' => $conversation]);
            $hasReplied->is_read = 0;

            $this->Notifications->save($hasReplied);
        } else {
            $data = [];
            $data['user_id'] = $event->getData('participant')->user->id;
            $data['type'] = $event->getData('type');
            $data['data'] = serialize(['sender' => $sender, 'conversation' => $conversation]);
            $data['foreign_key'] = $conversation->id;

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
            ->where(['id' => $event->getData('user_id')])
            ->first();

        if (is_null($user)) {
            return false;
        }

        $data = [];
        $data['user_id'] = $user->id;
        $data['type'] = $event->getData('type');
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
            ->where(['Badges.id' => $event->getData('badge')->badge_id])
            ->first();

        if (is_null($badge)) {
            return false;
        }

        $this->Users = TableRegistry::get('Users');

        $user = $this->Users
            ->find()
            ->where(['id' => $event->getData('badge')->user_id])
            ->select([
                'id'
            ])
            ->first();

        if (is_null($user)) {
            return false;
        }

        $data = [];
        $data['user_id'] = $event->getData('badge')->user_id;
        $data['type'] = $event->getData('type');
        $data['data'] = serialize(['badge' => $badge, 'user' => $user]);

        $entity = $this->Notifications->newEntity($data);
        $this->Notifications->save($entity);

        return true;
    }
}
