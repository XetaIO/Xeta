<?php
namespace App\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use App\Model\Table\BlogAttachmentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BlogAttachmentsTable Test Case
 */
class BlogAttachmentsTableTest extends TestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = [
		'BlogAttachments' => 'app.blog_attachments', 
		'Users' => 'app.users', 
		'BlogArticles' => 'app.blog_articles', 
		'BlogCategories' => 'app.blog_categories', 
		'BlogArticlesComments' => 'app.blog_articles_comments', 
		'BlogArticlesLikes' => 'app.blog_articles_likes', 
		'BadgesUsers' => 'app.badges_users', 
		'Badges' => 'app.badges', 
		'Articles' => 'app.articles'
	];

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$config = TableRegistry::exists('BlogAttachments') ? [] : ['className' => 'App\Model\Table\BlogAttachmentsTable'];

		$this->BlogAttachments = TableRegistry::get('BlogAttachments', $config);

	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogAttachments);

		parent::tearDown();
	}

/**
 * Test initialize method
 *
 * @return void
 */
	public function testInitialize() {
		$this->markTestIncomplete('Not implemented yet.');
	}

/**
 * Test validationDefault method
 *
 * @return void
 */
	public function testValidationDefault() {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
