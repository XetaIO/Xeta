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
            'id' => 1,
            'name' => 'Banni',
            'css' => 'color:#A1705D;font-weight:bold;',
            'is_staff' => 0,
            'is_member' => 0,
            'created' => '2015-01-16 16:51:12',
            'modified' => '2015-01-21 02:03:10'
        ],
        [
            'id' => 2,
            'name' => 'Membre',
            'css' => 'font-weight:bold;',
            'is_staff' => 0,
            'is_member' => 1,
            'created' => '2015-01-16 16:51:22',
            'modified' => '2015-01-21 02:02:21'
        ],
        [
            'id' => 3,
            'name' => 'Éditeur',
            'css' => 'color:#9ADD7D;font-weight:bold;',
            'is_staff' => 1,
            'is_member' => 0,
            'created' => '2015-01-16 16:51:30',
            'modified' => '2015-01-21 02:02:12'
        ],
        [
            'id' => 4,
            'name' => 'Modérateur',
            'css' => 'color:#FF6B43;font-weight:bold;',
            'is_staff' => 1,
            'is_member' => 0,
            'created' => '2015-01-16 16:51:51',
            'modified' => '2015-01-21 02:02:03'
        ],
        [
            'id' => 5,
            'name' => 'Administrateur',
            'css' => 'color:#FF4A43;font-weight:bold;',
            'is_staff' => 1,
            'is_member' => 0,
            'created' => '2015-01-16 16:52:00',
            'modified' => '2016-11-01 08:28:26'
        ]
    ];
}
