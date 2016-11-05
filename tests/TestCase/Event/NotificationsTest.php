<?php
namespace App\Test\TestCase\Event;

use App\Event\Notifications;
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
        'app.notifications',
        'app.conversations',
        'app.conversations_messages',
        'app.conversations_users'
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
     * dispatchParticipants method
     *
     * @return void
     */
    public function testDispatchParticipants()
    {
        //Insert participants.
        $data = [
            'conversation_id' => 1,
            'user_id' => 2
        ];
        $this->ConversationsUsers = TableRegistry::get('ConversationsUsers');
        $entity = $this->ConversationsUsers->newEntity($data);
        $this->ConversationsUsers->save($entity);

        $notifications = new Notifications();
        $event = new Event('Model.Notifications.dispatchParticipants', $this, [
            'type' => 'conversation.reply',
            'conversation_id' => 1,
            'sender_id' => 1
        ]);
        $this->assertTrue($notifications->dispatchParticipants($event));

        //Test for the anti-spam notification.
        $result = $this->Notifications
            ->find()
            ->where(['user_id' => 2, 'type' => 'conversation.reply'])
            ->select(['id', 'user_id', 'type', 'is_read'])
            ->count();
        $this->assertEquals(1, $result);
        $this->assertTrue($notifications->dispatchParticipants($event));
        $this->assertEquals(1, $result, 'Should still has one notification.');

        $result = $this->Notifications
            ->find()
            ->where(['user_id' => 2, 'type' => 'conversation.reply'])
            ->select(['id', 'user_id', 'type', 'is_read'])
            ->hydrate(false)
            ->first();

        $expected = [
            'id' => 1,
            'user_id' => 2,
            'type' => 'conversation.reply',
            'is_read' => 0
        ];
        $this->assertEquals($expected, $result);
    }
}
