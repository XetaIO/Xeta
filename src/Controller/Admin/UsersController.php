<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

class UsersController extends AppController {

/**
 * Search users form.
 *
 * @return void
 */
	public function index() {
	}

/**
 * Search users.
 *
 * @return void
 */
	public function search() {
		//Keyword to search. (For pagination)
		if (!empty($this->request->data['search'])) {
			$keyword = $this->request->data['search'];
			$this->request->session()->write('Search.Admin.Users.Keyword', $keyword);
		} else {

			if ($this->request->session()->read('Search.Admin.Users.Keyword')) {
				$keyword = $this->request->session()->read('Search.Admin.Users.Keyword');
			} else {

				$keyword = '';
			}
		}

		//Search type. (For pagination)
		if (!empty($this->request->data['type'])) {
			$type = $this->request->data['type'];
			$this->request->session()->write('Search.Admin.Users.Type', $type);
		} else {

			if ($this->request->session()->read('Search.Admin.Users.Type')) {
				$type = $this->request->session()->read('Search.Admin.Users.Type');
			} else {

				$type = '';
			}
		}

		switch($type) {
			case "username":
				$this->paginate = [
					'limit' => 15,
					'conditions' => [
						'Users.username LIKE' => "%$keyword%"
					],
					'order' => [
						'Users.username' => 'asc'
					]
				];
			break;

			case "ip":
				$this->paginate = [
					'limit' => 15,
					'conditions' => [
						'Users.last_login_ip LIKE' => "%$keyword%"
					],
					'order' => [
						'Users.last_login_ip' => 'asc'
					]
				];
			break;

			case "mail":
				$this->paginate = [
					'limit' => 15,
					'conditions' => [
						'Users.email LIKE' => "%$keyword%"
					],
					'order' => [
						'Users.email' => 'asc'
					]
				];
			break;

			default:
				$this->paginate = [
					'limit' => 15,
					'conditions' => [
						'Users.username LIKE' => "%$keyword%"
					],
					'order' => [
						'Users.username' => 'asc'
					]
				];
		}

		$users = $this->paginate($this->Users->find());
		$this->set(compact('users', 'keyword', 'type'));
	}

/**
 * Edit an user.
 *
 * @return \Cake\Network\Response|void
 */
	public function edit() {
		$user = $this->Users
			->find('slug', [
				'slug' => $this->request->slug,
				'slugField' => 'Users.slug'
			])
			->first();

		//Check if the user is found.
		if (empty($user)) {
			$this->Flash->error(__('This user doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		if ($this->request->is('put')) {
			$this->Users->patchEntity($user, $this->request->data());

			if ($this->Users->save($user, ['validate' => 'update'])) {

				$this->Flash->success(__("This user has been updated successfully !"));

				return $this->redirect(['action' => 'index']);
			}
		}

		$this->set(compact('user'));
	}

/**
 * Delete an user and all his articles, comments and likes.
 *
 * @return \Cake\Network\Response
 */
	public function delete() {
		$user = $this->Users
			->find('slug', [
				'slug' => $this->request->slug,
				'slugField' => 'Users.slug'
			])
			->first();

		//Check if the user is found.
		if (empty($user)) {
			$this->Flash->error(__('This user doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		if ($this->Users->delete($user)) {

			$this->Flash->success(__("This user has been deleted successfully !"));

			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->error(__("Unable to delete this user."));

		return $this->redirect(['action' => 'index']);
	}

/**
 * Delete an avatar.
 *
 * @return \Cake\Network\Response
 */
	public function deleteAvatar() {
		$user = $this->Users
			->find('slug', [
				'slug' => $this->request->slug,
				'slugField' => 'Users.slug'
			])
			->first();

		//Check if the user is found.
		if (empty($user)) {
			$this->Flash->error(__('This user doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		$user->avatar = '../img/avatar.png';

		if ($this->Users->save($user)) {

			$this->Flash->success(__("His avatar has been deleted successfully !"));

			return $this->redirect($this->referer());
		}

		$this->Flash->error(__("Unable to delete his avatar."));

		return $this->redirect($this->referer());
	}
}
