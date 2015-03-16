<?php
namespace App\Controller\Component\Forum;

use Cake\Controller\Component;

class AntiSpamComponent extends Component {

/**
 * Default config.
 *
 * AntiSpam rules used to check before to post a comment or
 * before to create a thread on the forum. (In minutes)
 *
 * staff : Ignore staff (With group key is_staff)
 * Default : true
 *
 * @var array
 */
	protected $_defaultConfig = [
		'rules' => [
			'ForumPosts' => 5,
			'ForumThreads' => 5
		],
		'staff' => true
	];

/**
 * Request object
 *
 * @var \Cake\Network\Request
 */
	protected $_request;

/**
 * Instance of the Session object
 *
 * @return void
 */
	protected $_session;

/**
 * Instance of the Controller object
 *
 * @return void
 */
	protected $_controller;

/**
 * The type of the spam to check
 *
 * @var array
 */
	protected $_types = [
		'post',
		'thread'
	];

/**
 * Initialize properties.
 *
 * @param array $config The config data.
 *
 * @return void
 */
	public function initialize(array $config) {
		$controller = $this->_registry->getController();
		$this->_controller = $controller;
		$this->_request = $controller->request;
		$this->_session = $controller->request->session();
	}

/**
 * Check if an user is not spamming.
 *
 * @param string $type The type of the check.
 * @param array $user The user to check. If empty, the current logged-in user will be used.
 *
 * @throws \Exception When the type is unknown.
 *
 * @return bool
 */
	public function check($type, array $user = []) {
		if (empty($user) || !is_array($user)) {
			$user = $this->_session->read('Auth.User');
		}

		if (!array_key_exists($type, $this->config()['rules'])) {
			throw new \Exception(__('The type "{0}" to check is not defined.', $type));
		}

		$config = $this->config();

		if ($config['staff'] === true) {
			$this->_controller->loadModel('Groups');

			$group = $this->_controller->Groups
				->find()
				->select(['Groups.id', 'Groups.is_staff'])
				->where(['Groups.id' => $user['group_id']])
				->first();

			if (!is_null($group) && $group->is_staff == true) {
				return true;
			}
		}

		$this->_controller->loadModel($type);
		$expire = time() - (60 * $config['rules'][$type]);

		$last = $this->_controller->{$type}
			->find()
			->select([$type . '.user_id', $type . '.created'])
			->where([$type . '.user_id' => $user['id']])
			->order([$type . '.created' => 'DESC'])
			->first();

		if (!is_null($last) && $last->created->timestamp > $expire) {
			return false;
		}

		return true;
	}
}
