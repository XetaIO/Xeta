<?php
namespace App\Test\TestCase\Controller\Forum;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class ThreadsControllerTest extends IntegrationTestCase
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
        'app.forum_posts'
    ];

    /**
     * Test edit method
     *
     * @return void
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

        $data = [
            'title' => 'title 1 modified',
            'category_id' => '2',
            'sticky' => '1',
            'thread_open' => '0'
        ];
        $this->put(['_name' => 'threads-edit', 'slug' => 'my slug', 'id' => 1, 'prefix' => 'forum'], $data);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertRedirect(['_name' => 'forum-threads', 'slug' => 'title 1 modified', 'id' => 1, 'prefix' => 'forum']);
    }

    /**
     * Test reply method
     *
     * @return void
     */
    public function testReply()
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
        //Test simple reply
        $data = [
            'message' => 'My awesome message.'
        ];
        $this->post(['_name' => 'threads-reply', 'slug' => 'my slug', 'id' => 1, 'prefix' => 'forum'], $data);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertRedirect(['controller' => 'posts', 'action' => 'go', 'prefix' => 'forum', 3]);

        $threads = TableRegistry::get('ForumThreads');
        $thread = $threads->get(1);
        $this->assertEquals(3, $thread->last_post_id);
        $this->assertEquals(2, $thread->reply_count);
        $this->assertEquals(1, $thread->last_post_user_id);
        $this->assertEquals(Time::now()->format('d/m/Y'), $thread->last_post_date->format('d/m/Y'));

        //Test reply with closing thread
        $data = [
            'message' => 'My awesome message.',
            'forum_thread' => [
                'thread_open' => '0'
            ]
        ];
        $this->post(['_name' => 'threads-reply', 'slug' => 'my slug', 'id' => 1, 'prefix' => 'forum'], $data);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertRedirect(['controller' => 'posts', 'action' => 'go', 'prefix' => 'forum', 4]);

        //Test reply with spamming
        $groups = TableRegistry::get('Groups');
        $group = $groups->get(5);
        $group->is_staff = 0;
        $groups->save($group);
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
        $data = [
            'message' => 'My awesome message.'
        ];
        $this->post(['_name' => 'threads-reply', 'slug' => 'my slug', 'id' => 1, 'prefix' => 'forum'], $data);
        $this->assertResponseSuccess();
        $this->post(['_name' => 'threads-reply', 'slug' => 'my slug', 'id' => 1, 'prefix' => 'forum'], $data);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home', 'prefix' => false]);
    }

    /**
     * Test lock method
     *
     * @return void
     */
    public function testLock()
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
        //Test non-existent
        $this->get(['_name' => 'threads-lock', 'slug' => 'my slug', 'id' => 3, 'prefix' => 'forum']);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home', 'prefix' => false]);

        //Test already locked
        $this->get(['_name' => 'threads-lock', 'slug' => 'my slug', 'id' => 2, 'prefix' => 'forum']);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertRedirect(['_name' => 'forum-threads', 'slug' => 'title-2', 'id' => 2]);

        //Test lock
        $this->get(['_name' => 'threads-lock', 'slug' => 'my slug', 'id' => 1, 'prefix' => 'forum']);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertRedirect(['_name' => 'forum-threads', 'slug' => 'title-1', 'id' => 1]);
    }

    /**
     * Test unlock method
     *
     * @return void
     */
    public function testUnlock()
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
        //Test non-existent
        $this->get(['_name' => 'threads-unlock', 'slug' => 'my slug', 'id' => 3, 'prefix' => 'forum']);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home', 'prefix' => false]);

        //Test already unlocked
        $this->get(['_name' => 'threads-unlock', 'slug' => 'my slug', 'id' => 1, 'prefix' => 'forum']);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertRedirect(['_name' => 'forum-threads', 'slug' => 'title-1', 'id' => 1]);

        //Test unlock
        $this->get(['_name' => 'threads-unlock', 'slug' => 'my slug', 'id' => 2, 'prefix' => 'forum']);
        $this->assertResponseSuccess();
        $this->assertSession('flash', 'Flash.flash.key');
        $this->assertRedirect(['_name' => 'forum-threads', 'slug' => 'title-2', 'id' => 2]);
    }
}
