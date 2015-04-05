<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class GroupsTable extends Table
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
        $this->table('groups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Acl.Acl', [
            'type' => 'requester'
        ]);
        $this->addBehavior('Translate', [
            'fields' => ['name'],
            'translationTable' => 'GroupsI18n'
        ]);

        $this->hasMany('Users', [
            'foreignKey' => 'group_id'
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
            ->notEmpty('name', __("You must set a name."))
            ->add('name', 'minLength', [
                'rule' => ['minLength', 3],
                'message' => __("The name can not be less than {0} characters.", 3)
            ]);

        return $validator;
    }
}
