<?php
namespace App\Controller\Component;

use App\Model\Entity\User;
use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

class SessionsActivityComponent extends Component {

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
 * Initialize properties.
 *
 * @param array $config The config data.
 * @return void
 */
	public function initialize(array $config) {
		$controller = $this->_registry->getController();
		$this->_request = $controller->request;
		$this->_session = $controller->request->session();
	}

/**
 * [beforeRender description]
 *
 * @param Event $event [description]
 *
 * @return void
 */
	public function beforeRender(Event $event) {
		if (empty($this->_session->id())) {
			$this->_session->write('Session.initialize', 1);
			return;
		}
		$this->Sessions = TableRegistry::get('Sessions');

		$prefix = isset($this->_request['prefix']) ? $this->_request['prefix'] . '/' : '';
		$controller = $prefix . $this->_request['controller'];
		$action = $this->_request['action'];
		$params = serialize($this->_request->pass);

		$userId = $this->_session->read('Auth.User.id');
		$record = compact('controller', 'action', 'params');
		$record['user_id'] = $userId;

		$record[$this->Sessions->primaryKey()] = $this->_session->id();
		$result = $this->Sessions->save(new Entity($record));
	}

/**
 * Get the list of the users online.
 *
 * @return array
 */
	public function getOnlineUsers() {
		$this->Sessions = TableRegistry::get('Sessions');

		$output = [
			'guests' => 0,
			'members' => 0,
		];

		$records = $this->Sessions
			->find('expires')
			->contain([
				'Users' => function ($q) {
					return $q->find('short');
				},
				'Users.Groups' => function ($q) {
					return $q->select(['css']);
				},
			])
			->select(['Sessions.user_id', 'Sessions.expires'])
			->toArray();

		foreach ($records as $key => $record) {
			if (is_null($record->user_id)) {
				$output['guests']++;

				unset($records[$key]);
				continue;
			} else {
				$output['members']++;
			}
		}

		//Total visitors.
		$output['total'] = $output['guests'] + $output['members'];

		//Visitor records.
		$output['records'] = $records;

		return $output;
	}

/**
 * Determine if the given user is online or offline.
 *
 * @param App\Model\Entity\User $user The user to check.
 *
 * @return bool
 */
	public function getOnlineStatus(User $user) {
		if (empty($user)) {
			return false;
		}

		$this->Sessions = TableRegistry::get('Sessions');
		$online = $this->Sessions
			->find('expires')
			->select(['Sessions.expires', 'Sessions.user_id'])
			->where([
				'Sessions.user_id' => $user->id
			])
			->first();

		if (!empty($online)) {
			return true;
		}

		return false;
	}

}
