<?php
namespace App\Event\Forum;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

class Reader implements EventListenerInterface
{
    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Reader.Thread' => 'threadReader',
            'Reader.Category' => 'categoryReader'
        ];
    }

    /**
     * Event on thread readed
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    public function threadReader(Event $event)
    {
        $this->ThreadsTrackers = TableRegistry::get('ForumThreadsTrackers');

        $data = [
            'user_id' => $event->data['user_id'],
            'thread_id' => $event->data['thread_id'],
            'category_id' => $event->data['category_id']
        ];

        $old = $this->ThreadsTrackers
            ->find()
            ->where($data)
            ->first();

        if (!is_null($old)) {
            $read = $this->ThreadsTrackers->patchEntity($old, $data);
        } else {
            $read = $this->ThreadsTrackers->newEntity($data);
        }
        $read->date = new Time();

        if ($this->ThreadsTrackers->save($read)) {
            return true;
        }

        return false;
    }

    /**
     * Event triggered when user access to a forum category node
     * checks how there unread thread.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    public function categoryReader(Event $event)
    {
        $this->Threads = TableRegistry::get('ForumThreads');

        $userId = $event->data['user_id'];
        $descendants = $event->data['descendants'];
        $category = $event->data['category'];

        $threads = $this->Threads
            ->find()
            ->select(['id', 'category_id', 'last_post_date', 'created'])
            ->where([
                'category_id' => $category->id,
            ])
            ->toArray();

        $unread = 0;

        //Check how many threads are unread for this category.
        if (!is_null($threads)) {
            foreach ($threads as $thread) {
                if (!$this->_checkThreadTracker($userId, $thread)) {
                    $unread++;
                }
            }
        }

        //Check how many threads are unread for all childrens of this category.
        foreach ($descendants as $children) {
            $unread += $this->_checkChildrens($children, $userId, $unread);
        }

        $data = [
            'user_id' => $userId,
            'category_id' => $category->id,
        ];

        return $this->_saveTracker($data, $unread);
    }

    /**
     * Check if the threadTracker exist and if the user has readed this thread.
     *
     * @param int $userId The user id.
     * @param \App\Model\Entity\ForumThread $thread The thread that was fired.
     *
     * @return bool
     */
    protected function _checkThreadTracker($userId, $thread)
    {
        $this->ThreadsTrackers = TableRegistry::get('ForumThreadsTrackers');

        $threadReaded = $this->ThreadsTrackers
            ->find()
            ->where([
                'user_id' => $userId,
                'thread_id' => $thread->id
            ])
            ->first();

        if (is_null($threadReaded) || $threadReaded->date < $thread->last_post_date) {
            return false;
        }

        return true;
    }

    /**
     * Check the current child of a category node and count unread thread
     *
     * @param \App\Model\Entity\ForumThread $children The children that was fired.
     * @param int $userId The user id.
     * @param int $unread The number of unread threads.
     *
     * @return mixed
     */
    protected function _checkChildrens($children, $userId, $unread)
    {
        $this->Threads = TableRegistry::get('ForumThreads');
        $this->Categories = TableRegistry::get('ForumCategories');

        $threads = $this->Threads
            ->find()
            ->select(['id', 'category_id', 'last_post_date', 'created'])
            ->where([
                'category_id' => $children->id,
            ]);

        $unreadChildren = 0;
        foreach ($threads as $thread) {
            if (!$this->_checkThreadTracker($userId, $thread)) {
                $unreadChildren++;
            }
        }

        //List all childrens where the category is open.
        $childs = $this->Categories
            ->find()
            ->select(['id', 'title'])
            ->where([
                'lft >' => $children->lft,
                'rght <' => $children->rght,
                'category_open' => 1
            ])
            ->toArray();

        foreach ($childs as $child) {
            $unreadSubChil = 0;

            $childsThreads = $this->Threads
                ->find()
                ->select(['id', 'category_id', 'last_post_date', 'created'])
                ->where([
                    'category_id' => $child->id,
                ])
                ->toArray();

            foreach ($childsThreads as $thread) {
                if (!$this->_checkThreadTracker($userId, $thread)) {
                    $unreadSubChil++;
                }
            }

            $data = [
                'user_id' => $userId,
                'category_id' => $child->id
            ];

            $this->_saveTracker($data, $unreadSubChil);

            $unreadChildren += $unreadSubChil;
        }

        $data = [
            'user_id' => $userId,
            'category_id' => $children->id
        ];
        $this->_saveTracker($data, $unreadChildren);

        $unread += $unreadChildren;

        return $unread;
    }

    /**
     * Save the Categories Trackers.
     *
     * @param int $data The data to use.
     * @param int $unread The number of unread threads.
     *
     * @return mixed
     */
    protected function _saveTracker($data, $unread)
    {
        $this->CategoriesTrackers = TableRegistry::get('ForumCategoriesTrackers');

        $old = $this->CategoriesTrackers
            ->find()
            ->where($data)
            ->first();

        if (!is_null($old)) {
            $tracker = $this->CategoriesTrackers->patchEntity($old, $data);
        } else {
            $tracker = $this->CategoriesTrackers->newEntity($data);
        }

        $tracker->nbunread = $unread;
        $tracker->date = new Time();

        if ($this->CategoriesTrackers->save($tracker)) {
            return true;
        }

        return false;
    }
}
