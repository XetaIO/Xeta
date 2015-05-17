<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\PaypalComponent;
use App\Test\Lib\Utility;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class PaypalComponentTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.premium_offers',
        'app.premium_discounts',
        'app.premium_transactions',
        'app.badges',
        'app.badges_users',
        'app.notifications'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        Configure::write('Paypal.mail', 'seller@paypal.com');
        $controller = new Controller(new Request(), new Response());
        $registry = new ComponentRegistry($controller);

        $this->PaypalComponent = new PaypalComponent($registry);
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

        unset($this->PaypalComponent);
    }

    /**
     * Test isCurrencyValid
     *
     * @return void
     */
    public function testIsCurrencyValid()
    {
        $custom = [
            'offer_id' => 2,
            'period' => 6
        ];

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isCurrencyValid',
            [$custom, 'EUR']
        );

        $this->assertTrue($result);

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isCurrencyValid',
            [$custom, 'DOL']
        );

        $this->assertFalse($result);
    }

    /**
     * Test updateDiscount
     *
     * @return void
     */
    public function testUpdateDiscount()
    {
        $this->Discount = TableRegistry::get('PremiumDiscounts');

        $entity = $this->Discount->get(1);
        $this->assertEquals($entity->used, 0);

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_updateDiscount',
            [$entity]
        );
        $this->assertTrue($result);

        $entity = $this->Discount->get(1);
        $this->assertEquals($entity->used, 1);
    }

    /**
     * Test isDiscountValid
     *
     * @return void
     */
    public function testIsDiscountValid()
    {
        $this->Discount = TableRegistry::get('PremiumDiscounts');

        $entity = $this->Discount->get(2);
        $this->assertEquals($entity->used, 2);

        $custom = [
            'offer_id' => 1
        ];
        $mcGross = 3.55;
        $tax = 0.17;
        $discount = 0.00;

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isDiscountValid',
            [$custom, $mcGross, $tax, $discount]
        );
        $this->assertTrue($result);

        $custom = [
            'discount_id' => 1,
            'offer_id' => 2
        ];
        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isDiscountValid',
            [$custom, $mcGross, $tax, $discount]
        );
        $this->assertFalse($result);

        $custom = [
            'discount_id' => 2,
            'offer_id' => 2
        ];
        $mcGross = 24.35;
        $tax = 19.6;
        $discount = 4.75;

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isDiscountValid',
            [$custom, $mcGross, $tax, $discount]
        );
        $this->assertTrue($result);

        $discount = 4.70;

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isDiscountValid',
            [$custom, $mcGross, $tax, $discount]
        );
        $this->assertFalse($result);

        $mcGross = 24.30;
        $discount = 4.75;

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isDiscountValid',
            [$custom, $mcGross, $tax, $discount]
        );
        $this->assertFalse($result);

        $entity = $this->Discount->get(2);
        $this->assertEquals($entity->used, 3);
    }

    /**
     * Test isPriceValid
     *
     * @return void
     */
    public function testIsPriceValid()
    {
        $custom = [
            'offer_id' => 2,
            'period' => 7
        ];
        $mcGross = 3.55;
        $tax = 0.17;
        $discount = 0.00;

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isPriceValid',
            [$custom, $mcGross, $tax, $discount]
        );
        $this->assertFalse($result);

        $custom = [
            'offer_id' => 2,
            'period' => 6
        ];
        $mcGross = 11.36;
        $tax = 1.86;

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isPriceValid',
            [$custom, $mcGross, $tax, $discount]
        );
        $this->assertTrue($result);

        $tax = 1.87;

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isPriceValid',
            [$custom, $mcGross, $tax, $discount]
        );
        $this->assertFalse($result);
    }

    /**
     * Test isEmailValid
     *
     * @return void
     */
    public function testIsEmailValid()
    {
        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isEmailValid',
            ['seller@fail.com']
        );
        $this->assertFalse($result);

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isEmailValid',
            ['seller@paypal.com']
        );
        $this->assertTrue($result);
    }

    /**
     * Test isTransactionNew
     *
     * @return void
     */
    public function testIsTransactionNew()
    {
        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isTransactionNew',
            ['W13078622810RHB95']
        );
        $this->assertFalse($result);

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_isTransactionNew',
            ['W130786228']
        );
        $this->assertTrue($result);
    }

    /**
     * Test updateUser
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $this->Users = TableRegistry::get('Users');

        $entity = $this->Users->get(1);
        $this->assertFalse($entity->premium);

        $custom = [
            'user_id' => 69
        ];
        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_updateUser',
            [$custom]
        );
        $this->assertFalse($result);
        $this->assertFalse($entity->premium);

        $custom = [
            'user_id' => 1,
            'period' => 6
        ];
        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_updateUser',
            [$custom]
        );
        $this->assertInstanceOf('App\Model\Entity\User', $result);
        $this->assertTrue($result->premium);
        $this->assertEquals($this->PaypalComponent->_action, 'new');

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_updateUser',
            [$custom]
        );

        $this->assertEquals($this->PaypalComponent->_action, 'extend');
    }

    /**
     * Test insertTransaction
     *
     * @return void
     */
    public function testInsertTransaction()
    {
        $this->Transactions = TableRegistry::get('PremiumTransactions');

        $custom = [
            'user_id' => 1,
            'offer_id' => 2,
            'period' => 6,
            'discount_id' => 2
        ];
        $price = 5.68;
        $tax = 0.93;
        $txn = '86W10RHB130786228';
        $name = 'My Name';
        $country = 'FRANCE';
        $city = 'Paris';
        $address = 'My awesome address';

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_insertTransaction',
            [$custom, $price, $tax, $txn, $name, $country, $city, $address]
        );

        $this->assertTrue($result);

        $transaction = $this->Transactions->get(3);
        $this->assertInstanceOf('App\Model\Entity\PremiumTransaction', $transaction);

        $expected = [
            'id' => 3,
            'user_id' => 1,
            'premium_offer_id' => 2,
            'premium_discount_id' => 2,
            'price' => 5.68,
            'tax' => 0.93,
            'txn' => '86W10RHB130786228',
            'action' => 'new',
            'period' => 6,
            'name' => 'My Name',
            'country' => 'FRANCE',
            'city' => 'Paris',
            'address' => 'My awesome address'
        ];
        $transaction = $transaction->toArray();
        unset($transaction['created'], $transaction['modified']);

        $this->assertEquals($transaction, $expected);
    }

    /**
     * test notifiy
     *
     * @return void
     */
    public function testNotify()
    {
        $post = [
            'mc_gross' => 3.59,
            'tax' => 0.59,
            'address_street' => 'Av. de la Pelouse, 87648672 Mayet',
            'payment_status' => 'Completed',
            'address_zip' => '75002',
            'first_name' => 'SandboxTest',
            'mc_fee' => 0.37,
            'address_country_code' => 'FR',
            'address_name' => 'SandboxTest Account',
            'custom' => 'user_id=1&offer_id=1&period=1',
            'payer_status' => 'unverified',
            'business' => 'seller@paypal.com',
            'address_country' => 'France',
            'address_city' => 'Paris',
            'quantity' => 1,
            'payer_email' => 'buyer@frenchmoddingteam.com',
            'txn_id' => '6Y558383LH909062H',
            'last_name' => 'Account',
            'receiver_email' => 'seller@paypal.com',
            'item_name' => 'Premium 1 month',
            'discount' => 0.00,
            'mc_currency' => 'EUR',
            'residence_country' => 'FR',
            'transaction_subject' => 'user_id=1&offer_id=1&period=1',
            'payment_gross' => ''
        ];

        $controller = new Controller(new Request(compact('post')), new Response());
        $registry = new ComponentRegistry($controller);

        $this->Paypal = $this->getMock(
            "App\Controller\Component\PaypalComponent",
            ["_sendResponse"],
            [$registry]
        );

        $this->Paypal->expects($this->any())->method('_sendResponse')->will($this->returnValue('VERIFIED'));
        $result = $this->Paypal->notify();
        $this->assertTrue($result);

        $this->Paypal = $this->getMock(
            "App\Controller\Component\PaypalComponent",
            ["_sendResponse"],
            [$registry]
        );

        $this->Paypal->expects($this->any())->method('_sendResponse')->will($this->returnValue('INVALID'));
        $result = $this->Paypal->notify();
        $this->assertFalse($result);

        $this->Paypal = $this->getMock(
            "App\Controller\Component\PaypalComponent",
            ["_sendResponse"],
            [$registry]
        );

        $this->Paypal->_registry->getController()->request->data['paymentStatus'] = 'invalid';
        $this->Paypal->expects($this->any())->method('_sendResponse')->will($this->returnValue('VERIFIED'));
        $result = $this->Paypal->notify();
        $this->assertFalse($result);
    }

    /**
     * test unlockbadges
     *
     * @return void
     */
    public function testUnlockbadges()
    {
        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_unlockBadges',
            ['fail']
        );

        $this->assertFalse($result);

        $this->Users = TableRegistry::get('Users');
        $user = $this->Users->get(1);

        $result = $this->Utility->callProtectedMethod(
            $this->PaypalComponent,
            '_unlockBadges',
            [$user]
        );

        $this->assertTrue($result);
    }
}
