<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class SessionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'string', 'length' => 255],
        'user_id' => ['type' => 'integer'],
        'data' => ['type' => 'text'],
        'controller' => ['type' => 'string', 'length' => 255],
        'action' => ['type' => 'string', 'length' => 255],
        'params' => ['type' => 'text'],
        'expires' => ['type' => 'integer'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
        ],
    ];
}
