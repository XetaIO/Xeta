<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

class ArticlesController extends AppController {

/**
 * Display all articles.
 *
 * @return void
 */
	public function index() {
		$this->paginate = [
			'maxLimit' => 15
		];
		$this->loadModel('BlogArticles');
		$articles = $this->BlogArticles
			->find()
			->contain([
				'BlogCategories' => function($q) {
					return $q->select([
							'title',
							'slug'
						]);
				},
				'Users' => function($q) {
					return $q->find('short');
				}
			])
			->order([
				'BlogArticles.created' => 'desc'
			]);

		$articles = $this->paginate($articles);
		$this->set(compact('articles'));
	}

/**
 * Add an article.
 *
 * @return void
 */
	public function add() {
		$this->loadModel('BlogArticles');
		$article = $this->BlogArticles->newEntity($this->request->data);

		if ($this->request->is('post', 'put')) {
			$article->user_id = $this->Auth->user('id');

			if ($this->BlogArticles->save($article)) {

				$this->Flash->success(__("Your article has been created successfully !"));

				return $this->redirect(['action' => 'index']);
			}
		}

		$categories = $this->BlogArticles->BlogCategories->find('list');
		$this->set(compact('article', 'categories'));
	}

/**
 * Edit an Article.
 *
 * @return void
 */
	public function edit() {
		$this->loadModel('BlogArticles');

		$article = $this->BlogArticles
			->find('slug', [
				'slug' => $this->request->slug,
				'slugField' => 'BlogArticles.slug'
			])
			->contain([
				'BlogCategories',
				'Users' => function ($q) {
						return $q->find('short');
				}
			])
			->first();

		//Check if the article is found.
		if (empty($article)) {
			$this->Flash->error(__('This article doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		if ($this->request->is(['post', 'put'])) {
			$this->BlogArticles->patchEntity($article, $this->request->data());

			if ($this->BlogArticles->save($article)) {

				$this->Flash->success(__("This article has been updated successfully !"));

				return $this->redirect(['action' => 'index']);
			}
		}

		$categories = $this->BlogArticles->BlogCategories->find('list');
		$this->set(compact('article', 'categories'));
	}

/**
 * Delete an Article and all his comments and likes.
 *
 * @return void
 */
	public function delete() {
		$this->loadModel('BlogArticles');

		$article = $this->BlogArticles
			->find('slug', [
				'slug' => $this->request->slug,
				'slugField' => 'BlogArticles.slug'
			])
			->first();

		//Check if the article is found.
		if (empty($article)) {
			$this->Flash->error(__('This article doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		if ($this->BlogArticles->delete($article)) {

			$this->Flash->success(__("This article has been deleted successfully !"));

			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->error(__("Unable to delete this article."));

		return $this->redirect(['action' => 'index']);
	}
}
