<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class ContactControllerTest extends IntegrationTestCase
{

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
        $data = [
            'email' => '',
            'name' => '',
            'message' => ''
        ];

        $this->post(['controller' => 'contact', 'action' => 'index'], $data);

        $this->assertResponseOk();
        $this->assertResponseContains('text-danger');
    }
}
