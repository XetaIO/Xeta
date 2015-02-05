<?php
namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\I18n\Number;
use Cake\ORM\Entity;
use HTMLPurifier;
use HTMLPurifier_Config;

class ForumThread extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'*' => true
	];

/**
 * Get the number of threads.
 *
 * @return int
 */
	protected function _getThreadCount($threads) {
		return Number::format($threads);
	}
}
