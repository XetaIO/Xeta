<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\SluggableBehavior;
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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		$table = $this->getMock('Cake\ORM\Table');
		$this->behavior = new SluggableBehavior($table);
	}

/**
 * Test findSlug method
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

}
