<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class SettingsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'name' => ['type' => 'string'],
        'value_int' => ['type' => 'integer'],
        'value_str' => ['type' => 'string'],
        'value_bool' => ['type' => 'boolean'],
        'last_updated_user_id' => ['type' => 'integer'],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
            'UNIQUE' => ['type' => 'unique', 'columns' => ['name']],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
}
