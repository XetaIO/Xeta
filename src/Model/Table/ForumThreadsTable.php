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
 * Returns a rules checker object that will be used for validating
 * application integrity.
 *
 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
 *
 * @return \Cake\ORM\RulesChecker
 */
/*	public function buildRules(RulesChecker $rules) {
		$rules->add($rules->existsIn(['category_id'], 'Categories'));
		$rules->add($rules->existsIn(['user_id'], 'Users'));
		$rules->add($rules->existsIn(['first_post_id'], 'FirstPosts'));
		$rules->add($rules->existsIn(['last_post_id'], 'LastPosts'));
		$rules->add($rules->existsIn(['last_post_user_id'], 'LastPostUsers'));
		return $rules;
	}*/
}
