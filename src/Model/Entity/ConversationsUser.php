<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ConversationsUser Entity.
 */
class ConversationsUser extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'conversation_id' => true,
        'user_id' => true,
        'is_read' => true,
        'important' => true,
        'conversation' => true,
        'user' => true,
    ];
}
