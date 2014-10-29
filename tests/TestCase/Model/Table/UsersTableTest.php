<?php
namespace App\Test\TestCase\Model\Table;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class UsersTest extends TestCase {

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
	public function setUp() {
		parent::setUp();
		$this->Users = TableRegistry::get('Users');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		$folder = new Folder(TEST_WWW_ROOT . 'upload');
		$folder->delete(TEST_WWW_ROOT . 'upload');
	}

/**
 * test findShort
 *
 * @return void
 */
	public function testFindShort() {
		$query = $this->Users->find('short')->where(['id' => 1])->first();
		$this->assertInstanceOf('App\Model\Entity\User', $query);
		$result = $query->toArray();
		$expected = [
			'first_name' => 'Maria',
			'last_name' => 'Riano',
			'username' => 'mariano',
			'slug' => 'mariano'
		];

		$this->assertEquals($expected, $result);
	}

/**
 * test findMedium
 *
 * @return void
 */
	public function testFindMedium() {
		$query = $this->Users->find('medium')->where(['id' => 1])->first();
		$this->assertInstanceOf('App\Model\Entity\User', $query);
		$result = $query->toArray();
		$expected = [
			'first_name' => 'Maria',
			'last_name' => 'Riano',
			'username' => 'mariano',
			'avatar' => '../img/avatar.png',
			'slug' => 'mariano'
		];

		$this->assertEquals($expected, $result);
	}

/**
 * test findFull
 *
 * @return void
 */
	public function testFindFull() {
		$query = $this->Users->find('full')->where(['id' => 1])->first();
		$this->assertInstanceOf('App\Model\Entity\User', $query);
		$result = $query->toArray();
		$expected = [
			'first_name' => 'Maria',
			'last_name' => 'Riano',
			'username' => 'mariano',
			'avatar' => '../img/avatar.png',
			'slug' => 'mariano',
			'role' => 'admin',
			'facebook' => 'mariano',
			'twitter' => 'mariano',
			'signature' => 'My awesome signature',
			'created' => new Time('2014-03-17 01:16:23'),
			'last_login' => new Time('2014-03-17 01:23:31')
		];

		$this->assertEquals($expected, $result);
	}

/**
 * test validationCreate
 *
 * @return void
 */
	public function testValidationCreate() {
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

		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user, ['validate' => 'create']);

		$this->assertFalse($result);
		$this->assertEquals($expected, $this->_getL2Keys($user->errors()), 'Should return errors.');

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

		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user, ['validate' => 'create']);

		$this->assertFalse($result);
		$this->assertEquals($expected, $this->_getL2Keys($user->errors()), 'Should return errors.');

		$data = [
			'username' => 'Xeta',
			'password' => '12345678',
			'password_confirm' => '12345678',
			'email' => 'xeta@example.com'
		];

		$expected = [
			'first_name' => null,
			'last_name' => null,
			'username' => 'Xeta',
			'slug' => 'xeta',
		];

		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user, ['validate' => 'create']);

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
	public function testValidationAccount() {
		$fakeImage = [
			'name' => 'tmp_avatar.php',
			'tmp_name' => TEST_WWW_ROOT . 'img' . DS . 'fakeImage.png',
			'error' => UPLOAD_ERR_NO_FILE,
			'type' => 'image/gif',
			'size' => 6000000000
		];
		$data = [
			'first_name' => $this->_generateRandomString(101),
			'last_name' => $this->_generateRandomString(101),
			'avatar_file' => $fakeImage,
			'facebook' => $this->_generateRandomString(201),
			'twitter' => $this->_generateRandomString(201),
			'biography' => $this->_generateRandomString(3001),
			'signature' => $this->_generateRandomString(301)
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
				'fileExtension'
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
		$this->Users->patchEntity($user, $data);
		$result = $this->Users->save($user, ['validate' => 'account']);

		$this->assertFalse($result);
		$this->assertEquals($expected, $this->_getL2Keys($user->errors()));

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
		$this->Users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':id'
				]
			]
		]);

		$user = $this->Users->get(1);
		$this->Users->patchEntity($user, $data);
		$result = $this->Users->save($user, ['validate' => 'account']);

		$this->assertInstanceOf('App\Model\Entity\User', $result);
		$this->assertEmpty($user->errors());

		$expected = [
			'first_name' => 'my firstname',
			'last_name' => 'my lastname',
			'username' => 'mariano',
			'avatar' => 'upload' . DS . '1' . DS . '1.png',
			'slug' => 'mariano',
			'role' => 'admin',
			'facebook' => 'my facebook',
			'twitter' => 'my twitter',
			'signature' => 'my signature',
			'created' => new Time('2014-03-17 01:16:23'),
			'last_login' => new Time('2014-03-17 01:23:31')
		];
		$user = $this->Users->find('full')->where(['id' => 1])->first()->toArray();

		$this->assertEquals($expected, $user);
	}

