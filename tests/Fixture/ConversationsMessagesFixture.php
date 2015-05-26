<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ConversationsMessagesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'conversation_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'message' => ['type' => 'text'],
        'edit_count' => ['type' => 'integer'],
        'last_edit_user_id' => ['type' => 'integer'],
        'last_edit_date' => ['type' => 'datetime'],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'conversation_id' => 1,
            'user_id' => 1,
            'message' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'edit_count' => 1,
            'last_edit_user_id' => 1,
            'last_edit_date' => '2015-05-26 21:49:42',
            'created' => '2015-05-26 21:49:32',
            'modified' => '2015-05-26 21:49:32'
        ]
    ];
}
