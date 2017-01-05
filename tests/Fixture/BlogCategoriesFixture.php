<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class BlogCategoriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'title' => ['type' => 'string'],
        'description' => ['type' => 'text'],
        'article_count' => ['type' => 'integer'],
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
            'title' => 'Categorie 1',
            'description' => 'Lorem ipsum dolor sit amet.',
            'article_count' => 2,
            'created' => '2014-10-29 15:36:57',
            'modified' => '2014-10-29 15:36:57'
        ],
        [
            'title' => 'Categorie 2',
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
            'article_count' => 0,
            'created' => '2014-10-29 15:36:57',
            'modified' => '2014-10-29 15:36:57'
        ],
        [
            'title' => 'Categorie 3',
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
            'article_count' => 1,
            'created' => '2014-10-29 15:36:57',
            'modified' => '2014-10-29 15:36:57'
        ]
    ];
}
