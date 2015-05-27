<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ConversationsMessagesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('conversations_messages');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Conversations' => ['reply_count']
        ]);

        $this->belongsTo('Conversations', [
            'foreignKey' => 'conversation_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('LastEditUsers', [
            'className' => 'Users',
            'foreignKey' => 'last_edit_user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationCreate(Validator $validator)
    {
        $validator
            ->provider('purifier', 'App\Model\Validation\PurifierValidator')
            ->notEmpty('message', __d('conversations', 'You must specify a message for your response.'))
            ->add('message', [
                'purifierMinLength' => [
                    'rule' => ['purifierMinLength', 5],
                    'provider' => 'purifier',
                    'message' => __d('conversations', 'Your message must contain at least {0} characters.', 5)
                ]
            ]);

        return $validator;
    }
}
