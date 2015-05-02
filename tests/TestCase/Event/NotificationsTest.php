<?php
namespace App\Test\TestCase\Event;

use App\Event\Forum\Notifications;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class NotificationsTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.forum_threads_followers',
        'app.forum_threads',
        'app.forum_posts',
        'app.notifications'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Notifications = TableRegistry::get('Notifications');
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->Notifications);
    }

    /**
     * newNotificationWithTypeIncorect method
     *
     * @return void
     */
    public function testNewNotificationWithTypeIncorect()
    {
        $notifications = new Notifications();
        $event = new Event('Model.Notifications.new', $this, [
            'type' => 'abc'
        ]);
        $this->assertFalse($notifications->newNotification($event));
    }

    /**
     * newNotificationWithNoType method
     *
     * @return void
     */
    public function testNewNotificationWithNoType()
    {
        //Not integer values.
        $notifications = new Notifications();
        $event = new Event('Model.Notifications.new');
        $this->assertFalse($notifications->newNotification($event));
    }

    /**
     * newNotificationThreadReply method
     *
     * @return void
     */
    public function testNewNotificationThreadReply()
    {
        //Not integer value.
        $notifications = new Notifications();
        $event = new Event('Model.Notifications.new', $this, [
            'type' => 'thread.reply',
            'thread_id' => 'abc'
        ]);
        $this->assertFalse($notifications->newNotification($event));
    }

    /**
     * newNotificationTPostLike method
     *
     * @return void
     */
    public function testNewNotificationTPostLike()
    {
        //Not integer value.
        $notifications = new Notifications();
        $event = new Event('Model.Notifications.new', $this, [
            'type' => 'post.like',
            'post_id' => 'abc'
        ]);
        $this->assertFalse($notifications->newNotification($event));

        //Liked their posts.
        $notifications = new Notifications();
        $event = new Event('Model.Notifications.new', $this, [
            'type' => 'post.like',
            'post_id' => 1,
            'sender_id' => 1
        ]);
        $this->assertTrue($notifications->newNotification($event));

        //New notification.
        $notifications = new Notifications();
        $event = new Event('Model.Notifications.new', $this, [
            'type' => 'post.like',
            'post_id' => 2,
            'sender_id' => 1
        ]);
        $this->assertTrue($notifications->newNotification($event));

        $result = $this->Notifications
            ->find()
            ->where(['user_id' => 2, 'type' => 'post.like'])
            ->select(['user_id', 'type', 'is_read'])
            ->hydrate(false)
            ->first();

        $expected = [
            'user_id' => 2,
            'type' =>  'post.like',
            'is_read' => 0
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * newNotificationThreadLock method
     *
     * @return void
     */
    public function testNewNotificationThreadLock()
    {
        //Not integer value.
        $notifications = new Notifications();
        $event = new Event('Model.Notifications.new', $this, [
            'type' => 'thread.lock',
            'thread_id' => 'abc'
        ]);
        $this->assertFalse($notifications->newNotification($event));

        //Locked their threads.
        $notifications = new Notifications();
        $event = new Event('Model.Notifications.new', $this, [
            'type' => 'thread.lock',
            'thread_id' => 1,
            'sender_id' => 1
        ]);
        $this->assertTrue($notifications->newNotification($event));

        //New notification.
        $notifications = new Notifications();
        $event = new Event('Model.Notifications.new', $this, [
            'type' => 'thread.lock',
            'thread_id' => 2,
            'sender_id' => 1
        ]);
        $this->assertTrue($notifications->newNotification($event));

        $result = $this->Notifications
            ->find()
            ->where(['user_id' => 2, 'type' => 'thread.lock'])
            ->select(['user_id', 'type', 'is_read'])
            ->hydrate(false)
            ->first();

        $expected = [
            'user_id' => 2,
            'type' =>  'thread.lock',
            'is_read' => 0
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * newDispatchNotification method
     *
     * @return void
     */
    public function testDispatchNotification()
    {
        //Insert followers.
        $data = [
            'thread_id' => 1,
            'user_id' => 2
        ];
        $this->Followers = TableRegistry::get('ForumThreadsFollowers');
        $entity = $this->Followers->newEntity($data);
        $this->Followers->save($entity);

        $notifications = new Notifications();
        $event = new Event('Model.Notifications.dispatch', $this, [
            'type' => 'thread.reply',
            'thread_id' => 1,
            'sender_id' => 1
        ]);
        $this->assertTrue($notifications->dispatchNotification($event));

        $result = $this->Notifications
            ->find()
            ->where(['user_id' => 2, 'type' => 'thread.reply'])
            ->select(['user_id', 'type', 'is_read'])
            ->hydrate(false)
            ->first();

        $expected = [
            'user_id' => 2,
            'type' =>  'thread.reply',
            'is_read' => 0
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * newDispatchNotificationWithNoFollowers method
     *
     * @return void
     */
    public function testDispatchNotificationWithNoFollowers()
    {
        $notifications = new Notifications();
        $event = new Event('Model.Notifications.dispatch', $this, [
            'type' => 'thread.reply',
            'thread_id' => 2,
            'sender_id' => 1
        ]);
        $this->assertTrue($notifications->dispatchNotification($event));
    }
}
