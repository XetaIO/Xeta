<?php
namespace App\Test\TestCase\Auth;

use App\Auth\CookieAuthenticate;
use Cake\Auth\BasicAuthenticate;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

class CookieAuthenticateTest extends TestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = ['app.users'];

/**
 * setup
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->request = new Request('posts/index');
		Router::setRequestInfo($this->request);
		$this->response = $this->getMock('Cake\Network\Response');

		Security::salt('somerandomhaskeysomerandomhaskey');
		$this->registry = new ComponentRegistry(new Controller($this->request, $this->response));
		$this->registry->load('Cookie');
		$this->registry->load('Session');
		$this->registry->load('Auth');
		$this->auth = new CookieAuthenticate($this->registry);

		$password = password_hash('password', PASSWORD_DEFAULT);
		$Users = TableRegistry::get('Users');
		$Users->updateAll(['password' => $password], []);
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		$this->registry->Cookie->delete('Users');
	}

/**
 * test authenticate with username and password
 *
 * @return void
 */
	public function testAuthenticate() {
		$expected = array(
			'id' => 1,
			'username' => 'mariano',
			'email' => 'mariano@example.com',
			'first_name' => 'Maria',
			'last_name' => 'Riano',
			'avatar' => '../img/avatar.png',
			'biography' => 'My awesome biography',
			'signature' => 'My awesome signature',
			'facebook' => 'mariano',
			'twitter' => 'mariano',
			'role' => 'admin',
			'slug' => 'mariano',
			'blog_articles_comment_count' => 0,
			'blog_article_count' => 0,
			'counter_id' => 1,
			'register_ip' => '192.168.0.1',
			'last_login_ip' => '192.168.0.1',
			'last_login' => new Time('2014-03-17 01:23:31'),
			'created' => new Time('2014-03-17 01:16:23'),
			'modified' => new Time('2014-03-17 01:18:31')
		);

		$result = $this->auth->authenticate($this->request, $this->response);
		$this->assertFalse($result);

		$this->registry->Cookie->write(
			'User',
			['username' => 'mariano', 'password' => 'password']
		);
		$result = $this->auth->authenticate($this->request, $this->response);
		$this->assertEquals($expected, $result);
	}

/**
 * test authenticate with empty user.
 *
 * @return void
 */
	public function testAuthenticateNoUsername() {
		$this->registry->Cookie->write(
			'User',
			['username' => '', 'password' => 'password']
		);

		$result = $this->auth->authenticate($this->request, $this->response);
		$this->assertFalse($result);
	}

/**
 * test authenticate with password fail.
 *
 * @return void
 */
	public function testAuthenticateFail() {
		$this->registry->Cookie->write(
			'User',
			['username' => 'mariano', 'password' => 'passwordfail']
		);
		$result = $this->auth->authenticate($this->request, $this->response);
		$this->assertFalse($result);
	}

/**
 * test authenticate with no CookieComponent.
 *
 * @return void
 */
	public function testAuthenticateNoCookieComponent() {
		$this->_registry = new ComponentRegistry(new Controller($this->request, $this->response));
		$this->_registry->load('Cookie');
		$this->_auth = new CookieAuthenticate($this->_registry);

		$this->assertTrue($this->_registry->loaded('Cookie'));

		$this->_registry->unload('Cookie');

		$this->setExpectedException('RuntimeException');
		$this->_auth->authenticate($this->request, $this->response);
	}

/**
 * test logout.
 *
 * @return void
 */
	public function testLogout() {
		$this->registry->Cookie->write(
			'User',
			['username' => 'mariano', 'password' => 'password']
		);
		$user = $this->auth->authenticate($this->request, $this->response);

		$resultTrue = $this->registry->Cookie->check('User');
		$this->assertTrue($resultTrue);

		$this->auth->logout($user);
		$resultFalse = $this->registry->Cookie->check('User');
		$this->assertFalse($resultFalse);
	}

}
