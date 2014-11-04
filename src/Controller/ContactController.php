<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use Cake\Validation\Validator;

class ContactController extends AppController {

/**
 * Beforefilter.
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
 * Contact page.
 *
 * @return \Cake\Network\Response|void
 */
	public function index() {
		$contact = [
			'schema' => [
				'name' => [
					'type' => 'string',
					'length' => 100
				],
				'email' => [
					'type' => 'string',
					'length' => 100
				],
				'subject' => [
					'type' => 'string',
					'length' => 255
				],
				'message' => [
					'type' => 'string'
				]
			],
			'required' => [
				'name' => 1,
				'email' => 1,
				'message' => 1
			]
		];

		if ($this->request->is('post')) {

			$validator = new Validator();
			$validator
				->validatePresence('email')
				->notEmpty('email', __('You need to put your E-mail.'))
				->add('email', 'validFormat', [
					'rule' => 'email',
					'message' => __("You must specify a valid E-mail address.")
				])
				->validatePresence('name')
				->notEmpty('name', __('You need to put your name.'))

				->validatePresence('message')
				->notEmpty('message', __("You need to give a message."))
				->add('message', 'minLength', [
					'rule' => ['minLength', 10],
					'message' => __("Your message can not contain less than {0} characters.", 10)
				]);

			$contact['errors'] = $validator->errors($this->request->data());

			if (empty($contact['errors'])) {
				$viewVars = [
					'ip' => $this->request->clientIp()
				];

				$viewVars = array_merge($this->request->data(), $viewVars);

				$email = new Email();
				$email->profile('default')
					->template('contact')
					->emailFormat('html')
					->from(['contact@xeta.io' => 'Contact Form'])
					->to(Configure::read('Author.email'))
					->subject(($viewVars['subject']) ? $viewVars['subject'] : 'Someone has contacted you')
					->viewVars($viewVars)
					->send();

				$this->Flash->success(__("Your message has been sent successfully, you will get a response shortly !"));

				return $this->redirect('/');
			}
		}

		$this->set(compact('contact'));
	}
}
