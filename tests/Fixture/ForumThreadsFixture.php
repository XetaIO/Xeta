<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ForumThreadsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'category_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'title' => ['type' => 'string', 'length' => 150],
        'reply_count' => ['type' => 'integer'],
        'view_count' => ['type' => 'biginteger'],
        'thread_open' => ['type' => 'integer', 'length' => 3, 'default' => '1', 'comment' => 'Display: 1, Closed: 0, Deleted: 2'],
        'sticky' => ['type' => 'integer', 'length' => 3, 'default' => '0', 'comment' => 'Epinglé'],
        'first_post_id' => ['type' => 'integer'],
        'last_post_date' => ['type' => 'datetime'],
        'last_post_id' => ['type' => 'integer'],
        'last_post_user_id' => ['type' => 'integer'],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
        ],
    ];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'category_id' => 1,
            'user_id' => 1,
            'title' => 'title 1',
            'reply_count' => 1,
            'view_count' => 1,
            'thread_open' => 1,
            'sticky' => 1,
            'first_post_id' => 1,
            'last_post_date' => '2015-03-17 14:18:15',
            'last_post_id' => 1,
            'last_post_user_id' => 1,
            'created' => '2015-03-17 14:18:16',
            'modified' => '2015-03-17 14:18:16'
        ],
        [
            'category_id' => 2,
            'user_id' => 2,
            'title' => 'title 2',
            'reply_count' => 2,
            'view_count' => 2,
            'thread_open' => 0,
            'sticky' => 0,
            'first_post_id' => 2,
            'last_post_date' => '2015-03-17 14:18:16',
            'last_post_id' => 2,
            'last_post_user_id' => 2,
            'created' => '2015-03-17 14:18:15',
            'modified' => '2015-03-17 14:18:16'
        ]
    ];
}
