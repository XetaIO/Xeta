<?php
namespace App\View\Cell;

use Cake\View\Cell;

class BlogCell extends Cell {

/**
 * Display the sidebar on the blog pages.
 *
 * @return void
 */
	public function sidebar() {
		$this->loadModel('BlogCategories');
		$this->loadModel('BlogArticles');

		$ArticleSearch = $this->BlogArticles->newEntity($this->request->data);

		//Select all Categories.
		$Categories = $this->BlogCategories
			->find()
			->select([
				'title',
				'slug',
				'article_count'
			])
			->all();

		//Select featured article.
		$Featured = $this->BlogArticles
			->find()
			->select([
				'title',
				'slug',
				'created',
				'comment_count'
			])
			->contain([
				'Users' => function($q) {
					return $q
						->select([
							'first_name',
							'last_name',
							'username',
							'slug'
						]);
				}
			])
			->where([
				'BlogArticles.slug !=' => $this->request->slug
			])
			->order([
				'BlogArticles.created' => 'desc'
			])
			->first();

		//Select all articles and group them by monthly.
		$Archives = $this->BlogArticles
			->find('all')
			->select([
				'date' => 'DATE_FORMAT(created,\'%d-%m-%Y\')',
				'count' => 'COUNT(id)'
			])
			->group('DATE(created)')
			->order([
				'date' => 'desc'
			])
			->toArray();

		$this->set(compact('Categories', 'Featured', 'Archives', 'ArticleSearch'));
	}
}
