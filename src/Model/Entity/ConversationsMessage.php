<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ConversationsMessage Entity.
 */
class ConversationsMessage extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'conversation_id' => true,
        'user_id' => true,
        'message' => true,
        'conversation' => true,
        'user' => true,
    ];
}
