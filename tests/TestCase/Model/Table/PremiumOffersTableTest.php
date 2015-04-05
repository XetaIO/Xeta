<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class PremiumOffersTableTest extends TestCase
{

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
    public function setUp()
    {
        parent::setUp();

        $this->Offers = TableRegistry::get('PremiumOffers');
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

        unset($this->Offers);
    }

    /**
     * Test findOffers
     *
     * @return void
     */
    public function testFindOffers()
    {
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
    public function testFindOfferByPeriod()
    {
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
    public function testFindOfferByIdAndPeriod()
    {
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

    /**
     * Test validationDefault
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $data = [
            'period' => 'test',
            'price' => 'test',
            'tax' => 'test',
            'currency_code' => '.test.fail.',
            'currency_symbol' => 'test.fail'
        ];

        $expected = [
            'period' => ['numeric'],
            'price' => ['numeric'],
            'tax' => ['numeric'],
            'currency_code' => ['maxLength'],
            'currency_symbol' => ['maxLength']
        ];

        $offer = $this->Offers->newEntity($data);
        $result = $this->Offers->save($offer);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($offer->errors()), 'Should return errors.');

        $data = [
            'user_id' => 2,
            'period' => 12,
            'price' => 24,
            'tax' => 19.6,
            'currency_code' => 'EUR',
            'currency_symbol' => '€'
        ];

        $expected = [
            'id' => 3,
            'user_id' => 2,
            'period' => 12,
            'price' => 24.0,
            'tax' => 19.6,
            'currency_code' => 'EUR',
            'currency_symbol' => '€'
        ];

        $offer = $this->Offers->newEntity($data);
        $result = $this->Offers->save($offer);

        $this->assertInstanceOf('App\Model\Entity\PremiumOffer', $result);
        $offer = $this->Offers->find()->where(['id' => $result->id])->first()->toArray();
        unset($offer['created']);
        unset($offer['modified']);

        $this->assertEquals($expected, $offer);
    }
}
