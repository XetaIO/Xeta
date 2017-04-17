<?php
namespace App\Event;

use App\Event\Notifications;
use App\Model\Entity\BlogArticlesComment;
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
        $this->Flash = $controller->loadComponent('Flash');
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
            'Model.Users.register' => 'registerBadge'
        ];
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
        $user = $event->getData('user');

        if (!$user instanceof User) {
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

        $userId = $event->getData('user')->id;
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
        $comment = $event->getData('comment');

        if (!$comment instanceof BlogArticlesComment) {
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

        $userId = $event->getData('comment')->user_id;
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
        $badgeUser = $this->BadgesUsers->newEntity($data);

        $badgeUser = $this->BadgesUsers->save($badgeUser);

        $this->Flash->badge('You have unlocked a badge !', [
            'key' => 'badge',
            'params' => [
                'badge' => $badge
            ]
        ]);

        EventManager::instance()->attach(new Notifications());
        $event = new Event('Model.Notifications.new', $this, [
            'type' => 'badge',
            'badge' => $badgeUser
        ]);
        EventManager::instance()->dispatch($event);

        return true;
    }
}
