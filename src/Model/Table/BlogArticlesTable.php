<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BlogArticlesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 *
 * @return void
 */
	public function initialize(array $config) {
		$this->table('blog_articles');
		$this->displayField('title');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('CounterCache', [
			'Users' => ['blog_article_count'],
			'BlogCategories' => ['article_count']
		]);
		$this->addBehavior('Sluggable');

		$this->belongsTo('BlogCategories', [
			'foreignKey' => 'category_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
		$this->hasMany('BlogArticlesComments', [
			'foreignKey' => 'article_id',
			'dependent' => true
		]);
		$this->hasMany('BlogArticlesLikes', [
			'foreignKey' => 'article_id',
			'dependent' => true
		]);
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator Instance of the validator.
 *
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->validatePresence('category_id', 'create')
			->notEmpty('category_id', __("You must select a category."))
			->add('category_id', 'valid', ['rule' => 'numeric'])
			->validatePresence('title')
			->notEmpty('title', __("The title is required."))
			->add('title', [
				'minLength' => [
					'rule' => ['minLength', 5],
					'message' => __("Please, {0} characters minimum for the title.", 5)
				]
			])
			->validatePresence('content')
			->notEmpty('content', __("The content is required."))
			->add('content', 'minLength', [
				'rule' => ['minLength', 15],
				'message' => __("Please, {0} characters minimum for the content.", 15)
			])
			->validatePresence('is_display', 'create')
			->notEmpty('is_display')
			->add('is_display', 'inList', [
				'rule' => ['inList', [0, 1]],
				'message' => __("Incorrect value, please do not attempt to modify the HTML, little hacker. ;)")
			]);

		return $validator;
	}
}
