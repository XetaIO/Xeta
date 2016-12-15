<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PollsFixture
 *
 */
class PollsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'article_id' => ['type' => 'integer'],
        'name' => ['type' => 'string'],
        'is_display' => ['type' => 'boolean', 'default' => '1'],
        'user_count' => ['type' => 'integer', 'default' => '0'],
        'is_timed' => ['type' => 'boolean', 'default' => '0'],
        'end_date' => ['type' => 'datetime'],
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
            'article_id' => 1,
            'name' => 'Is my website the best website ?',
            'is_display' => 1,
            'user_count' => 1,
            'is_timed' => 0,
            'end_date' => null,
            'created' => '2016-12-15 17:14:00',
            'modified' => '2016-12-15 17:14:00'
        ],
        [
            'user_id' => 1,
            'article_id' => 2,
            'name' => 'Is my website the best website ?',
            'is_display' => 1,
            'user_count' => 0,
            'is_timed' => 1,
            'end_date' => '2014-12-15 17:14:00',
            'created' => '2016-12-15 17:14:00',
            'modified' => '2016-12-15 17:14:00'
        ]
    ];
}
