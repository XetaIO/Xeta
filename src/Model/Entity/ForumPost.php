<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ForumPost Entity.
 */
class ForumPost extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'thread_id' => true,
        'user_id' => true,
        'message' => true,
        'likes' => true,
        'last_edit_date' => true,
        'last_edit_user_id' => true,
        'edit_count' => true,
        'thread' => true,
        'user' => true,
        'last_edit_user' => true,
    ];
}
