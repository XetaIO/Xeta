<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class ForumThreadsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.forum_threads',
        'app.forum_categories'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->ForumThreads = TableRegistry::get('ForumThreads');
        $this->Utility = new Utility;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ForumThreads);

        parent::tearDown();
    }

    /**
     * Test validationCreate
     *
     * @return void
     */
    public function testValidationCreate()
    {
        $data = [
            'title' => '',
            'message' => ''
        ];

        $expected = [
            'title' => [
                '_empty'
            ],
            'message' => [
                '_empty',
            ]
        ];

        $thread = $this->ForumThreads->newEntity($data, ['validate' => 'create']);
        $result = $this->ForumThreads->save($thread);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($thread->errors()), 'Should return errors.');

        $data = [
            'title' => '123',
            'message' => '123'
        ];

        $expected = [
            'title' => [
                'lengthBetween'
            ],
            'message' => [
                'purifierMinLength',
            ]
        ];

        $thread = $this->ForumThreads->newEntity($data, ['validate' => 'create']);
        $result = $this->ForumThreads->save($thread);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($thread->errors()), 'Should return errors.');

        $data = [
            'title' => 'My title',
            'user_id' => 1,
            'category_id' => 1,
            'message' => '<a>My awesome link</a>'
        ];

        $expected = [
            'title' => 'My title',
            'user_id' => 1,
            'category_id' => 1,
            'thread_open' => 1,
            'sticky' => 0
        ];

        $thread = $this->ForumThreads->newEntity($data, ['validate' => 'create']);
        $result = $this->ForumThreads->save($thread);

        $this->assertInstanceOf('App\Model\Entity\ForumThread', $result);
        $thread = $this->ForumThreads
            ->find()
            ->where(['id' => $result->id])
            ->select(['title', 'user_id', 'category_id', 'thread_open', 'sticky'])
            ->first()
            ->toArray();

        $this->assertEquals($expected, $thread);
    }
}
