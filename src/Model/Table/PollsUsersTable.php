<?php
namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * PollsUsers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Polls
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Answers
 */
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

        $this->belongsTo('Polls', [
            'foreignKey' => 'poll_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Answers', [
            'foreignKey' => 'answer_id'
        ]);
    }
}
