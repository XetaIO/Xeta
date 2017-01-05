<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class ConversationsControllerTest extends IntegrationTestCase
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
        'app.badges',
        'app.badges_i18n',
        'app.badges_users',
        'app.conversations',
        'app.conversations_messages',
        'app.conversations_users',
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
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(['controller' => 'conversations', 'action' => 'index']);
        $this->assertResponseOk();
        $this->assertResponseContains('Lorem ipsum dolor sit amet');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndexNoConversations()
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

        $this->get(['controller' => 'conversations', 'action' => 'index']);
        $this->assertResponseOk();
        $this->assertResponseContains('You don\'t have any conversations yet.');
    }

    /**
     * Test action method
     *
     * @return void
     */
    public function testActionUnknow()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
        $data = [
            '_csrfToken' => '123456789',
            'action' => 'unknowAction'
        ];

        $this->post(['controller' => 'conversations', 'action' => 'action'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('Action unknown.');
    }

    /**
     * Test action method
     *
     * @return void
     */
    public function testActionNoConversations()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
        $data = [
            '_csrfToken' => '123456789',
            'action' => 'star'
        ];

        $this->post(['controller' => 'conversations', 'action' => 'action'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('You have not chosen any conversations.');
    }

    /**
     * Test action method
     *
     * @return void
     */
    public function testActionStar()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
        $data = [
            '_csrfToken' => '123456789',
            'action' => 'star',
            'conversations' => [1]
        ];

        $this->post(['controller' => 'conversations', 'action' => 'action'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('Your conversation(s) has been Stared.');
    }

    /**
     * Test action method
     *
     * @return void
     */
    public function testActionNormal()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
        $data = [
            '_csrfToken' => '123456789',
            'action' => 'normal',
            'conversations' => [1]
        ];

        $this->post(['controller' => 'conversations', 'action' => 'action'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('Your conversation(s) has been set normal.');
    }

    /**
     * Test action method
     *
     * @return void
     */
    public function testActionExit()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
        $data = [
            '_csrfToken' => '123456789',
            'action' => 'exit',
            'conversations' => [1]
        ];

        $this->post(['controller' => 'conversations', 'action' => 'action'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('You have left your conversation(s) successfully.');

        $Conversations = TableRegistry::get('Conversations');
        $conversation = $Conversations->get(1);
        $this->assertEquals(2, $conversation->conversation_open, 'Conversation must be deleted.');
    }

    /**
     * Test create method
     *
     * @return void
     */
    public function testCreate()
    {
        $data = [
            '_csrfToken' => '123456789',
            'users' => 'larry,',
            'title' => 'Test title',
            'message' => '<p>Lorem ipsum dolor sit amet, aliquet feugiat.</p>',
            'open_invite' => '0',
            'conversation_open' => '1'
        ];

        $this->post(['controller' => 'conversations', 'action' => 'create'], $data);
        $this->assertSession('Your conversation has been created successfully !', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'conversations', 'action' => 'view', 'id' => 2, 'slug' => 'test-title']);

        $Conversations = TableRegistry::get('Conversations');
        $conversation = $Conversations->get(2);
        $this->assertEquals('Test title', $conversation->title);
        $this->assertEquals(2, $conversation->recipient_count);
        $this->assertEquals(0, $conversation->open_invite);
        $this->assertEquals(1, $conversation->conversation_open);

        $ConvMessages = TableRegistry::get('ConversationsMessages');
        $message = $ConvMessages->get(2);
        $this->assertEquals('<p>Lorem ipsum dolor sit amet, aliquet feugiat.</p>', $message->message);
        $this->assertEquals(0, $message->edit_count);

        $ConvUsers = TableRegistry::get('ConversationsUsers');
        $user = $ConvUsers->find()->where(['user_id' => 2, 'conversation_id' => 2])->first();
        $this->assertEquals(0, $user->is_read);
    }

    /**
     * Test create method
     *
     * @return void
     */
    public function testCreateMaxUsers()
    {
        $data = [
            '_csrfToken' => '123456789',
            'users' => str_repeat('larry, ', 100),
            'title' => 'Test title',
            'message' => '<p>Lorem ipsum dolor sit amet, aliquet feugiat.</p>',
            'open_invite' => '0',
            'conversation_open' => '1'
        ];

        $this->post(['controller' => 'conversations', 'action' => 'create'], $data);
        $this->assertResponseOk();
        $this->assertResponseContains('You cannot invite more than');
    }

    /**
     * Test create method
     *
     * @return void
     */
    public function testCreateUserNotFound()
    {
        $data = [
            '_csrfToken' => '123456789',
            'users' => 'UserNotFound,',
            'title' => 'Test title',
            'message' => '<p>Lorem ipsum dolor sit amet, aliquet feugiat.</p>',
            'open_invite' => '0',
            'conversation_open' => '1'
        ];

        $this->post(['controller' => 'conversations', 'action' => 'create'], $data);
        $this->assertResponseOk();
        $this->assertResponseContains('Please enter at least one valid recipient.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get(['controller' => 'conversations', 'action' => 'view', 'id' => 1, 'slug' => 'title']);
        $this->assertResponseOk();
        $this->assertResponseContains('Lorem ipsum dolor sit amet, aliquet feugiat.');
        $this->assertResponseContains('Maria Riano');
    }

    /**
     * Test inviteMember method
     *
     * @return void
     */
    public function testInviteMember()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
        $this->get(['controller' => 'conversations', 'action' => 'inviteMember', 'query' => 'mar']);
        $this->assertResponseOk();
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('mariano');
        $this->assertResponseNotContains('larry');
    }

    /**
     * Test quote method
     *
     * @return void
     */
    public function testQuote()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
        $this->get(['controller' => 'conversations', 'action' => 'quote', 1]);
        $this->assertResponseOk();
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('"error": false');
    }

    /**
     * Test quote method
     *
     * @return void
     */
    public function testQuoteNotExist()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
        $this->get(['controller' => 'conversations', 'action' => 'quote', 2]);
        $this->assertResponseOk();
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('"error": true');
    }

    /**
     * Test getEditMessage method
     *
     * @return void
     */
    public function testGetEditMessage()
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
        $this->post(['controller' => 'conversations', 'action' => 'getEditMessage'], $data);
        $this->assertResponseOk();
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('"error":false');
    }

    /**
     * Test getEditMessage method
     *
     * @return void
     */
    public function testGetEditMessageNotExist()
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
        $this->post(['controller' => 'conversations', 'action' => 'getEditMessage'], $data);
        $this->assertResponseOk();
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('"error":true');
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
    }

    /**
     * Test getEditMessage method
     *
     * @return void
     */
    public function testGetEditMessageNotAuthorized()
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
        $this->post(['controller' => 'conversations', 'action' => 'getEditMessage'], $data);
        $this->assertResponseOk();
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('"error":true');
        $this->assertResponseContains("You don't have the authorization to edit this message !");
    }

    /**
     * Test messageEdit method
     *
     * @return void
     */
    public function testMessageEdit()
    {
        $data = [
            '_csrfToken' => '123456789',
            'message' => 'test edit'
        ];
        $this->post(['controller' => 'conversations', 'action' => 'messageEdit', 1], $data);
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'conversations', 'action' => 'go', 1]);

        $ConvMessages = TableRegistry::get('ConversationsMessages');
        $entity = $ConvMessages->get(1);
        $this->assertSame(2, $entity->edit_count);
        $this->assertSame('test edit', $entity->message);
    }

    /**
     * Test messageEdit method
     *
     * @return void
     */
    public function testMessageEditNotExist()
    {
        $data = [
            '_csrfToken' => '123456789',
            'message' => 'test edit'
        ];
        $this->post(['controller' => 'conversations', 'action' => 'messageEdit', 2], $data);
        $this->assertResponseCode(302);
        $this->assertSession("This post doesn't exist or has been deleted !", 'Flash.flash.0.message');
    }

    /**
     * Test messageEdit method
     *
     * @return void
     */
    public function testMessageEditNotAuthorized()
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
        $data = [
            '_csrfToken' => '123456789',
            'message' => 'test edit'
        ];
        $this->post(['controller' => 'conversations', 'action' => 'messageEdit', 1], $data);
        $this->assertResponseCode(302);
        $this->assertSession("You don't have the authorization to edit this post !", 'Flash.flash.0.message');
    }
}
