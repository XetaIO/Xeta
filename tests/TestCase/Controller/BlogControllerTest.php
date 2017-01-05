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
        'app.aros',
        'app.acos',
        'app.aros_acos',
        'app.badges',
        'app.badges_i18n',
        'app.badges_users',
        'app.blog_categories',
        'app.blog_categories_i18n',
        'app.blog_articles',
        'app.blog_articles_i18n',
        'app.blog_articles_comments',
        'app.blog_articles_likes',
        'app.blog_attachments',
        'app.groups',
        'app.groups_i18n',
        'app.polls',
        'app.polls_answers',
        'app.notifications',
        'app.polls_users',
        'app.settings',
        'app.sessions',
        'app.users',
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
        $this->get(['controller' => 'blog', 'action' => 'category', 'slug' => 'title', 'id' => 4]);
        $this->assertSession('This category doesn\'t exist or has been deleted.', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }

    /**
     * Test article method
     *
     * @return void
     */
    public function testArticleWithPollAndAttachementAndRelatedArticle()
    {
        $this->get(['controller' => 'blog', 'action' => 'article', 'slug' => 'title', 'id' => 1]);
        $this->assertResponseOk();
        $this->assertResponseContains('First article', 'Must cointain article');
        $this->assertResponseContains('Is my website the best website ?', 'Must cointain poll');
        $this->assertResponseContains('Attachment.zip', 'Must cointain attachement');
        $this->assertResponseContains('Third article', 'Must cointain related articles');
    }

    /**
     * Test article method
     *
     * @return void
     */
    public function testArticleNotFound()
    {
        $this->get(['controller' => 'blog', 'action' => 'article', 'slug' => 'title', 'id' => 1337]);
        $this->assertSession('This article doesn\'t exist or has been deleted.', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }

    /**
     * Test article method
     *
     * @return void
     */
    public function testArticleWithComment()
    {
        $data = [
            '_csrfToken' => '123456789',
            'comment' => 'This is my awesome comment.'
        ];
        $this->post(['controller' => 'blog', 'action' => 'article', 'slug' => 'title', 'id' => 1], $data);
        $this->assertSession('Your comment has been posted successfully !', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'go', 3]);
    }

    /**
     * Test article method
     *
     * @return void
     */
    public function testArticleWithCommentNotConnected()
    {
        $this->session([
            'Auth' => []
        ]);
        $data = [
            '_csrfToken' => '123456789',
            'comment' => 'This is my awesome comment.'
        ];
        $this->post(['controller' => 'blog', 'action' => 'article', 'slug' => 'title', 'id' => 1], $data);
        $this->assertSession('You must be connected to post a comment.', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'article', 'slug' => 'first-article', 'id' => 1]);
    }

    /**
     * Test quote method
     *
     * @return void
     */
    public function testQuote()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->get(['controller' => 'blog', 'action' => 'quote', 1, 1]);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('Maria Riano has said');
    }

    /**
     * Test quote method
     *
     * @return void
     */
    public function testQuoteNotAjax()
    {
        $this->get(['controller' => 'blog', 'action' => 'quote', 1, 1]);
        $this->assertResponseError();
    }

    /**
     * Test quote method
     *
     * @return void
     */
    public function testQuoteNotFound()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->get(['controller' => 'blog', 'action' => 'quote', 1, 1337]);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('This comment doesn\u0027t exist.');
    }

    /**
     * Test go method
     *
     * @return void
     */
    public function testGo()
    {
        $this->get(['controller' => 'blog', 'action' => 'go', 1]);
        $this->assertResponseCode(302);
        $this->assertRedirect([
            'controller' => 'blog',
            'action' => 'article',
            'slug' => 'first-article',
            'id' => 1,
            '?' => ['page' => 1],
            '#' => 'comment-' . '1'
        ]);
    }

    /**
     * Test go method
     *
     * @return void
     */
    public function testGoCommentNotFound()
    {
        $this->get(['controller' => 'blog', 'action' => 'go', 1337]);
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }

    /**
     * Test archive method
     *
     * @return void
     */
    public function testArchive()
    {
        $this->get(['controller' => 'blog', 'action' => 'archive', '10-2014']);
        $this->assertResponseOk();
        $this->assertResponseContains('First article');
        $this->assertResponseContains('Third article');
    }

    /**
     * Test archive method
     *
     * @return void
     */
    public function testArchiveNoArticle()
    {
        $this->get(['controller' => 'blog', 'action' => 'archive', '11-2014']);
        $this->assertResponseOk();
        $this->assertResponseContains('No articles found');
    }

    /**
     * Test search method
     *
     * @return void
     */
    public function testSearchWithoutParams()
    {
        $this->get(['controller' => 'blog', 'action' => 'search']);
        $this->assertResponseOk();
        $this->assertResponseContains('First article');
        $this->assertResponseContains('Third article');
    }

    /**
     * Test search method
     *
     * @return void
     */
    public function testSearchWithParams()
    {
        $data = [
            '_csrfToken' => '123456789',
            'search' => 'First'
        ];
        $this->post(['controller' => 'blog', 'action' => 'search'], $data);
        $this->assertResponseOk();
        $this->assertResponseContains('First article');
    }

    /**
     * Test search method
     *
     * @return void
     */
    public function testSearchNoArticles()
    {
        $data = [
            '_csrfToken' => '123456789',
            'search' => 'No article'
        ];
        $this->post(['controller' => 'blog', 'action' => 'search'], $data);
        $this->assertResponseOk();
        $this->assertResponseContains('No results found');
    }

    /**
     * Test articleLike method
     *
     * @return void
     */
    public function testArticleLike()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 2,
                ]
            ]
        ]);

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->get(['controller' => 'blog', 'action' => 'articleLike', 1]);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('Thanks for');
        $this->assertResponseContains('"error": false');
    }

    /**
     * Test articleLike method
     *
     * @return void
     */
    public function testArticleLikeNotAjax()
    {
        $this->get(['controller' => 'blog', 'action' => 'articleLike', 1]);
        $this->assertResponseError();
    }

    /**
     * Test articleLike method
     *
     * @return void
     */
    public function testArticleLikeAlreadyLiked()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->get(['controller' => 'blog', 'action' => 'articleLike', 1]);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('You already like this article !');
        $this->assertResponseContains('"error": true');
    }

    /**
     * Test articleLike method
     *
     * @return void
     */
    public function testArticleLikeNotFound()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->get(['controller' => 'blog', 'action' => 'articleLike', 1337]);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('This article doesn\u0027t exist !');
        $this->assertResponseContains('"error": true');
    }

    /**
     * Test articleUnlike method
     *
     * @return void
     */
    public function testArticleUnlike()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->get(['controller' => 'blog', 'action' => 'articleUnlike', 1]);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('"error": false');
    }

    /**
     * Test articleUnlike method
     *
     * @return void
     */
    public function testArticleUnlikeNotAjax()
    {
        $this->get(['controller' => 'blog', 'action' => 'articleUnlike', 1]);
        $this->assertResponseError();
    }

    /**
     * Test articleUnlike method
     *
     * @return void
     */
    public function testArticleUnlikeNotFound()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $this->get(['controller' => 'blog', 'action' => 'articleUnlike', 1337]);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('You don\u0027t like this article !');
        $this->assertResponseContains('"error": true');
    }

    /**
     * Test deleteComment method
     *
     * @return void
     */
    public function testDeleteComment()
    {
        $this->get(['controller' => 'blog', 'action' => 'deleteComment', 1]);
        $this->assertSession('This comment has been deleted successfully !', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'article', 'slug' => 'first-article', 'id' => 1, '?' => ['page' => 1]]);
    }

    /**
     * Test deleteComment method
     *
     * @return void
     */
    public function testDeleteCommentNotFound()
    {
        $this->configRequest([
            'headers' => [
                'Referer' => '/blog'
            ]
        ]);
        $this->get(['controller' => 'blog', 'action' => 'deleteComment', 1337]);
        $this->assertSession('This comment doesn\'t exist or has been deleted !', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }

    /**
     * Test deleteComment method
     *
     * @return void
     */
    public function testDeleteCommentWithoutAuthorization()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 2,
                ]
            ]
        ]);
        $this->configRequest([
            'headers' => [
                'Referer' => '/blog'
            ]
        ]);
        $this->get(['controller' => 'blog', 'action' => 'deleteComment', 1]);
        $this->assertSession('You don\'t have the authorization to delete this comment !', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }

    /**
     * Test getEditComment method
     *
     * @return void
     */
    public function testGetEditComment()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $data = [
            '_csrfToken' => '123456789',
            'id' => 1
        ];

        $this->post(['controller' => 'blog', 'action' => 'getEditComment'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('Lorem ipsum dolor sit amet.');
        $this->assertResponseContains('"error":false');
    }

    /**
     * Test getEditComment method
     *
     * @return void
     */
    public function testGetEditCommentNotAjax()
    {
        $data = [
            '_csrfToken' => '123456789',
            'id' => 1
        ];

        $this->post(['controller' => 'blog', 'action' => 'getEditComment'], $data);
        $this->assertResponseError();
    }

    /**
     * Test getEditComment method
     *
     * @return void
     */
    public function testGetEditCommentNotFound()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $data = [
            '_csrfToken' => '123456789',
            'id' => 1337
        ];

        $this->post(['controller' => 'blog', 'action' => 'getEditComment'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('This comment doesn\'t exist or has been deleted !');
        $this->assertResponseContains('"error":true');
    }

    /**
     * Test getEditComment method
     *
     * @return void
     */
    public function testGetEditCommentNotAuthorized()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 2,
                ]
            ]
        ]);
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);

        $data = [
            '_csrfToken' => '123456789',
            'id' => 1
        ];

        $this->post(['controller' => 'blog', 'action' => 'getEditComment'], $data);
        $this->assertJson($this->_response->body());
        $this->assertResponseContains('You don\'t have the authorization to edit this comment !');
        $this->assertResponseContains('"error":true');
    }

    /**
     * Test editComment method
     *
     * @return void
     */
    public function testEditComment()
    {
        $data = [
            '_csrfToken' => '123456789',
            'content' => 'test edit'
        ];

        $this->post(['controller' => 'blog', 'action' => 'editComment', 1], $data);
        $this->assertSession('This comment has been edited successfully !', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'go', 1]);
    }

    /**
     * Test editComment method
     *
     * @return void
     */
    public function testEditCommentNotPost()
    {
        $data = [
            '_csrfToken' => '123456789',
            'content' => 'test edit'
        ];

        $this->get(['controller' => 'blog', 'action' => 'editComment', 1]);
        $this->assertResponseError();
    }

    /**
     * Test editComment method
     *
     * @return void
     */
    public function testEditCommentNotFound()
    {
        $this->configRequest([
            'headers' => [
                'Referer' => '/blog'
            ]
        ]);
        $data = [
            '_csrfToken' => '123456789',
            'content' => 'test edit'
        ];

        $this->post(['controller' => 'blog', 'action' => 'editComment', 1337], $data);
        $this->assertSession('This comment doesn\'t exist or has been deleted !', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }

    /**
     * Test editComment method
     *
     * @return void
     */
    public function testEditCommentNotAuthorized()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'mariano',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 2,
                ]
            ]
        ]);
        $this->configRequest([
            'headers' => [
                'Referer' => '/blog'
            ]
        ]);
        $data = [
            '_csrfToken' => '123456789',
            'content' => 'test edit'
        ];

        $this->post(['controller' => 'blog', 'action' => 'editComment', 1], $data);
        $this->assertSession('You don\'t have the authorization to edit this comment !', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }
}
