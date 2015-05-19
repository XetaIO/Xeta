<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ConversationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('conversations');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('LastMessage', [
            'className' => 'ConversationsMessages',
            'foreignKey' => 'last_message_id'
        ]);
        $this->belongsTo('LastMessageUser', [
            'className' => 'Users',
            'foreignKey' => 'last_message_user_id'
        ]);
        $this->hasMany('ConversationsMessages', [
            'foreignKey' => 'conversation_id'
        ]);
        $this->hasMany('ConversationsUsers', [
            'className' => 'ConversationsUsers',
            'foreignKey' => 'conversation_id'
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
            ->allowEmpty('title');

        $validator
            ->add('open_invite', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('open_invite');

        $validator
            ->add('conversation_open', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('conversation_open');

        $validator
            ->add('reply_count', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('reply_count');

        $validator
            ->add('recipient_count', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('recipient_count');

        $validator
            ->add('last_message_date', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('last_message_date');

        return $validator;
    }
}
