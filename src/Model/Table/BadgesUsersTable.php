<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BadgesUsersTable extends Table
{

    /**
     * Initialize method.
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('badges_users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Badges', [
            'foreignKey' => 'badge_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->notEmpty('badge_id', __("You must select a badge."))
            ->add('badge_id', 'numeric', [
                'rule' => 'numeric'
            ])
            ->notEmpty('user_id', __("You must select an user."))
            ->add('user_id', 'numeric', [
                'rule' => 'numeric'
            ]);

        return $validator;
    }
}
