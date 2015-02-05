<?php
namespace App\Model\Table;

use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ForumPostsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 *
 * @return void
 */
	public function initialize(array $config) {
		$this->table('forum_posts');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('CounterCache', [
			'Users' => ['forum_post_count'],
			'ForumThreads' => ['reply_count']
		]);

		$this->belongsTo('ForumThreads', [
			'foreignKey' => 'thread_id'
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id'
		]);
		$this->belongsTo('LastEditUsers', [
			'className' => 'Users',
			'foreignKey' => 'last_edit_user_id'
		]);
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator Validator instance.
 *
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create');

		return $validator;
	}

/**
 * AfterSave callback.
 *
 * @param \Cake\Event\Event $event   The afterSave event that was fired.
 * @param \Cake\ORM\Entity $entity  The entity that was saved.
 * @param \ArrayObject $options The options passed to the callback.
 *
 * @return bool
 */
	public function afterSave(Event $event, Entity $entity, ArrayObject $options) {
		if ($entity->isNew()) {
			$event = new Event('Model.ForumPosts.reply', $this, [
				'post' => $entity
			]);
			$this->eventManager()->dispatch($event);
		}

		return true;
	}
}
