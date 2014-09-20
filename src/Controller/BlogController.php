<?php
namespace App\Controller;


use Cake\Core\Configure;
use Cake\Error\NotFoundException;
use Cake\Event\Event;
use Cake\Routing\Router;

class BlogController extends AppController {

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

		$this->Auth->allow(['index', 'category', 'article', 'go', 'archive']);
	}

/**
 * Display all Articles.
 *
 * @return void
 */
	public function index() {
		$this->loadModel('BlogArticles');
		$this->paginate = [
			'contain' => [
				'BlogCategories',
				'Users' => function ($q) {
						return $q
							->select(
								[
									'first_name',
									'last_name',
									'username',
									'slug'
								]
							);
				}
			],
			'maxLimit' => Configure::read('Blog.article_per_page'),
			'order' => [
				'BlogArticles.created' => 'desc'
			]
		];
		$this->set('blogArticles', $this->paginate($this->BlogArticles));
	}

/**
 * Display a specific category with all its articles.
 *
 * @return void
 */
	public function category() {
		$this->loadModel('BlogCategories');

		$Category = $this->BlogCategories
			->find(
				'slug', [
					'slug' => $this->request->slug,
					'slugField' => 'BlogCategories.slug'
				]
			)
			->contain(['BlogArticles'])
			->first();

		//Check if the category is found.
		if (empty($Category)) {
			$this->Flash->error(__('This category doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		//Paginate all Articles.
		$this->loadModel('BlogArticles');
		$this->paginate = [
			'maxLimit' => Configure::read('Blog.article_per_page')
		];

		$CategoryArticles = $this->BlogArticles
			->find()
			->contain([
					'Users' => function ($q) {
							return $q
								->select(
									[
										'first_name',
										'last_name',
										'username',
										'slug'
									]
								);
					}
				]
			)
			->where([
					'BlogArticles.category_id' => $Category->id
				]
			)
			->order([
					'BlogArticles.created' => 'desc'
				]
			);

		$Articles = $this->paginate($CategoryArticles);

		$this->set(compact('Category', 'Articles'));
	}

/**
 * Display a specific article.
 *
 * @return mixed
 */
	public function article() {
		$this->loadModel('BlogArticles');

		$Article = $this->BlogArticles
			->find(
				'slug', [
					'slug' => $this->request->slug,
					'slugField' => 'BlogArticles.slug'
				]
			)
			->contain(
				[
					'BlogCategories',
					'Users' => function ($q) {
							return $q
								->select(
									[
										'username',
										'first_name',
										'last_name',
										'slug',
										'avatar',
										'facebook',
										'twitter',
										'signature'
									]
								);
					}
				]
			)
			->first();

		//Check if the article is found.
		if (empty($Article)) {
			$this->Flash->error(__('This article doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		$this->loadModel('BlogArticlesComments');

		//A comment has been posted.
		if ($this->request->is('post')) {

			//Check if the user is connected.
			if (!$this->Auth->user()) {
				return $this->Flash->error(__('You must be connected to post a comment.'));
			}

			$this->request->data['article_id'] = $Article->id;
			$this->request->data['user_id'] = $this->Auth->user('id');

			$NewComment = $this->BlogArticlesComments->newEntity($this->request->data);

			if ($insertComment = $this->BlogArticlesComments->save($NewComment, ['validate' => 'create'])) {

				$this->Flash->success(__('Your comment has been posted successfully !'));
				//Redirect the user to the last page of the article.
				$this->redirect(
					[
						'action' => 'go',
						$insertComment->id
					]
				);
			}
		}

		//Paginate all comments related to the article.
		$this->paginate = [
			'maxLimit' => Configure::read('Blog.comment_per_page')
		];

		$ArticleComments = $this->BlogArticlesComments
			->find()
			->where(
				[
					'article_id' => $Article->id
				]
			)
			->contain(
				[
					'Users' => function ($q) {
							return $q
								->select(
									[
										'username',
										'first_name',
										'last_name',
										'slug',
										'avatar'
									]
								);
					}
				]
			)
			->order(
				[
					'BlogArticlesComments.created' => 'asc'
				]
			);

		$Comments = $this->paginate($ArticleComments);

		//Select the like for the current auth user.
		$this->loadModel('BlogArticlesLikes');
		$Like = $this->BlogArticlesLikes
			->find()
			->where(
				[
					'user_id' => ($this->Auth->user()) ? $this->Auth->user('id') : null,
					'article_id' => $Article->id
				]
			)
			->first();

		//Build the newEntity for the comment form.
		$FormComments = $this->BlogArticlesComments->newEntity();

		$this->set(compact('Article', 'FormComments', 'Comments', 'Like'));
	}

/**
 * Quote a message.
 *
 * @param int $ArticleId Id of the article where is the message to quote.
 * @param int $CommentId Id of the message to quote.
 *
 * @throws \Cake\Error\NotFoundException
 *
 * @return mixed
 */
	public function quote($ArticleId = null, $CommentId = null) {
		if (!$this->request->is('ajax')) {
			throw new NotFoundException();
		}

		$this->loadModel('BlogArticlesComments');

		$Comment = $this->BlogArticlesComments
			->find()
			->where(
				[
					'BlogArticlesComments.article_id' => $ArticleId,
					'BlogArticlesComments.id' => $CommentId
				]
			)
			->contain(
				[
					'Users' => function ($q) {
							return $q
								->select(
									[
										'id',
										'first_name',
										'last_name',
										'username',
										'slug'
									]
								);
					}
				]
			)
			->first();

		if (!is_null($Comment)) {
			$Comment->toArray();

			//Build the quote.
			$json['comment'] =
				'<div>'
				. '     <div>'
				. '         <a href="'
				. Router::url(
					[
						'action' => 'go',
						$Comment->id
					]
				)
				.           '">'
				. '             <strong>' . $Comment->user->full_name . ' ' . __("has said :") . '</strong>'
				. '         </a>'
				. '	    </div>'
				. '     <blockquote>'
				.           $Comment->content
				. '     </blockquote>'
				. ' </div><p>&nbsp;</p><p>&nbsp;</p>';

			$json['error'] = false;

			$this->set(compact('json'));
		} else {
			$json['comment'] = __("This comment doesn't exist.");
			$json['error'] = true;

			$this->set(compact('json'));
		}

		//Send response in JSON.
		$this->set('_serialize', 'json');
	}

/**
 * Redirect an user to an article, page and comment.
 *
 * @param int $CommentId Id of the comment.
 *
 * @return mixed
 */
	public function go($CommentId = null) {
		$this->loadModel('BlogArticlesComments');

		$Comment = $this->BlogArticlesComments
			->find()
			->contain(
				[
					'BlogArticles'
				]
			)
			->where(
				[
					'BlogArticlesComments.id' => $CommentId
				]
			)
			->first();

		if (is_null($Comment)) {
			$this->Flash->error(__("This comment doesn't exist or has been deleted."));

			return $this->redirect(['action' => 'index']);
		}

		$Comment->toArray();

		//Count the number of message before this message.
		$messagesBefore = $this->BlogArticlesComments
			->find()
			->where(
				[
					'BlogArticlesComments.article_id' => $Comment->article_id,
					'BlogArticlesComments.created <' => $Comment->created
				]
			)
			->count();

		//Get the number of messages per page.
		$messagesPerPage = Configure::read('Blog.comment_per_page');

		//Calculate the page.
		$page = floor($messagesBefore / $messagesPerPage) + 1;

		$page = ($page > 1) ? $page : 1;

		//Redirect the user.
		return $this->redirect(
			[
				'_name' => 'blog-article',
				'slug' => $Comment->blog_article->slug,
				'?' => ['page' => $page],
				'#' => 'comment-' . $CommentId
			]
		);
	}

/**
 * Get all articles by a date formatted to "m-Y".
 *
 * @param string $date The date of the archive.
 *
 * @return mixed
 */
	public function archive($date = null) {
		//Paginate all Articles.
		$this->loadModel('BlogArticles');
		$this->paginate = [
			'maxLimit' => Configure::read('Blog.article_per_page'),
			'order' => [
				'BlogArticles.created' => 'desc'
			]
		];

		$ArchiveArticles = $this->BlogArticles
			->find()
			->where(
				[
					'DATE_FORMAT(BlogArticles.created,\'%m-%Y\')' => $date
				]
			)
			->contain(
				[
					'BlogCategories',
					'Users' => function ($q) {
							return $q
								->select(
									[
										'first_name',
										'last_name',
										'username',
										'slug'
									]
								);
					}
				]
			);

		//Check if we have a result.
		$CheckArticles = $ArchiveArticles->toArray();

		if (empty($CheckArticles)) {
			$this->Flash->error(__('There is not articles for this date.'));

			return $this->redirect(['action' => 'index']);
		}

		//Paginate articles.
		$Articles = $this->paginate($ArchiveArticles);

		//Get the Time object of the first item. (To display it the view.)
		$date = $Articles->toArray()[0]->created;

		$this->set(compact('Articles', 'date'));
	}

/**
 * Search articles.
 *
 * @return void
 */
	public function search() {
		$this->loadModel('BlogArticles');

		//Check the keyword to search. (For pagination)
		if (!empty($this->request->data['search'])) {

			$keyword = $this->request->data['search'];
			$this->Session->write('Search.Blog.Keyword', $keyword);
		} else {

			if ($this->Session->read('Search.Blog.Keyword')) {

				$keyword = $this->Session->read('Search.Blog.Keyword');
			} else {

				$keyword = '';
			}
		}

		//Pagination
		$this->paginate = [
			'maxLimit' => Configure::read('Blog.article_per_page')
		];

		$Articles = $this->BlogArticles
			->find()
			->contain(
				[
					'Users' => function ($q) {
						return $q
							->select(
								[
									'first_name',
									'last_name',
									'username',
									'slug'
								]
							);
					}
				]
			)
			->where(function($q) use ($keyword) {
					return $q
						->like('title', "%$keyword%");
			})
			->order([
					'BlogArticles.created' => 'desc'
			]);

		$Articles = $this->paginate($Articles);

		$this->set(compact('Articles', 'keyword'));
	}

/**
 * Like an article.
 *
 * @param int $ArticleId Id of the article to like.
 *
 * @throws \Cake\Error\NotFoundException
 *
 * @return mixed
 */
	public function articleLike($ArticleId = null) {
		if (!$this->request->is('ajax')) {
			throw new NotFoundException();
		}

		//Check if the user hasn't already liked this article.
		$this->loadModel('BlogArticlesLikes');
		$CheckLike = $this->BlogArticlesLikes
			->find()
			->where(
				[
					'BlogArticlesLikes.user_id' => $this->Auth->user('id'),
					'BlogArticlesLikes.article_id' => $ArticleId
				]
			)
			->first();

		if (!is_null($CheckLike)) {
			$json['message'] = __('You already like this article !');
			$json['error'] = true;

			$this->set(compact('json'));

			return $this->set('_serialize', 'json');
		}

		//Check if the article exist.
		$this->loadModel('BlogArticles');
		$CheckArticle = $this->BlogArticles
			->find()
			->where(
				[
					'id' => $ArticleId
				]
			)
			->first();

		if (is_null($CheckArticle)) {
			$json['message'] = __("This article doesn't exist !");
			$json['error'] = true;

			$this->set(compact('json'));

			return $this->set('_serialize', 'json');
		}

		//Prepare data to be saved.
		$data['BlogArticlesLikes']['user_id'] = $this->Auth->user('id');
		$data['BlogArticlesLikes']['article_id'] = $ArticleId;

		$like = $this->BlogArticlesLikes->newEntity($data);

		if ($this->BlogArticlesLikes->save($like)) {
			$json['message'] = __('Thanks for {0} this article ! ', "<i class='fa fa-heart text-danger'></i>");
			$json['title'] = __('You {0} this article.', "<i class='fa fa-heart text-danger'></i>");
			$json['url'] = Router::url(
				[
					'action' => 'articleUnlike',
					$ArticleId
				]
			);
			$json['error'] = false;
		} else {

			$json['message'] = __('An error occurred, please try again later.');
			$json['error'] = true;
		}

		$this->set(compact('json'));

		return $this->set('_serialize', 'json');
	}

/**
 * Unlike an article.
 *
 * @param int|null $ArticleId Id of the article to like.
 *
 * @throws \Cake\Error\NotFoundException
 *
 * @return mixed
 */
	public function articleUnlike($ArticleId = null) {
		if (!$this->request->is('ajax')) {
			throw new NotFoundException();
		}

		//Check if the user like this article.
		$this->loadModel('BlogArticlesLikes');
		$Like = $this->BlogArticlesLikes
			->find()
			->where(
				[
					'user_id' => $this->Auth->user('id'),
					'article_id' => $ArticleId
				]
			)
			->first();

		if (is_null($Like)) {
			$json['message'] = __("You don't like this article !");
			$json['error'] = true;

			$this->set(compact('json'));

			return $this->set('_serialize', 'json');
		}

		if ($this->BlogArticlesLikes->delete($Like)) {
			$json['url'] = Router::url(
				[
					'action' => 'articleLike',
					$ArticleId
				]
			);
			$json['title'] = __('Like {0}', "<i class='fa fa-heart text-danger'></i>");
			$json['error'] = false;
		} else {

			$json['message'] = __('An error occurred, please try again later.');
			$json['error'] = true;
		}

		$this->set(compact('json'));

		return $this->set('_serialize', 'json');
	}
}
