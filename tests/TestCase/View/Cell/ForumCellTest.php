<?php
namespace App\Test\TestCase\View\Cell;

use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class ForumCellTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var void
     */
    public $fixtures = [
        'app.forum_posts',
        'app.forum_threads',
        'app.sessions',
        'app.groups',
        'app.groups_i18n',
        'app.users'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->request = new Request([
            'params' => [
                'pass' => [2, 'title-2'],
                'id' => 2,
                'slug' => 'title-2',
                'prefix' => 'forum',
                'controller' => 'forum',
                'action' => 'threads'
            ]
        ]);
        $this->response = $this->getMock('Cake\Network\Response');
        $this->View = new View($this->request, $this->response);

        $this->Sessions = TableRegistry::get('Sessions');
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->View);
    }

    /**
     * Test suggestion
     *
     * @return void
     */
    public function testSuggestion()
    {
        $data = [
            'id' => 'd2k8c70sggoc4lhu8d4d3crq45',
            'user_id' => null,
            'data' => '',
            'controller' => 'forum/forum',
            'action' => 'threads',
            'params' => serialize([2, 'title-2']),
            'expires' => Time::now()->timestamp + ini_get('session.gc_maxlifetime')
        ];
        $session = $this->Sessions->newEntity($data);
        $this->Sessions->save($session);

        $cell = $this->View->cell('Forum::suggestion');
        $render = "{$cell}";

        $this->assertEquals('suggestion', $cell->template);
        $this->assertContains('mariano', $render);
        $this->assertContains('title 1', $render);
        $this->assertContains('/forum/threads/title-1.1', $render);
        //To test if there is "1 user on this page". Can't test more due to the translation system.
        $this->assertContains(' 1 u', $render);

        $request = new Request(['params' => [
            'id' => 1,
            'slug' => 'title-1',
            'prefix' => 'forum',
            'controller' => 'forum',
            'action' => 'threads'
        ]]);
        $this->View = new View($request, $this->response);

        $cell = $this->View->cell('Forum::suggestion');
        $render = "{$cell}";

        $this->assertNotContains('panel-suggestion', $render);
    }

    /**
     * Test sidebar
     *
     * @return void
     */
    public function testSidebar()
    {
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
        $sessions = $this->Sessions->newEntities($data);
        foreach ($sessions as $session) {
            $this->Sessions->save($session);
        }

        $cell = $this->View->cell('Forum::sidebar');
        $render = "{$cell}";

        $this->assertContains('panel-staff-online', $render);
        $this->assertContains('panel-latest-threads', $render);

        $session = $this->Sessions->find()->where(['id' => 'd2k8c70sggoc4lhu8d4d3crq46'])->first();
        $this->Sessions->delete($session);

        $cell = $this->View->cell('Forum::sidebar');
        $render = "{$cell}";

        $this->assertNotContains('panel-staff-online', $render);
        $this->assertContains('panel-latest-threads', $render);
    }
}
