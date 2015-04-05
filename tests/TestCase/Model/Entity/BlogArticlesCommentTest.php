<?php
namespace App\Test\TestCase\Model\Entity;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BlogArticlesCommentTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.blog_articles_comments'];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->BlogArticlesComments = TableRegistry::get('BlogArticlesComments');
    }

    /**
     * Test getContent
     *
     * @return void
     */
    public function testGetContent()
    {
        $data = [
            'content' => '<script>alert(\'hi\')</script> <h1>Lorem</h1><p>test</p>'
        ];

        $comment = $this->BlogArticlesComments->newEntity($data);

        $this->assertEquals('<h1>Lorem</h1><p>test</p>', $comment->content);
    }

    /**
     * Test getContentEmpty
     *
     * @return void
     */
    public function testGetContentEmpty()
    {
        $data = [
            'content' => '<script>alert(\'hi\')</script> <h1>Lorem</h1><p>test</p>'
        ];

        $comment = $this->BlogArticlesComments->newEntity($data);

        $this->assertEquals('Lorem<p>test</p>', $comment->content_empty);
    }
}
