<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ForumCategoriesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 *
 * @return void
 */
	public function initialize(array $config) {
		$this->table('forum_categories');
		$this->displayField('title');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Tree');

		$this->belongsTo('ParentForumCategories', [
			'className' => 'ForumCategories',
			'foreignKey' => 'parent_id'
		]);
		$this->hasMany('ChildForumCategories', [
			'className' => 'ForumCategories',
			'foreignKey' => 'parent_id'
		]);
		$this->hasMany('ForumThreads', [
			'foreignKey' => 'category_id'
		]);
		$this->belongsTo('LastPost', [
			'className' => 'ForumPosts',
			'foreignKey' => 'last_post_id'
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
		$rules->add($rules->existsIn(['parent_id'], 'ParentForumCategories'));
		return $rules;
	}
}
