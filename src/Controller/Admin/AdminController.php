<?php
namespace App\Controller\Admin;


use App\Controller\AppController;
use Cake\Error\NotFoundException;
use Cake\Event\Event;

class AdminController extends AppController {

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
		parent::beforeFilter($event);

		if (!$this->Auth->user() || $this->Auth->user('role') != 'admin') {
			throw new NotFoundException;
		}

		$this->layout = 'admin';
	}

/**
 * Index page.
 *
 * @return void
 */
	public function home() {
	}
}
