<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class BadgesUsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'badge_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'created' => ['type' => 'datetime'],
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
            'badge_id' => 1,
            'user_id' => 1,
            'created' => '2014-11-10 14:44:45'
        ],
    ];
}
