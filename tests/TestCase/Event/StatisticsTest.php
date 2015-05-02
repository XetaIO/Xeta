<?php
namespace App\Test\TestCase\Event;

use App\Event\Forum\Statistics;
use Cake\Event\Event;
use Cake\TestSuite\TestCase;

class StatisticsTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.forum_posts_likes',
        'app.forum_posts',
        'app.forum_threads'
    ];

    /**
     * newPostsLikeStats method
     *
     * @return void
     */
    public function testNewPostsLikeStats()
    {
        $statistics = new Statistics();
        $event = new Event('Model.ForumPostsLikes.update');
        $this->assertEquals(2, (int)$statistics->newPostsLikeStats($event));
    }

    /**
     * newPostStats method
     *
     * @return void
     */
    public function testNewPostStats()
    {
        $statistics = new Statistics();
        $event = new Event('Model.ForumPosts.new');
        $this->assertEquals(2, (int)$statistics->newPostStats($event));
    }

    /**
     * newThreadStats method
     *
     * @return void
     */
    public function testNewThreadStats()
    {
        $statistics = new Statistics();
        $event = new Event('Model.ForumThreads.new');
        $this->assertEquals(2, (int)$statistics->newThreadStats($event));
    }

    /**
     * newUserStats method
     *
     * @return void
     */
    public function testNewUserStats()
    {
        $statistics = new Statistics();
        $event = new Event('Model.Users.register');
        $result = $statistics->newUserStats($event);
        $this->assertEquals(2, (int)$result['TotalUsers']);
        $this->assertEquals('larry', $result['LastRegistered']->username);
    }
}
