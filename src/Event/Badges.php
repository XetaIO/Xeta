<?php
namespace App\Event;

use App\Event\Forum\Notifications;
use App\Model\Entity\BlogArticlesComment;
use App\Model\Entity\ForumPost;
use App\Model\Entity\User;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;

class Badges implements EventListenerInterface
{

    /**
     * Construct method.
     *
     * @param \Cake\Controller\Controller $controller The controller instance where the Event is dispatched.
     */
    public function __construct($controller = null)
    {
        if (is_null($controller)) {
            $this->registry = new ComponentRegistry(new Controller(new Request(), new Response()));
            $this->registry->load('Flash');
            $this->Flash = $this->registry->Flash;
        } else {
            $this->Flash = $controller->loadComponent('Flash');
        }
    }

    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Model.BlogArticlesComments.add' => 'commentsBadge',
            'Model.Users.register' => 'registerBadge',
            'Model.Users.premium' => 'premiumBadge',
            'Model.ForumPosts.reply' => 'postsReplyBadge'
        ];
    }

    /**
     * Unlock all badges related to the posts in the Forum.
     *
     * @param \Cake\Event\Event $event The Model.ForumPosts.reply event that was fired.
     *
     * @return bool
     */
    public function postsReplyBadge(Event $event)
    {
        $this->Badges = TableRegistry::get('Badges');

        if (!$event->data['post'] instanceof ForumPost) {
            return false;
        }

        $badges = $this->Badges
            ->find('all')
            ->select([
                'id',
                'name',
                'picture',
                'rule'
            ])
            ->where([
                'type' => 'postsForum'
            ])
            ->hydrate(false)
            ->toArray();

        if (empty($badges)) {
            return true;
        }

        $this->Users = TableRegistry::get('Users');

        $userId = $event->data['post']->user_id;

        $user = $this->Users
            ->find()
            ->where([
                'id' => $userId
            ])
            ->select([
                'forum_post_count'
            ])
            ->first();

        foreach ($badges as $badge) {
            if ($user['forum_post_count'] >= $badge['rule']) {
                $this->_unlockBadge($badge, $userId);
            }
        }

        return true;
    }

    /**
     * Unlock all badges related to premium.
     *
     * @param \Cake\Event\Event $event The Model.Users.premium event that was fired.
     *
     * @return bool
     */
    public function premiumBadge(Event $event)
    {
        $this->Badges = TableRegistry::get('Badges');

        if (!$event->data['user'] instanceof User) {
            return false;
        }

        $badges = $this->Badges
            ->find('all')
            ->select([
                'id',
                'name',
                'picture',
                'rule'
            ])
            ->where([
                'type' => 'premium'
            ])
            ->hydrate(false)
            ->toArray();

        if (empty($badges)) {
            return true;
        }

        $this->Users = TableRegistry::get('Users');

        $userId = $event->data['user']->id;

        $user = $this->Users
            ->find()
            ->where([
                'id' => $userId
            ])
            ->select([
                'end_subscription'
            ])
            ->first();

        foreach ($badges as $badge) {
            if ($user->premium == $badge['rule']) {
                $this->_unlockBadge($badge, $userId);
            }
        }

        return true;
    }

    /**
     * Unlock all badges related to comments.
     *
     * @param \Cake\Event\Event $event The Model.Users.register event that was fired.
     *
     * @return bool
     */
    public function registerBadge(Event $event)
    {
        $this->Badges = TableRegistry::get('Badges');

        if (!$event->data['user'] instanceof User) {
            return false;
        }

        $badges = $this->Badges
            ->find('all')
            ->select([
                'id',
                'name',
                'picture',
                'rule'
            ])
            ->where([
                'type' => 'registration'
            ])
            ->hydrate(false)
            ->toArray();

        if (empty($badges)) {
            return true;
        }

        $this->Users = TableRegistry::get('Users');

        $userId = $event->data['user']->id;
        $user = $this->Users
            ->find()
            ->where([
                'id' => $userId
            ])
            ->select([
                'created'
            ])
            ->first();

        $today = new Time();
        $created = $user->created;
        $diff = $today->diff($created)->y;

        foreach ($badges as $badge) {
            if ($diff >= $badge['rule']) {
                $this->_unlockBadge($badge, $userId);
            }
        }

        return true;
    }

    /**
     * Unlock all badges related to comments.
     *
     * @param \Cake\Event\Event $event The Model.BlogArticlesComments.add event that was fired.
     *
     * @return bool
     */
    public function commentsBadge(Event $event)
    {
        $this->Badges = TableRegistry::get('Badges');

        if (!$event->data['comment'] instanceof BlogArticlesComment) {
            return false;
        }

        $badges = $this->Badges
            ->find('all')
            ->select([
                'id',
                'name',
                'picture',
                'rule'
            ])
            ->where([
                'type' => 'comments'
            ])
            ->hydrate(false)
            ->toArray();

        if (empty($badges)) {
            return true;
        }

        $this->Users = TableRegistry::get('Users');

        $userId = $event->data['comment']->user_id;
        $userComments = $this->Users
            ->find()
            ->where([
                'id' => $userId
            ])
            ->select([
                'blog_articles_comment_count'
            ])
            ->hydrate(false)
            ->first();

        foreach ($badges as $badge) {
            if ($userComments['blog_articles_comment_count'] >= $badge['rule']) {
                $this->_unlockBadge($badge, $userId);
            }
        }

        return true;
    }

    /**
     * Unlock a badge and set a Flash message.
     *
     * @param array $badge The badge to unlock.
     * @param int $userId  The user at unlock the badge.
     *
     * @return bool
     */
    protected function _unlockBadge($badge, $userId)
    {
        $this->BadgesUsers = TableRegistry::get('BadgesUsers');

        $hasBadge = $this->BadgesUsers
            ->find()
            ->where([
                'badge_id' => $badge['id'],
                'user_id' => $userId
            ])
            ->first();

        if (!is_null($hasBadge)) {
            return true;
        }

        $data = [];
        $data['badge_id'] = $badge['id'];
        $data['user_id'] = $userId;
        $badge = $this->BadgesUsers->newEntity($data);

        $badge = $this->BadgesUsers->save($badge);

        $this->Flash->badge('You have unlock a badge !', [
            'key' => 'badge',
            'params' => [
                'badge' => $badge
            ]
        ]);
        
        EventManager::instance()->attach(new Notifications());
        $event = new Event('Model.Notifications.new', $this, [
            'type' => 'badge',
            'badge' => $badge
        ]);
        EventManager::instance()->dispatch($event);
        return true;
    }
}
