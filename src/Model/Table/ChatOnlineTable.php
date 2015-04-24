<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ChatOnlineTable extends Table
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
        $this->table('chat_online');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);
    }
}
