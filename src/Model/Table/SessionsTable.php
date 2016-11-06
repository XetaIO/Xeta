<?php
namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\Table;

class SessionsTable extends Table
{

    /**
     * Initialize method.
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('sessions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Custom finder for select sessions no-expired.
     *
     * @param \Cake\ORM\Query $query The query finder.
     *
     * @return \Cake\ORM\Query
     */
    public function findExpires(Query $query)
    {
        $timeout = Configure::read('Session.handler.timeoutOnline') ? Configure::read('Session.handler.timeoutOnline') : 5;
        $expire = time() + ini_get('session.gc_maxlifetime') - (60 * $timeout);

        return $query->where(['Sessions.expires >=' => $expire]);
    }
}
