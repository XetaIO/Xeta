<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BlogArticlesCommentsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.blog_articles_comments',
        'app.blog_articles',
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
        $this->BlogArticlesComments = TableRegistry::get('BlogArticlesComments');
        $this->Utility = new Utility;
    }

    /**
     * Test validationCreate
     *
     * @return void
     */
    public function testValidationCreate()
    {
        $data = [
            'content' => 'fail'
        ];

        $expected = [
            'content' => [
                'minLength'
            ]
        ];

        $comment = $this->BlogArticlesComments->newEntity($data, ['validate' => 'create']);
        $result = $this->BlogArticlesComments->save($comment);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($comment->errors()), 'Should return errors.');

        $data = [
            'content' => 'not fail'
        ];

        $comment = $this->BlogArticlesComments->newEntity($data, ['validate' => 'create']);
        $result = $this->BlogArticlesComments->save($comment);

        $this->assertInstanceOf('App\Model\Entity\BlogArticlesComment', $result);
        $this->assertEmpty($comment->errors());
    }
}
