<?php
namespace App\Test\TestCase\Model\Entity;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class PremiumTransactionTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.premium_transactions',
        'app.premium_offers',
        'app.premium_discounts'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Transactions = TableRegistry::get('PremiumTransactions');
    }

    /**
     * Test getDiscount
     *
     * @return void
     */
    public function testGetDiscount()
    {
        $transaction = $this->Transactions
            ->find()
            ->contain([
                'PremiumOffers',
                'PremiumDiscounts'
            ])
            ->where([
                'PremiumTransactions.id' => 2
            ])
            ->first();

        $this->assertEquals(4.75, $transaction->discount);
    }
}
