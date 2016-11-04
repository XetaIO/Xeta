<?php
namespace App\Controller;

use App\Event\Badges;
use App\Event\Notifications;
use App\Event\Statistics;
use App\Utility\Users as UsersUtility;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Mailer\MailerAwareTrait;

class UsersController extends AppController
{
    use MailerAwareTrait;

    /**
     * Initialize handle.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $action = $this->request->action;

        if ($action === 'login' || $action === 'forgotPassword') {
            $this->loadComponent('Recaptcha.Recaptcha');
        }
    }

    /**
     * BeforeFilter handle.
     *
     * @param Event $event The beforeFilter event that was fired.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['index', 'logout', 'profile', 'forgotPassword', 'resetPassword']);
    }

    /**
     * Display all Users.
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'maxLimit' => Configure::read('User.user_per_page')
        ];
        $users = $this->Users
            ->find()
            ->contain([
                'Groups'
            ])
            ->order([
                'Users.created' => 'desc'
            ]);

        $users = $this->paginate($users);

        $this->set(compact('users'));
    }

    /**
     * Login and register page.
     *
     * @return \Cake\Network\Response|void
     */
    public function login()
    {
        if ($this->request->is('post')) {
            $method = ($this->request->data['method']) ? $this->request->data['method'] : false;

            switch ($method) {
                case "login":
                    $userLogin = $this->Auth->identify();

                    if ($userLogin) {
                        if ($userLogin['is_deleted'] == true) {
                            $this->Flash->error(__("This account has been deleted."));

                            $userRegister = $this->Users->newEntity($this->request->data);

                            break;
                        }

                        $this->Auth->setUser($userLogin);

                        $user = $this->Users->newEntity($userLogin, ['accessibleFields' => ['id' => true]]);
                        $user->isNew(false);

                        $user->last_login = new Time();
                        $user->last_login_ip = $this->request->clientIp();

                        $this->Users->save($user);

                        //Cookies.
                        $this->Cookie->configKey('CookieAuth', [
                            'expires' => '+1 year',
                            'httpOnly' => true
                        ]);
                        $this->Cookie->write('CookieAuth', [
                            'username' => $this->request->data('username'),
                            'password' => $this->request->data('password')
                        ]);

                        //Badge Event.
                        $this->eventManager()->attach(new Badges($this));

                        $user = new Event('Model.Users.register', $this, [
                            'user' => $user
                        ]);
                        $this->eventManager()->dispatch($user);

                        $url = $this->Auth->redirectUrl();
                        if (substr($this->Auth->redirectUrl(), -5) == 'login') {
                            $url = ['controller' => 'pages', 'action' => 'home'];
                        }

                        return $this->redirect($url);
                    }

                    $this->Flash->error(__("Your username or password doesn't match."));

                    $userRegister = $this->Users->newEntity($this->request->data);

                    break;

                case "register":
                    $userRegister = $this->Users->newEntity($this->request->data, ['validate' => 'create']);

                    $userRegister->register_ip = $this->request->clientIp();
                    $userRegister->last_login_ip = $this->request->clientIp();
                    $userRegister->last_login = new Time();

                    if ($this->Recaptcha->verify()) {
                        if ($this->Users->save($userRegister)) {
                            $user = $this->Auth->identify();

                            if ($user) {
                                $this->Auth->setUser($user);
                            }

                            $user = $this->Users->get($user['id']);

                            //Statistics Event.
                            $this->eventManager()->attach(new Statistics());
                            $stats = new Event('Model.Users.register', $this);
                            $this->eventManager()->dispatch($stats);

                            //Notification Events.
                            $this->eventManager()->attach(new Notifications());
                            $event = new Event('Model.Notifications.new', $this, [
                                'user_id' => $user->id,
                                'type' => 'bot'
                            ]);
                            $this->eventManager()->dispatch($event);

                            $viewVars = [
                                'user' => $user,
                                'name' => $user->full_name
                            ];

                            $this->getMailer('User')->send('register', [$user, $viewVars]);

                            $this->Flash->success(__("Your account has been created successfully !"));

                            $url = $this->Auth->redirectUrl();
                            if (substr($this->Auth->redirectUrl(), -5) == 'login') {
                                $url = ['controller' => 'pages', 'action' => 'home'];
                            }

                            return $this->redirect($url);
                        }

                        $this->Flash->error(__("Please, correct your mistake."));
                    } else {
                        $this->Flash->error(__("Please, correct your Captcha."));
                    }

                    break;
            }
        } else {
            //Save the referer URL before the user send the login/register request else it will delete the referer.
            $this->request->session()->write('Auth.redirect', $this->referer());

            $userRegister = $this->Users->newEntity($this->request->data, ['validate' => 'create']);
        }

        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        $this->set(compact('userRegister'));
    }

