<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\AclHelper;
use Cake\Network\Request;
use Cake\Network\Session;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class AclHelperTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.groups',
        'app.acos',
        'app.aros',
        'app.aros_acos'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->View = new View();
        $this->session = new Session();
        $this->View->request = new Request(['session' => $this->session]);
        $this->Acl = new AclHelper($this->View);

        $this->session->write([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'group_id' => 1
                ]
            ]
        ]);
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->Acl, $this->View, $this->session);
    }

    /**
     * Test check
     *
     * @return void
     */
    public function testCheck()
    {
        $result = $this->Acl->check(['controller' => 'pages', 'action' => 'home']);
        $this->assertFalse($result);

        $result = $this->Acl->check(['controller' => 'blog', 'action' => 'index']);
        $this->assertFalse($result);

        $this->session->write([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'group_id' => 5
                ]
            ]
        ]);

        $result = $this->Acl->check(['controller' => 'pages', 'action' => 'home']);
        $this->assertTrue($result);

        $result = $this->Acl->check(['controller' => 'blog', 'action' => 'index']);
        $this->assertTrue($result);
    }

    /**
     * Test link
     *
     * @return void
     */
    public function testLink()
    {
        $result = $this->Acl->link('test', ['controller' => 'blog', 'action' => 'index']);
        $this->assertEmpty($result);

        $this->session->write([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'group_id' => 5
                ]
            ]
        ]);

        $result = $this->Acl->link('test', ['controller' => 'pages', 'action' => 'home']);
        $expected = [
            'a' => ['href' => '/'],
            'test',
            '/a'
        ];
        $this->assertHtml($expected, $result);

        $result = $this->Acl->link('test', ['controller' => 'blog', 'action' => 'index']);
        $expected = [
            'a' => ['href' => '/blog'],
            'test',
            '/a'
        ];
        $this->assertHtml($expected, $result);
    }
}
