<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ForumThreadsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 *
 * @return void
 */
	public function initialize(array $config) {
		$this->table('forum_threads');
		$this->displayField('title');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('CounterCache', [
			'Users' => ['forum_thread_count'],
			'ForumCategories' => ['thread_count']
		]);

		$this->belongsTo('ForumCategories', [
			'foreignKey' => 'category_id'
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id'
		]);
		$this->belongsTo('FirstPosts', [
			'className' => 'ForumPosts',
			'foreignKey' => 'first_post_id'
		]);
		$this->belongsTo('LastPosts', [
			'className' => 'ForumPosts',
			'foreignKey' => 'last_post_id'
		]);
		$this->belongsTo('LastPostUsers', [
			'className' => 'Users',
			'foreignKey' => 'last_post_user_id'
		]);
		$this->hasMany('ForumPosts', [
			'foreignKey' => 'thread_id',
			'dependent' => true,
			'cascadeCallbacks' => true
		]);
	}

/**
 * Create validation rules.
 *
 * @param \Cake\Validation\Validator $validator Validator instance.
 *
 * @return \Cake\Validation\Validator
 */
	public function validationCreate(Validator $validator) {
		$validator
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create');

		return $validator;
	}
}
