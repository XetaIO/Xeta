<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class BlogArticlesTable extends Table
{

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config)
	{
		$this->table('blog_articles');
		$this->displayField('title');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('CounterCache', [
			'Users' => ['blog_article_count']
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
		]);
		$this->hasMany('BlogArticlesLikes', [
			'foreignKey' => 'article_id',
		]);
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator)
	{
		$validator
			->add('category_id', 'valid', ['rule' => 'numeric'])
			->validatePresence('category_id', 'create')
			->notEmpty('category_id')
			->add('user_id', 'valid', ['rule' => 'numeric'])
			->validatePresence('user_id', 'create')
			->notEmpty('user_id')
			->validatePresence('title', 'create')
			->notEmpty('title')
			->validatePresence('content', 'create')
			->notEmpty('content')
			->add('is_display', 'valid', ['rule' => 'numeric'])
			->validatePresence('is_display', 'create')
			->notEmpty('is_display');

		return $validator;
	}


}
