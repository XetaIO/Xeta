<?php
namespace App\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class PremiumTransactionsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.premium_transactions'];

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
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->Transactions);
    }

    /**
     * Test findTransactionByTxn
     *
     * @return void
     */
    public function testFindTransactionByTxn()
    {
        $query = $this->Transactions->find('transactionByTxn', ['txn' => 'W13078622810RHB95']);
        $this->assertInstanceOf('App\Model\Entity\PremiumTransaction', $query);

        $result = $query->toArray();
        $expected = [
            'id' => 1,
            'txn' => 'W13078622810RHB95'
        ];

        $this->assertEquals($expected, $result);
    }
}
