<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class PagesControllerTest extends IntegrationTestCase
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
        'app.blog_articles',
        'app.blog_articles_i18n',
        'app.blog_articles_likes',
        'app.blog_articles_comments',
        'app.blog_categories'
    ];

    /**
     * Test home method
     *
     * @return void
     */
    public function testHome()
    {
        $this->get(['controller' => 'pages', 'action' => 'home']);

        $this->assertResponseOk();
        //We can't test messages due to the translation system.
        $this->assertResponseContains('First article');
        $this->assertResponseNotContains('Second article');
    }

    /**
     * Test acceptCookie method
     *
     * @return void
     */
    public function testAcceptCookie()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->get(['controller' => 'pages', 'action' => 'acceptCookie']);

        $this->assertResponseOk();
        $this->assertResponseNotEmpty();
        $this->assertTrue(isset($this->_response->cookie()['allowCookies']));
    }

    /**
     * Test acceptCookie method not in AJAX.
     *
     * @return void
     */
    public function testAcceptCookieNotInAjax()
    {
        $this->get(['controller' => 'pages', 'action' => 'acceptCookie']);

        $this->assertResponseError();
    }

    /**
     * Test lang method
     *
     * @return void
     */
    public function lang()
    {
        Configure::write('App.fullBaseUrl', 'http://localhost');
        $this->configRequest([
            'headers' => [
                'Referer' => 'http://localhost/blog/view'
            ]
        ]);

        $this->get(['controller' => 'pages', 'action' => 'lang']);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'blog', 'action' => 'view']);
    }
}
