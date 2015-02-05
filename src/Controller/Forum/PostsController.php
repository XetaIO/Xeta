<?php
namespace App\Controller\Forum;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Error\NotFoundException;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Utility\Inflector;

class PostsController extends AppController {

/**
 * Components.
 *
 * @var array
 */
	public $components = [
		'RequestHandler'
	];

/**
 * BeforeFilter handle.
 *
 * @param Event $event The beforeFilter event that was fired.
 *
 * @return void
 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow(['go']);
	}

/**
 * Redirect an user to a thread, page and post.
 *
 * @param int $postId Id of the post.
 *
 * @return \Cake\Network\Response
 */
	public function go($postId = null) {
		$this->loadModel('ForumPosts');

		$post = $this->ForumPosts
			->find()
			->contain([
				'ForumThreads'
			])
			->where([
				'ForumPosts.id' => $postId
			])
			->first();

		if (is_null($post)) {
			$this->Flash->error(__("This post doesn't exist or has been deleted."));

			return $this->redirect(['controller' => 'forum', 'action' => 'index', 'prefix' => 'forum']);
		}

		$post->toArray();

		//Count the number of posts before this post.
		$postsBefore = $this->ForumPosts
			->find()
			->where([
				'ForumPosts.thread_id' => $post->thread_id,
				'ForumPosts.created <' => $post->created
			])
			->count();

		//Get the number of posts per page.
		$postsPerPage = Configure::read('Forum.Threads.posts_per_page');

		//Calculate the page.
		$page = ceil($postsBefore / $postsPerPage);

		$page = ($page > 1) ? $page : 1;

		//Redirect the user.
		return $this->redirect([
			'_name' => 'forum-threads',
			'slug' => Inflector::slug($post->forum_thread->title, '-'),
			'id' => $post->forum_thread->id,
			'?' => ['page' => $page],
			'#' => 'post-' . $postId
		]);
	}

/**
 * Edit a post.
 *
 * @param int $id Id of the post.
 *
 * @return \Cake\Network\Response
 */
	public function edit($id = null) {
		$this->loadModel('ForumPosts');

		$post = $this->ForumPosts
			->find()
			->where([
				'ForumPosts.id' => $id
			])
			->first();

		if (is_null($post)) {
			$this->Flash->error(__("This post doesn't exist or has been deleted !"));

			return $this->redirect($this->referer());
		}

		if ($post->user_id != $this->Auth->user('id') && $this->Auth->isAuthorized() === false) {
			$this->Flash->error(__("You don't have the authorization to edit this post !"));

			return $this->redirect($this->referer());
		}

		$this->ForumPosts->patchEntity($post, $this->request->data());
		$post->last_edit_date = new Time();
		$post->last_edit_user_id = $this->Auth->user('id');
		$post->edit_count++;

		if ($this->ForumPosts->save($post)) {
			$this->Flash->success(__("This post has been edited successfully !"));
		}

		return $this->redirect(['action' => 'go', $post->id]);
	}

/**
 * Get the form to edit a post.
 *
 * @throws \Cake\Error\NotFoundException When it's not an AJAX request.
 *
 * @return void
 */
	public function getEditPost() {
		if (!$this->request->is('ajax')) {
			throw new NotFoundException();
		}

		$this->loadModel('ForumPosts');
		$this->layout = false;

		$post = $this->ForumPosts
			->find()
			->where([
				'ForumPosts.id' => $this->request->data['id']
			])
			->first();

		if (is_null($post)) {
			$this->Flash->error(__("This post doesn't exist or has been deleted !"));
		}

		if ($post->user_id != $this->Auth->user('id') && $this->Auth->isAuthorized() === false) {
			$this->Flash->error(__("You don't have the authorization to edit this post !"));
		} else {
			$this->set(compact('post'));
		}
	}
}
