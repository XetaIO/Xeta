<?php
namespace App\Controller;

use Cake\Controller\Controller;
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
}
