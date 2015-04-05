<?php
namespace App\Test\TestCase\Model\Entity;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class GroupTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.groups'];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Groups = TableRegistry::get('Groups');
    }

    /**
     * Test parendNode
     *
     * @return void
     */
    public function testParendNode()
    {
        $entity = $this->Groups->get(1);
        $result = $entity->parentNode();
        $this->assertNull($result);
    }
}