    /**
     * Logout an user.
     *
     * @return \Cake\Network\Response
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Page to configure our account.
     *
     * @return void
     */
    public function account()
    {
        $user = $this->Users->get($this->Auth->user('id'));

        if ($this->request->is('put')) {
            $user->accessible('avatar_file', true);
            $this->Users->patchEntity($user, $this->request->data(), ['validate' => 'account']);

            if ($this->Users->save($user)) {
                $this->request->session()->write('Auth.User.avatar', $user->avatar);
                $this->Flash->success(__("Your information has been updated !"));
            }
        }

        $this->set(compact('user'));
    }

    /**
     * Page to configure our settings.
     *
     * @return \Cake\Network\Response|void
     */
    public function settings()
    {
        $user = $this->Users->get($this->Auth->user('id'));

        $oldEmail = $user->email;

        if ($this->request->is('put')) {
            $method = ($this->request->data['method']) ? $this->request->data['method'] : false;

            switch ($method) {
                case "email":
                    if (!isset($this->request->data['email'])) {
                        $this->set(compact('user', 'oldEmail'));

                        return $this->redirect(['action' => 'settings']);
                    }

                    $this->Users->patchEntity($user, $this->request->data(), ['validate' => 'settings']);

                    if ($this->Users->save($user)) {
                        $oldEmail = $this->request->data['email'];

                        $this->Flash->success(__("Your E-mail has been changed !"));
                    }
                    break;

                case "password":
                    $data = $this->request->data;
                    if (!isset($data['old_password']) || !isset($data['password']) || !isset($data['password_confirm'])) {
                        $this->set(compact('user', 'oldEmail'));

                        return $this->Flash->error(__("Please, complete all fields !"));
                    }

                    if (!(new DefaultPasswordHasher)->check($data['old_password'], $user->password)) {
                        $this->set(compact('user', 'oldEmail'));

                        return $this->Flash->error(__("Your old password don't match !"));
                    }

                    $this->Users->patchEntity($user, $this->request->data(), ['validate' => 'settings']);
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__("Your password has been changed !"));
                    }
                    break;
            }
        }

        $this->set(compact('user', 'oldEmail'));
    }

    /**
     * View a profile page of an user.
     *
     * @return \Cake\Network\Response|void
     */
    public function profile()
    {
        $user = $this->Users
            ->find()
            ->where([
                'Users.id' => $this->request->id
            ])
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'name', 'css', 'is_staff', 'is_member']);
                },
                'BlogArticles' => function ($q) {
                    return $q
                        ->limit(Configure::read('User.Profile.max_blog_articles'))
                        ->order(['BlogArticles.created' => 'DESC']);
                },
                'BlogArticlesComments' => function ($q) {
                    return $q
                        ->limit(Configure::read('User.Profile.max_blog_comments'))
                        ->contain([
                            'BlogArticles' => function ($q) {
                                return $q->select(['id', 'title']);
                            }
                        ])
                        ->order(['BlogArticlesComments.created' => 'DESC']);
                },
                'BadgesUsers' => function ($q) {
                    return $q
                        ->contain([
                            'Badges' => function ($q) {
                                return $q
                                    ->select([
                                        'name',
                                        'picture'
                                    ]);
                            }
                        ])
                        ->order([
                            'BadgesUsers.id' => 'DESC'
                        ]);
                }
            ])
            ->map(function ($user) {
                $user->online = $this->SessionsActivity->getOnlineStatus($user);
                $user->background_profile = UsersUtility::getProfileBackground();

                return $user;
            })
            ->first();

        if (is_null($user) || $user->is_deleted == true) {
            $this->Flash->error(__('This user doesn\'t exist or has been deleted.'));

            return $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }

        $this->set(compact('user'));
    }

    /**
     * Delete an user with all his comments, articles and likes.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {
        if (!$this->request->is('post')) {
            return $this->redirect(['action' => 'settings']);
        }

        $user = $this->Users->get($this->Auth->user('id'));

        if (!(new DefaultPasswordHasher)->check($this->request->data['password'], $user->password)) {
            $this->Flash->error(__("Your password doesn't match !"));

            return $this->redirect(['action' => 'settings']);
        }

        $user->is_deleted = true;

        if ($this->Users->save($user)) {
            $this->Flash->success(__("Your account has been deleted successfully ! Thanks for your visit !"));

            return $this->redirect($this->Auth->logout());
        }

        $this->Flash->error(__("Unable to delete your account, please try again."));

        return $this->redirect(['action' => 'settings']);
    }

    /**
     * Display all notifications related to the user.
     *
     * @return void
     */
    public function notifications()
    {
        $this->loadModel('Notifications');

        $this->paginate = [
            'maxLimit' => Configure::read('User.notifications_per_page')
        ];

        $notifications = $this->Notifications
            ->find()
            ->where([
                'user_id' => $this->Auth->user('id')
            ])
            ->order([
                'is_read' => 'ASC',
                'created' => 'DESC'
            ])
            ->find('map', [
                'session' => $this->request->session()
            ]);

        $notifications = $this->paginate($notifications);

        $this->set(compact('notifications'));
    }

    /**
     * Display the form to reset the password.
     *
     * @return \Cake\Network\Response|void
     */
    public function forgotPassword()
    {
        if ($this->Auth->user()) {
            return $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }

        if ($this->request->is('post')) {
            $user = $this->Users
                ->find()
                ->where([
                    'Users.email' => $this->request->data['email']
                ])
                ->first();

            if (is_null($user)) {
                $this->Flash->error(__("This E-mail doesn't exist or the account has been deleted."));

                $this->set(compact('user'));

                return;
            }

            if (!$this->Recaptcha->verify()) {
                $this->Flash->error(__("Please, correct your Captcha."));

                $this->set(compact('user'));

                return;
            }

            //Generate the unique code
            $code = md5(rand() . uniqid() . time());

            //Update the user's information
            $user->password_code = $code;
            $user->password_code_expire = new Time();

            $this->Users->save($user);

            $viewVars = [
                'userId' => $user->id,
                'name' => $user->full_name,
                'username' => $user->username,
                'code' => $code
            ];

            $this->getMailer('User')->send('forgotPassword', [$user, $viewVars]);

            $this->Flash->success(__("An E-mail has been send to <strong>{0}</strong>. Please follow the instructions in the E-mail.", h($user->email)));
        }

        $this->set(compact('user'));
    }

    /**
     * Display the form to reset his password.
     *
     * @return \Cake\Network\Response|void
     */
    public function resetPassword()
    {
        if ($this->Auth->user()) {
            return $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }

        //Prevent for empty code.
        if (empty(trim($this->request->code))) {
            $this->Flash->error(__("This code is not associated with this users or is incorrect."));

            return $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }

        $user = $this->Users
            ->find()
            ->where([
                'Users.password_code' => $this->request->code,
                'Users.id' => $this->request->id
            ])
            ->first();

        if (is_null($user)) {
            $this->Flash->error(__("This code is not associated with this users or is incorrect."));

            return $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }

        $expire = $user->password_code_expire->timestamp + (Configure::read('User.ResetPassword.expire_code') * 60);

        if ($expire < time()) {
            $this->Flash->error(__("This code is expired, please ask another E-mail code."));

            return $this->redirect(['action' => 'forgotPassword']);
        }

        if ($this->request->is(['post', 'put'])) {
            $this->Users->patchEntity($user, $this->request->data, ['validate' => 'resetpassword']);

            if ($this->Users->save($user)) {
                $this->Flash->success(__("Your password has been changed !"));

                //Reset the code and the time.
                $user->password_code = '';
                $user->password_code_expire = new Time();
                $user->password_reset_count = $user->password_reset_count + 1;
                $this->Users->save($user);

                return $this->redirect(['controller' => 'users', 'action' => 'login']);
            }
        }

        $this->set(compact('user'));
    }
}
