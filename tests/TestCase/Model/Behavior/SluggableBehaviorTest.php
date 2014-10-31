<?php
namespace App\Test\TestCase\Model\Behavior;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class SluggableBehaviorTest extends TestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = ['app.users'];

/**
 * teardown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

/**
 * test findSlug.
 *
 * @return void
 */
	public function testFindSlug() {
		$table = TableRegistry::get('users');
		$row = $table->find('slug', [
						'slug' => 'mariano',
						'slugField' => 'users.slug'
					])->first();
		$this->assertEquals('mariano', $row->username);
	}

/**
 * test beforeSave.
 *
 * @return void
 */
	public function testBeforeSave() {
		$table = TableRegistry::get('users');
		$table->addBehavior('Sluggable', [
			'field' => 'username'
		]);

		$before = $table->get(1);
		$entity = new Entity(['id' => 1, 'username' => 'Foo']);
		$table->save($entity);
		$after = $table->get(1);

		$this->assertEquals('mariano', $before->slug);
		$this->assertEquals('foo', $after->slug);
	}
}
