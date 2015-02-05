<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class ForumCategory extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'*' => true
	];

/**
 * Get the number of child for this node.
 *
 * @return int
 */
	protected function _getChildCount() {
		$category = TableRegistry::get('ForumCategories');
		return $category->childCount($this);
	}
}
