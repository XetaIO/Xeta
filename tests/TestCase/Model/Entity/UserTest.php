<?php
namespace App\Test\TestCase\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class UserTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.users'];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Users = TableRegistry::get('Users');
    }

    /**
     * Test setPassword
     *
     * @return void
     */
    public function testSetPassword()
    {
        $data = [
            'password' => '12345678'
        ];

        $user = $this->Users->newEntity($data);

        $this->assertTrue((new DefaultPasswordHasher)->check($data['password'], $user->password));
    }

    /**
     * Test getFullName
     *
     * @return void
     */
    public function testGetFullName()
    {
        $data = [
            'first_name' => 'Edward',
            'last_name' => 'Snowden',
            'username' => 'edward'
        ];

        $user = $this->Users->newEntity($data);

        $this->assertEquals('Edward Snowden', $user->full_name, 'Should return the full name.');

        $data = [
            'username' => 'edward'
        ];

        $user = $this->Users->newEntity($data);

        $this->assertEquals('edward', $user->full_name, 'Should return the username');
    }

    /**
     * Test getBiography
     *
     * @return void
     */
    public function testGetBiography()
    {
        $data = [
            'biography' => '<script>alert(\'hi\')</script> <h1>Lorem</h1> <p>test</p>'
        ];

        $user = $this->Users->newEntity($data);

        $this->assertEquals('<h1>Lorem</h1> <p>test</p>', $user->biography);
    }

    /**
     * Test getSignature
     *
     * @return void
     */
    public function testGetSignature()
    {
        $data = [
            'signature' => '<script>alert(\'hi\')</script> <h1>Lorem</h1> <p>test</p>'
        ];

        $user = $this->Users->newEntity($data);

        $this->assertEquals('Lorem <p>test</p>', $user->signature);
    }

    /**
     * Test parendNode
     *
     * @return void
     */
    public function testParendNode()
    {
        $entity = $this->Users->get(1);
        unset($entity->id);
        $result = $entity->parentNode();
        $this->assertNull($result);

        $entity = $this->Users->get(1);
        $result = $entity->parentNode();
        $expected = [
            'Groups' => [
                'id' => 5
            ]
        ];
        $this->assertEquals($expected, $result);

        $entity = $this->Users->get(1);
        unset($entity->group_id);
        $result = $entity->parentNode();
        $expected = [
            'Groups' => [
                'id' => 5
            ]
        ];
        $this->assertEquals($expected, $result);

        $entity = $this->Users->get(1);
        $entity->group_id = false;
        $result = $entity->parentNode();
        $this->assertNull($result);
    }
}
