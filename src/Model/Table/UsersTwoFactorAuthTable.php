<?php
namespace App\Model\Table;

use Cake\Database\Schema\Table as Schema;
use Cake\ORM\Table;

class UsersTwoFactorAuthTable extends Table
{
    /**
     * Initialize schema method
     *
     * @param \Cake\Database\Schema\Table $schema The schema of the Table.
     *
     * @return \Cake\Database\Schema\Table
     */
    protected function _initializeSchema(Schema $schema)
    {
        $schema->columnType('secret', 'encryptedsecurity');
        $schema->columnType('username', 'encryptedsecurity');
        $schema->columnType('session', 'encryptedsecurity');
        $schema->columnType('recovery_code', 'encryptedsecurity');

        return $schema;
    }

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

        $this->table('users_two_factor_auth');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }
}
