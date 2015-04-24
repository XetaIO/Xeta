<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BlogArticlesLikesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.blog_articles',
        'app.blog_articles_likes',
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
        $this->BlogArticlesLikes = TableRegistry::get('BlogArticlesLikes');
        $this->Utility = new Utility;
    }

    /**
     * Test validationDefault
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $data = [
            'article_id' => 'abc',
            'user_id' => 'def',
        ];

        $expected = [
            'article_id' => [
                'numeric'
            ],
            'user_id' => [
                'numeric'
            ]
        ];

        $like = $this->BlogArticlesLikes->newEntity($data);
        $result = $this->BlogArticlesLikes->save($like);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($like->errors()), 'Should return errors.');

        $data = [
            'article_id' => 1,
            'user_id' => 1,
        ];

        $like = $this->BlogArticlesLikes->newEntity($data);
        $result = $this->BlogArticlesLikes->save($like);

        $this->assertInstanceOf('App\Model\Entity\BlogArticlesLike', $result);
        $this->assertEmpty($like->errors());
    }
}
