<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class GroupsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'name' => ['type' => 'string', 'length' => 100],
        'css' => ['type' => 'string'],
        'is_staff' => ['type' => 'integer', 'length' => 2, 'default' => 0],
        'is_member' => ['type' => 'integer', 'length' => 2, 'default' => 0],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
        ]
    ];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'name' => 'Administrator',
            'css' => 'color:#FF4A43;font-weight:bold;',
            'is_staff' => 1,
            'is_member' => 0,
            'created' => '2015-01-16 16:49:24',
            'modified' => '2015-01-16 16:49:24'
        ],
        [
            'name' => 'Member',
            'css' => 'font-weight:bold;',
            'is_staff' => 0,
            'is_member' => 1,
            'created' => '2015-01-16 16:49:24',
            'modified' => '2015-01-16 16:49:24'
        ],
        [
            'name' => 'Random Group',
            'css' => 'color:#FF4A43;font-weight:bold;',
            'is_staff' => 0,
            'is_member' => 0,
            'created' => '2015-01-16 16:49:24',
            'modified' => '2015-01-16 16:49:24'
        ],
        [
            'name' => 'Random Group',
            'css' => 'font-weight:bold;',
            'is_staff' => 0,
            'is_member' => 0,
            'created' => '2015-01-16 16:49:24',
            'modified' => '2015-01-16 16:49:24'
        ],
        [
            'name' => 'Administrator',
            'css' => 'color:#FF4A43;font-weight:bold;',
            'is_staff' => 1,
            'is_member' => 0,
            'created' => '2015-01-16 16:49:24',
            'modified' => '2015-01-16 16:49:24'
        ]
    ];
}
