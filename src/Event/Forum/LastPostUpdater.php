<?php
namespace App\Event\Forum;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

class LastPostUpdater implements EventListenerInterface
{
    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'LastPostUpdater.new' => 'newPost',
            'LastPostUpdater.delete' => 'deletePost'
        ];
    }

    /**
     * A new post has been posted.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return false
     */
    public function newPost(Event $event)
    {
        if (!isset($event->data['thread']) || !isset($event->data['post'])) {
            return false;
        }
        if ($this->_updateCategories($event->data['thread'], $event->data['post'])) {
            return true;
        }
        return false;
    }

    /**
     * A post has been deleted.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return false
     */
    public function deletePost(Event $event)
    {
        if (!isset($event->data['thread'])) {
            return false;
        }
        $this->ForumPosts = TableRegistry::get('ForumPosts');

        $thread = $event->data['thread'];
        $newLastPost = $this->ForumPosts
            ->find()
            ->where(['thread_id' => $thread->id])
            ->order(['created' => 'DESC'])
            ->first();

        if ($this->_updateCategories($thread, $newLastPost)) {
            return true;
        }

        return false;
    }

    /**
     * Update each parent categories related to the thread category.
     *
     * @param \App\Model\Entity\ForumThread $thread The thread where we must update the categories.
     * @param \App\Model\Entity\ForumPost $post The new last post.
     *
     * @return bool
     */
    protected function _updateCategories($thread, $post)
    {
        $this->ForumCategories = TableRegistry::get('ForumCategories');

        $category = $this->ForumCategories->get($thread->category_id);
        $parents = $this->ForumCategories
            ->find()
            ->where([
                'lft <=' => $category->lft,
                'rght >=' => $category->rght
            ]);

        foreach ($parents as $parent) {
            $parent->last_post_id = $post->id;
            $this->ForumCategories->save($parent);
        }

        return true;
    }
}
