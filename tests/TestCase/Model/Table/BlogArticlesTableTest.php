<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BlogArticlesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
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
        $this->BlogArticles = TableRegistry::get('BlogArticles');
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
            'category_id' => 'abc',
            'title' => 'fail',
            'content' => 'fail',
            'is_display' => 'fail'
        ];

        $expected = [
            'category_id' => [
                'numeric'
            ],
            'title' => [
                'minLength'
            ],
            'content' => [
                'minLength'
            ],
            'is_display' => [
                'inList'
            ]
        ];

        $article = $this->BlogArticles->newEntity($data);
        $result = $this->BlogArticles->save($article);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($article->errors()), 'Should return errors.');

        $data = [
            'category_id' => 1,
            'title' => 'First article',
            'content' => $this->Utility->generateRandomString(20),
            'is_display' => 1
        ];

        $expected = [
            'title' => [
                'unique'
            ]
        ];

        $article = $this->BlogArticles->newEntity($data);
        $result = $this->BlogArticles->save($article, ['validate' => 'default']);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($article->errors()), 'Should return errors.');

        $data = [
            'category_id' => 1,
            'title' => 'Test article',
            'content' => $this->Utility->generateRandomString(20),
            'is_display' => 1
        ];

        $article = $this->BlogArticles->newEntity($data);
        $result = $this->BlogArticles->save($article);

        $this->assertInstanceOf('App\Model\Entity\BlogArticle', $result);
        $this->assertEmpty($article->errors());
    }
}
