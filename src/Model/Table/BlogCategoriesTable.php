<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BlogCategoriesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('blog_categories');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Translate', [
            'fields' => ['title', 'description'],
            'translationTable' => 'BlogCategoriesI18n'
        ]);

        $this->hasMany('BlogArticles', [
            'foreignKey' => 'category_id',
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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('title', __("The title is required."))
            ->add('title', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => __("This title is already used.")
                ],
                'minLength' => [
                    'rule' => ['minLength', 3],
                    'message' => __("Please, {0} characters minimum for the title.", 3)
                ]
            ])
            ->add('description', [
                'maxLength' => [
                    'rule' => ['maxLength', 255],
                    'message' => __("Please, {0} characters maximum for the description.", 255)
                ]
            ]);

        return $validator;
    }
}
