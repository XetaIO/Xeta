<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BlogAttachmentsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.blog_attachments'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Attachments = TableRegistry::get('BlogAttachments');
        $this->Utility = new Utility;
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        $folder = new Folder(TEST_WWW_ROOT . 'upload');
        $folder->delete(TEST_WWW_ROOT . 'upload');
    }

    /**
     * Test validationDefault
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $data = [
            'article_id' => 'abc',
            'user_id' => 'abc',
            'url_file' => [
                'name' => 'tmp_avatar.php',
                'tmp_name' => TEST_TMP . 'tmp_avatar.png',
                'error' => UPLOAD_ERR_OK,
                'type' => 'image/gif',
                'size' => 6969
            ]
        ];

        $expected = [
            'article_id' => [
                'numeric'
            ],
            'url_file' => [
                'mimeType',
                'fileExtension'
            ]
        ];

        $attachment = $this->Attachments->get(1);
        $this->Attachments->patchEntity($attachment, $data);
        $result = $this->Attachments->save($attachment);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($attachment->errors()));

        $data = [
            'article_id' => 1,
            'user_id' => 1,
            'url_file' => [
                'name' => 'attachment.zip',
                'tmp_name' => TEST_TMP . 'Attachment.zip',
                'error' => UPLOAD_ERR_OK,
                'type' => 'application/octet-stream',
                'size' => 6969
            ]
        ];

        $this->Attachments->removeBehavior('Upload');
        $this->Attachments->addBehavior('Xety/Cake3Upload.Upload', [
            'root' => TEST_WWW_ROOT,
            'fields' => [
                'url' => [
                    'path' => 'upload' . DS . ':id' . DS . ':id'
                ]
            ]
        ]);

        $attachment = $this->Attachments->get(1);
        $this->Attachments->patchEntity($attachment, $data);
        $result = $this->Attachments->save($attachment);

        $this->assertInstanceOf('App\Model\Entity\BlogAttachment', $result);
        $this->assertEmpty($attachment->errors());

        $expected = [
            'id' => 1,
            'user_id' => 1,
            'article_id' => 1,
            'name' => 'Attachment.zip',
            'url' => 'upload' . DS . '1' . DS . '1.zip',
            'size' => 1584,
            'extension' => '.zip',
            'download' => 1,
        ];
        $attachment = $this->Attachments
            ->find()
            ->where(['id' => 1])
            ->first()
            ->toArray();

        unset($attachment['created']);
        unset($attachment['modified']);

        $this->assertEquals($expected, $attachment);
    }
}
