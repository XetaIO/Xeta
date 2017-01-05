<?php
namespace App\Test\TestCase\I18n;

use App\I18n\Language;
use Cake\Controller\Controller;
use Cake\I18n\I18n;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

class LanguageTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var void
     */
    public $fixtures = [
        'app.users'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        Security::salt('12345678901234567890123456789012345678901');
        $this->controller = new Controller(new Request(), new Response());
        $this->controller->loadComponent('Cookie');
        $this->controller->loadComponent('Auth');
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        I18n::locale(I18n::defaultLocale());
        unset($this->controller);
    }

    /**
     * Test set language not connected with no cookie method
     *
     * @return void
     */
    public function testSetLanguageNotConnectedWithNoCookie()
    {
        $this->controller->request->env('HTTP_ACCEPT_LANGUAGE', 'enZZ');
        $language = new Language($this->controller);

        $this->assertEquals('en_US', I18n::locale());
        $language->setLanguage();
        $this->assertEquals('en_US', I18n::locale());

        $this->controller->Cookie->delete('language');
        $this->controller->request->env('HTTP_ACCEPT_LANGUAGE', 'fr_FR');
        $language = new Language($this->controller);

        $this->assertEquals('en_US', I18n::locale());
        $language->setLanguage();
        $this->assertEquals('en_US', I18n::locale());
    }

    /**
     * Test set language not connected method
     *
     * @return void
     */
    public function testSetLanguageNotConnected()
    {
        $this->controller->Cookie->write('language', 'fr_FR');
        $language = new Language($this->controller);

        $language->setLanguage();
        $this->assertEquals('fr_FR', I18n::locale());
    }

    /**
     * Test set language connected method
     *
     * @return void
     */
    public function testSetLanguageConnected()
    {
        $this->controller->request->session()->write([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                    'language' => 'fr_FR'
                ]
            ]
        ]);

        $language = new Language($this->controller);
        $this->assertNull($this->controller->Cookie->read('language'));

        $language->setLanguage();

        $this->assertEquals('fr_FR', $this->controller->Cookie->read('language'));
        $this->assertEquals('fr_FR', I18n::locale());
    }

    /**
     * Test set language method with changing the language
     *
     * @return void
     */
    public function testSetLanguageAndChangeTheLanguage()
    {
        $this->controller->request->addParams(['lang' => 'fr_FR']);
        $language = new Language($this->controller);

        $this->assertNull($this->controller->Cookie->read('language'));

        $language->setLanguage();

        $this->assertEquals('fr_FR', $this->controller->Cookie->read('language'));
        $this->assertEquals('fr_FR', I18n::locale());
    }

    /**
     * Test set language connected method with changing the language
     *
     * @return void
     */
    public function testSetLanguageConnectedAndChangeTheLanguage()
    {
        $this->controller->request->addParams(['lang' => 'en_US']);
        $this->controller->request->session()->write([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                    'language' => 'fr_FR'
                ]
            ]
        ]);

        $language = new Language($this->controller);
        $this->assertEquals('fr_FR', $this->controller->request->session()->read('Auth.User.language'));
        $this->assertNull($this->controller->Cookie->read('language'));

        $language->setLanguage();
        $this->assertEquals('en_US', $this->controller->request->session()->read('Auth.User.language'));
        $this->assertEquals('en_US', $this->controller->Cookie->read('language'));
        $this->assertEquals('en_US', I18n::locale());
    }
}
