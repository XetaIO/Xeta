<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PollsUsersFixture
 *
 */
class PollsUsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'poll_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'answer_id' => ['type' => 'integer'],
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
            'poll_id' => 1,
            'user_id' => 1,
            'answer_id' => 1,
            'created' => '2016-12-15 17:18:19',
            'modified' => '2016-12-15 17:18:19'
        ],
    ];
}
