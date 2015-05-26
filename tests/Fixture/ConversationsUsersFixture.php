<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ConversationsUsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'conversation_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'is_read' => ['type' => 'integer', 'length' => 4],
        'is_star' => ['type' => 'integer', 'length' => 4],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'conversation_id' => 1,
            'user_id' => 1,
            'is_read' => 1,
            'is_star' => 1,
            'created' => '2015-05-26 21:49:37',
            'modified' => '2015-05-26 21:49:37'
        ]
    ];
}
