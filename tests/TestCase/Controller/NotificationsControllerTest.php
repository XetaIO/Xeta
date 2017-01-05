<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class NotificationsControllerTest extends IntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.aros',
        'app.acos',
        'app.aros_acos',
        'app.groups',
        'app.groups_i18n',
        'app.notifications',
        'app.settings',
        'app.sessions',
        'app.users',
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

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

        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

        $data = [
            'user_id' => 1,
            'foreign_key' => null,
            'type' => 'bot',
            'data' => 'a:1:{s:4:"icon";s:32:"../img/notifications/welcome.png";}',
            'is_read' => '0'
        ];

        $this->Notifications = TableRegistry::get('Notifications');
        $entity = $this->Notifications->newEntity($data);
        $this->Notifications->save($entity);
    }

    /**
     * test markAsRead method
     *
     * @return void
     */
    public function testMarkAsRead()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $data = [
            '_csrfToken' => '123456789',
            'id' => 1
        ];

        $this->post(['controller' => 'notifications', 'action' => 'markAsRead'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('"error": false');

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
        //Test markAsRead when the notif is already readed
        $this->post(['controller' => 'notifications', 'action' => 'markAsRead'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('"error": false', 'Should not throw an error.');
    }

    /**
     * test markAsRead method
     *
     * @return void
     */
    public function testMarkAsReadNotAjax()
    {
        $this->get(['controller' => 'notifications', 'action' => 'markAsRead']);
        $this->assertResponseError();
    }

    /**
     * test markAsRead method
     *
     * @return void
     */
    public function testMarkAsReadUnauthorized()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 2,
                ]
            ]
        ]);
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $data = [
            '_csrfToken' => '123456789',
            'id' => 1
        ];

        $this->post(['controller' => 'notifications', 'action' => 'markAsRead'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('"error": true');
    }

    /**
     * test markAsRead method
     *
     * @return void
     */
    public function testMarkAsReadNotFound()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $data = [
            '_csrfToken' => '123456789',
            'id' => 1337
        ];

        $this->post(['controller' => 'notifications', 'action' => 'markAsRead'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('"error": true');
    }
}
