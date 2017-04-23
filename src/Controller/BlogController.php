<?php
namespace App\Controller;

use App\Event\Badges;
use App\Event\Statistics;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;

class BlogController extends AppController
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
     * BeforeFilter handle.
     *
     * @param Event $event The beforeFilter event that was fired.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['index', 'category', 'article', 'go', 'archive', 'search']);
    }

    /**
     * Display all Articles.
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('BlogArticles');
        $this->paginate = [
            'maxLimit' => Configure::read('Blog.article_per_page')
        ];

        $articles = $this->BlogArticles
            ->find()
            ->contain([
                'BlogCategories',
                'Users' => function ($q) {
                    return $q->find('short');
                },
                'Polls',
                'BlogAttachments'
            ])
            ->order([
                'BlogArticles.created' => 'desc'
            ])
            ->where([
                'BlogArticles.is_display' => 1
            ]);

        $articles = $this->paginate($articles);

        $this->set(compact('articles'));
    }

    /**
     * Display a specific category with all its articles.
     *
     * @return \Cake\Network\Response|void
     */
    public function category()
    {
        $this->loadModel('BlogCategories');

        $category = $this->BlogCategories
            ->find()
            ->where([
                'BlogCategories.id' => $this->request->id
            ])
            ->contain([
                'BlogArticles'
            ])
            ->first();

        //Check if the category is found.
        if (empty($category)) {
            $this->Flash->error(__('This category doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        //Paginate all Articles.
        $this->loadModel('BlogArticles');
        $this->paginate = [
            'maxLimit' => Configure::read('Blog.article_per_page')
        ];

        $articles = $this->BlogArticles
            ->find()
            ->contain([
                'Users' => function ($q) {
                    return $q->find('short');
                },
                'Polls',
                'BlogAttachments'
            ])
            ->where([
                'BlogArticles.category_id' => $category->id,
                'BlogArticles.is_display' => 1
            ])
            ->order([
                'BlogArticles.created' => 'desc'
            ]);

        $articles = $this->paginate($articles);

        $this->set(compact('category', 'articles'));
    }

    /**
     * Display a specific article.
     *
     * @return \Cake\Network\Response|void
     */
    public function article()
    {
        $this->loadModel('BlogArticles');

        $article = $this->BlogArticles
            ->find()
            ->where([
                'BlogArticles.id' => $this->request->id,
                'BlogArticles.is_display' => 1
            ])
            ->contain([
                'BlogCategories',
                'BlogAttachments',
                'Users' => function ($q) {
                    return $q->find('full');
                },
                'Polls',
                'Polls.PollsAnswers',
                'Polls.PollsAnswers.Polls' => function ($q) {
                    return $q->select(['id', 'user_count']);
                },
                'Polls.PollsUsers'
            ])
            ->first();

        //Check if the article is found.
        if (is_null($article)) {
            $this->Flash->error(__('This article doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('BlogArticlesComments');

        //A comment has been posted.
        if ($this->request->is('post')) {
            //Check if the user is connected.
            if (!$this->Auth->user()) {
                $this->Flash->error(__('You must be connected to post a comment.'));

                return $this->redirect([
                    '_name' => 'blog-article',
                    'slug' => h($article->title),
                    'id' => $article->id
                ]);
            }

            $this->request = $this->request
                ->withData('article_id', $article->id)
                ->withData('user_id', $this->Auth->user('id'));

            $newComment = $this->BlogArticlesComments->newEntity($this->request->getParsedBody(), ['validate' => 'create']);

            //Attach Event.
            $this->BlogArticlesComments->eventManager()->attach(new Badges($this));

            if ($insertComment = $this->BlogArticlesComments->save($newComment)) {
                $this->eventManager()->attach(new Statistics());
                $event = new Event('Model.BlogArticlesComments.new');
                $this->eventManager()->dispatch($event);

                $this->Flash->success(__('Your comment has been posted successfully !'));
                //Redirect the user to the last page of the article.
                $this->redirect([
                    'action' => 'go',
                    $insertComment->id
                ]);
            }
        }

        $this->loadModel('PollsUsers');
        $hasVoted = $this->PollsUsers
            ->find()
            ->contain([
                'Polls' => function ($q) {
                    return $q->select(['id']);
                },
                'PollsAnswers'
            ])
            ->where([
                'PollsUsers.user_id' => $this->Auth->user('id'),
                'Polls.id' => $article->poll ? $article->poll->id : null
            ])
            ->first();

        //Paginate all comments related to the article.
        $this->paginate = [
            'maxLimit' => Configure::read('Blog.comment_per_page')
        ];

        $comments = $this->BlogArticlesComments
            ->find()
            ->where([
                'BlogArticlesComments.article_id' => $article->id
            ])
            ->contain([
                'Users' => function ($q) {
                    return $q->find('medium');
                }
            ])
            ->order([
                'BlogArticlesComments.created' => 'asc'
            ]);

        $comments = $this->paginate($comments);

        //Select the like for the current auth user.
        $this->loadModel('BlogArticlesLikes');
        $like = $this->BlogArticlesLikes
            ->find()
            ->where([
                'user_id' => ($this->Auth->user()) ? $this->Auth->user('id') : null,
                'article_id' => $article->id
            ])
            ->first();

        //Build the newEntity for the comment form.
        $formComments = $this->BlogArticlesComments->newEntity();

        //Search related articles
        $keywords = preg_split("/([\s,\W])+/", $article->title);

        $query = $this->BlogArticles->find();
        $query
            ->contain([
                'BlogCategories',
            ]);

        foreach ($keywords as $keyword) {
            $query->orWhere(function ($exp, $q) use ($keyword) {
                return $exp->like('BlogArticles.title', '%' . $keyword . '%');
            });
        }

        $articles = $query->andWhere([
            'BlogArticles.is_display' => 1,
            'BlogArticles.id !=' => $article->id
        ]);

        //Current user.
        $this->loadModel('Users');
        $currentUser = $this->Users
            ->find()
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select(['id', 'group_id'])
            ->first();

        $this->set(compact('article', 'formComments', 'comments', 'like', 'articles', 'currentUser', 'hasVoted'));
    }

    /**
     * Quote a message.
     *
     * @param int $articleId Id of the article where is the message to quote.
     * @param int $commentId Id of the message to quote.
     *
     * @throws \Cake\Network\Exception\NotFoundException
     *
     * @return mixed
     */
    public function quote($articleId = null, $commentId = null)
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $this->loadModel('BlogArticlesComments');

        $comment = $this->BlogArticlesComments
            ->find()
            ->where([
                'BlogArticlesComments.article_id' => $articleId,
                'BlogArticlesComments.id' => $commentId
            ])
            ->contain([
                'Users' => function ($q) {
                        return $q->find('short');
                }
            ])
            ->first();

        $json = [];

        if (!is_null($comment)) {
            $comment->toArray();

            $url = Router::url(['action' => 'go', $comment->id]);
            $text = __("has said :");

            //Build the quote.
            $json['comment'] = <<<EOT
<div>
     <div>
        <a href="{$url}">
            <strong>{$comment->user->full_name} {$text}</strong>
        </a>
    </div>
    <blockquote>
        $comment->content
    </blockquote>
</div><p>&nbsp;</p><p>&nbsp;</p>
EOT;

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
     * @param int $commentId Id of the comment.
     *
     * @return \Cake\Network\Response
     */
    public function go($commentId = null)
    {
        $this->loadModel('BlogArticlesComments');

        $comment = $this->BlogArticlesComments
            ->find()
            ->contain([
                'BlogArticles'
            ])
            ->where([
                'BlogArticlesComments.id' => $commentId
            ])
            ->first();

        if (is_null($comment)) {
            $this->Flash->error(__("This comment doesn't exist or has been deleted."));

            return $this->redirect(['action' => 'index']);
        }

        $comment->toArray();

        //Count the number of message before this message.
        $messagesBefore = $this->BlogArticlesComments
            ->find()
            ->where([
                'BlogArticlesComments.article_id' => $comment->article_id,
                'BlogArticlesComments.created <' => $comment->created
            ])
            ->count();

        //Get the number of messages per page.
        $messagesPerPage = Configure::read('Blog.comment_per_page');

        //Calculate the page.
        $page = floor($messagesBefore / $messagesPerPage) + 1;

        $page = ($page > 1) ? $page : 1;

        //Redirect the user.
        return $this->redirect([
            '_name' => 'blog-article',
            'slug' => $comment->blog_article->title,
            'id' => $comment->blog_article->id,
            '?' => ['page' => $page],
            '#' => 'comment-' . $commentId
        ]);
    }

    /**
     * Get all articles by a date formatted to "m-Y".
     *
     * @param string $date The date of the archive.
     *
     * @return void
     */
    public function archive($date = null)
    {
        $this->loadModel('BlogArticles');

        $this->paginate = [
            'maxLimit' => Configure::read('Blog.article_per_page')
        ];

        $archives = $this->BlogArticles
            ->find()
            ->where([
                'DATE_FORMAT(BlogArticles.created,\'%m-%Y\')' => $date,
                'BlogArticles.is_display' => 1
            ])
            ->contain([
                'BlogCategories',
                'Users' => function ($q) {
                        return $q->find('short');
                },
                'Polls',
                'BlogAttachments'
            ])
            ->order([
                'BlogArticles.created' => 'desc'
            ]);

        $articles = $this->paginate($archives);

        $this->set(compact('articles', 'date'));
    }

    /**
     * Search articles.
     *
     * @return void
     */
    public function search()
    {
        $this->loadModel('BlogArticles');

        //Check the keyword to search. (For pagination)
        if (!empty($this->request->getData('search'))) {
            $keyword = $this->request->getData('search');
            $this->request->session()->write('Search.Blog.Keyword', $keyword);
        } else {
            if ($this->request->session()->read('Search.Blog.Keyword')) {
                $keyword = $this->request->session()->read('Search.Blog.Keyword');
            } else {
                $keyword = '';
            }
        }

        //Pagination
        $this->paginate = [
            'maxLimit' => Configure::read('Blog.article_per_page')
        ];

        $articles = $this->BlogArticles
            ->find()
            ->contain([
                'Users' => function ($q) {
                    return $q->find('short');
                },
                'Polls',
                'BlogAttachments'
            ])
            ->where([
                'BlogArticles.is_display' => 1
            ])
            ->andWhere(function ($q) use ($keyword) {
                return $q
                    ->like('title', "%$keyword%");
            })
            ->order([
                'BlogArticles.created' => 'desc'
            ]);

        $articles = $this->paginate($articles);

        $this->set(compact('articles', 'keyword'));
    }

    /**
     * Like an article.
     *
     * @param int $articleId Id of the article to like.
     *
     * @throws \Cake\Network\Exception\NotFoundException When it's not an AJAX request.
     *
     * @return void
     */
    public function articleLike($articleId = null)
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        //Check if the user hasn't already liked this article.
        $this->loadModel('BlogArticlesLikes');
        $checkLike = $this->BlogArticlesLikes
            ->find()
            ->where([
                'BlogArticlesLikes.user_id' => $this->Auth->user('id'),
                'BlogArticlesLikes.article_id' => $articleId
            ])
            ->first();

        $json = [];

        if (!is_null($checkLike)) {
            $json['message'] = __('You already like this article !');
            $json['error'] = true;

            $this->set(compact('json'));

            $this->set('_serialize', 'json');

            return;
        }

        //Check if the article exist.
        $this->loadModel('BlogArticles');
        $checkArticle = $this->BlogArticles
            ->find()
            ->where([
                'BlogArticles.id' => $articleId,
                'BlogArticles.is_display' => 1
            ])
            ->first();

        if (is_null($checkArticle)) {
            $json['message'] = __("This article doesn't exist !");
            $json['error'] = true;

            $this->set(compact('json'));
            $this->set('_serialize', 'json');

            return;
        }

        //Prepare data to be saved.
        $data = [];
        $data['BlogArticlesLikes']['user_id'] = $this->Auth->user('id');
        $data['BlogArticlesLikes']['article_id'] = $articleId;

        $like = $this->BlogArticlesLikes->newEntity($data);

        if ($this->BlogArticlesLikes->save($like)) {
            //Update the Statistics
            $this->eventManager()->attach(new Statistics());
            $event = new Event('Model.BlogArticlesLikes.new');
            $this->eventManager()->dispatch($event);

            $json['message'] = __('Thanks for {0} this article ! ', "<i class='fa fa-heart text-danger'></i>");
            $json['title'] = __('You {0} this article.', "<i class='fa fa-heart text-danger'></i>");
            $json['url'] = Router::url(
                [
                    'action' => 'articleUnlike',
                    $articleId
                ]
            );
            $json['error'] = false;
        } else {
            $json['message'] = __('An error occurred, please try again later.');
            $json['error'] = true;
        }

        $this->set(compact('json'));

        $this->set('_serialize', 'json');
    }

    /**
     * Unlike an article.
     *
     * @param int|null $articleId Id of the article to like.
     *
     * @throws \Cake\Network\Exception\NotFoundException When it's not an AJAX request.
     *
     * @return void
     */
    public function articleUnlike($articleId = null)
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        //Check if the user like this article.
        $this->loadModel('BlogArticlesLikes');
        $like = $this->BlogArticlesLikes
            ->find()
            ->contain([
                'BlogArticles'
            ])
            ->where([
                'BlogArticlesLikes.user_id' => $this->Auth->user('id'),
                'BlogArticlesLikes.article_id' => $articleId,
                'BlogArticles.is_display' => 1
            ])
            ->first();

        $json = [];

        if (is_null($like)) {
            $json['message'] = __("You don't like this article !");
            $json['error'] = true;

            $this->set(compact('json'));

            $this->set('_serialize', 'json');

            return;
        }

        if ($this->BlogArticlesLikes->delete($like)) {
            //Update the Statistics
            $this->eventManager()->attach(new Statistics());
            $event = new Event('Model.BlogArticlesLikes.new');
            $this->eventManager()->dispatch($event);

            $json['url'] = Router::url([
                                'action' => 'articleLike',
                                $articleId
                            ]);
            $json['title'] = __('Like {0}', "<i class='fa fa-heart text-danger'></i>");
            $json['error'] = false;
        } else {
            $json['message'] = __('An error occurred, please try again later.');
            $json['error'] = true;
        }

        $this->set(compact('json'));

        $this->set('_serialize', 'json');
    }

    /**
     * Delete a comment.
     *
     * @param int $id Id of the comment to delete.
     *
     * @return \Cake\Network\Response
     */
    public function deleteComment($id = null)
    {
        $this->loadModel('BlogArticlesComments');

        $comment = $this->BlogArticlesComments
            ->find()
            ->contain([
                'BlogArticles'
            ])
            ->where([
                'BlogArticlesComments.id' => $id
            ])
            ->first();

        if (is_null($comment)) {
            $this->Flash->error(__("This comment doesn't exist or has been deleted !"));

            return $this->redirect($this->referer());
        }

        //Current user.
        $this->loadModel('Users');
        $currentUser = $this->Users
            ->find()
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select(['id', 'group_id'])
            ->first();

        if ($comment->user_id != $this->Auth->user('id') && !$currentUser->group->is_staff) {
            $this->Flash->error(__("You don't have the authorization to delete this comment !"));

            return $this->redirect($this->referer());
        }

        if ($this->BlogArticlesComments->delete($comment)) {
            $this->eventManager()->attach(new Statistics());
            $event = new Event('Model.BlogArticlesComments.new');
            $this->eventManager()->dispatch($event);

            $this->Flash->success(__("This comment has been deleted successfully !"));
        }

        return $this->redirect(['_name' => 'blog-article', 'slug' => $comment->blog_article->title, 'id' => $comment->blog_article->id, '?' => ['page' => $comment->blog_article->last_page]]);
    }

    /**
     * Get the form to edit a comment.
     *
     * @throws \Cake\Network\Exception\NotFoundException When it's not an AJAX request.
     *
     * @return void
     */
    public function getEditComment()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $this->loadModel('BlogArticlesComments');
        $comment = $this->BlogArticlesComments
            ->find()
            ->where([
                'BlogArticlesComments.id' => $this->request->getData('id')
            ])
            ->first();

        $json = [
            'error' => false,
            'errorMessage' => ''
        ];

        if (is_null($comment)) {
            $json['error'] = true;
            $json['errorMessage'] = __("This comment doesn't exist or has been deleted !");

            $this->set(compact('json'));

            return;
        }

        //Current user.
        $this->loadModel('Users');
        $currentUser = $this->Users
            ->find()
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select(['id', 'group_id'])
            ->first();

        if ($comment->user_id != $this->Auth->user('id') && !$currentUser->group->is_staff) {
            $json['error'] = true;
            $json['errorMessage'] = __("You don't have the authorization to edit this comment !");

            $this->set(compact('json'));

            return;
        }

        $this->set(compact('json', 'comment'));
    }

    /**
     * Edit a comment.
     *
     * @param int $id Id of the comment.
     *
     * @throws \Cake\Network\Exception\NotFoundException When it's not a POST request.
     *
     * @return \Cake\Network\Response
     */
    public function editComment($id = null)
    {
        if (!$this->request->is('post')) {
            throw new NotFoundException();
        }

        $this->loadModel('BlogArticlesComments');

        $comment = $this->BlogArticlesComments
            ->find()
            ->contain([
                'BlogArticles'
            ])
            ->where([
                'BlogArticlesComments.id' => $id
            ])
            ->first();

        if (is_null($comment)) {
            $this->Flash->error(__("This comment doesn't exist or has been deleted !"));

            return $this->redirect($this->referer());
        }

        //Current user.
        $this->loadModel('Users');
        $currentUser = $this->Users
            ->find()
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select(['id', 'group_id'])
            ->first();

        if ($comment->user_id != $this->Auth->user('id') && !$currentUser->group->is_staff) {
            $this->Flash->error(__("You don't have the authorization to edit this comment !"));

            return $this->redirect($this->referer());
        }

        $this->BlogArticlesComments->patchEntity($comment, $this->request->getParsedBody());
        if ($this->BlogArticlesComments->save($comment)) {
            $this->Flash->success(__("This comment has been edited successfully !"));
        }

        return $this->redirect(['action' => 'go', $comment->id]);
    }
}
