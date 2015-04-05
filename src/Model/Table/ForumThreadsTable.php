<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ForumThreadsTable extends Table
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
        $this->table('forum_threads');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Users' => ['forum_thread_count'],
            'ForumCategories' => [
                'thread_count' => [
                    'conditions' => ['ForumThreads.thread_open !=' => 2]
                ]
            ]
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
    public function validationCreate(Validator $validator)
    {
        $validator
            ->provider('purifier', 'App\Model\Validation\PurifierValidator')
            ->notEmpty('title', __('You must set a title for your thread.'))
            ->add('title', [
                'lengthBetween' => [
                    'rule' => ['lengthBetween', 5, 150],
                    'message' => __("The title must be between {0} and {1} characters.", 5, 150)
                ]
            ])
            ->notEmpty('message', __('You must specify a message for your thread.'))
            ->add('message', [
                'purifierMinLength' => [
                    'rule' => ['purifierMinLength', 10],
                    'provider' => 'purifier',
                    'message' => __('Your message must contain at least {0} characters.', 10)
                ]
            ]);

        return $validator;
    }
}
