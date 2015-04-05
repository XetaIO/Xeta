<?php
namespace App\Controller;

use App\Event\Badges;
use App\Event\Forum\Statistics;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;

class UsersController extends AppController
{

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

        $this->Auth->allow(['index', 'logout', 'profile']);
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
        $userRegister = $this->Users->newEntity($this->request->data, ['validate' => 'create']);

        if ($this->request->is('post')) {
            $method = ($this->request->data['method']) ? $this->request->data['method'] : false;

            switch ($method) {
                case "login":

                    $userLogin = $this->Auth->identify();

                    if ($userLogin) {
                        $this->Auth->setUser($userLogin);

                        $user = $this->Users->newEntity($userLogin);
                        $user->isNew(false);

                        $user->last_login = new Time();
                        $user->last_login_ip = $this->request->clientIp();

                        $this->Users->save($user);

                        //Write in the session the virtual field.
                        $this->request->session()->write('Auth.User.premium', $user->premium);

                        //Cookies.
                        $this->Cookie->configKey('CookieAuth', [
                            'expires' => '+1 year',
                            'httpOnly' => true
                        ]);
                        $this->Cookie->write('CookieAuth', [
                            'username' => $this->request->data('username'),
                            'password' => $this->request->data('password')
                        ]);

                        //Event.
                        $this->eventManager()->attach(new Badges($this));

                        $user = new Event('Model.Users.register', $this, [
                            'user' => $user
                        ]);
                        $this->eventManager()->dispatch($user);

                        return $this->redirect($this->Auth->redirectUrl());
                    }

                    $this->Flash->error(__("Your username or password doesn't match."));

                    break;

                case "register":

                    $userRegister->register_ip = $this->request->clientIp();
                    $userRegister->last_login_ip = $this->request->clientIp();
                    $userRegister->last_login = new Time();

                    if ($this->Users->save($userRegister)) {
                        $user = $this->Auth->identify();

                        if ($user) {
                            $this->Auth->setUser($user);
                        }

                        //Event.
                        $this->eventManager()->attach(new Statistics());

                        $stats = new Event('Model.Users.register', $this);
                        $this->eventManager()->dispatch($stats);

                        $this->Flash->success(__("Your account has been created successfully !"));

                        return $this->redirect($this->Auth->redirectUrl());
                    }

                    $this->Flash->error(__("Please, correct your mistake."));

                    break;
            }
        } else {
            //Save the referer URL before the user send the login/register request else it will delete the referer.
            $this->request->session()->write('Auth.redirect', $this->referer());
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
            ->find('slug', [
                'slug' => $this->request->slug,
                'slugField' => 'Users.slug'
            ])
            ->contain([
                'BlogArticles' => function ($q) {
                    return $q
                        ->limit(Configure::read('User.Profile.max_articles'));
                },
                'BlogArticlesComments' => function ($q) {
                    return $q
                        ->limit(Configure::read('User.Profile.max_comments'));
                },
                'BlogArticlesLikes' => function ($q) {
                    return $q
                        ->limit(Configure::read('User.Profile.max_likes'));
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
            ->first();

        if (is_null($user)) {
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
        $user = $this->Users->get($this->Auth->user('id'));

        if ($this->Users->delete($user)) {
            $this->Flash->success(__("Your account has been deleted successfully ! Thanks for your visit !"));

            return $this->redirect($this->Auth->logout());
        }

        $this->Flash->error(__("Unable to delete your account, please try again."));

        return $this->redirect(['action' => 'settings']);
    }

    /**
     * Display all premium transactions related to the user.
     *
     * @return void
     */
    public function premium()
    {
        $this->loadModel('PremiumTransactions');

        $this->paginate = [
            'maxLimit' => Configure::read('User.transaction_per_page')
        ];

        $transactions = $this->PremiumTransactions
            ->find()
            ->contain([
                'PremiumOffers',
                'PremiumDiscounts'
            ])
            ->where([
                'PremiumTransactions.user_id' => $this->Auth->user('id')
            ])
            ->order([
                'PremiumTransactions.created' => 'desc'
            ]);

        $transactions = $this->paginate($transactions);

        $this->set(compact('transactions'));
    }
}
