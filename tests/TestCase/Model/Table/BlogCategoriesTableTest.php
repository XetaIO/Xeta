<?php
namespace App\Test\TestCase\Model\Table;

use App\Test\Lib\Utility;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BlogCategoriesTableTest extends TestCase
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
            'title' => 'ab',
            'description' => $this->Utility->generateRandomString(260),
        ];

        $expected = [
            'title' => [
                'minLength'
            ],
            'description' => [
                'maxLength'
            ]
        ];

        $category = $this->BlogCategories->newEntity($data);
        $result = $this->BlogCategories->save($category);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($category->errors()), 'Should return errors.');

        $data = [
            'title' => 'Categorie 2',
            'description' => 'test'
        ];

        $expected = [
            'title' => [
                'unique'
            ]
        ];

        $category = $this->BlogCategories->newEntity($data);
        $result = $this->BlogCategories->save($category);

        $this->assertFalse($result);
        $this->assertEquals($expected, $this->Utility->getL2Keys($category->errors()), 'Should return errors.');

        $data = [
            'title' => 'Categorie 4',
            'description' => 'Lorem ipsum dolor sit amet.'
        ];

        $category = $this->BlogCategories->newEntity($data);
        $result = $this->BlogCategories->save($category);

        $this->assertInstanceOf('App\Model\Entity\BlogCategory', $result);
        $this->assertEmpty($category->errors());
    }
}
