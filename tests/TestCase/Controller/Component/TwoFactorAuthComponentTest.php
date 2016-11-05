<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\TwoFactorAuthComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class TwoFactorAuthComponentTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users_two_factor_auth',
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->registry = new ComponentRegistry(
            new Controller(
                new Request(
                    [
                        'environment' => [
                            'REMOTE_ADDR' => '127.0.0.1',
                            'HTTP_USER_AGENT' => 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_4; en-ca) AppleWebKit/534.8+ (KHTML, like Gecko) Version/5.0 Safari/533.16'
                        ]
                    ]
                ),
                new Response()
            )
        );
        $this->TwoFactorAuth = new TwoFactorAuthComponent($this->registry);
        $this->UsersTwoFactorAuth = TableRegistry::get('UsersTwoFactorAuth');

        $data = [
            'user_id' => 1,
            'session' => $this->registry->getController()->request->clientIp() . $this->registry->getController()->request->header('User-Agent') . gethostbyaddr($this->registry->getController()->request->clientIp()),
        ];
        $tfa = $this->UsersTwoFactorAuth->newEntity($data);
        $this->UsersTwoFactorAuth->save($tfa);
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->TwoFactorAuth);
    }

    /**
     * Test isAuthorized method
     *
     * @return void
     */
    public function testIsAuthorizedOk()
    {
        $result = $this->TwoFactorAuth->isAuthorized(1);
        $this->assertTrue($result);

        $this->TwoFactorAuth->_registry->getController()->request->env('REMOTE_ADDR', '127.0.0.1');
        $this->TwoFactorAuth->_registry->getController()->request->env('HTTP_USER_AGENT', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_4; en-ca) AppleWebKit/534.8+ (KHTML, like Gecko) Version/5.0 Safari/533.16');
        $result = $this->TwoFactorAuth->isAuthorized(1);
        $this->assertTrue($result);
    }

    public function testIsAuthorizedFakeUserAgent()
    {
        $this->TwoFactorAuth->_registry->getController()->request->env('HTTP_USER_AGENT', 'Another User Agent');
        $result = $this->TwoFactorAuth->isAuthorized(1);
        $this->assertFalse($result);

        $this->TwoFactorAuth->_registry->getController()->request->env('HTTP_USER_AGENT', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_4; en-ca) AppleWebKit/534.8+ (KHTML, like Gecko) Version/5.0 Safari/533.16');
        $result = $this->TwoFactorAuth->isAuthorized(1);
        $this->assertTrue($result);
    }

    public function testIsAuthorizedFakeIP()
    {
        $this->TwoFactorAuth->_registry->getController()->request->env('REMOTE_ADDR', '127.0.0.1');
        $result = $this->TwoFactorAuth->isAuthorized(1);
        $this->assertTrue($result);

        $this->TwoFactorAuth->_registry->getController()->request->env('REMOTE_ADDR', '127.0.0.2');
        $result = $this->TwoFactorAuth->isAuthorized(1);
        $this->assertFalse($result);
    }
}
