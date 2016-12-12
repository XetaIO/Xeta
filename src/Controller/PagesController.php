<?php
namespace App\Controller;

use App\Event\Statistics;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class PagesController extends AppController
{

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
    }

    /**
     * Beforefilter.
     *
     * @param Event $event The beforeFilter event that was fired.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['home', 'maintenance', 'acceptCookie', 'lang', 'terms']);
    }

    /**
     * Home page.
     *
     * @return void
     */
    public function home()
    {
        $this->loadModel('BlogArticles');
        $this->loadModel('BlogArticlesComments');

        $articles = $this->BlogArticles
            ->find()
            ->contain([
                'BlogCategories',
                'Users'
            ])
            ->order([
                'BlogArticles.created' => 'desc'
            ])
            ->limit(Configure::read('Home.articles'))
            ->where([
                'BlogArticles.is_display' => 1
            ]);

        $comments = $this->BlogArticlesComments
            ->find()
            ->contain([
                'BlogArticles' => function ($q) {
                    return $q
                        ->select([
                            'title'
                        ]);
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
            ]);

        $statistics = $this->_buildStats([
            'Users' => 'Model.Users.register',
            'Articles' => 'Model.BlogArticles.new',
            'ArticlesLikes' => 'Model.BlogArticlesLikes.new',
            'ArticlesComments' => 'Model.BlogArticlesComments.new'
        ]);

        $this->set(compact('articles', 'comments', 'statistics'));
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
            $statistics[$type] = Cache::remember($type, function () {
                $this->eventManager()->attach(new Statistics());
                $event = new Event($event);
                $this->eventManager()->dispatch($event);

                return $event->result;
            }, 'statistics');
        }

        return $statistics;
    }

    /**
     * The user accept the use of cookies.
     *
     * @throws \Cake\Network\Exception\NotFoundException When it's not an AJAX request.
     *
     * @return void
     */
    public function acceptCookie()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $this->Cookie->configKey('allowCookies', [
            'expires' => '+1 year',
            'httpOnly' => true
        ]);
        $this->Cookie->write('allowCookies', 'true');

        $json = [];
        $json['message'] = __('Thanks for accepting to use the cookies !');
        $this->set(compact('json'));

        $this->set('_serialize', 'json');
    }

    /**
     * Redirect to the referer.
     *
     * @return void
     */
    public function lang()
    {
        $this->redirect($this->referer());
    }

    /**
     * Display the maintenance page or a 404 if the site isn't in maintenance.
     *
     * @return void
     */
    public function maintenance()
    {
        if (Configure::read('Site.maintenance') === false) {
            throw new NotFoundException();
        }
    }

    /**
     * Display the Terms page.
     *
     * @return void
     */
    public function terms()
    {
    }
}
