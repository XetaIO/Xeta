<?php
namespace App\Controller\Forum;

use App\Controller\AppController;
use App\Event\Forum\Statistics;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Number;

class ForumController extends AppController {

/**
 * Helpers.
 *
 * @var array
 */
	public $helpers = [
		'Forum'
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

		$this->Auth->allow(['index', 'categories', 'threads']);
	}

/**
 * Index page.
 *
 * @return \Cake\Network\Response
 */
	public function index() {
		$this->loadModel('ForumCategories');

		$categories = $this->ForumCategories
			->find('threaded')
			->contain([
				'LastPost',
				'LastPost.Users' => function ($q) {
					return $q->find('short');
				}
			]);

		$statistics = [];

		$statistics['TotalPosts'] = Cache::remember('statisticsTotalPosts', function () {
			$this->eventManager()->attach(new Statistics());
			$event = new Event('Model.ForumPosts.new');
			$this->eventManager()->dispatch($event);

			return $event->result;
		}, 'forum');

		$statistics['TotalThreads'] = Cache::remember('statisticsTotalThreads', function () {
			$this->eventManager()->attach(new Statistics());
			$event = new Event('Model.ForumThreads.new');
			$this->eventManager()->dispatch($event);

			return $event->result;
		}, 'forum');

		$statistics['TotalPostsLikes'] = Cache::remember('statisticsTotalPostsLikes', function () {
			$this->eventManager()->attach(new Statistics());
			$event = new Event('Model.ForumPostsLikes.update');
			$this->eventManager()->dispatch($event);

			return $event->result;
		}, 'forum');

		$statistics['Users'] = Cache::remember('statisticsUsers', function () {
			$this->eventManager()->attach(new Statistics());
			$event = new Event('Model.Users.register');
			$this->eventManager()->dispatch($event);

			return $event->result;
		}, 'forum');

		$statistics['Groups'] = Cache::remember('statisticsGroups', function () {
			$this->eventManager()->attach(new Statistics());
			$event = new Event('Model.Groups.update');
			$this->eventManager()->dispatch($event);

			return $event->result;
		}, 'forum');

		$online = $this->SessionsActivity->getOnlineUsers();

		$this->set(compact('categories', 'statistics', 'online'));
	}

/**
 * Display all sub-categories and all threads for this category.
 *
 * @return \Cake\Network\Response
 */
	public function categories() {
		$this->loadModel('ForumCategories');

		$category = $this->ForumCategories
			->find()
			->contain([
				'ParentForumCategories',
				'ChildForumCategories'
			])
			->where([
				'ForumCategories.id' => $this->request->id
			])
			->first();

		//Check if the category is found.
		if (empty($category)) {
			$this->Flash->error(__('This category doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		$this->loadModel('ForumThreads');
		$this->paginate = [
			'maxLimit' => Configure::read('Forum.Categories.threads_per_page')
		];

		//Threads.
		$threads = $this->ForumThreads
			->find()
			->contain([
				'Users' => function ($q) {
					return $q->find('short');
				},
				'LastPostUsers' => function ($q) {
					return $q->find('short');
				},
				'LastPosts'
			])
			->where([
				'ForumThreads.category_id' => $category->id,
				'ForumThreads.thread_open !=' => 2
			])
			->order([
				'ForumThreads.sticky' => 'DESC',
				'ForumThreads.last_post_date' => 'DESC'
			]);

		$threads = $this->paginate($threads);

		//Categories.
		$categories = $this->ForumCategories
			->find('children', ['for' => $this->request->id])
			->find('threaded')
			->contain([
				'LastPost',
				'LastPost.Users' => function ($q) {
					return $q->find('short');
				}
			]);

		//Breadcrumbs.
		$breadcrumbs = $this->ForumCategories->find('path', ['for' => $category->id])->toArray();
		array_pop($breadcrumbs);

		$this->set(compact('category', 'threads', 'breadcrumbs', 'categories'));
	}

/**
 * Dispay a thread and all its posts.
 *
 * @return \Cake\Network\Response
 */
	public function threads() {
		$this->loadModel('ForumThreads');

		$thread = $this->ForumThreads
			->find()
			->contain([
				'FirstPosts',
				'FirstPosts.Users' => function ($q) {
					return $q->find('full')->formatResults(function ($users) {
						return $users->map(function ($user) {
							$user->online = $this->SessionsActivity->getOnlineStatus($user);
							return $user;
						});
					});
				},
				'FirstPosts.Users.Groups' => function ($q) {
					return $q->select(['id', 'name', 'css', 'is_staff', 'is_member']);
				},
				'FirstPosts.Users.BadgesUsers' => function ($q) {
					return $q
						->contain([
							'Badges' => function ($q) {
								return $q
									->select([
										'name',
										'picture'
									]);
							}
						])
						->order([
							'BadgesUsers.id' => 'DESC'
						]);
				},
				'FirstPosts.LastEditUsers' => function ($q) {
					return $q->find('short');
				},
				'FirstPosts.ForumPostsLikes' => function ($q) {
					return $q->where([
						'ForumPostsLikes.user_id' => $this->Auth->user('id')
					]);
				}
			])
			->where([
				'ForumThreads.id' => $this->request->id
			])
			->first();

		//Check if the thread is found.
		if (empty($thread)) {
			$this->Flash->error(__('This thread doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		//Paginate Posts
		$this->loadModel('ForumPosts');
		$this->paginate = [
			'maxLimit' => Configure::read('Forum.Threads.posts_per_page')
		];

		$posts = $this->ForumPosts
			->find()
			->contain([
				'Users' => function ($q) {
					return $q->find('full')->formatResults(function ($users) {
						return $users->map(function ($user) {
							$user->online = $this->SessionsActivity->getOnlineStatus($user);
							return $user;
						});
					});
				},
				'Users.Groups' => function ($q) {
					return $q->select(['id', 'name', 'css', 'is_staff', 'is_member']);
				},
				'Users.BadgesUsers' => function ($q) {
					return $q
						->contain([
							'Badges' => function ($q) {
								return $q
									->select([
										'name',
										'picture'
									]);
							}
						])
						->order([
							'BadgesUsers.id' => 'DESC'
						]);
				},
				'LastEditUsers' => function ($q) {
					return $q->find('short');
				},
				'ForumPostsLikes' => function ($q) {
					return $q->where([
						'ForumPostsLikes.user_id' => $this->Auth->user('id')
					]);
				}
			])
			->where([
				'ForumPosts.thread_id' => $thread->id,
				'ForumPosts.id !=' => $thread->first_post->id
			])
			->order([
				'ForumPosts.created' => 'ASC'
			]);

		$posts = $this->paginate($posts);

		$this->loadModel('ForumCategories');

		//Breadcrumbs.
		$breadcrumbs = $this->ForumCategories->find('path', ['for' => $thread->category_id])->toArray();

		//Categories list.
		$categories = $this->ForumCategories
			->find('treeList', [
				'spacer' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
			])
			->toArray();

		//Build the newEntity for the comment form.
		$postForm = $this->ForumPosts->newEntity();

		//Increment the Views Counter.
		$thread->view_count++;
		$this->ForumThreads->save($thread);

		$this->set(compact('thread', 'breadcrumbs', 'posts', 'postForm', 'categories'));
	}
}
