<?php
namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;

class UsersController extends AppController {

/**
 * BeforeFilter handle.
 *
 * @param Event $event The beforeFilter event that was fired.
 *
 * @return void
 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow(['index', 'logout', 'profile']);
	}

/**
 * Display all Users.
 *
 * @return void
 */
	public function index() {
		$this->paginate = [
			'maxLimit' => Configure::read('User.user_per_page')
		];
		$Users = $this->Users
			->find('full')
			->order([
				'Users.created' => 'desc'
			]);

		$Users = $this->paginate($Users);

		$this->set(compact('Users'));
	}

/**
 * LogIn and register page.
 *
 * @return mixed
 */
	public function login() {
		$userRegister = $this->Users->newEntity($this->request->data);

		if ($this->request->is('post')) {
			$method = ($this->request->data['method']) ? $this->request->data['method'] : false;

			switch ($method)
			{
				case "login":

					$userLogin = $this->Auth->identify();

					if ($userLogin) {
						$this->Auth->setUser($userLogin);

						$user = $this->Users->newEntity($userLogin);
						$user->isNew(false);

						$user->last_login = new Time();
						$user->last_login_ip = $this->request->clientIp();

						$this->Users->save($user);

						return $this->redirect($this->Auth->redirectUrl());
					}

					$this->Flash->error(__("Your username or password doesn't match."));

					break;

				case "register":

					$userRegister->register_ip = $this->request->clientIp();
					$userRegister->last_login_ip = $this->request->clientIp();

					if ($newUser = $this->Users->save($userRegister, ['validate' => 'create'])) {

						$user = $this->Auth->identify();

						if ($user) {
							$this->Auth->setUser($user);
						}

						$this->Flash->success(__("Your account has been created successfully !"));

						return $this->redirect($this->Auth->redirectUrl());
					}

					$this->Flash->error(__("Please, correct your mistake."));

					break;
			}
		} else {

			//Save the referer URL before the user send the login/register request else it will delete the referer.
			$this->Session->write('Auth.redirect', $this->referer());
		}

		if ($this->Auth->user()) {
			return $this->redirect($this->Auth->redirectUrl());
		}

		$this->set(compact('userRegister'));
	}

/**
 * LogOut an user.
 *
 * @return void
 */
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

/**
 * Page to configure our account.
 *
 * @return void
 */
	public function account() {
		$User = $this->Users->get($this->Auth->user('id'));

		if ($this->request->is(['post', 'put'])) {
			$User->accessible('avatar_file', true);
			$this->Users->patchEntity($User, $this->request->data());

			if ($this->Users->save($User, ['validate' => 'account'])) {
				$this->Flash->success(__("Your information has been updated !"));
			}
		}

		$this->set(compact('User'));
	}

/**
 * Page to configure our settings.
 *
 * @return mixed
 */
	public function settings() {
		$User = $this->Users->get($this->Auth->user('id'));

		$oldEmail = $User->email;

		if ($this->request->is(['post', 'put'])) {
			$method = ($this->request->data['method']) ? $this->request->data['method'] : false;

			switch ($method)
			{
				case "email":

					if (!isset($this->request->data['email'])) {
						$this->set(compact('User', 'oldEmail'));
						return $this->redirect(['action' => 'settings']);
					}

					$check = $this->Users
						->find()
						->where(['email' => $this->request->data['email']])
						->first();

					if (!is_null($check) || $oldEmail == $this->request->data['email']) {
						$this->set(compact('User', 'oldEmail'));
						return $this->Flash->error(__("This E-mail is already use or you don't have provided a new E-mail."));
					}

					$this->Users->patchEntity($User, $this->request->data());

					if ($this->Users->save($User, ['validate' => 'settings'])) {
						$oldEmail = $this->request->data['email'];

						$this->Flash->success(__("Your E-mail has been changed !"));
					}
					break;

				case "password":

					$data = $this->request->data;
					if (!isset($data['old_password']) || !isset($data['password']) || !isset($data['password_confirm'])) {
						$this->set(compact('User', 'oldEmail'));
						return $this->Flash->error(__("Please, complete all fields !"));
					}

					if (!(new DefaultPasswordHasher)->check($data['old_password'], $User->password)) {
						$this->set(compact('User', 'oldEmail'));
						return $this->Flash->error(__("Your old password don't match !"));
					}

					$this->Users->patchEntity($User, $this->request->data());
					if ($this->Users->save($User, ['validate' => 'settings'])) {

						$this->Flash->success(__("Your password has been changed !"));
					}
					break;
			}
		}

		$this->set(compact('User', 'oldEmail'));
	}

/**
 * View a profile page of an user.
 *
 * @return void
 */
	public function profile() {
		$User = $this->Users
			->find('slug', [
				'slug' => $this->request->slug,
				'slugField' => 'Users.slug'
			])
			->contain([
				'BlogArticles' => function($q) {
						return $q
							->limit(Configure::read('User.Profile.max_articles'));
				},
				'BlogArticlesComments' => function($q) {
						return $q
							->limit(Configure::read('User.Profile.max_comments'));
				},
				'BlogArticlesLikes' => function($q) {
						return $q
							->limit(Configure::read('User.Profile.max_likes'));
				},
			])
			->first();

		if (is_null($User)) {
			$this->Flash->error(__('This user doesn\'t exist or has been deleted.'));

			return $this->redirect(['controller' => 'pages', 'action' => 'home']);
		}

		$this->set(compact('User'));
	}
}
