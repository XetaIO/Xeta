<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Event\Statistics;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Number;
use Mexitek\PHPColors\Color;
use Widop\GoogleAnalytics\Client;
use Widop\GoogleAnalytics\Query;
use Widop\GoogleAnalytics\Service;
use Widop\HttpAdapter\CurlHttpAdapter;

class AdminController extends AppController
{

    /**
     * Index page.
     *
     * @return void
     */
    public function home()
    {
        if (Configure::read('Analytics.enabled') === true) {
            $httpAdapter = new CurlHttpAdapter();
            $client = new Client(Configure::read('Analytics.client_id'), Configure::read('Analytics.private_key'), $httpAdapter);
            $service = new Service($client);

            $statistics = Cache::remember('statistics', function () use ($service) {
                $statistics = new Query(Configure::read('Analytics.profile_id'));
                $statistics
                    ->setStartDate(new \DateTime(Configure::read('Analytics.start_date')))
                    ->setEndDate(new \DateTime())
                    ->setMetrics([
                        'ga:visits', 'ga:visitors', 'ga:pageviews', 'ga:pageviewsPerVisit',
                        'ga:avgtimeOnSite', 'ga:visitBounceRate', 'ga:percentNewVisits'
                    ]);

                return $service->query($statistics);
            }, 'analytics');

            $browsers = Cache::remember('browsers', function () use ($service) {
                $browsers = new Query(Configure::read('Analytics.profile_id'));
                $browsers
                    ->setStartDate(new \DateTime(Configure::read('Analytics.start_date')))
                    ->setEndDate(new \DateTime())
                    ->setDimensions(['ga:browser'])
                    ->setMetrics(['ga:pageviews'])
                    ->setSorts(['ga:pageviews'])
                    ->setFilters(['ga:browser==Chrome,ga:browser==Firefox,ga:browser==Internet Explorer,ga:browser==Safari,ga:browser==Opera']);

                return $service->query($browsers);
            }, 'analytics');

            $continents = Cache::remember('continents', function () use ($service) {
                $continentsRows = new Query(Configure::read('Analytics.profile_id'));
                $continentsRows
                    ->setStartDate(new \DateTime(Configure::read('Analytics.start_date')))
                    ->setEndDate(new \DateTime())
                    ->setDimensions(['ga:continent'])
                    ->setMetrics(['ga:visitors'])
                    ->setSorts(['ga:visitors'])
                    ->setFilters(['ga:continent==Africa,ga:continent==Americas,ga:continent==Asia,ga:continent==Europe,ga:continent==Oceania']);

                $continentsRows = $service->query($continentsRows);

                $color = new Color("1abc9c");
                $light = 1;

                $continents = [];

                foreach (array_reverse($continentsRows->getRows()) as $continentRow) {
                    $continent = [];
                    $continent['label'] = $continentRow[0];
                    $continent['data'] = $continentRow[1];
                    $continent['color'] = '#' . $color->lighten($light);

                    array_push($continents, $continent);
                    $light += 10;
                }

                return $continents;
            }, 'analytics');

            $graphVisitors = Cache::remember('graphVisitors', function () use ($service) {
                $graphVisitors = new Query(Configure::read('Analytics.profile_id'));
                $graphVisitors
                    ->setStartDate(new \DateTime('-7 days'))
                    ->setEndDate(new \DateTime())
                    ->setDimensions(['ga:date'])
                    ->setMetrics(['ga:visits', 'ga:pageviews'])
                    ->setSorts(['ga:date']);

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

        $usersGraph = [];

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

        $stats = $this->_buildStats([
            'Users' => 'Model.Users.register',
            'Articles' => 'Model.BlogArticles.new',
            'ArticlesLikes' => 'Model.BlogArticlesLikes.new',
            'ArticlesComments' => 'Model.BlogArticlesComments.new'
        ]);

        $this->set(compact('stats', 'usersGraph'));
    }

    /**
     * Build the statistics for the home page.
     *
     * @param array $array The array of statistics to build.
     *
     * @return array
     */
    protected function _buildStats(array $array)
    {
        $statistics = [];

        foreach ($array as $type => $event) {
            $statistics[$type] = Cache::remember($type, function () use ($event) {
                $this->eventManager()->attach(new Statistics());
                $event = new Event($event);
                $this->eventManager()->dispatch($event);

                return $event->result;
            }, 'statistics');
        }

        return $statistics;
    }
}
