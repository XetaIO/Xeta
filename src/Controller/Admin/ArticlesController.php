<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Event\Statistics;
use Cake\Event\Event;
use Cake\I18n\I18n;

class ArticlesController extends AppController
{
    /**
     * Helpers.
     *
     * @var array
     */
    public $helpers = ['I18n'];

    /**
     * Display all articles.
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('BlogArticles');

        $this->paginate = [
            'maxLimit' => 15
        ];

        $articles = $this->BlogArticles
            ->find()
            ->contain([
                'BlogCategories' => function ($q) {
                    return $q
                        ->select([
                            'id',
                            'title'
                        ]);
                },
                'Users' => function ($q) {
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
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
        $this->loadModel('BlogArticles');

        $this->BlogArticles->locale(I18n::defaultLocale());
        $article = $this->BlogArticles->newEntity($this->request->getParsedBody());

        if ($this->request->is('post')) {
            $article->user_id = $this->Auth->user('id');
            $article->setTranslations($this->request->getParsedBody());

            if ($this->BlogArticles->save($article)) {
                $this->eventManager()->attach(new Statistics());
                $event = new Event('Model.BlogArticles.new');
                $this->eventManager()->dispatch($event);

                $this->Flash->success(__d('admin', 'Your article has been created successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $categories = $this->BlogArticles->BlogCategories->find('list');

        $this->set(compact('article', 'categories'));
    }

    /**
     * Edit an Article.
     *
     * @return \Cake\Network\Response|void
     */
    public function edit()
    {
        $this->loadModel('BlogArticles');

        $this->BlogArticles->locale(I18n::defaultLocale());
        $article = $this->BlogArticles
            ->find('translations')
            ->where([
                'BlogArticles.id' => $this->request->id
            ])
            ->contain([
                'BlogAttachments',
                'BlogCategories',
                'Users' => function ($q) {
                        return $q->find('short');
                }
            ])
            ->first();

        //Check if the article is found.
        if (empty($article)) {
            $this->Flash->error(__d('admin', 'This article doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('put')) {
            $this->BlogArticles->patchEntity($article, $this->request->getParsedBody());
            $article->setTranslations($this->request->getParsedBody());

            if ($this->BlogArticles->save($article)) {
                $this->Flash->success(__d('admin', 'This article has been updated successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $categories = $this->BlogArticles->BlogCategories->find('list');
        $this->set(compact('article', 'categories'));
    }

    /**
     * Delete an Article and all his comments and likes.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {
        $this->loadModel('BlogArticles');

        $article = $this->BlogArticles
            ->find()
            ->where([
                'BlogArticles.id' => $this->request->id
            ])
            ->first();

        //Check if the article is found.
        if (empty($article)) {
            $this->Flash->error(__d('admin', 'This article doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->BlogArticles->delete($article)) {
            $this->eventManager()->attach(new Statistics());
            $event = new Event('Model.BlogArticles.new');
            $this->eventManager()->dispatch($event);

            $this->Flash->success(__d('admin', 'This article has been deleted successfully !'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__d('admin', 'Unable to delete this article.'));

        return $this->redirect(['action' => 'index']);
    }
}
