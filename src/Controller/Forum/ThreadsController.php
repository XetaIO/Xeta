<?php
namespace App\Controller\Forum;

use App\Controller\AppController;
use App\Event\Badges;
use Cake\I18n\Time;
use Cake\utility\Inflector;

class ThreadsController extends AppController {

	public function edit() {
		$this->loadModel('ForumThreads');

		if ($this->request->is('put')) {
			$thread = $this->ForumThreads
				->find()
				->where([
					'ForumThreads.id' => $this->request->id
				])
				->first();
			debug($thread);
			//Check if the thread is found.
			if (is_null($thread)) {
				$this->Flash->error(__("This thread doesn't exist or has been deleted !"));

				return $this->redirect($this->referer());
			}

			//Check if the user has the permission to edit it.
			if ($this->Auth->isAuthorized() === false) {
				$this->Flash->error(__("You don't have the authorization to edit this post !"));

				return $this->redirect([
					'_name' => 'forum-threads',
					'slug' => Inflector::slug($thread->title, '-'),
					'id' => $thread->id
				]);
			}
			$this->ForumThreads->patchEntity($thread, $this->request->data);

			if ($this->ForumThreads->save($thread)) {

				if ($thread->sticky == true) {
					$this->Flash->success(__('Your thread has been edited and set to sticky successfully !'));
				} else {
					$this->Flash->success(__('Your thread has been edited successfully !'));
				}

				return $this->redirect([
					'_name' => 'forum-threads',
					'slug' => Inflector::slug($thread->title, '-'),
					'id' => $thread->id
				]);
			}

		}

		$this->redirect($this->referer());
	}

/**
 * Reply to a thread.
 *
 * @return \Cake\Network\Response
 */
	public function reply() {
		$this->loadModel('ForumPosts');

		if ($this->request->is('post')) {

			//Build the newEntity for the post form.
			$this->request->data['forum_thread']['id'] = $this->request->params['id'];
			$this->request->data['forum_thread']['last_post_date'] = new Time();
			$this->request->data['forum_thread']['last_post_user_id'] = $this->Auth->user('id');
			$this->request->data['user_id'] = $this->Auth->user('id');
			$this->request->data['thread_id'] = $this->request->id;

			$post = $this->ForumPosts->newEntity($this->request->data, [
				'associated' => ['ForumThreads']
				]);

			if ($post->forum_thread->isNew() === true) {
				$post->forum_thread->isNew(false);
			}

			//Attach Event.
			$this->ForumPosts->eventManager()->attach(new Badges($this));

			if ($newPost = $this->ForumPosts->save($post)) {
				//Update the last post id.
				$this->loadModel('ForumThreads');

				$thread = $this->ForumThreads->get($this->request->params['id']);
				$thread->last_post_id = $newPost->id;
				$this->ForumThreads->save($thread);

				if ($this->request->data['forum_thread']['thread_open'] == false) {
					$this->Flash->success(__('Your reply has been posted successfully and the thread has been closed !'));
				} else {
					$this->Flash->success(__('Your reply has been posted successfully !'));
				}

				//Redirect the user to the last page of the article.
				return $this->redirect([
					'controller' => 'posts',
					'action' => 'go',
					'prefix' => 'forum',
					$newPost->id
				]);
			}
		}

		$this->redirect($this->referer());
	}

/**
 * Lock a thread.
 *
 * @return \Cake\Network\Response
 */
	public function lock() {
		$this->loadModel('ForumThreads');

		$thread = $this->ForumThreads
			->find()
			->where([
				'ForumThreads.id' => $this->request->id
			])
			->select([
				'ForumThreads.id',
				'ForumThreads.thread_open',
				'ForumThreads.title'
			])
			->first();

		//Check if the thread is found.
		if (is_null($thread)) {
			$this->Flash->error(__("This thread doesn't exist or has been deleted !"));

			return $this->redirect($this->referer());
		}

		//Chgeck if the thread is not already open.
		if ($thread->thread_open == false) {
			$this->Flash->error(__("This thread is already closed !"));

			return $this->redirect([
				'_name' => 'forum-threads',
				'slug' => Inflector::slug($thread->title, '-'),
				'id' => $thread->id
			]);
		}

		//Check if the user has the permission to unlock it.
		if ($this->Auth->isAuthorized() === false) {
			$this->Flash->error(__("You don't have the authorization to lock this post !"));

			return $this->redirect([
				'_name' => 'forum-threads',
				'slug' => Inflector::slug($thread->title, '-'),
				'id' => $thread->id
			]);
		}

		$thread->thread_open = false;

		if ($this->ForumThreads->save($thread)) {
			$this->Flash->success(__("This thread has been locked successfully !"));

			return $this->redirect([
				'_name' => 'forum-threads',
				'slug' => Inflector::slug($thread->title, '-'),
				'id' => $thread->id
			]);
		}

		$this->redirect($this->referer());
	}

/**
 * Unlock a thread.
 *
 * @return \Cake\Network\Response
 */
	public function unlock() {
		$this->loadModel('ForumThreads');

		$thread = $this->ForumThreads
			->find()
			->where([
				'ForumThreads.id' => $this->request->id
			])
			->select([
				'ForumThreads.id',
				'ForumThreads.thread_open',
				'ForumThreads.title'
			])
			->first();

		//Check if the thread is found.
		if (is_null($thread)) {
			$this->Flash->error(__("This thread doesn't exist or has been deleted !"));

			return $this->redirect($this->referer());
		}

		//Chgeck if the thread is not already open.
		if ($thread->thread_open == true) {
			$this->Flash->error(__("This thread is already open !"));

			return $this->redirect([
				'_name' => 'forum-threads',
				'slug' => Inflector::slug($thread->title, '-'),
				'id' => $thread->id
			]);
		}

		//Check if the user has the permission to unlock it.
		if ($this->Auth->isAuthorized() === false) {
			$this->Flash->error(__("You don't have the authorization to unlock this post !"));

			return $this->redirect([
				'_name' => 'forum-threads',
				'slug' => Inflector::slug($thread->title, '-'),
				'id' => $thread->id
			]);
		}

		$thread->thread_open = true;
		if ($this->ForumThreads->save($thread)) {
			$this->Flash->success(__("This thread has been unlocked successfully !"));

			return $this->redirect([
				'_name' => 'forum-threads',
				'slug' => Inflector::slug($thread->title, '-'),
				'id' => $thread->id
			]);
		}

		$this->redirect($this->referer());
	}
}
