<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class BlogArticlesI18nFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'blog_articles_i18n';

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
            'model' => 'BlogArticles',
            'foreign_key' => 1,
            'field' => 'title',
            'content' => 'First article'
        ],
        [
            'locale' => 'en_US',
            'model' => 'BlogArticles',
            'foreign_key' => 1,
            'field' => 'content',
            'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat.'
        ],
        [
            'locale' => 'en_US',
            'model' => 'BlogArticles',
            'foreign_key' => 2,
            'field' => 'title',
            'content' => 'Second article'
        ],
        [
            'locale' => 'en_US',
            'model' => 'BlogArticles',
            'foreign_key' => 2,
            'field' => 'content',
            'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat.'
        ],
        [
            'locale' => 'en_US',
            'model' => 'BlogArticles',
            'foreign_key' => 3,
            'field' => 'title',
            'content' => 'Third article'
        ],
        [
            'locale' => 'en_US',
            'model' => 'BlogArticles',
            'foreign_key' => 3,
            'field' => 'content',
            'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat.'
        ]
    ];
}
