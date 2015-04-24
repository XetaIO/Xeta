<?php
namespace App\Test\TestCase\Model\Entity;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BlogCategoryTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.blog_categories'];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->BlogCategories = TableRegistry::get('BlogCategories');
    }

    /**
     * Test getArticleCountFormat
     *
     * @return void
     */
    public function testGetArticleCountFormat()
    {
        $data = [
            'title' => 'Categorie 3',
            'article_count' => 10000
        ];

        $category = $this->BlogCategories->newEntity($data);

        $this->assertEquals('10 000', $category->article_count_format);
    }
}
