<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ForumCategory Entity.
 */
class ForumCategory extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'description' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'parent_forum_category' => true,
        'child_forum_categories' => true,
    ];
}
