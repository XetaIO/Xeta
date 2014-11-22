<?php
namespace App\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class PremiumDiscountsTableTest extends TestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = ['app.premium_discounts'];

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Discounts = TableRegistry::get('PremiumDiscounts');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		unset($this->Discounts);
	}

/**
 * Test findDiscountByCodeAndOffer
 *
 * @return void
 */
	public function testFindDiscountByCodeAndOffer() {
		$query = $this->Discounts->find('discountByCodeAndOffer', [
			'code' => 'XETATEST',
			'offer_id' => 1
		]);
		$this->assertInstanceOf('App\Model\Entity\PremiumDiscount', $query);

		$result = $query->toArray();
		$expected = [
			'id' => 1,
			'code' => 'XETATEST',
			'discount' => 20,
			'used' => 0,
			'max_use' => 2,
		];

		$this->assertEquals($expected, $result);
	}

/**
 * Test findDiscountByIdAndOffer
 *
 * @return void
 */
	public function testFindDiscountByIdAndOffer() {
		$query = $this->Discounts->find('discountByIdAndOffer', [
			'id' => '1',
			'offer_id' => 1
		]);
		$this->assertInstanceOf('App\Model\Entity\PremiumDiscount', $query);

		$result = $query->toArray();
		$expected = [
			'id' => 1,
			'code' => 'XETATEST',
			'discount' => 20,
			'used' => 0,
			'max_use' => 2,
		];

		$this->assertEquals($expected, $result);
	}

/**
 * Test isDiscountValid
 *
 * @return void
 */
	public function testIsDiscountValid() {
		$entity = $this->Discounts->get(1);
		$this->assertInstanceOf('App\Model\Entity\PremiumDiscount', $entity);
		$this->assertTrue($this->Discounts->isDiscountValid($entity));

		$entity->used = 2;
		$entity->max_use = 2;
		$this->assertFalse($this->Discounts->isDiscountValid($entity));
	}

}
