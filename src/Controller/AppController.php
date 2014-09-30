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
		'Csrf' => [
			'secure' => true
		],
		'Auth' => [
			'loginAction' => [
				'controller' => 'users',
				'action' => 'login'
			],
			'loginRedirect' => [
				'controller' => 'Pages',
				'action' => 'home'
			],
			'logoutRedirect' => [
				'controller' => 'Pages',
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
 * BeforeFilter handle.
 *
 * @param Event $event The beforeFilter event that was fired.
 *
 * @throws \Cake\Error\NotFoundException When the user has not the required rank.
 *
 * @return void
 */
	public function beforeFilter(Event $event) {
		if (isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {

			if (!$this->Auth->user()) {
				return $this->redirect(['controller' => 'users', 'action' => 'login', 'prefix' => false]);
			}

			if ($this->Auth->user('role') != 'admin') {
				throw new NotFoundException;
			}

			$this->layout = 'admin';
		}
	}
}
