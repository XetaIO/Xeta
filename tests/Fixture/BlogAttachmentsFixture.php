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
            'name' => 'Attachment.zip',
            'size' => 1584,
            'extension' => '.zip',
            'url' => TEST_TMP . 'Attachment.zip',
            'download' => 1,
            'created' => '2014-12-23 13:23:36',
            'modified' => '2014-12-23 13:23:36'
        ],
        [
            'user_id' => 1,
            'article_id' => 2,
            'name' => 'not_found.zip',
            'size' => 1584,
            'extension' => '.zip',
            'url' => TEST_TMP . 'not_found.zip',
            'download' => 0,
            'created' => '2014-12-23 13:23:36',
            'modified' => '2014-12-23 13:23:36'
        ]
    ];
}
