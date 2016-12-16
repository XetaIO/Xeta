<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class BlogArticlesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'category_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'title' => ['type' => 'string'],
        'content' => ['type' => 'text'],
        'comment_count' => ['type' => 'integer', 'default' => '0'],
        'like_count' => ['type' => 'integer', 'default' => '0'],
        'is_display' => ['type' => 'integer', 'default' => '1'],
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
            'category_id' => 1,
            'user_id' => 1,
            'title' => 'First article',
            'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
            'comment_count' => 2,
            'like_count' => 1,
            'is_display' => 1,
            'created' => '2014-10-28 15:48:53',
            'modified' => '2014-10-28 15:48:53'
        ],
        [
            'category_id' => 1,
            'user_id' => 1,
            'title' => 'Second article',
            'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
            'comment_count' => 0,
            'like_count' => 0,
            'is_display' => 0,
            'created' => '2014-10-29 15:48:53',
            'modified' => '2014-10-29 15:48:53'
        ],
        [
            'category_id' => 3,
            'user_id' => 1,
            'title' => 'Third article',
            'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat.',
            'comment_count' => 0,
            'like_count' => 0,
            'is_display' => 1,
            'created' => '2014-10-29 15:48:53',
            'modified' => '2014-10-29 15:48:53'
        ]
    ];
}