/**
 * test validationSettings
 *
 * @return void
 */
	public function testValidationSettings() {
		$data = [
			'email' => 'larry@example.com'
		];

		$expected = [
			'email' => [
				'unique'
			]
		];

		$user = $this->Users->get(1);
		$this->Users->patchEntity($user, $data);
		$result = $this->Users->save($user, ['validate' => 'settings']);

		$this->assertFalse($result, 'Should be false because this Email is already token.');
		$this->assertEquals($expected, $this->_getL2Keys($user->errors()));

		$data = [
			'email' => 'larry.com'
		];

		$expected = [
			'email' => [
				'email'
			]
		];

		$user = $this->Users->get(1);
		$this->Users->patchEntity($user, $data);
		$result = $this->Users->save($user, ['validate' => 'settings']);

		$this->assertFalse($result, 'Should be false because this Email is not correct.');
		$this->assertEquals($expected, $this->_getL2Keys($user->errors()));

		$data = [
			'email' => 'new@exemple.com'
		];

		$user = $this->Users->get(1);
		$this->Users->patchEntity($user, $data);
		$result = $this->Users->save($user, ['validate' => 'settings']);

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
		$this->Users->patchEntity($user, $data);
		$result = $this->Users->save($user, ['validate' => 'settings']);

		$this->assertFalse($result, 'Should be false because the pass doesn not match and not 8 characters.');
		$this->assertEquals($expected, $this->_getL2Keys($user->errors()));

		$data = [
			'password' => '12345678',
			'password_confirm' => '12345678',
		];

		$user = $this->Users->get(1);
		$this->Users->patchEntity($user, $data);
		$result = $this->Users->save($user, ['validate' => 'settings']);

		$this->assertInstanceOf('App\Model\Entity\User', $result);
		$this->assertTrue((new DefaultPasswordHasher)->check($data['password'], $result->password));
	}

/**
 * test validationUpdate
 *
 * @return void
 */
	public function testValidationUpdate() {
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
		$this->Users->patchEntity($user, $data);
		$result = $this->Users->save($user, ['validate' => 'update']);

		$this->assertFalse($result, 'Should be false because the username & Email are already used.');
		$this->assertEquals($expected, $this->_getL2Keys($user->errors()));

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
		$this->Users->patchEntity($user, $data);
		$result = $this->Users->save($user, ['validate' => 'update']);

		$this->assertFalse($result, 'Should be false because the username & Email are not correct.');
		$this->assertEquals($expected, $this->_getL2Keys($user->errors()));

		$data = [
			'username' => 'newmariano',
			'email' => 'new@example.com'
		];

		$user = $this->Users->get(1);
		$this->Users->patchEntity($user, $data);
		$result = $this->Users->save($user, ['validate' => 'update']);

		$this->assertInstanceOf('App\Model\Entity\User', $result);
		$this->assertEquals($data['username'], $result->username);
		$this->assertEquals($data['email'], $result->email);
	}

/**
 * Extract keys on 2 levels.
 *
 * @param array $array The array to extract keys.
 *
 * @return array
 */
	protected function _getL2Keys($array) {
		foreach ($array as $key => $rules) {
			$vals[$key] = array_keys($rules);
		}

		return $vals;
	}

/**
 * Generate a random string with a custom length.
 *
 * @param int $length The length of the string.
 *
 * @return string
 */
	protected function _generateRandomString($length = 10) {
		$string = '';
		for ($i = 0; $i < $length; $i++) {
			$string .= 'z';
		}
		return $string;
	}
}
