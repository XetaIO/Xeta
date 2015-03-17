<?php
namespace App\Controller\Component\Chat;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\I18n\Time;

class UserComponent extends Component {

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
 * Handle a connected User.
 *
 * @return false|void
 */
	public function handleUsers() {
		if (!$this->_controller->Auth->user()) {
			return false;
		}

		$this->_controller->loadModel('ChatOnline');

		//Check if the User is in Online List.
		$user = $this->_controller->ChatOnline
			->find()
			->where(['ChatOnline.user_id' => $this->_controller->Auth->user('id')])
			->select([
				'ChatOnline.id',
				'ChatOnline.user_id'
			])
			->first();

		if (is_null($user)) {
			$this->_controller->loadModel('Users');
			$user = $this->_controller->Users
				->find()
				->contain([
					'Groups' => function ($q) {
						return $q->select(['id', 'name', 'css', 'is_staff', 'is_member']);
					}
				])
				->select([
					'Users.id',
					'Users.end_subscription',
					'Users.username',
					'Users.slug',
					'Users.group_id'
				])
				->where(['Users.id' => $this->_controller->Auth->user('id')])
				->first();

			$data = [];
			$data['user_id'] = $user->id;
			$data['username'] = $user->username;
			$data['group_id'] = $user->group_id;
			$data['slug'] = $user->slug;
			$data['css'] = $user->group_css;

			$entity = $this->_controller->ChatOnline->newEntity($data);
			$this->_controller->ChatOnline->save($entity);
		} else {
			$timeOut = Time::now();
			$timeOut = Configure::read('Chat.usersTimeOut') > 1 ? $timeOut->subSeconds(Configure::read('Chat.usersTimeOut')) : $timeOut->subSecond(1);

			//We check if the user has been offline for a while to update all
			//his information, it will limit the SQL request in the database.
			if ($timeOut > $user->modified) {
				$this->_controller->loadModel('Users');
				$refreshUser = $this->_controller->Users
					->find()
					->contain([
						'Groups' => function ($q) {
							return $q->select(['id', 'name', 'css', 'is_staff', 'is_member']);
						}
					])
					->select([
						'Users.id',
						'Users.end_subscription',
						'Users.username',
						'Users.slug',
						'Users.group_id'
					])
					->where(['Users.id' => $this->_controller->Auth->user('id')])
					->first();

				$user->css = $refreshUser->group_css;
				$user->username = $refreshUser->username;
				$user->group_id = $refreshUser->group_id;
				$user->slug = $refreshUser->slug;
				$user->modified = Time::now();
			} else {
				$user->modified = Time::now();
			}

			$this->_controller->ChatOnline->save($user);
		}
	}

/**
 * Check if an user is banned or not.
 *
 * @return array
 */
	public function isBanned() {
		$this->_controller->loadModel('ChatBans');

		$array = [
			'banned' => false
		];

		$banned = $this->_controller->ChatBans
			->find()
			->where(['ChatBans.user_id' => $this->_controller->Auth->user('id')])
			->first();

		if (!is_null($banned) && ($banned->forever === true || $banned->end_date > Time::now())) {
			$array['banned'] = true;
			$array['end'] = ($banned->forever === true) ? 'forever' : $banned->end_date;
			$array['reason'] = $banned->reason;

			return $array;
		}

		return $array;
	}
}
