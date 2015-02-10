<?php
namespace App\Controller\Forum;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Error\NotFoundException;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Routing\Router;
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
 * Unlike a post.
 *
 * @throws \Cake\Error\NotFoundException When it's not an AJAX request.
 *
 * @return void
 */
	public function unlike() {
		if (!$this->request->is('ajax')) {
			throw new NotFoundException();
		}

		//Check if the user like this article.
		$this->loadModel('ForumPostsLikes');
		$like = $this->ForumPostsLikes
			->find()
			->where([
				'ForumPostsLikes.user_id' => $this->Auth->user('id'),
				'ForumPostsLikes.post_id' => $this->request->data['id']
			])
			->first();

		$json = [];

		if (is_null($like)) {
			$json['message'] = __("You don't like this post !");
			$json['error'] = true;

			$this->set(compact('json'));

			$this->set('_serialize', 'json');
		}

		if ($this->ForumPostsLikes->delete($like)) {
			$json['url'] = Router::url([
				'action' => 'like'
			]);
			$json['title'] = __('Like {0}', "<i class='fa fa-heart text-danger'></i>");
			$json['error'] = false;
		} else {

			$json['message'] = __('An error occurred, please try again later.');
			$json['error'] = true;
		}

		$this->set(compact('json'));

		$this->set('_serialize', 'json');
	}

/**
 * Like a post.
 *
 * @throws \Cake\Error\NotFoundException When it's not an AJAX request.
 *
 * @return void
 */
	public function like() {
		if (!$this->request->is('ajax')) {
			throw new NotFoundException();
		}

		//Check if the user hasn't already liked this post.
		$this->loadModel('ForumPostsLikes');
		$like = $this->ForumPostsLikes
			->find()
			->where([
				'ForumPostsLikes.user_id' => $this->Auth->user('id'),
				'ForumPostsLikes.post_id' => $this->request->data['id']
			])
			->first();

		$json = [];

		if (!is_null($like)) {
			$json['message'] = __('You already like this post !');
			$json['error'] = true;

			$this->set(compact('json'));

			$this->set('_serialize', 'json');
		}

		//Check if the post exist.
		$this->loadModel('ForumPosts');
		$post = $this->ForumPosts
			->find()
			->where([
				'ForumPosts.id' => $this->request->data['id'],
			])
			->first();

		if (is_null($post)) {
			$json['message'] = __("This article doesn't exist !");
			$json['error'] = true;

			$this->set(compact('json'));

			$this->set('_serialize', 'json');
		}

		//Prepare data to be saved.
		$data = [];
		$data['ForumPostsLikes']['user_id'] = $this->Auth->user('id');
		$data['ForumPostsLikes']['post_id'] = $this->request->data['id'];
		$data['ForumPostsLikes']['receiver_id'] = $post->user_id;

		$like = $this->ForumPostsLikes->newEntity($data);

		if ($this->ForumPostsLikes->save($like)) {
			$json['message'] = __('Thanks for {0} this post ! ', "<i class='fa fa-heart text-danger'></i>");
			$json['title'] = __('You {0} this article.', "<i class='fa fa-heart text-danger'></i>");
			$json['url'] = Router::url([
				'action' => 'unlike'
			]);
			$json['error'] = false;
		} else {

			$json['message'] = __('An error occurred, please try again later.');
			$json['error'] = true;
		}

		$this->set(compact('json'));

		$this->set('_serialize', 'json');
	}

/**
 * Delete a post.
 *
 * @return \Cake\Network\Response
 */
	public function delete() {
		$this->loadModel('ForumPosts');

		$post = $this->ForumPosts
			->find()
			->contain([
				'ForumThreads' => function ($q) {
					return $q->select([
						'id',
						'last_post_id',
						'first_post_id'
					]);
				}
			])
			->where(['ForumPosts.id' => $this->request->id])
			->first();

		//The post doesn't exist or has been deleted.
		if (is_null($post)) {
			$this->Flash->error(__("This post doesn't exist or has been deleted."));

			return $this->redirect(['controller' => 'forum', 'action' => 'index', 'prefix' => 'forum']);
		}

		//We can't delete the first post of a thread.
		if ($post->id == $post->forum_thread->first_post_id) {
			$this->Flash->error(__("You cannot delete the first post of a thread."));

			return $this->redirect([
				'controller' => 'posts',
				'action' => 'go',
				$post->forum_thread->first_post_id
			]);
		}

		//Delete the comment.
		if (!$this->ForumPosts->delete($post)) {
			$this->Flash->success(__("An error occurred while deleting the post. Please, try again."));

			return $this->redirect($this->referer());
		}

		//If it was the last post of the thread, find the new "last post" and edit the thread.
		if ($post->id == $post->forum_thread->last_post_id) {
			$lastPost = $this->ForumPosts
				->find()
				->select([
					'ForumPosts.id',
					'ForumPosts.user_id',
					'ForumPosts.created'
				])
				->where(['ForumPosts.thread_id' => $post->forum_thread->id])
				->order(['ForumPosts.created' => 'DESC'])
				->first();

			$this->loadModel('ForumThreads');
			$thread = $this->ForumThreads
				->find()
				->select([
					'ForumThreads.id',
					'ForumThreads.title',
					'ForumThreads.last_post_id',
					'ForumThreads.last_post_date',
					'ForumThreads.first_post_id'
				])
				->where(['ForumThreads.id' => $post->forum_thread->id])
				->first();

			//Update the last post for the thread.
			$thread->last_post_id = $lastPost->id;
			$thread->last_post_date = $lastPost->created;
			$thread->last_post_user_id = $lastPost->user_id;

			$this->ForumThreads->save($thread);

			$this->Flash->success(__("The post has been deleted successfully !"));

			return $this->redirect([
				'controller' => 'posts',
				'action' => 'go',
				$lastPost->id
			]);
		}

		$this->Flash->success(__("The post has been deleted successfully !"));

		//Redirect the user.
		return $this->redirect([
			'controller' => 'posts',
			'action' => 'go',
			$post->forum_thread->last_post_id
		]);
	}

/**
 * Quote a post.
 *
 * @throws \Cake\Error\NotFoundException
 *
 * @return mixed
 */
	public function quote() {
		if (!$this->request->is('ajax')) {
			throw new NotFoundException();

		}

		$this->loadModel('ForumPosts');

		$post = $this->ForumPosts
			->find()
			->where([
				'ForumPosts.id' => $this->request->data['id']
			])
			->contain([
				'Users' => function ($q) {
						return $q->find('short');
				}
			])
			->first();

		$json = [];

		if (!is_null($post)) {
			$post->toArray();

			$url = Router::url(['action' => 'go', $post->id]);
			$text = __("has said :");

			//Build the quote.
			$json['post'] = <<<EOT
<div>
	<div>
		<a href="{$url}">
			<strong>{$post->user->full_name} {$text}</strong>
		</a>
	</div>
	<blockquote>
		$post->message
	</blockquote>
</div><p>&nbsp;</p><p>&nbsp;</p>
EOT;

			$json['error'] = false;

			$this->set(compact('json'));
		} else {
			$json['post'] = __("This comment doesn't exist.");
			$json['error'] = true;

			$this->set(compact('json'));
		}

		//Send response in JSON.
		$this->set('_serialize', 'json');
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
