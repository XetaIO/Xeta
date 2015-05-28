<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ForumCategoriesTracker Entity.
 */
class ForumCategoriesTracker extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'category_id' => true,
        'date' => true,
        'nbunread' => true,
        'user' => true,
        'category' => true,
    ];
}
