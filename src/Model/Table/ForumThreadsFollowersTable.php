<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ForumThreadsFollowersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('forum_threads_followers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ForumThreads', [
            'foreignKey' => 'thread_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('user_id', __("You must set an user."))
            ->add('user_id', 'numeric', [
                'rule' => 'numeric',
                'message' => __("The user must be numeric.")
            ])
            ->notEmpty('thread_id', __("You must set a thread."))
            ->add('thread_id', 'numeric', [
                'rule' => 'numeric',
                'message' => __("The thread must be numeric.")
            ]);

        return $validator;
    }
}
