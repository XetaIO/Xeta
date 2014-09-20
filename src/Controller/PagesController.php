<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Utility\Inflector;

class PagesController extends AppController {

/**
 * Beforefilter.
 *
 * @param Event $event The beforeFilter event that was fired.
 *
 * @return void
 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow(['home']);
	}

/**
 * Home page.
 *
 * @return void
 */
	public function home() {
		$this->loadModel('BlogArticles');
		$this->loadModel('BlogArticlesComments');

		$Articles = $this->BlogArticles
			->find()
			->contain([
				'BlogCategories'
			])
			->order([
				'BlogArticles.created' => 'desc'
			])
			->limit(Configure::read('Home.articles'))
			->toArray();

		$Comments = $this->BlogArticlesComments
			->find()
			->contain([
				'BlogArticles' => function($q) {
					return $q
						->select(
							[
								'title',
								'slug'
							]
						);
				},
				'Users' => function($q) {
					return $q
						->select(
							[
								'first_name',
								'last_name',
								'username',
								'avatar',
								'slug'
							]
						);
				}
			])
			->order([
					'BlogArticlesComments.created' => 'desc'
			])
			->limit(Configure::read('Home.comments'))
			->toArray();

		$this->set(compact('Articles', 'Comments'));
	}
}
