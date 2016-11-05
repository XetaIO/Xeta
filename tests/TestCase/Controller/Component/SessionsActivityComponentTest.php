<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\SessionsActivityComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class SessionsActivityComponentTest extends TestCase
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
        'app.sessions'
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
        $this->SessionsActivity = new SessionsActivityComponent($this->registry);
        $this->Sessions = TableRegistry::get('Sessions');

        $data = [
            [
                'id' => 'd2k8c70sggoc4lhu8d4d3crq45',
                'user_id' => null,
                'data' => '',
                'controller' => 'forum/forum',
                'action' => 'threads',
                'params' => serialize([2, 'title-2']),
                'expires' => Time::now()->timestamp + ini_get('session.gc_maxlifetime')
            ],
            [
                'id' => 'd2k8c70sggoc4lhu8d4d3crq46',
                'user_id' => 1,
                'data' => '',
                'controller' => 'forum/forum',
                'action' => 'threads',
                'params' => serialize([2, 'title-2']),
                'expires' => Time::now()->timestamp + ini_get('session.gc_maxlifetime')
            ]
        ];
        $sessions = $this->Sessions->newEntities($data, ['accessibleFields' => ['id' => true]]);
        foreach ($sessions as $session) {
            $this->Sessions->save($session);
        }
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->SessionsActivity);
    }

    /**
     * Test getOnlineUsers method
     *
     * @return void
     */
    public function testGetOnlineUsers()
    {
        $result = $this->SessionsActivity->getOnlineUsers();
        $this->assertEquals(1, $result['guests']);
        $this->assertEquals(1, $result['members']);
        $this->assertEquals(2, $result['total']);
        $this->assertEquals(1, count($result['records']));
    }

    /**
     * Test getOnlineStatus method
     *
     * @return void
     */
    public function testGetOnlineStatus()
    {
        $users = TableRegistry::get('Users');

        $result = $this->SessionsActivity->getOnlineStatus($users->get(1));
        $this->assertTrue($result);

        $result = $this->SessionsActivity->getOnlineStatus($users->get(2));
        $this->assertFalse($result);
    }

    /**
     * Test getOnlineSessionsForUserNoUser method
     *
     * @return void
     */
    public function testGetOnlineSessionsForUserNoUser()
    {
        $result = $this->SessionsActivity->getOnlineSessionsForUser(null);
        $this->assertFalse($result);
    }

    /**
     * Test getOnlineSessionsForUser method
     *
     * @return void
     */
    public function testGetOnlineSessionsForUser()
    {
        $expected = [
            'id' => 'd2k8c70sggoc4lhu8d4d3crq46',
            'user_id' => 1,
            'data' => '',
            'controller' => 'forum/forum',
            'action' => 'threads',
            'params' => serialize([2, 'title-2'])
        ];
        $result = $this->SessionsActivity->getOnlineSessionsForUser(1);
        unset($result[0]['expires']);
        $this->assertEquals($expected, (array)$result[0]->toArray());
    }
}
