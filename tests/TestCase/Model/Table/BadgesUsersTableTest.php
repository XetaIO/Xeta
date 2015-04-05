<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BadgesUsersTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.badges_users'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->BadgesUsers = TableRegistry::get('BadgesUsers');
        $this->Utility = new Utility;
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $data = [
            'badge_id' => 'abc',
            'user_id' => 'def',
        ];

        $expected = [
            'badge_id' => [
                'numeric'
            ],
            'user_id' => [
                'numeric'
            ]
        ];

        $badge = $this->BadgesUsers->newEntity($data);
        $result = $this->BadgesUsers->save($badge);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($badge->errors()), 'Should return errors.');

        $data = [
            'badge_id' => 2,
            'user_id' => 1,
        ];

        $badge = $this->BadgesUsers->newEntity($data);
        $result = $this->BadgesUsers->save($badge);

        $this->assertInstanceOf('App\Model\Entity\BadgesUser', $result);
        $this->assertEmpty($badge->errors());
    }
}
