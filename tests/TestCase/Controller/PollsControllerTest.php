<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;

class PollsControllerTest extends IntegrationTestCase
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

        $this->configRequest([
            'headers' => [
                'Referer' => '/blog'
            ]
        ]);
    }

    /**
     * Test vote method
     *
     * @return void
     */
    public function testVoteMethod()
    {
        $this->get(['controller' => 'polls', 'action' => 'vote']);
        $this->assertResponseError();
    }

    /**
     * Test vote method
     *
     * @return void
     */
    public function testVoteWithoutParams()
    {
        $this->post(['controller' => 'polls', 'action' => 'vote']);
        $this->assertResponseError();
    }

    /**
     * Test vote method
     *
     * @return void
     */
    public function testVoteWrongAnswer()
    {
        $data = [
            'answer_id' => 1337,
            '_csrfToken' => '123456789'
        ];
        $this->post(['controller' => 'polls', 'action' => 'vote', 'slug' => 'title', 'id' => 1], $data);
        $this->assertSession('This answer doesn\'t exist.', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }

    /**
     * Test vote method
     *
     * @return void
     */
    public function testVoteTimedExpired()
    {
        $data = [
            'answer_id' => 3,
            '_csrfToken' => '123456789'
        ];
        $this->post(['controller' => 'polls', 'action' => 'vote', 'slug' => 'title', 'id' => 2], $data);
        $this->assertSession('This poll is expired, you can not vote anymore.', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }

    /**
     * Test vote method
     *
     * @return void
     */
    public function testVoteAlreadyVoted()
    {
        $data = [
            'answer_id' => 1,
            '_csrfToken' => '123456789'
        ];
        $this->post(['controller' => 'polls', 'action' => 'vote', 'slug' => 'title', 'id' => 1], $data);
        $this->assertSession('You have already voted for this poll ! (You voted <strong>Yes</strong>).', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }

    /**
     * Test vote method
     *
     * @return void
     */
    public function testVote()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'larry',
                    'avatar' => '../img/avatar.png',
                    'group_id' => 2,
                ]
            ]
        ]);
        $data = [
            'answer_id' => 1,
            '_csrfToken' => '123456789'
        ];
        $this->post(['controller' => 'polls', 'action' => 'vote', 'slug' => 'title', 'id' => 1], $data);
        $this->assertSession('Your have successfully voted for this poll ! (You voted <strong>Yes</strong>).', 'Flash.flash.0.message');
        $this->assertResponseCode(302);
        $this->assertRedirect(['controller' => 'blog', 'action' => 'index']);
    }
}
