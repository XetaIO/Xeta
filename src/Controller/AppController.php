<?php
namespace App\Controller;

use App\Event\Badges;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Time;

class AppController extends Controller {

/**
 * Components.
 *
 * @var array
 */
	public $components = [
		'Flash',
		'Cookie',
		'Csrf' => [
			'secure' => true
		],
		'Auth' => [
			'authenticate' => [
				'Form',
				'Xety/Cake3CookieAuth.Cookie'
			],
			'authorize' => ['Controller'],
			'loginAction' => [
				'controller' => 'users',
				'action' => 'login',
				'prefix' => false
			],
			'unauthorizedRedirect' => [
				'controller' => 'pages',
				'action' => 'home',
				'prefix' => false
			],
			'loginRedirect' => [
				'controller' => 'pages',
				'action' => 'home'
			],
			'logoutRedirect' => [
				'controller' => 'pages',
				'action' => 'home'
			]
		]
	];

/**
 * Helpers.
 *
 * @var array
 */
	public $helpers = [
		'Form' => [
			'templates' => [
				'error' => '<div class="text-danger">{{content}}</div>',
				'radioWrapper' => '{{input}}{{label}}',
				'nestingLabel' => '<label{{attrs}}>{{text}}</label>',
			]
		]
	];

/**
 * isAuthorized handle.
 *
 * @param array $user The current user.
 *
 * @return bool
 */
	public function isAuthorized($user) {
		if (!isset($this->request->params['prefix'])) {
			return true;
		}

		// Admin can access every action
		if (isset($user['role']) && $user['role'] === 'admin') {
			return true;
		}

		// Default deny
		return false;
	}

/**
 * beforeFilter handle.
 *
 * @param Event $event The beforeFilter event that was fired.
 *
 * @return void
 */
	public function beforeFilter(Event $event) {
		//Automaticaly Login.
		if (!$this->Auth->user() && $this->Cookie->read('CookieAuth')) {
			$this->loadModel('Users');

			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);

				$user = $this->Users->newEntity($user);
				$user->isNew(false);

				$user->last_login = new Time();
				$user->last_login_ip = $this->request->clientIp();

				$this->Users->save($user);

				//Event.
				$this->eventManager()->attach(new Badges($this));

				$user = new Event('Model.Users.register', $this, [
					'user' => $user
				]);
				$this->eventManager()->dispatch($user);
			} else {
				$this->Cookie->delete('CookieAuth');
			}
		}

		if (isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
			$this->layout = 'admin';
		}

		$allowCookies = $this->Cookie->check('allowCookies');
		$this->set(compact('allowCookies'));
	}
}
