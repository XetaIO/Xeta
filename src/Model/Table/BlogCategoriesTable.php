<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BlogCategories Model
 */
class BlogCategoriesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('blog_categories');
		$this->displayField('title');
		$this->primaryKey('id');
		$this->addBehavior('Timestamp');
		$this->addBehavior('Sluggable');

		$this->hasMany('BlogArticles', [
			'foreignKey' => 'category_id',
		]);
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator Instance of the validator.
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->validatePresence('title', 'create')
			->notEmpty('title')
			->validatePresence('description', 'create')
			->notEmpty('description')
			->validatePresence('slug', 'create')
			->notEmpty('slug')
			->add('article_count', 'valid', ['rule' => 'numeric'])
			->validatePresence('article_count', 'create')
			->notEmpty('article_count')
			->add('last_article_id', 'valid', ['rule' => 'numeric'])
			->validatePresence('last_article_id', 'create')
			->notEmpty('last_article_id');

		return $validator;
	}

}
