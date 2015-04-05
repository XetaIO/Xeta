<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class GroupsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.groups'];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Groups = TableRegistry::get('Groups');
        $this->Groups->removeBehavior('Acl');
        $this->Utility = new Utility;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groups);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $data = [
            'name' => '12',
        ];

        $expected = [
            'name' => ['minLength']
        ];

        $group = $this->Groups->newEntity($data);
        $result = $this->Groups->save($group);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($group->errors()), 'Should return errors.');

        $data = [
            'name' => 'Moderateur'
        ];

        $expected = [
            'id' => 6,
            'name' => 'Moderateur',
            'css' => null,
            'is_staff' => 0,
            'is_member' => 0
        ];

        $group = $this->Groups->newEntity($data);
        $result = $this->Groups->save($group);

        $this->assertInstanceOf('App\Model\Entity\Group', $result);
        $group = $this->Groups->find()->where(['id' => $result->id])->first()->toArray();
        unset($group['created']);
        unset($group['modified']);

        $this->assertEquals($expected, $group);
    }
}
