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
     * @param Event $event
     *
     * @return bool
     */
    public function threadReader(Event $event)
    {
        $this->ThreadsTrackers = TableRegistry::get('ForumThreadsTrackers');

        $data = [
            'user_id' => $event->data['user'],
            'thread_id' => $event->data['thread'],
            'category_id' => $event->data['category']
        ];

        $old = $this->ThreadsTrackers
            ->find()
            ->where($data)
            ->first();

        if ($old) {
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
     * Checks how there unread thread.
     *
     * @param Event $event
     * @return bool
     */
    public function categoryReader(Event $event)
    {
        $this->Threads = TableRegistry::get('ForumThreads');

        $user = $event->data['user'];
        $descendants = $event->data['descendants'];
        $category = $event->data['category'];
        $NBunread = 0;

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
                if (!$this->_checkThreadTracker($user, $thread)) {
                    $NBunread++;
                }
            }
        }

        //Combien de topic sont non lu dans les enfants et sous enfants
        foreach ($descendants as $k => $children) {
            // Compte les NBUnread sur cet enfant
            $NBunread = $this->_checkChildrens($children, $user, $NBunread, $k);
        }

        $data = [
            'user_id' => $user,
            'category_id' => $category->id,
        ];

        return $this->_saveTracker($data, $NBunread);
    }

    /**
     * Just check if the threadTracker exist and if the readed date
     * are after the last_post_date. Return bool
     *
     * @param $user
     * @param $thread
     *
     * @return bool
     */
    private function _checkThreadTracker($user, $thread)
    {
        $this->ThreadsTrackers = TableRegistry::get('ForumThreadsTrackers');

        $threadReaded = $this->ThreadsTrackers
            ->find()
            ->where([
                'user_id' => $user,
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
     * @param $children
     * @param $user
     * @param $NBunread
     * @param $k
     *
     * @return mixed
     */
    private function _checkChildrens($children, $user, $NBunread)
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
            if (!$this->_checkThreadTracker($user, $thread)) {
                $NBunread++;
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
            $NBunread2 = 0;

            $Childsthreads = $this->Threads
                ->find()
                ->select(['id', 'category_id', 'last_post_date', 'created'])
                ->where([
                    'category_id' => $child->id,

                ])
                ->toArray();

            foreach ($Childsthreads as $thread) {
                //debug($this->_checkThreadTracker($user, $thread));
                if (!$this->_checkThreadTracker($user, $thread)) {
                    $NBunread2++;
                }
            }

            $data = [
                'user_id' => $user,
                'category_id' => $child->id
            ];

            //$this->_saveTracker($data, $NBunread2);

            $NBunread += $NBunread2;
        }

        return $NBunread;
    }

    /**
     * @param $data
     * @param $NBunread
     * @return bool
     */
    private function _saveTracker($data, $NBunread)
    {
        $this->CategoriesTrackers = TableRegistry::get('ForumCategoriesTrackers');

        $old = $this->CategoriesTrackers
            ->find()
            ->where($data)
            ->first();

        if ($old) {
            $read = $this->CategoriesTrackers->patchEntity($old, $data);
            $read->nbunread = $NBunread;
            $read->date = new Time();

            if ($this->CategoriesTrackers->save($read)) {
                return true;
            }
        }

        $read = $this->CategoriesTrackers->newEntity($data);
        $read->nbunread = $NBunread;
        $read->date = new Time();

        if ($this->CategoriesTrackers->save($read)) {
            return true;
        }

        return false;
    }
}
