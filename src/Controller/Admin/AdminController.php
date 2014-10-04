<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\I18n\Number;
use Widop\GoogleAnalytics\Client;
use Widop\GoogleAnalytics\Query;
use Widop\GoogleAnalytics\Service;
use Widop\HttpAdapter\CurlHttpAdapter;

class AdminController extends AppController {

/**
 * Index page.
 *
 * @return void
 */
	public function home() {
		if (Configure::read('Analytics.enabled') === true) {

			$httpAdapter = new CurlHttpAdapter();
			$client = new Client(Configure::read('Analytics.client_id'), Configure::read('Analytics.private_key'), $httpAdapter);
			$service = new Service($client);

			$statistics = Cache::remember('statistics', function() use ($service) {
				$statistics = new Query(Configure::read('Analytics.profile_id'));
				$statistics
					->setStartDate(new \DateTime(Configure::read('Analytics.start_date')))
					->setEndDate(new \DateTime())
					->setMetrics(array(
						'ga:visits', 'ga:visitors', 'ga:pageviews', 'ga:pageviewsPerVisit',
						'ga:avgtimeOnSite', 'ga:visitBounceRate', 'ga:percentNewVisits'
					));

				return $service->query($statistics);
			}, 'analytics');

			$browsers = Cache::remember('browsers', function() use ($service) {
				$browsers = new Query(Configure::read('Analytics.profile_id'));
				$browsers
					->setStartDate(new \DateTime(Configure::read('Analytics.start_date')))
					->setEndDate(new \DateTime())
					->setDimensions(array('ga:browser'))
					->setMetrics(array('ga:pageviews'))
					->setSorts(array('ga:pageviews'))
					->setFilters(array('ga:browser==Chrome,ga:browser==Firefox,ga:browser==Internet Explorer,ga:browser==Safari,ga:browser==Opera'));

				return $service->query($browsers);
			}, 'analytics');

			$continents = Cache::remember('continents', function() use ($service) {
				$continents = new Query(Configure::read('Analytics.profile_id'));
				$continents
					->setStartDate(new \DateTime(Configure::read('Analytics.start_date')))
					->setEndDate(new \DateTime())
					->setDimensions(array('ga:continent'))
					->setMetrics(array('ga:visitors'))
					->setFilters(array('ga:continent==Africa,ga:continent==Americas,ga:continent==Asia,ga:continent==Europe,ga:continent==Oceania'));

				return $service->query($continents);
			}, 'analytics');

			$graphVisitors = Cache::remember('graphVisitors', function() use ($service) {
				$graphVisitors = new Query(Configure::read('Analytics.profile_id'));
				$graphVisitors
					->setStartDate(new \DateTime('-7 days'))
					->setEndDate(new \DateTime())
					->setDimensions(array('ga:date'))
					->setMetrics(array('ga:visits', 'ga:pageviews'))
					->setSorts(array('ga:date'));

				return $service->query($graphVisitors);
			}, 'analytics');

			$this->set(compact('statistics', 'browsers', 'continents', 'graphVisitors'));
		}

		$this->loadModel('Users');
		//UsersGraph
		$usersGraphCount = $this->Users
			->find('all')
			->select([
				'date' => 'DATE_FORMAT(created,\'%d-%m-%Y\')',
				'count' => 'COUNT(id)'
			])
			->group('DATE(created)')
			->order([
				'date' => 'desc'
			])
			->where([
				'UNIX_TIMESTAMP(DATE(created)) >' => (new \DateTime('-8 days'))->getTimestamp()
			])
			->toArray();

		$usersGraph = array();

		//Fill the new array with the date of the 8 past days and give them the value 0.
		for ($i = 0; $i < 8; $i++) {
			$date = new \DateTime("$i days ago");

			$usersGraph[$date->format('d-m-Y')] = 0;
		}

		//Foreach value that we got in the database, parse the array by the key date,
		//and if the key exist, attribute the new value.
		foreach ($usersGraphCount as $user) {
			$usersGraph[$user->date] = intval($user->count);
		}
		$usersGraph = array_reverse($usersGraph);

		$usersCount = Number::format($this->Users
			->find()
			->count(),
			['locale' => 'fr_FR']);

		$this->loadModel('BlogArticles');
		$articlesCount = Number::format($this->BlogArticles
			->find()
			->count(),
			['locale' => 'fr_FR']);

		$this->loadModel('BlogArticlesComments');
		$commentsCount = Number::format($this->BlogArticlesComments
			->find()
			->count(),
			['locale' => 'fr_FR']);

		$this->loadModel('BlogCategories');
		$categoriesCount = Number::format($this->BlogCategories
			->find()
			->count(),
			['locale' => 'fr_FR']);

		$this->set(compact('usersCount', 'articlesCount', 'commentsCount', 'categoriesCount', 'usersGraph'));
	}
}
