<?php
namespace App\Test\TestCase\Controller\Forum;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class PostsControllerTest extends IntegrationTestCase
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
        'app.forum_threads',
        'app.forum_categories',
        'app.forum_posts',
        'app.forum_posts_likes',
        'app.notifications'
    ];

    /**
     * Test unlike method.
     */
    public function testUnlike()
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
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->post(['controller' => 'posts', 'action' => 'unlike', 'prefix' => 'forum'], ['id' => 1]);
        $this->assertResponseOk();
        $this->assertResponseNotEmpty();
        $response = json_decode($this->_response->body(), JSON_PRETTY_PRINT);
        $this->assertFalse($response['error']);
        $this->assertEquals('/forum/posts/like', $response['url']);
        $this->assertTrue(isset($response['title']));

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->post(['controller' => 'posts', 'action' => 'unlike', 'prefix' => 'forum'], ['id' => 2]);
        $this->assertResponseOk();
        $this->assertResponseNotEmpty();
        $response = json_decode($this->_response->body(), JSON_PRETTY_PRINT);
        $this->assertTrue($response['error']);
        $this->assertTrue(isset($response['message']));
    }

    /**
     * Test like method
     */
    public function testLike()
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
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->post(['controller' => 'posts', 'action' => 'like', 'prefix' => 'forum'], ['id' => 2]);
        $this->assertResponseOk();
        $this->assertResponseNotEmpty();
        $response = json_decode($this->_response->body(), JSON_PRETTY_PRINT);
        $this->assertFalse($response['error']);
        $this->assertEquals('/forum/posts/unlike', $response['url']);
        $this->assertTrue(isset($response['title']));
        $this->assertTrue(isset($response['message']));

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->post(['controller' => 'posts', 'action' => 'like', 'prefix' => 'forum'], ['id' => 1]);
        $this->assertResponseOk();
        $this->assertResponseNotEmpty();
        $response = json_decode($this->_response->body(), JSON_PRETTY_PRINT);
        $this->assertTrue($response['error']);
        $this->assertTrue(isset($response['message']));
    }

    /**
     * Test delete method
     *
     * Need to be fixed. (Related to the URL post 'threads-reply')
     */
    /*public function testDelete()
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
        //Simple delete
        $this->post(['_name' => 'threads-reply', 'slug' => 'my slug', 'id' => 1, 'prefix' => 'forum'], ['message' => 'My awesome message.']);
        $this->get(['_name' => 'posts-delete', 'prefix' => 'forum', 'id' => 3]);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertSession('Flash/success', 'Flash.flash.element');
        $this->assertRedirect(['controller' => 'posts', 'action' => 'go', 'prefix' => 'forum', 1]);
    }*/

    /**
     * Test quote method
     */
    public function testQuote()
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
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->post(['_name' => 'posts-quote', 'prefix' => 'forum', 'id' => 1], ['id' => 1]);
        $this->assertResponseOk();
        $this->assertResponseNotEmpty();
        $response = json_decode($this->_response->body(), JSON_PRETTY_PRINT);
        $this->assertFalse($response['error']);
        $this->assertContains('<blockquote>', $response['post']);
    }

    /**
     * Test method go
     */
    public function testGo()
    {
        $this->get(['controller' => 'posts', 'action' => 'go', 'prefix' => 'forum', 1]);
        $this->assertResponseSuccess();
        $this->assertRedirect([
            '_name' => 'forum-threads',
            'slug' => 'title 1',
            'id' => 1,
            'prefix' => 'forum',
            '?' => ['page' => 1],
            '#' => 'post-' . '1'
        ]);

        $this->get(['controller' => 'posts', 'action' => 'go', 'prefix' => 'forum', 3]);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertSession('Flash/error', 'Flash.flash.element');
        $this->assertRedirect(['controller' => 'forum', 'action' => 'index', 'prefix' => 'forum']);
    }

    /**
     * Test edit method
     */
    public function testEdit()
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
        $this->post(['_name' => 'posts-edit', 'prefix' => 'forum', 'id' => 1], ['message' => '<i>This is my awesome message</i>']);
        $this->assertResponseSuccess();
        $this->assertSession('Flash/success', 'Flash.flash.element');
        $this->assertRedirect(['controller' => 'posts', 'action' => 'go', 'prefix' => 'forum', 1]);

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 1,
                ]
            ]
        ]);
        $this->post(['_name' => 'posts-edit', 'prefix' => 'forum', 'id' => 1], ['message' => '<i>This is my awesome message</i>']);
        $this->assertResponseSuccess();
        $this->assertSession('Flash/error', 'Flash.flash.element');
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home', 'prefix' => false]);
    }
}
