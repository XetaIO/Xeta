<?php

namespace App\Event\Forum;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

/**
 * Class LastPostUpdater
 * @package App\Event\Forum
 */
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

    public function __construct()
    {
        $this->ForumCategories = TableRegistry::get('ForumCategories');
        $this->Threads = TableRegistry::get('ForumThreads');
        $this->Posts = TableRegistry::get('ForumPosts');
    }

    /**
     * We send a new notification to an user.
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

        if ($this->__updateCategories($event->data['thread'], $event->data['post'])) {
            return true;
        }

        return false;

    }

    /**
     * @param Event $event
     * @return bool
     */
    public function deletePost(Event $event)
    {
        if (!isset($event->data['thread'])) {
            return false;
        }
        $thread = $event->data['thread'];
        $post = false;

        if ($this->__updateCategories($thread, $post)) {
            return true;
        }

        return false;
    }

    /**
     * Update Parents Categories
     *
     * @param $thread
     * @param $post
     * @return bool
     */
    private function __updateCategories($thread, $post)
    {
        $category = $this->ForumCategories->get($thread->category_id);
        $parents = $this->ForumCategories
            ->find()
            ->where([
                'lft <=' => $category->lft,
                'rght >=' => $category->rght
            ]);
        foreach ($parents as $parent) {
            if (!$post) {
                $conditions = [];
                $childrens = $this->ForumCategories
                    ->find('children', ['for' => $parent->id])->toArray();
                if ($childrens) {
                    foreach ($childrens as $child) {
                        $cdt = ['category_id' => $child->id];
                        array_push($conditions, $cdt);
                    }
                    $LastThread = $this->Threads->find()->where(['OR' => $conditions])->order(['last_post_date' => 'DESC'])->first();
                } else {
                    $LastThread = $this->Threads->find()->where(['category_id' => $parent->id])->order(['last_post_date' => 'DESC'])->first();
                }
                if ($LastThread) {
                    $parent->last_post_id = $LastThread->id;
                    $this->ForumCategories->save($parent);
                }
            } else {
                $parent->last_post_id = $post->id;
                $this->ForumCategories->save($parent);
            }
        }
        return true;
    }
}
