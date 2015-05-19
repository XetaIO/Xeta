<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ConversationsUsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('conversations_users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Conversations', [
            'foreignKey' => 'conversation_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('is_read', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('is_read');

        $validator
            ->add('important', 'valid', ['rule' => 'numeric'])
            ->requirePresence('important', 'create')
            ->notEmpty('important');

        return $validator;
    }
}
