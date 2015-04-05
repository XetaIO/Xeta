<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class GroupsI18nFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'locale' => ['type' => 'string', 'length' => 6],
        'model' => ['type' => 'string', 'length' => 255],
        'foreign_key' => ['type' => 'integer'],
        'field' => ['type' => 'string', 'length' => 255],
        'content' => ['type' => 'text'],
        '_indexes' => [
            'locale' => ['type' => 'index', 'columns' => ['locale']],
            'model' => ['type' => 'index', 'columns' => ['model']],
            'row_id' => ['type' => 'index', 'columns' => ['foreign_key']],
            'field' => ['type' => 'index', 'columns' => ['field']],
        ],
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
            'locale' => 'en_US',
            'model' => 'Groups',
            'foreign_key' => 1,
            'field' => 'name',
            'content' => 'Administrator'
        ],
        [
            'locale' => 'en_US',
            'model' => 'Groups',
            'foreign_key' => 2,
            'field' => 'name',
            'content' => 'Member'
        ]
    ];
}
