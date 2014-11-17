<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class BlogAttachmentsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('blog_attachments');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('BlogArticles', [
			'foreignKey' => 'article_id'
		]);
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator The Validator instance.
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create');

		return $validator;
	}

}
