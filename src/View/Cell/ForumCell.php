<?php
namespace App\View\Cell;

use Cake\Core\Configure;
use Cake\View\Cell;

class ForumCell extends Cell {

	public function suggestion() {
		$this->loadModel('Sessions');
		$this->loadModel('ForumThreads');

		$id = isset($this->request->id) ? $this->request->id : null;

		$suggestions = $this->ForumThreads
			->find()
			->contain([
				'FirstPosts',
				'FirstPosts.Users' => function ($q) {
					return $q->select([
						'id',
						'username',
						'slug',
						'end_subscription'
					]);
				},
				'FirstPosts.Users.Groups' => function ($q) {
					return $q->select(['id', 'name', 'css', 'is_staff', 'is_member']);
				},
			])
			->where([
				'ForumThreads.thread_open' => 1,
				'ForumThreads.id !=' => $id
			])
			->limit(3)
			->toArray();

		$prefix = isset($this->request['prefix']) ? $this->request['prefix'] . '/' : '';
		$controller = $prefix . $this->request['controller'];
		$action = $this->request['action'];

		$online = $this->Sessions
			->find('expires')
			->where([
				'Sessions.controller' => $controller,
				'Sessions.action' => $action,
				'Sessions.params' => serialize($this->request->pass)
			])
			->count();

		$this->set(compact('suggestions', 'online'));
	}

	public function sidebar() {
		$this->loadModel('Sessions');

		$staffOnline = $this->Sessions
			->find('expires')
			->contain([
				'Users' => function ($q) {
					return $q->find('full');
				},
				'Users.Groups'
			])
			->toArray();

		foreach ($staffOnline as $key => $staff) {
			if ($staff->user->group->is_staff == false) {
				unset($staffOnline[$key]);
			}
		}

		$this->set(compact('staffOnline'));
	}
}
