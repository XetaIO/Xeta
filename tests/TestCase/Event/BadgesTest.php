<?php
namespace App\Test\TestCase\Event;

use App\Event\Badges;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BadgesTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.blog_articles_comments',
        'app.badges',
        'app.badges_i18n',
        'app.badges_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->controller = new Controller(new Request(), new Response());
    }

    /**
     * test registerBadge
     *
     * @return void
     */
    public function testRegisterBadge()
    {
        $this->Users = TableRegistry::get('Users');
        $user = $this->Users->get(1);

        $data = [
            'created' => new Time('2013-11-10 14:43:54')
        ];

        $this->Users->patchEntity($user, $data);
        $this->Users->save($user);
        $user = $this->Users->get(1);

        $badge = new Badges($this->controller);
        $event = new Event('Model.Users.register', $this->controller, ['user' => $user]);
        $this->assertTrue($badge->registerBadge($event));

        $event = new Event('Model.Users.register', $this->controller, ['user' => 'fail']);
        $this->assertFalse($badge->registerBadge($event));
    }

    /**
     * test commentsBadge
     *
     * @return void
     */
    public function testCommentsBadge()
    {
        $this->Comments = TableRegistry::get('BlogArticlesComments');
        $comment = $this->Comments->get(1);

        $badge = new Badges($this->controller);
        $event = new Event('Model.BlogArticlesComments.add', $this->controller, ['comment' => $comment]);
        $this->assertTrue($badge->commentsBadge($event));

        $event = new Event('Model.BlogArticlesComments.add', $this->controller, ['comment' => 'fail']);
        $this->assertFalse($badge->commentsBadge($event));
    }
}
