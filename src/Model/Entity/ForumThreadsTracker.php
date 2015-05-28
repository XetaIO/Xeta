<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ForumThreadsTracker Entity.
 */
class ForumThreadsTracker extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'category_id' => true,
        'thread_id' => true,
        'user_id' => true,
        'date' => true,
        'category' => true,
        'thread' => true,
        'user' => true,
    ];
}
