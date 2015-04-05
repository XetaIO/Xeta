<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class BlogArticlesCommentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'article_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'content' => ['type' => 'text'],
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
            'article_id' => 1,
            'user_id' => 1,
            'content' => 'Lorem ipsum dolor sit amet.',
            'created' => '2014-10-28 16:02:02',
            'modified' => '2014-10-28 16:02:02'
        ],
        [
            'article_id' => 1,
            'user_id' => 1,
            'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
            'created' => '2014-10-29 16:02:02',
            'modified' => '2014-10-29 16:02:02'
        ]
    ];
}
