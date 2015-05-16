<?php
/**
 * Created by PhpStorm.
 * User: jc
 * Date: 12/05/2015
 * Time: 09:13
 */

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

	public function deletePost(Event $event)
	{
		if (!isset($event->data['thread'])) {
			return false;
		}
		$thread = $event->data['thread'];
		$NewLastPost = $this->Posts->find()->where(['thread_id' => $thread->id])->order(['created' => 'DESC'])->first();

		if ($this->__updateCategories($thread, $NewLastPost)) {
			return true;
		}

		return false;
	}

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
			$parent->last_post_id = $post->id;
			$this->ForumCategories->save($parent);
		}

		return true;
	}
} 