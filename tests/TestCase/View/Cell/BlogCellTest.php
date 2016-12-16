<?php
namespace App\Test\TestCase\View\Cell;

use App\View\Cell\BlogCell;
use Cake\Network\Request;
use Cake\TestSuite\TestCase;

class BlogCellTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var void
     */
    public $fixtures = [
        'app.blog_articles',
        'app.blog_categories',
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
        $this->request = $this->getMockBuilder('Cake\Network\Request')->getMock();
        $this->response = $this->getMockBuilder('Cake\Network\Response')->getMock();
        $this->View = new \Cake\View\View($this->request, $this->response);
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->View);
    }

    /**
     * Test sidebar
     *
     * @return void
     */
    public function testSidebar()
    {
        $cell = $this->View->cell('Blog::sidebar');
        $render = "{$cell}";

        $this->assertEquals('sidebar', $cell->template);
        $this->assertContains('Categorie 1 (2)', $render);
        $this->assertContains('Third article', $render);
        $this->assertContains('October 2014 (2)', $render);
    }

    /**
     * test sidebarWithSlug
     *
     * @return void
     */
    public function testSidebarWithSlug()
    {
        $request = new Request(['params' => [
            'slug' => 'first-article',
            'controller' => 'blog',
            'action' => 'article'
        ]]);
        $this->View = new \Cake\View\View($request, $this->response);
        $cell = $this->View->cell('Blog::sidebar');
        $render = "{$cell}";

        $this->assertNotContains('Featured', $render);
    }
}
