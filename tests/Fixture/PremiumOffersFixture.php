<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class PremiumOffersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'period' => ['type' => 'integer'],
        'price' => ['type' => 'float'],
        'tax' => ['type' => 'float', 'default' => '19.6'],
        'currency_code' => ['type' => 'string', 'length' => 3, 'default' => 'EUR'],
        'currency_symbol' => ['type' => 'string', 'length' => 4, 'default' => '€'],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
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
            'user_id' => 1,
            'period' => 1,
            'price' => 3,
            'tax' => 5.6,
            'currency_code' => 'EUR',
            'currency_symbol' => '€',
            'created' => '2014-11-21 10:57:44',
            'modified' => '2014-11-21 10:57:44'
        ],
        [
            'user_id' => 1,
            'period' => 6,
            'price' => 9.5,
            'tax' => 19.6,
            'currency_code' => 'EUR',
            'currency_symbol' => '€',
            'created' => '2014-11-21 10:57:44',
            'modified' => '2014-11-21 10:57:44'
        ]
    ];
}
