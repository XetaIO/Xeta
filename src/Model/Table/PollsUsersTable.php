<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class PollsUsersTable extends Table
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

        $this->table('polls_users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Polls' => ['user_count'],
            'PollsAnswers' => ['user_count']
        ]);

        $this->belongsTo('Polls', [
            'foreignKey' => 'poll_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('PollsAnswers', [
            'foreignKey' => 'answer_id'
        ]);
    }
}
