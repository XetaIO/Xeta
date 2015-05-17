<?php
namespace App\Test\TestCase\Controller\Component\Forum;

use App\Controller\Component\Forum\AntiSpamComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class AntiSpamComponentTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.badges',
        'app.badges_users',
        'app.groups',
        'app.forum_posts',
        'app.forum_threads',
        'app.notifications'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->registry = new ComponentRegistry(new Controller(new Request(), new Response()));
        $this->registry->getController()->request->session()->write(['Auth' => ['User' => ['id' => 1, 'group_id' => 1]]]);
        $this->AntiSpam = new AntiSpamComponent($this->registry);

        $this->Posts = TableRegistry::get('ForumPosts');
        $this->Threads = TableRegistry::get('ForumThreads');
    }

    /**
     * Test check
     * @return void
     */
    public function testCheck()
    {
        $user = [
            'id' => 1,
            'group_id' => 1
        ];
        $result = $this->AntiSpam->check('ForumPosts', $user);
        $this->assertTrue($result);

        $post = [
            'thread_id' => 1,
            'user_id' => 1,
            'message' => 'Hi 123'
        ];
        $this->Posts->save($this->Posts->newEntity($post));

        $result = $this->AntiSpam->check('ForumPosts', $user);
        $this->assertTrue($result);

        $user = [
            'id' => 1,
            'group_id' => 2
        ];
        $result = $this->AntiSpam->check('ForumPosts', $user);
        $this->assertFalse($result);

        $user = [
            'id' => 2,
            'group_id' => 2
        ];
        $result = $this->AntiSpam->check('ForumPosts', $user);
        $this->assertTrue($result);

        $result = $this->AntiSpam->check('ForumPosts');
        $this->assertTrue($result);

        $this->setExpectedException('Exception');
        $this->AntiSpam->check('ForumFail');
    }
}
