<?php
namespace App\Test\TestCase\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class UsersControllerTest extends IntegrationTestCase
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
        'app.blog_articles_comments',
        'app.blog_articles_likes',
        'app.badges',
        'app.badges_i18n',
        'app.badges_users',
        'app.notifications',
        'app.users_logs'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $password = password_hash('password', PASSWORD_DEFAULT);
        $Users = TableRegistry::get('Users');
        $Users->updateAll(['password' => $password], []);
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        $folder = new Folder(TEST_WWW_ROOT . 'upload');
        $folder->delete(TEST_WWW_ROOT . 'upload');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(['controller' => 'users', 'action' => 'index']);

        $this->assertResponseOk();
        $this->assertResponseContains('mariano');
    }

    /**
     * Test login method
     *
     * @return void
     */
    public function testLogin()
    {
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

        //Login successfull.
        $data = [
            'method' => 'login',
            'username' => 'mariano',
            'password' => 'password',
            '_csrfToken' => '123456789'
        ];

        $this->post(['controller' => 'users', 'action' => 'login'], $data);

        $this->assertResponseSuccess();
        $this->assertSession(1, 'Auth.User.id');
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home']);

        //Login fail.
        $data = [
            'method' => 'login',
            'username' => 'mariano',
            'password' => 'passfail',
            '_csrfToken' => '123456789'
        ];

        $this->post(['controller' => 'users', 'action' => 'login'], $data);

        $this->assertResponseOk();
        $this->assertSession(null, 'Auth.User.id');

        //Mailtrap bypass...
        sleep(1);

        //Register successfull.
        Configure::write('Recaptcha.bypass', true);
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];
        $data = [
            'method' => 'register',
            'username' => 'mariano2',
            'email' => 'test@xeta.io',
            'password' => '12345678',
            'password_confirm' => '12345678',
            '_csrfToken' => '123456789'
        ];

        $this->post(['controller' => 'users', 'action' => 'login'], $data);

        $this->assertResponseSuccess();
        $this->assertSession(3, 'Auth.User.id');
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home']);

        //Register fail. (Username already exist)
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];
        $data = [
            'method' => 'register',
            'username' => 'mariano',
            'email' => 'test@xeta.io',
            'password' => '12345678',
            'password_confirm' => '12345678',
            '_csrfToken' => '123456789'
        ];

        $this->post(['controller' => 'users', 'action' => 'login'], $data);

        $this->assertResponseSuccess();
        $this->assertSession(null, 'Auth.User.id');
        //We can't test the flash test due to the translation system.
        $this->assertResponseContains('infobox-danger');
    }

    /**
     * Test login method with saved referer
     *
     * @return void
     */
    public function testLoginSavedReferer()
    {
        Configure::write('App.fullBaseUrl', 'http://localhost');
        $this->configRequest([
            'headers' => [
                'Referer' => 'http://localhost/blog/view'
            ]
        ]);

        $this->get(['controller' => 'users', 'action' => 'login']);
        $this->assertResponseOk();
        $this->assertSession('http://localhost/blog/view', 'Auth.redirect');
    }

    /**
     * Test login method already logged
     *
     * @return void
     */
    public function testLoginAlreadyLogged()
    {
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

        $this->get(['controller' => 'users', 'action' => 'login']);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home']);
    }

    /**
     * Test logout method
     *
     * @return void
     */
    public function testLogout()
    {
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

        //Login successfull.
        $data = [
            'method' => 'login',
            'username' => 'mariano',
            'password' => 'password',
            '_csrfToken' => '123456789'
        ];

        $this->post('/users/login', $data);

        $this->assertResponseSuccess();
        $this->assertSession(1, 'Auth.User.id');

        $this->get(['controller' => 'users', 'action' => 'logout']);
        $this->assertSession(null, 'Auth.User.id');

        $this->assertRedirect(['controller' => 'pages', 'action' => 'home']);
    }

    /**
     * Test account unauthorized method
     *
     * @return void
     */
    public function testAccountUnauthorized()
    {
        $this->get(['controller' => 'users', 'action' => 'account']);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'users', 'action' => 'login', 'redirect' => '/users/account']);
    }

    /**
     * Test account authorized method
     *
     * @return void
     */
    public function testAccountAuthorized()
    {
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

        $this->get(['controller' => 'users', 'action' => 'account']);

        $this->assertResponseOk();
    }

    /**
     * Test account authorized with put method
     *
     * @return void
     */
    public function testAccountAuthorizedWithPut()
    {
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

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

        $data = [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'twitter' => 'Mariano',
            'facebook' => 'Mariano',
            'biography' => 'mariano biography',
            'signature' => 'mariano signature',
            'avatar_file' => [
                'name' => 'tmp_avatar.png',
                'tmp_name' => TEST_TMP . 'tmp_avatar.png',
                'error' => UPLOAD_ERR_OK,
                'type' => 'image/png',
                'size' => 6000
            ],
            '_csrfToken' => '123456789'
        ];

        $this->put(['controller' => 'users', 'action' => 'account'], $data);

        $this->assertResponseOk();

        $Users = TableRegistry::get('Users');
        $user = $Users->find()->where(['id' => 1])
            ->select(['first_name', 'last_name', 'twitter', 'facebook', 'biography', 'signature'])
            ->first()->toArray();

        unset($data['avatar_file'], $data['_csrfToken']);

        $this->assertEquals($data, $user);
    }

    /**
     * Test settings unauthorized method
     *
     * @return void
     */
    public function testSettingsUnauthorized()
    {
        $this->get(['controller' => 'users', 'action' => 'settings']);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'users', 'action' => 'login', 'redirect' => '/users/settings']);
    }

    /**
     * Test settings authorized method
     *
     * @return void
     */
    public function testSettingsAuthorized()
    {
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

        $this->get(['controller' => 'users', 'action' => 'settings']);

        $this->assertResponseOk();
    }

    /**
     * Test account authorized with put method for Email
     *
     * @return void
     */
    public function testSettingsAuthorizedWithPutForEmail()
    {
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

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

        $data = [
            'method' => 'email',
            'email' => 'mynew@email.io',
            '_csrfToken' => '123456789'
        ];

        $this->put(['controller' => 'users', 'action' => 'settings'], $data);

        $this->assertResponseOk();
        $this->assertResponseContains('infobox-success');

        $Users = TableRegistry::get('Users');
        $user = $Users->find()->where(['id' => 1])
            ->select(['email'])
            ->first()->toArray();

        unset($data['method'], $data['_csrfToken']);

        $this->assertEquals($data, $user);
    }

    /**
     * Test account authorized with put method for Email with no Email
     *
     * @return void
     */
    public function testSettingsAuthorizedWithPutForEmailWithNoEmail()
    {
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

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

        $data = [
            'method' => 'email',
            '_csrfToken' => '123456789'
        ];

        $this->put(['controller' => 'users', 'action' => 'settings'], $data);

        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'users', 'action' => 'settings']);
    }

    /**
     * Test account authorized with put method for Password
     *
     * @return void
     */
    public function testSettingsAuthorizedWithPutForPassword()
    {
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

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

        $data = [
            'method' => 'password',
            'old_password' => 'password',
            'password' => '12345678',
            'password_confirm' => '12345678',
            '_csrfToken' => '123456789'
        ];

        $this->put(['controller' => 'users', 'action' => 'settings'], $data);

        $this->assertResponseOk();
        $this->assertResponseContains('infobox-success');

        $Users = TableRegistry::get('Users');
        $user = $Users->find()->where(['id' => 1])
            ->select(['password'])
            ->first();

        unset($data['method'], $data['old_password'], $data['password_confirm']);

        $this->assertTrue((new DefaultPasswordHasher)->check($data['password'], $user->password));
    }

    /**
     * Test account authorized with put method for Password with no Password
     *
     * @return void
     */
    public function testSettingsAuthorizedWithPutForPasswordWithNoPassword()
    {
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

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

        $data = [
            'method' => 'password',
            'old_password' => 'password',
            'password' => '12345678',
            '_csrfToken' => '123456789'
        ];

        $this->put(['controller' => 'users', 'action' => 'settings'], $data);

        $this->assertResponseOk();
        $this->assertResponseContains('infobox-danger');
    }

    /**
     * Test account authorized with put method for Password with old Password fail
     *
     * @return void
     */
    public function testSettingsAuthorizedWithPutForPasswordWithOldPasswordFail()
    {
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];

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

        $data = [
            'method' => 'password',
            'old_password' => 'OldPasswordFail',
            'password' => '12345678',
            'password_confirm' => '12345678',
            '_csrfToken' => '123456789'
        ];

        $this->put(['controller' => 'users', 'action' => 'settings'], $data);

        $this->assertResponseOk();
        $this->assertResponseContains('infobox-danger');
    }

    /**
     * Test profile method
     *
     * @return void
     */
    public function testProfile()
    {
        $this->get(['_name' => 'users-profile', 'slug' => 'mariano', 'id' => 1]);
        $this->assertResponseOk();
        $this->assertResponseContains('My awesome biography');
    }

    /**
     * Test profile method with fake user
     *
     * @return void
     */
    public function testProfileWithFakeUser()
    {
        $this->get(['_name' => 'users-profile', 'slug' => 'marianoFail', 'id' => 69]);
        $this->assertResponseSuccess();
        //We can't test the flash message due to the translation system.
        $this->assertSession('Flash/error', 'Flash.flash.0.element');
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home']);
    }

    /**
     * Test profile authorized method
     *
     * @return void
     */
    public function testNotificationsAuthorized()
    {
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

        $this->get(['controller' => 'users', 'action' => 'notifications']);
        $this->assertResponseOk();
        $this->assertResponseContains('infobox infobox-primary');
    }

    /**
     * Test forgotPassword method
     *
     * @return void
     */
    public function testForgotPassword()
    {
        $this->get(['controller' => 'users', 'action' => 'forgotPassword']);
        $this->assertResponseOk();
        $this->assertResponseContains('email');

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
        $this->get(['controller' => 'users', 'action' => 'forgotPassword']);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home']);
    }

    /**
     * Test forgotPassword method
     *
     * @return void
     */
    public function testResetPassword()
    {
        $this->Users = TableRegistry::get('Users');
        $user = $this->Users->get(1);

        $code = md5(rand() . uniqid() . time());

        $user->password_code = $code;
        $user->password_code_expire = new Time();
        $user->password_reset_count = 2;
        $this->Users->save($user);

        //Empty code
        $this->get(['controller' => 'users', 'action' => 'resetPassword', 'id' => 1]);
        $this->assertResponseSuccess();
        $this->assertSession('Flash/error', 'Flash.flash.0.element');
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home']);

        //Incorrect user.
        $this->get(['_name' => 'users-resetpassword', 'code' => 'zz', 'id' => 69]);
        $this->assertResponseSuccess();
        $this->assertSession('Flash/error', 'Flash.flash.0.element');
        $this->assertRedirect(['controller' => 'pages', 'action' => 'home']);

        //Page without POST.
        $this->get(['_name' => 'users-resetpassword', 'code' => $code, 'id' => 1]);
        $this->assertResponseOk();
        $this->assertResponseContains('id="password"');

        //Expired code.
        $user->password_code_expire = $user->password_code_expire->subMinutes(15);
        $this->Users->save($user);

        $this->get(['_name' => 'users-resetpassword', 'code' => $code, 'id' => 1]);
        $this->assertResponseSuccess();
        $this->assertSession('Flash/error', 'Flash.flash.0.element');
        $this->assertRedirect(['controller' => 'users', 'action' => 'forgotPassword']);

        $user->password_code_expire = $user->password_code_expire->addMinutes(30);
        $this->Users->save($user);

        //Page with POST but fail validation.
        $this->_cookie = [
            'csrfToken' => '123456789'
        ];
        $data = [
            'password' => '1234567',
            'password_confirm' => '12345678',
            '_csrfToken' => '123456789'
        ];
        $this->put(['_name' => 'users-resetpassword', 'code' => $code, 'id' => 1], $data);
        $this->assertResponseOk();

        //Page with POST ok.
        $data = [
            'password' => '12345678',
            'password_confirm' => '12345678',
            '_csrfToken' => '123456789'
        ];
        $this->put(['_name' => 'users-resetpassword', 'code' => $code, 'id' => 1], $data);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'users', 'action' => 'login']);
    }
}
