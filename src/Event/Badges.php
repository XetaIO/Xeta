<?php
namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

class Badges implements EventListenerInterface {

/**
 * Construct method.
 *
 * @param object $controller The controller instance where the Event is dispatched.
 *
 * @return void
 */
	public function __construct($controller) {
		$this->Flash = $controller->loadComponent('Flash');
	}

/**
 * ImplementedEvents method.
 *
 * @return array
 */
	public function implementedEvents() {
		return array(
			'Model.BlogArticlesComments.add' => 'commentsBadge',
			'Model.Users.register' => 'registerBadge'
		);
	}

/**
 * Unlock all badges related to comments.
 *
 * @param \Cake\Event\Event $event The Model.BlogArticlesComments.add event that was fired.
 *
 * @return bool
 */
	public function registerBadge(Event $event) {
		$this->Badges = TableRegistry::get('Badges');

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
	public function commentsBadge(Event $event) {
		$this->Badges = TableRegistry::get('Badges');

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
			if ($userComments >= $badge['rule']) {
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
	protected function _unlockBadge($badge, $userId) {
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

		$data['badge_id'] = $badge['id'];
		$data['user_id'] = $userId;
		$newBadge = $this->BadgesUsers->newEntity($data);

		$this->BadgesUsers->save($newBadge, ['validate' => 'default']);

		$this->Flash->badge('You have unlock a badge !', [
			'key' => 'badge',
			'params' => [
				'badge' => $badge
			]
		]);

		return true;
	}
}
