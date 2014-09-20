<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\Number;

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
	public function _getArticleCountFormat() {
		return Number::format($this->article_count, ['places' => 0, 'locale' => 'fr_FR']);
	}
}
