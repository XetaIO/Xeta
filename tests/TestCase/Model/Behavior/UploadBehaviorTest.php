<?php
namespace App\Test\TestCase\Model\Behavior;

use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class UploadBehaviorTest extends TestCase {

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
		$this->users = TableRegistry::get('users');
		$this->users->removeBehavior('Upload');
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
 * test beforeSave
 *
 * @return void
 */
	public function testBeforeSaveErrorNoFile() {
		$file = [
			'name' => 'tmp_avatar.png',
			'tmp_name' => TEST_TMP . 'tmp_avatar.png',
			'error' => UPLOAD_ERR_NO_FILE,
			'type' => 'image/png',
			'size' => 201
		];

		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':id'
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_file' => $file];
		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);
		$this->users->save($user);

		$this->assertFalse(file_exists(TEST_WWW_ROOT . DS . 'upload' . DS . $user->id . DS . $user->id));
	}

/**
 * test beforeSaveErrorNoPathConfig
 *
 * @return void
 */
	public function testBeforeSaveErrorNoPathConfig() {
		$file = [ 'name' => 'tmp_avatar.png', 'tmp_name' => TEST_TMP . 'tmp_avatar.png', 'error' => UPLOAD_ERR_OK,
			'type' => 'image/png', 'size' => 201];

		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => []
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_file' => $file];
		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);

		$this->setExpectedException('LogicException');
		$this->users->save($user);
	}

/**
 * test testBeforeSaveUploadOk
 *
 * @return void
 */
	public function testBeforeSaveUploadOk() {
		$file = [ 'name' => 'tmp_avatar.png', 'tmp_name' => TEST_TMP . 'tmp_avatar.png', 'error' => UPLOAD_ERR_OK,
			'type' => 'image/png', 'size' => 201];

		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':id'
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_file' => $file];
		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);
		$result = $this->users->save($user);

		$this->assertTrue(file_exists(TEST_WWW_ROOT . DS . 'upload' . DS . $user->id . DS . $user->id . '.png'));
		$this->assertEquals('upload' . DS . '1' . DS . '1.png', $result->avatar);
	}

/**
 * test testBeforeSaveUploadOkWithPrefix
 *
 * @return void
 */
	public function testBeforeSaveUploadOkWithPrefix() {
		$file = [ 'name' => 'tmp_avatar.png', 'tmp_name' => TEST_TMP . 'tmp_avatar.png', 'error' => UPLOAD_ERR_OK,
			'type' => 'image/png', 'size' => 201];

		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':id',
					'prefix' => '..' . DS . '..' . DS
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_file' => $file];
		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);
		$result = $this->users->save($user);

		$this->assertEquals('..' . DS . '..' . DS . 'upload' . DS . '1' . DS . '1.png', $result->avatar);
	}

/**
 * test testBeforeSaveUploadOkWithOverwrite
 *
 * @return void
 */
	public function testBeforeSaveUploadOkWithOverwrite() {
		$file = [ 'name' => 'tmp_avatar.png', 'tmp_name' => TEST_TMP . 'tmp_avatar.png', 'error' => UPLOAD_ERR_OK,
			'type' => 'image/png', 'size' => 201];

		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':md5'
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_file' => $file];
		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);
		$before = $this->users->save($user);

		$this->assertTrue(file_exists(TEST_WWW_ROOT . $before->avatar), 'The new file should be created.');

		$this->users->removeBehavior('Upload');
		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':md5',
					'overwrite' => true
				]
			]
		]);

		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);
		$after = $this->users->save($user);

		$this->assertFalse(file_exists(TEST_WWW_ROOT . $before->avatar), 'The old file should be deleted when overwrite is true');
		$this->assertTrue(file_exists(TEST_WWW_ROOT . $after->avatar), 'The new file should be created.');

		$this->users->removeBehavior('Upload');
		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':md5',
					'overwrite' => false
				]
			]
		]);

		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);
		$last = $this->users->save($user);

		$this->assertTrue(file_exists(TEST_WWW_ROOT . $after->avatar), 'The old file should not be deleted when overwrite is
		false.');
		$this->assertTrue(file_exists(TEST_WWW_ROOT . $last->avatar), 'The new file should be created.');
	}

/**
 * test testBeforeSaveWithAvatarWithoutExtension
 *
 * @return void
 */
	public function testBeforeSaveWithAvatarWithoutExtension() {
		$file = [ 'name' => 'tmp_avatar', 'tmp_name' => TEST_TMP . 'tmp_avatar.png', 'error' => UPLOAD_ERR_OK,
			'type' => 'image/png', 'size' => 201];

		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':id'
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_file' => $file];
		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);

		$this->setExpectedException('ErrorException');
		$this->users->save($user);
	}

/**
 * test testBeforeSaveUploadOkWithOverwrite
 *
 * @return void
 */
	public function testBeforeSaveUploadOkWithOverwriteAndDefaultFile() {
		$file = [ 'name' => 'tmp_avatar.png', 'tmp_name' => TEST_TMP . 'tmp_avatar.png', 'error' => UPLOAD_ERR_OK,
			'type' => 'image/png', 'size' => 201];

		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':md5'
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_file' => $file];
		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);
		$before = $this->users->save($user);

		$this->users->removeBehavior('Upload');
		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':md5',
					'overwrite' => true,
					'defaultFile' => $before->avatar
				]
			]
		]);

		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);
		$after = $this->users->save($user);

		$this->assertTrue(file_exists(TEST_WWW_ROOT . $before->avatar), 'The old file should not be deleted because it\'s the
		defaultFile.');
		$this->assertTrue(file_exists(TEST_WWW_ROOT . $after->avatar), 'The new file should be created.');
	}

/**
 * test testBeforeSaveUploadOkWithCustomSuffix
 *
 * @return void
 */
	public function testBeforeSaveUploadOkWithCustomSuffix() {
		$file = [ 'name' => 'tmp_avatar.png', 'tmp_name' => TEST_TMP . 'tmp_avatar.png', 'error' => UPLOAD_ERR_OK,
			'type' => 'image/png', 'size' => 201];

		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'suffix' => '_test',
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':id'
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_test' => $file];
		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);
		$result = $this->users->save($user);

		$this->assertEquals('upload' . DS . '1' . DS . '1.png', $result->avatar, 'The avatar should be created because both
		suffix match.');

		$this->users->removeBehavior('Upload');
		$this->users->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'suffix' => '_testFail',
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':md5'
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_test' => $file];
		$user = $this->users->get(1);
		$this->users->patchEntity($user, $modifiedEntity);
		$resultFail = $this->users->save($user);

		$this->assertEquals($user->avatar, $resultFail->avatar, 'The avatar field should not be changed because the suffix does
		 not match with the field suffix.');
	}
}
