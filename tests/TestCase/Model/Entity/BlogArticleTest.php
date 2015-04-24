<?php
namespace App\Test\TestCase\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BlogArticleTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.blog_articles'];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->BlogArticles = TableRegistry::get('BlogArticles');
        Configure::write('Blog.comment_per_page', 10);
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

        $article = $this->BlogArticles->newEntity($data);

        $this->assertEquals('<h1>Lorem</h1><p>test</p>', $article->content);
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

        $article = $this->BlogArticles->newEntity($data);

        $this->assertEquals('Lorem<p>test</p>', $article->content_empty);
    }

    /**
     * Test getContentMeta
     *
     * @return void
     */
    public function testGetContentMeta()
    {
        $data = [
            'content' => '<script>alert(\'hi\')</script> <h1>Lorem</h1> <p>test</p>'
        ];

        $article = $this->BlogArticles->newEntity($data);

        $this->assertEquals('Lorem test', $article->content_meta);
    }

    /**
     * Test getLastPage
     *
     * @return void
     */
    public function testGetLastPage()
    {
        $data = [
            'comment_count' => 51
        ];

        $article = $this->BlogArticles->newEntity($data);

        $this->assertEquals(6, $article->last_page);
    }

    /**
     * Test getCommentCountFormat
     *
     * @return void
     */
    public function testGetCommentCountFormat()
    {
        $data = [
            'comment_count' => 10000
        ];

        $article = $this->BlogArticles->newEntity($data);

        $this->assertEquals('10 000', $article->comment_count_format);
    }

    /**
     * Test getLikeCountFormat
     *
     * @return void
     */
    public function testGetLikeCountFormat()
    {
        $data = [
            'like_count' => 10000
        ];

        $article = $this->BlogArticles->newEntity($data);

        $this->assertEquals('10 000', $article->like_count_format);
    }
}
