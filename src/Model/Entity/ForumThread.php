<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ForumThread Entity.
 */
class ForumThread extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'category_id' => true,
        'user_id' => true,
        'title' => true,
        'reply_count' => true,
        'view_count' => true,
        'thread_open' => true,
        'first_post_id' => true,
        'last_post_date' => true,
        'last_post_id' => true,
        'last_post_user_id' => true,
        'category' => true,
        'user' => true,
        'first_post' => true,
        'last_post' => true,
        'last_post_user' => true,
    ];
}
