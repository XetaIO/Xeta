<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Response;

class PremiumController extends AppController {

/**
 * BeforeFilter handle.
 *
 * @param Event $event The beforeFilter event that was fired.
 *
 * @return void
 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow(['index']);
	}

/**
 * Download an attachment realated to an article.
 *
 * @return \Cake\Network\Response|void
 */
	public function index() {
		$this->loadModel('Users');

		$user = null;

		if ($this->request->session()->read('Auth.User.id')) {
			$user = $this->Users->get($this->request->session()->read('Auth.User.id'));
		}

		$this->set(compact('user'));
	}
}
