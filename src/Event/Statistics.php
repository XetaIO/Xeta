<?php
namespace App\Event;

use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\I18n\Number;
use Cake\ORM\TableRegistry;

class Statistics implements EventListenerInterface
{

    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Model.Users.register' => 'newUserStats',
            'Model.Groups.update' => 'updateGroupStats',
            'Model.BlogArticles.new' => 'newArticleStats',
            'Model.BlogArticlesLikes.new' => 'newArticleLikeStats',
            'Model.BlogArticlesComments.new' => 'newArticleCommentStats'
        ];
    }

    /**
     * Count the articles and write it in the Cache.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return array|false
     */
    public function newArticleStats(Event $event)
    {
        $this->BlogArticles = TableRegistry::get('BlogArticles');

        $articles = $this->BlogArticles->find()->count();
        $articles = Number::format($articles);

        if ($this->_writeCache($articles, 'Articles')) {
            return $articles;
        }

        return false;
    }

    /**
     * Count the article's comments and write it in the Cache.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return array|false
     */
    public function newArticleCommentStats(Event $event)
    {
        $this->BlogArticlesComments = TableRegistry::get('BlogArticlesComments');

        $comments = $this->BlogArticlesComments->find()->count();
        $comments = Number::format($comments);

        if ($this->_writeCache($comments, 'ArticlesComments')) {
            return $comments;
        }

        return false;
    }

    /**
     * Count the article's likes and write it in the Cache.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return array|false
     */
    public function newArticleLikeStats(Event $event)
    {
        $this->BlogArticlesLikes = TableRegistry::get('BlogArticlesLikes');

        $likes = $this->BlogArticlesLikes->find()->count();
        $likes = Number::format($likes);

        if ($this->_writeCache($likes, 'ArticlesLikes')) {
            return $likes;
        }

        return false;
    }

    /**
     * Re-count the number of user and find the latest user and write it in the Cache.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return array|false
     */
    public function newUserStats(Event $event)
    {
        $this->Users = TableRegistry::get('Users');

        $totalUsers = $this->Users->find()->count();
        $totalUsers = Number::format($totalUsers);

        $lastRegistered = $this->Users->find('short')->order(['Users.created' => 'DESC'])->first();

        $data = [];
        $data['TotalUsers'] = $totalUsers;
        $data['LastRegistered'] = $lastRegistered;

        if ($this->_writeCache($data, 'Users')) {
            return $data;
        }

        return false;
    }

    /**
     * Get the Groups and write it in the Cache.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return array|false
     */
    public function updateGroupStats(Event $event)
    {
        $this->Groups = TableRegistry::get('Groups');

        $groups = $this->Groups->find('translations')->order(['Groups.id' => 'DESC'])->toArray();

        if ($this->_writeCache($groups, 'Groups')) {
            return $groups;
        }

        return false;
    }

    /**
     * Write the data into the Cache with the passed key.
     *
     * @param int|object|string $data The data to save in the Cache.
     * @param string $key The key to save the data.
     *
     * @return bool
     */
    protected function _writeCache($data, $key)
    {
        if (empty($data) || empty($key)) {
            return true;
        }

        $result = Cache::write($key, $data, 'statistics');
        if ($result) {
            return true;
        }

        return false;
    }
}
