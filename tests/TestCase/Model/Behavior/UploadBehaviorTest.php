<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\UploadBehavior;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\ORM\Entity;
use Cake\ORM\Table;
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

		$table = TableRegistry::get('users');
		$table->removeBehavior('Upload');
		$table->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':id',
					'overwrite' => true,
					'prefix' => '..' . DS,
					'defaultFile' => 'avatar.png'
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_file' => $file];
		$user = $table->get(1);
		$user->accessible('avatar_file', true);
		$table->patchEntity($user, $modifiedEntity);
		$table->save($user);
		$this->assertFalse(file_exists(TEST_WWW_ROOT . DS . 'upload' . DS . $user->id . DS . $user->id));
	}

/**
 * test beforeSaveErrorNoPathConfig
 *
 * @return void
 */
	public function testBeforeSaveErrorNoPathConfig() {
		$file = [
			'name' => 'tmp_avatar.png',
			'tmp_name' => TEST_TMP . 'tmp_avatar.png',
			'error' => UPLOAD_ERR_OK,
			'type' => 'image/png',
			'size' => 201
		];

		$table = TableRegistry::get('users');
		$table->removeBehavior('Upload');
		$table->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'overwrite' => true,
					'prefix' => '..' . DS,
					'defaultFile' => 'avatar.png'
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_file' => $file];
		$user = $table->get(1);
		$user->accessible('avatar_file', true);
		$table->patchEntity($user, $modifiedEntity);

		$this->setExpectedException('LogicException');
		$table->save($user);
	}

/**
 * test testBeforeSaveUploadOk
 *
 * @return void
 */
	public function testBeforeSaveUploadOk() {
		$file = [
			'name' => 'tmp_avatar.png',
			'tmp_name' => TEST_TMP . 'tmp_avatar.png',
			'error' => UPLOAD_ERR_OK,
			'type' => 'image/png',
			'size' => 201
		];

		$table = TableRegistry::get('users');
		$table->removeBehavior('Upload');
		$table->addBehavior('Upload', [
			'root' => TEST_WWW_ROOT,
			'fields' => [
				'avatar' => [
					'path' => 'upload' . DS . ':id' . DS . ':id',
					'overwrite' => true,
					'prefix' => '..' . DS,
					'defaultFile' => 'avatar.png'
				]
			]
		]);

		$modifiedEntity = ['id' => 1, 'avatar_file' => $file];
		$user = $table->get(1);
		$user->accessible('avatar_file', true);
		$table->patchEntity($user, $modifiedEntity);
		$table->save($user);
		$this->assertTrue(file_exists(TEST_WWW_ROOT . DS . 'upload' . DS . $user->id . DS . $user->id . '.png'));
	}
}
