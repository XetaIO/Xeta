<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class BlogArticlesCommentsTable extends Table
{

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config)
	{
		$this->table('blog_articles_comments');
		$this->displayField('comment');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('CounterCache', [
			'Users' => ['blog_articles_comment_count'],
			'BlogArticles' => ['comment_count']
		]);

		$this->belongsTo('BlogArticles', [
			'foreignKey' => 'article_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
	}

/**
 * Create validation rules.
 *
 * @param \Cake\Validation\Validator $validator
 * @return \Cake\Validation\Validator
 */
	public function validationCreate(Validator $validator)
	{
		$validator
			->validatePresence('content', 'create')
			->notEmpty('content')
			->add('content', [
				'minLength' => [
					'rule' => ['minLength', 5],
					'message' => __("Please, {0} characters minimum for your comment.", 5)
				]
			]);

		return $validator;
	}

}
