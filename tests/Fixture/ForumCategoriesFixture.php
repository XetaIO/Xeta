<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ForumCategoriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'title' => ['type' => 'string', 'length' => 255],
        'description' => ['type' => 'text'],
        'category_open' => ['type' => 'integer', 'length' => 2, 'default' => '1'],
        'thread_count' => ['type' => 'integer'],
        'last_post_id' => ['type' => 'integer'],
        'parent_id' => ['type' => 'integer', 'null' => true],
        'lft' => ['type' => 'integer'],
        'rght' => ['type' => 'integer'],
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
            'title' => 'Category 1',
            'description' => 'Description category 1',
            'category_open' => 1,
            'thread_count' => 1,
            'last_post_id' => 1,
            'parent_id' => null,
            'lft' => 1,
            'rght' => 2,
            'created' => '2015-03-17 14:39:47',
            'modified' => '2015-03-17 14:39:47'
        ],
        [
            'title' => 'Category 2',
            'description' => 'Description category 2',
            'category_open' => 1,
            'thread_count' => 1,
            'last_post_id' => 2,
            'parent_id' => null,
            'lft' => 3,
            'rght' => 4,
            'created' => '2015-03-17 14:39:47',
            'modified' => '2015-03-17 14:39:47'
        ]
    ];
}
