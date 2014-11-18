<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use HTMLPurifier;
use HTMLPurifier_Config;

class User extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'role' => false,
		'*' => true
	];

/**
 * Hash the password before to save.
 *
 * @param string $password Password to be hashed.
 *
 * @return string
 */
	protected function _setPassword($password) {
		return (new DefaultPasswordHasher)->hash($password);
	}

/**
 * Get the full name of the user. If empty, return the username.
 *
 * @return string
 */
	protected function _getFullName() {
		$fullName = trim($this->first_name . ' ' . $this->last_name);
		return (!empty($fullName)) ? $fullName : $this->username;
	}

/**
 * Purify the biography.
 *
 * @param string $biography The biography to be purify.
 *
 * @return string
 */
	protected function _getBiography($biography) {
		$config = HTMLPurifier_Config::createDefault();
		$config->loadArray(Configure::read('HtmlPurifier.User.biography'));

		$HTMLPurifier = new HTMLPurifier($config);

		return $HTMLPurifier->purify($biography);
	}

/**
 * Purify the signature.
 *
 * @param string $signature The signature to be purify.
 *
 * @return string
 */
	protected function _getSignature($signature) {
		$config = HTMLPurifier_Config::createDefault();
		$config->loadArray(Configure::read('HtmlPurifier.User.signature'));

		$HTMLPurifier = new HTMLPurifier($config);

		return $HTMLPurifier->purify($signature);
	}

/**
 * Set if the user is premium or not.
 *
 * @return bool
 */
	protected function _getPremium() {
		return $this->end_subscription > new Time();
	}

}
