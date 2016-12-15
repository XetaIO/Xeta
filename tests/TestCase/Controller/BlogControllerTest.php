<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

class BlogControllerTest extends IntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.settings',
        'app.users',
        'app.groups',
        'app.groups_i18n',
        'app.aros',
        'app.acos',
        'app.aros_acos',
        'app.sessions',
        'app.blog_categories',
        'app.blog_categories_i18n',
        'app.blog_articles',
        'app.blog_articles_i18n',
        'app.blog_articles_comments',
        'app.blog_articles_likes',
        'app.polls',
        'app.polls_answers',
        'app.notifications',
        'app.polls_users'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 5,
                ]
            ]
        ]);

        $this->_cookie = [
            'csrfToken' => '123456789'
        ];
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(['controller' => 'blog', 'action' => 'index']);
        $this->assertResponseOk();
        $this->assertResponseContains('First article');
        $this->assertResponseNotContains('Second article');
    }

    /**
     * Test category method
     *
     * @return void
     */
    public function testCategory()
    {
        $this->get(['controller' => 'blog', 'action' => 'category', 'slug' => 'title', 'id' => 1]);
        $this->assertResponseOk();
        $this->assertResponseContains('First article');
        $this->assertResponseNotContains('Second article');
    }

    /**
     * Test category method
     *
     * @return void
     */
    public function testCategoryNoArticle()
    {
        $this->get(['controller' => 'blog', 'action' => 'category', 'slug' => 'title', 'id' => 2]);
        $this->assertResponseOk();
        $this->assertResponseContains('No articles found');
    }

    /**
     * Test category method
     *
     * @return void
     */
    public function testCategoryNotFound()
    {
        $this->get(['controller' => 'blog', 'action' => 'category', 'slug' => 'title', 'id' => 3]);
        $this->assertSession('This category doesn\'t exist or has been deleted.', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }
}
