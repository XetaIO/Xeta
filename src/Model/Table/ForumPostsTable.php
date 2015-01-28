<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
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

		$this->belongsTo('Threads', [
			'foreignKey' => 'thread_id'
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id'
		]);
		$this->belongsTo('LastEditUsers', [
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
 * Returns a rules checker object that will be used for validating
 * application integrity.
 *
 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
 *
 * @return \Cake\ORM\RulesChecker
 */
	public function buildRules(RulesChecker $rules) {
		$rules->add($rules->existsIn(['thread_id'], 'Threads'));
		$rules->add($rules->existsIn(['user_id'], 'Users'));
		$rules->add($rules->existsIn(['last_edit_user_id'], 'LastEditUsers'));
		return $rules;
	}
}
