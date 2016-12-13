<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Polls Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $PollsAnswers
 * @property \Cake\ORM\Association\BelongsToMany $Users
 */
class PollsTable extends Table
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
        parent::initialize($config);

        $this->table('polls');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('PollsAnswers', [
            'foreignKey' => 'poll_id'
        ]);
        $this->belongsToMany('PollsUsers', [
            'foreignKey' => 'poll_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'polls_users'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->boolean('multiple_choice')
            ->requirePresence('multiple_choice', 'create')
            ->notEmpty('multiple_choice');

        $validator
            ->boolean('is_display')
            ->requirePresence('is_display', 'create')
            ->notEmpty('is_display');

        $validator
            ->integer('user_count')
            ->requirePresence('user_count', 'create')
            ->notEmpty('user_count');

        $validator
            ->boolean('is_timed')
            ->requirePresence('is_timed', 'create')
            ->notEmpty('is_timed');

        $validator
            ->dateTime('end_date')
            ->allowEmpty('end_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     *
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
