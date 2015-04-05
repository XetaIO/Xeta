<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class ForumPostsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.forum_posts',
        'app.forum_threads',
        'app.forum_categories',
        'app.badges',
        'app.badges_users',
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

        $this->ForumPosts = TableRegistry::get('ForumPosts');
        $this->Utility = new Utility;
        $this->Session = new Session();
        $this->Session->start();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ForumPosts, $this->Session);

        parent::tearDown();
    }

    /**
     * Test validationCreate method
     *
     * @return void
     */
    public function testValidationCreate()
    {
        $data = [
            'message' => ''
        ];

        $expected = [
            'message' => [
                '_empty',
            ]
        ];

        $post = $this->ForumPosts->newEntity($data, ['validate' => 'create']);
        $result = $this->ForumPosts->save($post);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($post->errors()), 'Should return errors.');

        $data = [
            'message' => '123'
        ];

        $expected = [
            'message' => [
                'purifierMinLength',
            ]
        ];

        $post = $this->ForumPosts->newEntity($data, ['validate' => 'create']);
        $result = $this->ForumPosts->save($post);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($post->errors()), 'Should return errors.');

        $data = [
            'user_id' => 1,
            'thread_id' => 1,
            'message' => '<a>My awesome link</a>'
        ];

        $expected = [
            'user_id' => 1,
            'thread_id' => 1,
            'edit_count' => 0,
            'like_count' => 0,
            'message' => '<a>My awesome link</a>'
        ];

        $post = $this->ForumPosts->newEntity($data, ['validate' => 'create']);
        $result = $this->ForumPosts->save($post);

        $this->assertInstanceOf('App\Model\Entity\ForumPost', $result);
        $post = $this->ForumPosts
            ->find()
            ->where(['id' => $result->id])
            ->select(['user_id', 'thread_id', 'message', 'edit_count', 'like_count'])
            ->first()
            ->toArray();

        $this->assertEquals($expected, $post);
    }

    /**
     * Test afterSave method
     *
     * @return void
     */
    public function testAfterSave()
    {
        $this->BadgesUsers = TableRegistry::get('BadgesUsers');

        $badge = $this->BadgesUsers->find()->where(['user_id' => 2])->first();
        $this->assertNull($badge);

        $data = [
            'user_id' => 2,
            'thread_id' => 1,
            'message' => '<a>My awesome link</a>'
        ];

        $this->assertFalse($this->Session->check('Flash.badge'));

        $post = $this->ForumPosts->newEntity($data, ['validate' => 'create']);
        $result = $this->ForumPosts->save($post);

        $this->assertInstanceOf('App\Model\Entity\ForumPost', $result);
        $this->assertTrue($this->Session->check('Flash.badge'));

        $badge = $this->BadgesUsers->find()->where(['user_id' => 2])->first()->toArray();

        $expected = [
            'id' => 2,
            'user_id' => 2,
            'badge_id' => 4
        ];

        unset($badge['created']);

        $this->assertEquals($expected, $badge);
    }
}
