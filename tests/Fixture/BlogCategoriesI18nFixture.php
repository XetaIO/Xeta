<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BlogCategoriesI18nFixture
 *
 */
class BlogCategoriesI18nFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'blog_categories_i18n';

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
            'model' => 'BlogCategories',
            'foreign_key' => 1,
            'field' => 'title',
            'content' => 'Categorie 1'
        ],
        [
            'locale' => 'en_US',
            'model' => 'BlogCategories',
            'foreign_key' => 1,
            'field' => 'content',
            'content' => 'Lorem ipsum dolor sit amet.'
        ],
        [
            'locale' => 'en_US',
            'model' => 'BlogCategories',
            'foreign_key' => 2,
            'field' => 'title',
            'content' => 'Categorie 2'
        ],
        [
            'locale' => 'en_US',
            'model' => 'BlogCategories',
            'foreign_key' => 2,
            'field' => 'content',
            'content' => 'Lorem ipsum dolor sit amet.'
        ],
    ];
}
