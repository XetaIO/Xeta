<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ChatBansTable extends Table
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
        $this->table('chat_bans');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Banisher', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
        ]);
    }
}
