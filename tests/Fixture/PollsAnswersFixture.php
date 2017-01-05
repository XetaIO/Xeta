<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PollsAnswersFixture
 *
 */
class PollsAnswersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'poll_id' => ['type' => 'integer'],
        'response' => ['type' => 'string', 'null' => false],
        'user_count' => ['type' => 'integer', 'default' => '0'],
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
            'response' => 'Yes',
            'user_count' => 1,
            'created' => '2016-12-15 17:16:47',
            'modified' => '2016-12-15 17:16:47'
        ],
        [
            'poll_id' => 1,
            'response' => 'No',
            'user_count' => 0,
            'created' => '2016-12-15 17:16:47',
            'modified' => '2016-12-15 17:16:47'
        ],
        [
            'poll_id' => 2,
            'response' => 'Yes',
            'user_count' => 0,
            'created' => '2016-12-15 17:16:47',
            'modified' => '2016-12-15 17:16:47'
        ]
    ];
}
