<?php
namespace App\Event\Forum;

use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\I18n\Number;
use Cake\ORM\TableRegistry;

class Statistics implements EventListenerInterface
{

    /**
     * Prefix used for the Cache keys.
     *
     * @var string
     */
    protected $_prefix = 'statistics';

    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return array(
            'Model.ForumThreads.new' => 'newThreadStats',
            'Model.ForumPosts.new' => 'newPostStats',
            'Model.Users.register' => 'newUserStats',
            'Model.Groups.update' => 'updateGroupStats',
            'Model.ForumPostsLikes.update' => 'newPostsLikeStats'
        );
    }

    /**
     * Re-count the number of posts likes and write it in the Cache.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return int|false
     */
    public function newPostsLikeStats(Event $event)
    {
        $this->ForumPostsLikes = TableRegistry::get('ForumPostsLikes');

        $totalPostsLikes = $this->ForumPostsLikes->find()->count();
        $totalPostsLikes = Number::format($totalPostsLikes);

        if ($this->_writeCache($totalPostsLikes, 'TotalPostsLikes')) {
            return $totalPostsLikes;
        }

        return false;
    }

    /**
     * Re-count the number of posts and write it in the Cache.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return int|false
     */
    public function newPostStats(Event $event)
    {
        $this->ForumPosts = TableRegistry::get('ForumPosts');

        $totalPosts = $this->ForumPosts->find()->count();
        $totalPosts = Number::format($totalPosts);

        if ($this->_writeCache($totalPosts, 'TotalPosts')) {
            return $totalPosts;
        }

        return false;
    }

    /**
     * Re-count the number of threads and write it in the Cache.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return int|false
     */
    public function newThreadStats(Event $event)
    {
        $this->ForumThreads = TableRegistry::get('ForumThreads');

        $totalThreads = $this->ForumThreads->find()->count();
        $totalThreads = Number::format($totalThreads);

        if ($this->_writeCache($totalThreads, 'TotalThreads')) {
            return $totalThreads;
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

        $result = Cache::write($this->_prefix . $key, $data, 'forum');
        if ($result) {
            return true;
        }

        return false;
    }
}
