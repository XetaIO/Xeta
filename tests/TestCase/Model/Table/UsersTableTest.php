<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Filesystem\Folder;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class UsersTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.users'];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Users = TableRegistry::get('Users');
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
     * test findShort
     *
     * @return void
     */
    public function testFindShort()
    {
        $query = $this->Users->find('short')->where(['id' => 1])->first();
        $this->assertInstanceOf('App\Model\Entity\User', $query);
        $result = $query->toArray();
        $expected = [
            'id' => 1,
            'first_name' => 'Maria',
            'last_name' => 'Riano',
            'username' => 'mariano'
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * test findMedium
     *
     * @return void
     */
    public function testFindMedium()
    {
        $query = $this->Users->find('medium')->where(['id' => 1])->first();
        $this->assertInstanceOf('App\Model\Entity\User', $query);
        $result = $query->toArray();
        $expected = [
            'id' => 1,
            'first_name' => 'Maria',
            'last_name' => 'Riano',
            'username' => 'mariano',
            'avatar' => '../img/avatar.png'
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * test findFull
     *
     * @return void
     */
    public function testFindFull()
    {
        $query = $this->Users->find('full')->where(['id' => 1])->first();
        $this->assertInstanceOf('App\Model\Entity\User', $query);
        $result = $query->toArray();
        $expected = [
            'id' => 1,
            'first_name' => 'Maria',
            'last_name' => 'Riano',
            'username' => 'mariano',
            'avatar' => '../img/avatar.png',
            'blog_articles_comment_count' => 2,
            'blog_article_count' => 2,
            'group_id' => 5,
            'facebook' => 'mariano',
            'twitter' => 'mariano',
            'signature' => 'My awesome signature',
            'created' => new Time('2014-03-17 01:16:23'),
            'last_login' => new Time('2014-03-17 01:23:31')
        ];

        unset($result['end_subscription']);

        $this->assertEquals($expected, $result);
    }

    /**
     * test validationCreate
     *
     * @return void
     */
    public function testValidationCreate()
    {
        $data = [
            'username' => 'test^&',
            'password' => '1234567',
            'password_confirm' => '7654321',
            'email' => 'test.fail'
        ];

        $expected = [
            'username' => [
                'alphanumeric'
            ],
            'password_confirm' => [
                'lengthBetween',
                'equalToPassword'
            ],
            'email' => [
                'email'
            ]
        ];

        $user = $this->Users->newEntity($data, ['validate' => 'create']);
        $result = $this->Users->save($user);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($user->errors()), 'Should return errors.');

        $data = [
            'username' => 'mariano',
            'password' => '12345678',
            'password_confirm' => '12345678',
            'email' => 'mariano@example.com'
        ];

        $expected = [
            'username' => [
                'unique'
            ],
            'email' => [
                'unique'
            ]
        ];

        $user = $this->Users->newEntity($data, ['validate' => 'create']);
        $result = $this->Users->save($user);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($user->errors()), 'Should return errors.');

        $data = [
            'username' => 'Xeta',
            'password' => '12345678',
            'password_confirm' => '12345678',
            'email' => 'xeta@example.com'
        ];

        $expected = [
            'id' => 3,
            'first_name' => null,
            'last_name' => null,
            'username' => 'Xeta'
        ];

        $user = $this->Users->newEntity($data, ['validate' => 'create']);
        $result = $this->Users->save($user);

        $this->assertInstanceOf('App\Model\Entity\User', $result);
        $user = $this->Users->find('short')->where(['id' => $result->id])->first()->toArray();

        $this->assertEquals($expected, $user);
        $this->assertTrue((new DefaultPasswordHasher)->check($data['password'], $result->password));
    }

    /**
     * test validationAccount
     *
     * @return void
     */
    public function testValidationAccount()
    {
        $fakeImage = [
            'name' => 'tmp_avatar.php',
            'tmp_name' => TEST_WWW_ROOT . 'img' . DS . 'fakeImage.png',
            'error' => UPLOAD_ERR_OK,
            'type' => 'image/gif',
            'size' => 6000000000
        ];
        $data = [
            'first_name' => $this->Utility->generateRandomString(101),
            'last_name' => $this->Utility->generateRandomString(101),
            'avatar_file' => $fakeImage,
            'facebook' => $this->Utility->generateRandomString(201),
            'twitter' => $this->Utility->generateRandomString(201),
            'biography' => $this->Utility->generateRandomString(3001),
            'signature' => $this->Utility->generateRandomString(301)
        ];

        $expected = [
            'first_name' => [
                'maxLength'
            ],
            'last_name' => [
                'maxLength'
            ],
            'avatar_file' => [
                'mimeType',
                'fileExtension',
                'maxDimension'
            ],
            'facebook' => [
                'maxLength'
            ],
            'twitter' => [
                'maxLength'
            ],
            'biography' => [
                'purifierMaxLength'
            ],
            'signature' => [
                'purifierMaxLength'
            ]
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'account']);
        $result = $this->Users->save($user);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($user->errors()));

        $image = [
            'name' => 'tmp_avatar.png',
            'tmp_name' => TEST_TMP . 'tmp_avatar.png',
            'error' => UPLOAD_ERR_OK,
            'type' => 'image/png',
            'size' => 6000
        ];
        $data = [
            'first_name' => 'my firstname',
            'last_name' => 'my lastname',
            'avatar_file' => $image,
            'facebook' => 'my facebook',
            'twitter' => 'my twitter',
            'biography' => 'my biography',
            'signature' => 'my signature'
        ];

        $this->Users->removeBehavior('Upload');
        $this->Users->addBehavior('Xety/Cake3Upload.Upload', [
            'root' => TEST_WWW_ROOT,
            'fields' => [
                'avatar' => [
                    'path' => 'upload' . DS . ':id' . DS . ':id'
                ]
            ]
        ]);

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'account']);
        $result = $this->Users->save($user);

        $this->assertInstanceOf('App\Model\Entity\User', $result);
        $this->assertEmpty($user->errors());

        $expected = [
            'id' => 1,
            'first_name' => 'my firstname',
            'last_name' => 'my lastname',
            'username' => 'mariano',
            'avatar' => 'upload' . DS . '1' . DS . '1.png'
        ];
        $user = $this->Users->find('medium')->where(['id' => 1])->first()->toArray();

        $this->assertEquals($expected, $user);
    }

    /**
     * test validationSettings
     *
     * @return void
     */
    public function testValidationSettings()
    {
        $data = [
            'email' => 'larry@example.com'
        ];

        $expected = [
            'email' => [
                'unique'
            ]
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'settings']);
        $result = $this->Users->save($user);

        $this->assertFalse($result, 'Should be false because this Email is already token.');
        $this->assertEquals($expected, $this->Utility->getL2Keys($user->errors()));

        $data = [
            'email' => 'larry.com'
        ];

        $expected = [
            'email' => [
                'email'
            ]
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'settings']);
        $result = $this->Users->save($user);

        $this->assertFalse($result, 'Should be false because this Email is not correct.');
        $this->assertEquals($expected, $this->Utility->getL2Keys($user->errors()));

        $data = [
            'email' => 'new@exemple.com'
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'settings']);
        $result = $this->Users->save($user);

        $this->assertInstanceOf('App\Model\Entity\User', $result);
        $this->assertEmpty($user->errors());
        $this->assertEquals($user->email, $data['email']);

        $data = [
            'password' => '12345678',
            'password_confirm' => '8765432',
        ];

        $expected = [
            'password_confirm' => [
                'lengthBetween',
                'equalToPassword'
            ]
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'settings']);
        $result = $this->Users->save($user);

        $this->assertFalse($result, 'Should be false because the pass doesn not match and not 8 characters.');
        $this->assertEquals($expected, $this->Utility->getL2Keys($user->errors()));

        $data = [
            'password' => '12345678',
            'password_confirm' => '12345678',
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'settings']);
        $result = $this->Users->save($user);

        $this->assertInstanceOf('App\Model\Entity\User', $result);
        $this->assertTrue((new DefaultPasswordHasher)->check($data['password'], $result->password));
    }

    /**
     * test validationResetpassword
     *
     * @return void
     */
    public function testValidationResetpassword()
    {
        $data = [
            'password' => '12345678',
            'password_confirm' => '8765432',
        ];

        $expected = [
            'password_confirm' => [
                'lengthBetween',
                'equalToPassword'
            ]
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'resetpassword']);
        $result = $this->Users->save($user);

        $this->assertFalse($result, 'Should be false because the pass doesn not match and not 8 characters.');
        $this->assertEquals($expected, $this->Utility->getL2Keys($user->errors()));

        $data = [
            'password' => '12345678',
            'password_confirm' => '12345678',
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'resetpassword']);
        $result = $this->Users->save($user);

        $this->assertInstanceOf('App\Model\Entity\User', $result);
        $this->assertTrue((new DefaultPasswordHasher)->check($data['password'], $result->password));
    }

    /**
     * test validationUpdate
     *
     * @return void
     */
    public function testValidationUpdate()
    {
        $data = [
            'username' => 'larry',
            'email' => 'larry@example.com'
        ];

        $expected = [
            'username' => [
                'unique'
            ],
            'email' => [
                'unique'
            ]
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'update']);
        $result = $this->Users->save($user);

        $this->assertFalse($result, 'Should be false because the username & Email are already used.');
        $this->assertEquals($expected, $this->Utility->getL2Keys($user->errors()));

        $data = [
            'username' => 'la^',
            'email' => 'example.com'
        ];

        $expected = [
            'username' => [
                'alphanumeric',
                'lengthBetween'
            ],
            'email' => [
                'email'
            ]
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'update']);
        $result = $this->Users->save($user);

        $this->assertFalse($result, 'Should be false because the username & Email are not correct.');
        $this->assertEquals($expected, $this->Utility->getL2Keys($user->errors()));

        $data = [
            'username' => 'newmariano',
            'email' => 'new@example.com'
        ];

        $user = $this->Users->get(1);
        $this->Users->patchEntity($user, $data, ['validate' => 'update']);
        $result = $this->Users->save($user);

        $this->assertInstanceOf('App\Model\Entity\User', $result);
        $this->assertEquals($data['username'], $result->username);
        $this->assertEquals($data['email'], $result->email);
    }
}
