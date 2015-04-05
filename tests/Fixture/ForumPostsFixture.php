<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ForumPostsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'thread_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'message' => ['type' => 'text'],
        'like_count' => ['type' => 'integer'],
        'last_edit_date' => ['type' => 'datetime'],
        'last_edit_user_id' => ['type' => 'integer'],
        'edit_count' => ['type' => 'integer'],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB', 'collation' => 'latin1_swedish_ci'
        ],
    ];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'thread_id' => 1,
            'user_id' => 1,
            'message' => 'My awesome message 1',
            'like_count' => 1,
            'last_edit_date' => '2015-03-17 14:49:03',
            'last_edit_user_id' => 1,
            'edit_count' => 1,
            'created' => '2015-03-17 14:49:02',
            'modified' => '2015-03-17 14:49:02'
        ],
        [
            'thread_id' => 2,
            'user_id' => 2,
            'message' => 'My awesome message 2',
            'like_count' => 2,
            'last_edit_date' => '2015-03-17 14:49:04',
            'last_edit_user_id' => 2,
            'edit_count' => 2,
            'created' => '2015-03-17 14:49:03',
            'modified' => '2015-03-17 14:49:03'
        ]
    ];
}
