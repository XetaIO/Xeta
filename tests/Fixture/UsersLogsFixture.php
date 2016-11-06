<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersLogsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'username' => ['type' => 'string', 'length' => 50],
        'user_ip' => ['type' => 'string', 'length' => 16],
        'user_agent' => ['type' => 'string'],
        'action' => ['type' => 'string'],
        'created' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
}
