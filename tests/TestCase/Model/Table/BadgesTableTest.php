<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\Filesystem\Folder;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BadgesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.badges'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Badges = TableRegistry::get('Badges');
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
        $folder = new Folder(TEST_WWW_ROOT . 'img' . DS . 'badges');
        $folder->delete(TEST_WWW_ROOT . 'img' . DS . 'badges');
    }

    /**
     * Test validationCreate
     *
     * @return void
     */
    public function testValidationCreate()
    {
        $fakeImage = [
            'name' => 'tmp_avatar.php',
            'tmp_name' => TEST_WWW_ROOT . 'img' . DS . 'fakeImage.png',
            'error' => UPLOAD_ERR_OK,
            'type' => 'image/gif',
            'size' => 6000000000
        ];

        $data = [
            'name' => 'abc',
            'picture_file' => $fakeImage,
            'type' => 'fail',
            'rule' => 'abc'
        ];

        $expected = [
            'name' => [
                'minLength'
            ],
            'picture_file' => [
                'mimeType',
                'fileExtension',
                'maxDimension'
            ],
            'type' => [
                'inList'
            ],
            'rule' => [
                'numeric'
            ]
        ];

        $badge = $this->Badges->newEntity($data, ['validate' => 'create']);
        $result = $this->Badges->save($badge);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($badge->errors()), 'Should return errors.');

        $image = [
            'name' => 'tmp_badge.png',
            'tmp_name' => TEST_TMP . 'tmp_badge.png',
            'error' => UPLOAD_ERR_OK,
            'type' => 'image/png',
            'size' => 6000
        ];

        $data = [
            'name' => 'Badge2',
            'picture_file' => $image,
            'type' => 'comments',
            'rule' => '1500'
        ];

        $expected = [
            'name' => 'Badge2',
            'picture' => 'img' . DS . 'badges' . DS . date('m') . '.png',
            'type' => 'comments',
            'rule' => 1500
        ];

        $this->Badges->removeBehavior('Upload');
        $this->Badges->addBehavior('Xety/Cake3Upload.Upload', [
            'root' => TEST_WWW_ROOT,
            'fields' => [
                'picture' => [
                    'path' => 'img' . DS . 'badges' . DS . ':m'
                ]
            ]
        ]);

        $badge = $this->Badges->newEntity($data, ['validate' => 'create']);
        $result = $this->Badges->save($badge);

        $this->assertInstanceOf('App\Model\Entity\Badge', $result);
        $badge = $this->Badges
            ->find()
            ->where(['id' => $result->id])
            ->select(['name', 'picture', 'type', 'rule'])
            ->first()
            ->toArray();

        $this->assertEquals($expected, $badge);
    }
}
