<?php
namespace App\Controller\Forum;

use App\Controller\AppController;
use App\Event\Badges;
use App\Event\Forum\Followers;
use App\Event\Forum\LastPostUpdater;
use App\Event\Forum\Notifications;
use App\Event\Forum\Reader;
use App\Event\Forum\Statistics;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\utility\Inflector;

class ThreadsController extends AppController
{

    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'ForumAntiSpam' => [
            'className' => 'App\Controller\Component\Forum\AntiSpamComponent'
        ]
    ];

    /**
     * Create a new thread.
     *
     * @return \Cake\Network\Response
     */
    public function create()
    {
        $this->loadModel('ForumThreads');
        $this->loadModel('ForumCategories');

        $thread = $this->ForumThreads->newEntity($this->request->data, ['validate' => 'create']);

        $category = $this->ForumCategories
            ->find()
            ->select(['id', 'title', 'category_open'])
            ->where([
                'ForumCategories.id' => $this->request->id
            ])
            ->first();

        //Check if the category if found is found.
        if (is_null($category)) {
            $this->Flash->error(__("This category doesn't exist or has been deleted !"));

            return $this->redirect($this->referer());
        }

        //Check if the category is not closed to threads.
        if ($category->category_open == false) {
            $this->Flash->error(__("You can't create a thread in the category <strong>{0}</strong> because this category is closed !", h($category->title)));

            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            //Spamming Restrictions.
            if (!$this->ForumAntiSpam->check('ForumThreads', $this->request->session()->read('Auth.User'))) {
                $this->Flash->error(__("You can't not create a thread in the next 5 minutes due to spamming restrictions."));

                return $this->redirect($this->referer());
            }

            $thread->category_id = $this->request->id;
            $thread->last_post_user_id = $this->Auth->user('id');
            $thread->user_id = $this->Auth->user('id');

            if ($newThread = $this->ForumThreads->save($thread)) {
                $this->loadModel('ForumPosts');

                $post = [];
                $post['thread_id'] = $newThread->id;
                $post['user_id'] = $this->Auth->user('id');
                $post['message'] = $this->request->data['message'];
                $post = $this->ForumPosts->newEntity($post);
                $newPost = $this->ForumPosts->save($post);

                $newThread->first_post_id = $newPost->id;
                $newThread->last_post_date = $newPost->created;
                $newThread->last_post_id = $newPost->id;
                $newThread->reply_count = 0;
                $this->ForumThreads->save($newThread);

                //LastPostUpdater Event.
                $this->eventManager()->attach(new LastPostUpdater());
                $event = new Event('LastPostUpdater.new', $this, [
                    'thread' => $newThread,
                    'post' => $newPost
                ]);
                $this->eventManager()->dispatch($event);

                //Statistics Event.
                $this->eventManager()->attach(new Statistics());
                $event = new Event('Model.ForumThreads.new', $this);
                $this->eventManager()->dispatch($event);

                //Followers Event.
                $this->eventManager()->attach(new Followers());
                $event = new Event('Model.ForumThreadsFollowers.new', $this, [
                    'user_id' => $this->Auth->user('id'),
                    'thread_id' => $newThread->id
                ]);
                $this->eventManager()->dispatch($event);

                $this->Flash->success(__('Your thread has been created successfully !'));

                return $this->redirect([
                    'controller' => 'posts',
                    'action' => 'go',
                    $newPost->id
                ]);

            }
        }

        //Breadcrumbs.
        $breadcrumbs = $this->ForumCategories->find('path', ['for' => $this->request->id])->toArray();

        $this->set(compact('thread', 'breadcrumbs'));
    }

    /**
     * Edit a thread.
     *
     * @return \Cake\Network\Response
     */
    public function edit()
    {
        $this->loadModel('ForumThreads');

        if ($this->request->is('put')) {
            $thread = $this->ForumThreads
                ->find()
                ->where([
                    'ForumThreads.id' => $this->request->id
                ])
                ->first();

            //Check if the thread is found.
            if (is_null($thread)) {
                $this->Flash->error(__("This thread doesn't exist or has been deleted !"));

                return $this->redirect($this->referer());
            }

            //Check if the user has the permission to edit it.
            if ($this->Auth->isAuthorized() === false) {
                $this->Flash->error(__("You don't have the authorization to edit this post !"));

                return $this->redirect([
                    '_name' => 'forum-threads',
                    'slug' => Inflector::slug($thread->title, '-'),
                    'id' => $thread->id
                ]);
            }

            $this->loadModel('ForumCategories');
            $category = $this->ForumCategories
                ->find()
                ->select(['id', 'title', 'category_open'])
                ->where([
                    'ForumCategories.id' => $this->request->data['category_id']
                ])
                ->first();

            //Check if the category is found.
            if (is_null($category)) {
                $this->Flash->error(__("This category doesn't exist or has been deleted !"));

                return $this->redirect($this->referer());
            }

            //Check if the category is not closed to threads.
            if ($category->category_open == false) {
                $this->Flash->error(__("You can't assign this thread to the category <strong>{0}</strong> because this category is closed !", h($category->title)));

                return $this->redirect($this->referer());
            }

            $this->ForumThreads->patchEntity($thread, $this->request->data, ['validate' => 'edit']);

            if ($this->ForumThreads->save($thread)) {
                if ($thread->sticky == true) {
                    $this->Flash->success(__('Your thread has been edited and set to sticky successfully !'));
                } else {
                    $this->Flash->success(__('Your thread has been edited successfully !'));
                }

                return $this->redirect([
                    '_name' => 'forum-threads',
                    'slug' => $thread->title,
                    'id' => $thread->id
                ]);
            }
        }

        $this->redirect($this->referer());
    }

    /**
     * Reply to a thread.
     *
     * @return \Cake\Network\Response
     */
    public function reply()
    {
        $this->loadModel('ForumPosts');

        if ($this->request->is('post')) {
            //Spamming Restrictions.
            if (!$this->ForumAntiSpam->check('ForumPosts', $this->request->session()->read('Auth.User'))) {
                $this->Flash->error(__("You can't not reply to a thread in the next 5 minutes due to spamming restrictions."));

                return $this->redirect($this->referer());
            }

            $this->loadModel('ForumThreads');

            $thread = $this->ForumThreads
                ->find()
                ->where(['ForumThreads.id' => $this->request->id])
                ->first();

            //Check if the thread is found.
            if (is_null($thread)) {
                $this->Flash->error(__("This thread doesn't exist or has been deleted !"));

                return $this->redirect($this->referer());
            }

            //Check if the thread is open.
            if ($thread->thread_open != 1) {
                $this->Flash->error(__("This thread is closed or has been deleted !"));

                return $this->redirect($this->referer());
            }

            //Build the newEntity for the post form.
            $this->request->data['forum_thread']['id'] = $this->request->id;
            $this->request->data['forum_thread']['last_post_date'] = new Time();
            $this->request->data['forum_thread']['last_post_user_id'] = $this->Auth->user('id');
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->request->data['thread_id'] = $this->request->id;

            $post = $this->ForumPosts->newEntity($this->request->data, [
                'associated' => ['ForumThreads'],
                'validate' => 'create'
            ]);

            //Handle validation errors (Due to the redirect)
            if (!empty($post->errors())) {
                $this->Flash->threadReply('Validation errors', [
                    'key' => 'ThreadReply',
                    'params' => [
                        'errors' => $post->errors()
                    ]
                ]);

                return $this->redirect($this->referer());
            }

            if ($post->forum_thread->isNew() === true) {
                $post->forum_thread->isNew(false);
            }

            if ($newPost = $this->ForumPosts->save($post)) {
                //Update the last post id for the thread.
                $this->loadModel('ForumThreads');
                $thread = $this->ForumThreads->get($this->request->id);
                $thread->last_post_id = $newPost->id;
                $this->ForumThreads->save($thread);

                //LastPostUpdater Event.
                $this->eventManager()->attach(new LastPostUpdater());
                $event = new Event('LastPostUpdater.new', $this, [
                    'thread' => $thread,
                    'post' => $newPost
                ]);
                $this->eventManager()->dispatch($event);

                //Statistics Event.
                $this->eventManager()->attach(new Statistics());
                $stats = new Event('Model.ForumPosts.new', $this);
                $this->eventManager()->dispatch($stats);

                //Followers Event.
                $this->eventManager()->attach(new Followers());
                $event = new Event('Model.ForumThreadsFollowers.new', $this, [
                    'user_id' => $this->Auth->user('id'),
                    'thread_id' => $thread->id
                ]);
                $this->eventManager()->dispatch($event);

                //Notifications Event.
                $this->eventManager()->attach(new Notifications());
                $event = new Event('Model.Notifications.dispatch', $this, [
                    'sender_id' => $this->Auth->user('id'),
                    'thread_id' => $thread->id,
                    'type' => 'thread.reply'
                ]);
                $this->eventManager()->dispatch($event);

                //Badges Event.
                $this->ForumPosts->eventManager()->attach(new Badges($this));

                $threadOpen = isset($this->request->data['forum_thread']['thread_open']) ? $this->request->data['forum_thread']['thread_open'] : true;

                if ($threadOpen == false) {
                    $this->Flash->success(__('Your reply has been posted successfully and the thread has been closed !'));
                } else {
                    $this->Flash->success(__('Your reply has been posted successfully !'));
                }

                //Redirect the user to the last page of the article.
                return $this->redirect([
                    'controller' => 'posts',
                    'action' => 'go',
                    'prefix' => 'forum',
                    $newPost->id
                ]);
            }
        }

        $this->redirect($this->referer());
    }

    /**
     * Lock a thread.
     *
     * @return \Cake\Network\Response
     */
    public function lock()
    {
        $this->loadModel('ForumThreads');

        $thread = $this->ForumThreads
            ->find()
            ->where([
                'ForumThreads.id' => $this->request->id
            ])
            ->select([
                'ForumThreads.id',
                'ForumThreads.thread_open',
                'ForumThreads.user_id',
                'ForumThreads.title'
            ])
            ->first();

        //Check if the thread is found.
        if (is_null($thread)) {
            $this->Flash->error(__("This thread doesn't exist or has been deleted !"));

            return $this->redirect($this->referer());
        }

        //Check if the thread is not already open.
        if ($thread->thread_open == false) {
            $this->Flash->error(__("This thread is already closed !"));

            return $this->redirect([
                '_name' => 'forum-threads',
                'slug' => Inflector::slug($thread->title, '-'),
                'id' => $thread->id
            ]);
        }

        //Check if the user has the permission to lock it.
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

        if ($thread->user_id != $this->Auth->user('id') && !$currentUser->group->is_staff) {
            $this->Flash->error(__("You don't have the authorization to lock this post !"));

            return $this->redirect([
                '_name' => 'forum-threads',
                'slug' => Inflector::slug($thread->title, '-'),
                'id' => $thread->id
            ]);
        }

        $thread->thread_open = false;

        if ($this->ForumThreads->save($thread)) {
            //Notifications Event.
            $this->eventManager()->attach(new Notifications());
            $event = new Event('Model.Notifications.new', $this, [
                'sender_id' => $this->Auth->user('id'),
                'thread_id' => $thread->id,
                'type' => 'thread.lock'
            ]);
            $this->eventManager()->dispatch($event);

            $this->Flash->success(__("This thread has been locked successfully !"));

            return $this->redirect([
                '_name' => 'forum-threads',
                'slug' => Inflector::slug($thread->title, '-'),
                'id' => $thread->id
            ]);
        }

        $this->redirect($this->referer());
    }

    /**
     * Unlock a thread.
     *
     * @return \Cake\Network\Response
     */
    public function unlock()
    {
        $this->loadModel('ForumThreads');

        $thread = $this->ForumThreads
            ->find()
            ->where([
                'ForumThreads.id' => $this->request->id
            ])
            ->select([
                'ForumThreads.id',
                'ForumThreads.thread_open',
                'ForumThreads.user_id',
                'ForumThreads.title'
            ])
            ->first();

        //Check if the thread is found.
        if (is_null($thread)) {
            $this->Flash->error(__("This thread doesn't exist or has been deleted !"));

            return $this->redirect($this->referer());
        }

        //Check if the thread is not already open.
        if ($thread->thread_open == true) {
            $this->Flash->error(__("This thread is already open !"));

            return $this->redirect([
                '_name' => 'forum-threads',
                'slug' => Inflector::slug($thread->title, '-'),
                'id' => $thread->id
            ]);
        }

        //Check if the user has the permission to unlock it.
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

        if ($thread->user_id != $this->Auth->user('id') && !$currentUser->group->is_staff) {
            $this->Flash->error(__("You don't have the authorization to unlock this post !"));

            return $this->redirect([
                '_name' => 'forum-threads',
                'slug' => Inflector::slug($thread->title, '-'),
                'id' => $thread->id
            ]);
        }

        $thread->thread_open = true;
        if ($this->ForumThreads->save($thread)) {
            $this->Flash->success(__("This thread has been unlocked successfully !"));

            return $this->redirect([
                '_name' => 'forum-threads',
                'slug' => Inflector::slug($thread->title, '-'),
                'id' => $thread->id
            ]);
        }

        $this->redirect($this->referer());
    }

    /**
     * Follow a thread.
     *
     * @return \Cake\Network\Response
     */
    public function follow()
    {
        $this->loadModel('ForumThreads');
        $thread = $this->ForumThreads
            ->find()
            ->where([
                'ForumThreads.id' => $this->request->id
            ])
            ->select([
                'ForumThreads.id'
            ])
            ->first();

        //Check if the thread is found.
        if (is_null($thread)) {
            $this->Flash->error(__("This thread doesn't exist or has been deleted !"));

            return $this->redirect($this->referer());
        }

        $this->loadModel('ForumThreadsFollowers');
        $isFollowed = $this->ForumThreadsFollowers
            ->find()
            ->where([
                'ForumThreadsFollowers.user_id' => $this->Auth->user('id'),
                'ForumThreadsFollowers.thread_id' => $thread->id
            ])
            ->first();

        if (!is_null($isFollowed)) {
            $this->Flash->error(__("You already follow this thread !"));

            return $this->redirect($this->referer());
        }

        $data = [];
        $data['thread_id'] = $thread->id;
        $data['user_id'] = $this->Auth->user('id');
        $follower = $this->ForumThreadsFollowers->newEntity($data);

        if ($this->ForumThreadsFollowers->save($follower)) {
            $this->Flash->success(__("You successfully follow this thread now !"));

            return $this->redirect($this->referer());
        } else {
            $this->Flash->error(__("There was an error while following the thread."));

            return $this->redirect($this->referer());
        }
    }

    /**
     * Unfollow a thread.
     *
     * @return \Cake\Network\Response
     */
    public function unfollow()
    {
        $this->loadModel('ForumThreads');
        $thread = $this->ForumThreads
            ->find()
            ->where([
                'ForumThreads.id' => $this->request->id
            ])
            ->select([
                'ForumThreads.id'
            ])
            ->first();

        //Check if the thread is found.
        if (is_null($thread)) {
            $this->Flash->error(__("This thread doesn't exist or has been deleted !"));

            return $this->redirect($this->referer());
        }

        $this->loadModel('ForumThreadsFollowers');
        $follower = $this->ForumThreadsFollowers
            ->find()
            ->where([
                'ForumThreadsFollowers.user_id' => $this->Auth->user('id'),
                'ForumThreadsFollowers.thread_id' => $thread->id
            ])
            ->first();

        if (is_null($follower)) {
            $this->Flash->error(__("You don't follow this thread !"));

            return $this->redirect($this->referer());
        }

        if ($this->ForumThreadsFollowers->delete($follower)) {
            $this->Flash->success(__("You successfully unfollow this thread now !"));

            return $this->redirect($this->referer());
        } else {
            $this->Flash->error(__("There was an error while unfollowing this thread."));

            return $this->redirect($this->referer());
        }
    }
}
