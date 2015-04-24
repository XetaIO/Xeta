<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class PremiumDiscountsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'premium_offer_id' => ['type' => 'integer'],
        'code' => ['type' => 'string', 'length' => 50],
        'discount' => ['type' => 'float'],
        'used' => ['type' => 'integer'],
        'max_use' => ['type' => 'integer'],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
            'code' => ['type' => 'unique', 'columns' => ['code']],
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
            'premium_offer_id' => 1,
            'code' => 'XETATEST',
            'discount' => 20,
            'used' => 0,
            'max_use' => 2,
            'created' => '2014-11-21 10:57:38',
            'modified' => '2014-11-21 10:57:38'
        ],
        [
            'user_id' => 1,
            'premium_offer_id' => 2,
            'code' => 'XETATEST2',
            'discount' => 50,
            'used' => 2,
            'max_use' => 3,
            'created' => '2014-11-21 10:57:38',
            'modified' => '2014-11-21 10:57:38'
        ]
    ];
}
