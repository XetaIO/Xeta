<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Conversation Entity.
 */
class Conversation extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'title' => true,
        'open_invite' => true,
        'conversation_open' => true,
        'reply_count' => true,
        'recipient_count' => true,
        'first_message_id' => true,
        'last_message_date' => true,
        'last_message_id' => true,
        'last_message_user_id' => true,
        'users' => true,
        'first_message' => true,
        'last_message' => true,
        'last_message_user' => true,
    ];
}
