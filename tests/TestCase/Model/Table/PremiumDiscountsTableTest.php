<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class PremiumDiscountsTableTest extends TestCase
{

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
    public function setUp()
    {
        parent::setUp();

        $this->Discounts = TableRegistry::get('PremiumDiscounts');
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

        unset($this->Discounts);
    }

    /**
     * Test findDiscountByCodeAndOffer
     *
     * @return void
     */
    public function testFindDiscountByCodeAndOffer()
    {
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
    public function testFindDiscountByIdAndOffer()
    {
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
    public function testIsDiscountValid()
    {
        $entity = $this->Discounts->get(1);
        $this->assertInstanceOf('App\Model\Entity\PremiumDiscount', $entity);
        $this->assertTrue($this->Discounts->isDiscountValid($entity));

        $entity->used = 2;
        $entity->max_use = 2;
        $this->assertFalse($this->Discounts->isDiscountValid($entity));
    }

    /**
     * Test validationDefault
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $data = [
            'premium_offer_id' => 'fail',
            'code' => $this->Utility->generateRandomString(55),
            'discount' => 'fail',
            'used' => 'fail',
            'max_use' => 'fail'
        ];

        $expected = [
            'premium_offer_id' => ['numeric'],
            'code' => ['maxLength'],
            'discount' => ['numeric'],
            'used' => ['numeric'],
            'max_use' => ['numeric']
        ];

        $discount = $this->Discounts->newEntity($data);
        $result = $this->Discounts->save($discount);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($discount->errors()), 'Should return errors.');

        $data = [
            'user_id' => 2,
            'premium_offer_id' => 1,
            'code' => 'TestCase',
            'discount' => 5.5,
            'used' => 5,
            'max_use' => 5
        ];

        $expected = [
            'id' => 3,
            'user_id' => 2,
            'premium_offer_id' => 1,
            'code' => 'TestCase',
            'discount' => 5.5,
            'used' => 5,
            'max_use' => 5
        ];

        $discount = $this->Discounts->newEntity($data);
        $result = $this->Discounts->save($discount);

        $this->assertInstanceOf('App\Model\Entity\PremiumDiscount', $result);
        $discount = $this->Discounts->find()->where(['id' => $result->id])->first()->toArray();
        unset($discount['created']);
        unset($discount['modified']);

        $this->assertEquals($expected, $discount);
    }
}
