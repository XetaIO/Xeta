<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ForumPostsLikesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'post_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'receiver_id' => ['type' => 'integer'],
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
            'id' => 1,
            'post_id' => 1,
            'user_id' => 1,
            'receiver_id' => 1,
            'created' => '2015-03-26 08:23:58',
            'modified' => '2015-03-26 08:23:58'
        ],
        [
            'id' => 2,
            'post_id' => 2,
            'user_id' => 2,
            'receiver_id' => 2,
            'created' => '2015-03-26 08:23:58',
            'modified' => '2015-03-26 08:23:58'
        ]
    ];
}
