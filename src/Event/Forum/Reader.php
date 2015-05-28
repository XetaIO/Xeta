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
            $read->date = new Time();

            if ($this->ThreadsTrackers->save($read)) {
                return true;
            }
        }
        $read = $this->ThreadsTrackers->newEntity($data);
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
        $Unread = 0;

        $threads = $this->Threads
            ->find()
            ->select(['id', 'category_id', 'last_post_date', 'created'])
            ->where([
                'category_id' => $category->id,
            ])
            ->toArray();

        //Combien de topic sont non lu dans cette section
        if (!is_null($threads)) {
            foreach ($threads as $thread) {
                if (!$this->_checkThreadTracker($userId, $thread)) {
                    $Unread++;
                }
            }
        }

        //Combien de topic sont non lu dans les enfants et sous enfants
        foreach ($descendants as $children) {
            // Compte les NBUnread sur cet enfant
            $Unread = $this->_checkChildrens($children, $userId, $Unread);
        }

        $data = [
            'user_id' => $userId,
            'category_id' => $category->id,
        ];

        return $this->_saveTracker($data, $Unread);
    }

    /**
     * Just check if the threadTracker exist and if the readed date
     * are after the last_post_date. Return bool
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
     * @param int $Unread The number of unread threads.
     *
     * @return mixed
     */
    protected function _checkChildrens($children, $userId, $Unread)
    {
        $this->Threads = TableRegistry::get('ForumThreads');
        $this->Categories = TableRegistry::get('ForumCategories');

        $threads = $this->Threads
            ->find()
            ->select(['id', 'category_id', 'last_post_date', 'created'])
            ->where([
                'category_id' => $children->id,
            ]);

        foreach ($threads as $thread) {
            if (!$this->_checkThreadTracker($userId, $thread)) {
                $Unread++;
            }
        }

        // Liste tout les sous-enfants de niveau inférieur de l'enfant
        $childs = $this->Categories
            ->find()
            ->select(['id', 'title'])
            ->where([
                'lft >' => $children->lft,
                'rght <' => $children->rght
            ])
            ->toArray();

        // Boucle les sous-enfants et compte le NB unread
        foreach ($childs as $child) {
            $Unread2 = 0;

            $childsThreads = $this->Threads
                ->find()
                ->select(['id', 'category_id', 'last_post_date', 'created'])
                ->where([
                    'category_id' => $child->id,

                ])
                ->toArray();

            foreach ($childsThreads as $thread) {
                //debug($this->_checkThreadTracker($user, $thread));
                if (!$this->_checkThreadTracker($userId, $thread)) {
                    $Unread2++;
                }
            }

            $data = [
                'user_id' => $userId,
                'category_id' => $child->id
            ];

            //$this->_saveTracker($data, $NBunread2);

            $Unread += $Unread2;
        }

        return $Unread;
    }

    /**
     * Save the Categories Trackers.
     *
     * @param int $data The data to use.
     * @param int $Unread The number of unread threads.
     *
     * @return mixed
     */
    protected function _saveTracker($data, $Unread)
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

        $tracker->nbunread = $Unread;
        $tracker->date = new Time();

        if ($this->CategoriesTrackers->save($tracker)) {
            return true;
        }

        return false;
    }
}
