<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

class GroupsControllerTest extends IntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.aros',
        'app.acos',
        'app.aros_acos',
        'app.groups',
        'app.groups_i18n',
        'app.notifications',
        'app.settings',
        'app.sessions',
        'app.users',
    ];

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get(['controller' => 'groups', 'action' => 'view', 'slug' => 'admin', 'id' => 5]);
        $this->assertResponseOk();
        $this->assertResponseContains('Maria Riano');
    }
}
