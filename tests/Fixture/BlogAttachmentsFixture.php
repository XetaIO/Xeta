<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class BlogAttachmentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'article_id' => ['type' => 'integer'],
        'name' => ['type' => 'string', 'length' => 255],
        'size' => ['type' => 'integer'],
        'extension' => ['type' => 'string', 'length' => 15],
        'url' => ['type' => 'string', 'length' => 255],
        'download' => ['type' => 'biginteger', 'length' => 20],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
        ]
    ];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'user_id' => 1,
            'article_id' => 1,
            'name' => 'attachment.zip',
            'size' => 1584,
            'extension' => '.zip',
            'url' => 'attachment.zip',
            'download' => 1,
            'created' => '2014-12-23 13:23:36',
            'modified' => '2014-12-23 13:23:36'
        ]
    ];
}
