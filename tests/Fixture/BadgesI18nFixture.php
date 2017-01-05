<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BadgesI18nFixture
 *
 */
class BadgesI18nFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'badges_i18n';

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'locale' => ['type' => 'string', 'length' => 6],
        'model' => ['type' => 'string'],
        'foreign_key' => ['type' => 'integer'],
        'field' => ['type' => 'string'],
        'content' => ['type' => 'text'],
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
            'model' => 'Badges',
            'foreign_key' => 1,
            'field' => 'name',
            'content' => 'Comments'
        ],
        [
            'locale' => 'en_US',
            'model' => 'Badges',
            'foreign_key' => 2,
            'field' => 'name',
            'content' => 'Premium'
        ],
        [
            'locale' => 'en_US',
            'model' => 'Badges',
            'foreign_key' => 3,
            'field' => 'name',
            'content' => 'Registration'
        ]
    ];
}
