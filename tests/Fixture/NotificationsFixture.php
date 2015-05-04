<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class NotificationsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'foreign_key' => ['type' => 'integer', 'null' => true],
        'type' => ['type' => 'string', 'length' => 150],
        'data' => ['type' => 'text', 'null' => true],
        'is_read' => ['type' => 'integer', 'length' => 2],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
        ],
    ];
}
