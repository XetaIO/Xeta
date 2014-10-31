<?php
namespace App\Model\Entity;

use Cake\I18n\Number;
use Cake\ORM\Entity;

class BlogCategory extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'*' => true
	];

/**
 * Get the number of articles formatted.
 *
 * @return string
 */
	protected function _getArticleCountFormat() {
		return Number::format($this->article_count);
	}
}
