<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class ContactControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.settings'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(['controller' => 'contact', 'action' => 'index']);

        $this->assertResponseOk();
    }

    /**
     * Test index method with invalid data
     *
     * @return void
     */
    public function testIndexWithInvalidData()
    {
        //Bypass mailtrap security
        sleep(3);
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

        $data = [
            'name' => '',
            'email' => '',
            'subject' => '',
            'message' => '',
            '_csrfToken' => '123456789'
        ];

        $this->post(['controller' => 'contact', 'action' => 'index'], $data);

        $this->assertResponseOk();
        $this->assertResponseContains('text-danger');
    }

    /**
     * Test index method with valid data
     *
     * @return void
     */
    public function testIndexWithValidData()
    {
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

        $data = [
            'email' => 'test@xeta.io',
            'name' => 'My Name',
            'subject' => '',
            'message' => 'My message',
            '_csrfToken' => '123456789'
        ];

        $this->post(['controller' => 'contact', 'action' => 'index'], $data);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home']);
    }
}
