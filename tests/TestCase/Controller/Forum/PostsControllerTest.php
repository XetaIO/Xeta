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
        'app.forum_posts_likes'
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
}
