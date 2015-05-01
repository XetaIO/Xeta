<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ForumThreadsFollowersFixture extends TestFixture
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
        'created' => ['type' => 'datetime'],
        'updated' => ['type' => 'datetime'],
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
            'thread_id' => 1,
            'user_id' => 1,
            'created' => '2015-04-29 10:10:40',
            'updated' => '2015-04-29 10:10:40'
        ],
    ];
}
