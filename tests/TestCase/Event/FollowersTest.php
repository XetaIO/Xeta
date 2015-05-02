<?php
namespace App\Test\TestCase\Event;

use App\Event\Forum\Followers;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class FollowersTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.forum_threads_followers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Followers = TableRegistry::get('ForumThreadsFollowers');
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->Followers);
    }

    /**
     * newFollower method
     *
     * @return void
     */
    public function testNewFollower()
    {
        //Not integer values.
        $followers = new Followers();
        $event = new Event('Model.ForumThreadsFollowers.new', $this, [
            'user_id' => 1,
            'thread_id' => 'abc'
        ]);
        $this->assertFalse($followers->newFollower($event));

        //Already exist.
        $event = new Event('Model.ForumThreadsFollowers.new', $this, [
            'user_id' => 1,
            'thread_id' => 1
        ]);
        $this->assertTrue($followers->newFollower($event));

        $result = $this->Followers
            ->find()
            ->where(['user_id' => 1, 'thread_id' => 1])
            ->hydrate(false)
            ->count();

        $this->assertEquals(1, $result);

        $event = new Event('Model.ForumThreadsFollowers.new', $this, [
            'user_id' => 1,
            'thread_id' => 2
        ]);
        $this->assertTrue($followers->newFollower($event));

        $result = $this->Followers
            ->find()
            ->where(['user_id' => 1, 'thread_id' => 2])
            ->select(['user_id', 'thread_id'])
            ->hydrate(false)
            ->first();

        $expected = [
            'user_id' => 1,
            'thread_id' => 2
        ];
        $this->assertEquals($expected, $result);
    }
}
