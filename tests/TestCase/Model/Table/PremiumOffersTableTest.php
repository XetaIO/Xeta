<?php
namespace App\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class PremiumOffersTableTest extends TestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = ['app.premium_offers'];

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Offers = TableRegistry::get('PremiumOffers');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		unset($this->Offers);
	}

/**
 * Test findOffers
 *
 * @return void
 */
	public function testFindOffers() {
		$query = $this->Offers->find('offers');
		$this->assertInstanceOf('Cake\ORM\Query', $query);
		$result = $query->hydrate(false)->toArray();
		$expected = [
			[
				'period' => 1,
				'price' => 3,
				'tax' => 5.6,
				'currency_symbol' => '€'
			],
			[
				'period' => 6,
				'price' => 9.5,
				'tax' => 19.6,
				'currency_symbol' => '€'
			]
		];

		$this->assertEquals($expected, $result);
	}

/**
 * Test findOfferByPeriod
 *
 * @return void
 */
	public function testFindOfferByPeriod() {
		$query = $this->Offers->find('offerByPeriod', ['period' => 6]);
		$this->assertInstanceOf('App\Model\Entity\PremiumOffer', $query);

		$result = $query->toArray();
		$expected = [
			'id' => 2,
			'period' => 6,
			'price' => 9.5,
			'tax' => 19.6,
			'currency_code' => 'EUR',
			'currency_symbol' => '€'
		];

		$this->assertEquals($expected, $result);
	}

/**
 * Test findOfferByIdAndPeriod
 *
 * @return void
 */
	public function testFindOfferByIdAndPeriod() {
		$query = $this->Offers->find('offerByPeriod', ['id' => 2, 'period' => 6]);
		$this->assertInstanceOf('App\Model\Entity\PremiumOffer', $query);

		$result = $query->toArray();
		$expected = [
			'id' => 2,
			'period' => 6,
			'price' => 9.5,
			'tax' => 19.6,
			'currency_code' => 'EUR',
			'currency_symbol' => '€'
		];

		$this->assertEquals($expected, $result);
	}

}
