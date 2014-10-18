<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Error\NotFoundException;
use Cake\Event\Event;

class PagesController extends AppController {

/**
 * Components.
 *
 * @var array
 */
	public $components = [
		'RequestHandler'
	];

/**
 * Beforefilter.
 *
 * @param Event $event The beforeFilter event that was fired.
 *
 * @return void
 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow(['home', 'acceptCookie']);
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
			->where([
				'BlogArticles.is_display' => 1
			])
			->toArray();

		$Comments = $this->BlogArticlesComments
			->find()
			->contain([
				'BlogArticles' => function ($q) {
					return $q
						->select(
							[
								'title',
								'slug'
							]
						);
				},
				'Users' => function ($q) {
					return $q->find('medium');
				}
			])
			->order([
					'BlogArticlesComments.created' => 'desc'
			])
			->limit(Configure::read('Home.comments'))
			->where([
				'BlogArticles.is_display' => 1
			])
			->toArray();

		$this->set(compact('Articles', 'Comments'));
	}

/**
 * The user accept the use of cookies.
 *
 * @throws \Cake\Error\NotFoundException When it's not an AJAX request.
 *
 * @return void
 */
	public function acceptCookie() {
		if (!$this->request->is('ajax')) {
			throw new NotFoundException();
		}

		$this->Cookie->configKey('allowCookies', [
			'expires' => '+1 year',
			'httpOnly' => true
		]);
		$this->Cookie->write('allowCookies', 'true');

		$json['message'] = __('Thanks for accepting to use the cookies !');
		$this->set(compact('json'));

		return $this->set('_serialize', 'json');
	}
}
