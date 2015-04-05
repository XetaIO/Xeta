<?php
namespace App\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class PremiumControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.groups',
        'app.groups_i18n',
        'app.aros',
        'app.acos',
        'app.aros_acos',
        'app.sessions',
        'app.premium_offers',
        'app.premium_transactions',
        'app.premium_discounts'
    ];

    /**
     * Test index method unauthorized
     *
     * @return void
     */
    public function testIndexUnauthorized()
    {
        $this->get(['controller' => 'premium', 'action' => 'index']);

        $this->assertResponseOk();
        //We can't test the flash test due to the translation system.
        $this->assertResponseContains('infobox-primary');
    }

    /**
     * Test index method unauthorized
     *
     * @return void
     */
    public function testIndexAuthorizedWithPremium()
    {
        $Users = TableRegistry::get('Users');
        $user = $Users->get(1);

        $time = new Time('+5 days');
        $user->end_subscription = $time;
        $Users->save($user);

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);

        $this->get(['controller' => 'premium', 'action' => 'index']);

        $this->assertResponseOk();
        //We can't test the flash test due to the translation system.
        $this->assertResponseContains('infobox-primary');
        $this->assertResponseContains($time->format('H:i:s d-m-Y'));
    }

    /**
     * Test subscribe method unauthorized
     *
     * @return void
     */
    public function testSubscribeUnauthorized()
    {
        $this->get(['controller' => 'premium', 'action' => 'subscribe']);

        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'users', 'action' => 'login']);
    }

    /**
     * Test subscribe method authorized with offer
     *
     * @return void
     */
    public function testSubscribeAuthorizedWithOffer()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);

        $data = [
            'period' => 1
        ];

        $this->post(['controller' => 'premium', 'action' => 'subscribe'], $data);

        $this->assertResponseSuccess();

        if (!empty(Configure::read('Paypal.user')) && !empty(Configure::read('Paypal.pwd'))) {
            $this->assertRedirectContains('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=');
        } else {
            $this->assertRedirect(['controller' => 'premium', 'action' => 'index']);
            $this->assertSession('flash', 'Flash.flash.key');
        }
    }

    /**
     * Test subscribe method authorized with fake offer
     *
     * @return void
     */
    public function testSubscribeAuthorizedWithFakeOffer()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);

        $data = [
            'period' => 69
        ];

        $this->post(['controller' => 'premium', 'action' => 'subscribe'], $data);

        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'premium', 'action' => 'index']);
        //We can't test the flash message due to the translation system.
        $this->assertSession('flash', 'Flash.flash.key');
    }

    /**
     * Test subscribe method authorized with offer and discount
     *
     * @return void
     */
    public function testSubscribeAuthorizedWithOfferAndDiscount()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);

        $data = [
            'period' => 1,
            'discount' => 'XETATEST'
        ];

        $this->post(['controller' => 'premium', 'action' => 'subscribe'], $data);

        $this->assertResponseSuccess();

        if (!empty(Configure::read('Paypal.user')) && !empty(Configure::read('Paypal.pwd'))) {
            $this->assertRedirectContains('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=');
        } else {
            $this->assertRedirect(['controller' => 'premium', 'action' => 'index']);
            $this->assertSession('flash', 'Flash.flash.key');
        }
    }

    /**
     * Test subscribe method authorized with offer and fake discount
     *
     * @return void
     */
    public function testSubscribeAuthorizedWithOfferAndFakeDiscount()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);

        $data = [
            'period' => 1,
            'discount' => 'XETATEST2'
        ];

        $this->post(['controller' => 'premium', 'action' => 'subscribe'], $data);

        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'premium', 'action' => 'index']);
        //We can't test the flash message due to the translation system.
        $this->assertSession('flash', 'Flash.flash.key');
    }

    /**
     * Test notify method
     *
     * @return void
     */
    public function testNotify()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);

        $this->get(['controller' => 'premium', 'action' => 'notify']);

        $this->assertResponseError();
    }

    /**
     * Test success method with fake txn id
     *
     * @return void
     */
    public function testSuccessWithFakeTxnId()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);

        $data = [
            'txn_id' => 'XETA123456789',
            'custom' => 'user_id=1',
            ''
        ];

        $this->post(['controller' => 'premium', 'action' => 'success'], $data);

        $this->assertResponseOk();
        $this->assertSession('XETA123456789', 'Premium.Check');
    }

    /**
     * Test success method with fake txn id
     *
     * @return void
     */
    public function testSuccessWithTxnId()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);

        $data = [
            'txn_id' => 'W13078622810RHB95',
            'custom' => 'user_id=1',
            ''
        ];

        $this->post(['controller' => 'premium', 'action' => 'success'], $data);

        $this->assertResponseOk();
        //We can't test the flash test due to the translation system.
        $this->assertResponseContains('infobox-primary');
    }

    /**
     * Test cancel method unauthorized
     *
     * @return void
     */
    public function testCancelUnauthorized()
    {
        $this->get(['controller' => 'premium', 'action' => 'cancel']);

        $this->assertResponseSuccess();
    }

    /**
     * Test cancel method authorized
     *
     * @return void
     */
    public function testCancelAuthorized()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);

        $this->get(['controller' => 'premium', 'action' => 'cancel']);

        $this->assertResponseOk();
    }
}
