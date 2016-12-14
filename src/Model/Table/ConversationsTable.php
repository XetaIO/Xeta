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
            'foreignKey' => 'conversation_id',
            'dependent' => true
        ]);
        $this->hasMany('ConversationsUsers', [
            'className' => 'ConversationsUsers',
            'foreignKey' => 'conversation_id',
            'dependent' => true
        ]);
    }

    /**
     * Create validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationCreate(Validator $validator)
    {
        $validator
            ->provider('purifier', 'App\Model\Validation\PurifierValidator')
            ->notEmpty('title', __d('conversations', 'You must specify a title for your conversation.'))
            ->add('title', 'minLength', [
                'rule' => ['minLength', 5],
                'message' => __d('conversations', 'Your title must contain at least {0} characters.', 5)
            ])

            ->notEmpty('message', __d('conversations', 'You must specify a message for your conversation.'))
            ->add('message', [
                'purifierMinLength' => [
                    'rule' => ['purifierMinLength', 5],
                    'provider' => 'purifier',
                    'message' => __d('conversations', 'Your message must contain at least {0} characters.', 5)
                ]
            ]);

        return $validator;
    }

    /**
     * Edit validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationEdit(Validator $validator)
    {
        $validator
            ->provider('purifier', 'App\Model\Validation\PurifierValidator')
            ->notEmpty('title', __d('conversations', 'You must specify a title for your conversation.'))
            ->add('title', 'minLength', [
                'rule' => ['minLength', 5],
                'message' => __d('conversations', 'Your title must contain at least {0} characters.', 5)
            ])

            ->notEmpty('message', __d('conversations', 'You must specify a message for your conversation.'))
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
