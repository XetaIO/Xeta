<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ConversationsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'title' => ['type' => 'string', 'length' => 150],
        'open_invite' => ['type' => 'integer', 'length' => 4, 'default' => '0'],
        'conversation_open' => ['type' => 'integer', 'length' => 2, 'default' => '1'],
        'reply_count' => ['type' => 'integer'],
        'recipient_count' => ['type' => 'integer'],
        'first_message_id' => ['type' => 'integer'],
        'last_message_date' => ['type' => 'datetime'],
        'last_message_id' => ['type' => 'integer'],
        'last_message_user_id' => ['type' => 'integer'],
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
            'user_id' => 1,
            'title' => 'Lorem ipsum dolor sit amet',
            'open_invite' => 1,
            'conversation_open' => 1,
            'reply_count' => 1,
            'recipient_count' => 1,
            'first_message_id' => 1,
            'last_message_date' => '2015-05-26 21:49:27',
            'last_message_id' => 1,
            'last_message_user_id' => 1,
            'created' => '2015-05-26 21:49:27',
            'modified' => '2015-05-26 21:49:27'
        ]
    ];
}
