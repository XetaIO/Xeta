<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Error\NotFoundException;
use Cake\Event\Event;

class AppController extends Controller {

/**
 * Components.
 *
 * @var array
 */
	public $components = [
		'Flash',
		'Session',
		'Cookie',
		'Csrf' => [
			'secure' => true
		],
		'Auth' => [
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
				'inputContainer' => '{{content}}',
				'inputContainerError' => '{{content}}{{error}}'
			]
		]
	];

/**
 * isAuthorized handle.
 *
 * @param array $user The current user.
 *
 * @return void
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
		if (isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
			$this->layout = 'admin';
		}

		$allowCookies = $this->Cookie->check('allowCookies');
		$this->set(compact('allowCookies'));
	}
}
