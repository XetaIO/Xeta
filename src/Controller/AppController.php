<?php
namespace App\Controller;

use App\Event\Badges;
use App\I18n\Language;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Time;

class AppController extends Controller
{

    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'Flash',
        'Cookie',
        'Acl.Acl',
        'SessionsActivity',
    /**
     * If you want enable CSRF uncomment this.
     * I recommend to enable it. If i have disable it, it's because
     * CloudFlare have some problem with the header X-CSRF-Token (AJAX Request).
     */
        /*'Csrf' => [
            'secure' => true
        ],*/
        'Auth' => [
            'className' => 'AclAuth',
            'allowedActionsForBanned' => [
                'Pages' => [
                    'home'
                ]
            ],
            'authenticate' => [
                'Form',
                'Xety/Cake3CookieAuth.Cookie'
            ],
            'flash' => [
                'element' => 'error',
                'key' => 'flash',
                'params' => [
                    'class' => 'error'
                ]
            ],
            'authorize' => [
                'Acl.Actions' => [
                    'actionPath' => 'app/'
                ]
            ],
            'loginAction' => [
                'controller' => 'users',
                'action' => 'login',
                'prefix' => false
            ],
            'unauthorizedRedirect' => [
                'controller' => 'pages',
                'action' => 'home',
                'prefix' => false
            ],
            'loginRedirect' => [
                'controller' => 'pages',
                'action' => 'home'
            ],
            'logoutRedirect' => [
                'controller' => 'pages',
                'action' => 'home'
            ],
            'authError' => 'You are not authorized to access that location !'
        ]
    ];

    /**
     * Helpers.
     *
     * @var array
     */
    public $helpers = [
        'Form' => [
            'templates' => [
                'error' => '<div class="text-danger">{{content}}</div>',
                'radioWrapper' => '{{input}}{{label}}',
                'nestingLabel' => '<label{{attrs}}>{{text}}</label>'
            ]
        ],
        'Acl'
    ];

    /**
     * beforeFilter handle.
     *
     * @param Event $event The beforeFilter event that was fired.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        //Define the language.
        $language = new Language($this);
        $language->setLanguage();

        //Check for the Premium.
        $premium = $this->request->session()->read('Premium.Check') ? $this->request->session()->read('Premium.Check') : null;
        if (!is_null($premium)) {
            $this->loadModel('PremiumTransactions');

            $transaction = $this->PremiumTransactions
                ->find()
                ->where([
                    'txn' => $this->request->session()->read('Premium.Check'),
                    'user_id' => $this->request->session()->read('Auth.User.id')
                ])
                ->contain(['Users'])
                ->first();

            if ($transaction) {
                //Write in the session the virtual field.
                $this->Auth->setUser($transaction->user->toArray());
                $this->request->session()->write('Auth.User.premium', $transaction->user->premium);

                $this->request->session()->delete('Premium.Check');
            }
        }

        //Set trustProxy or get the original visitor IP.
        $this->request->trustProxy = true;

        //Automatically Login.
        if (!$this->Auth->user() && $this->Cookie->read('CookieAuth')) {
            $this->loadModel('Users');

            $user = $this->Auth->identify();
            if ($user && $user['is_deleted'] == false) {
                $this->Auth->setUser($user);

                $user = $this->Users->newEntity($user);
                $user->isNew(false);

                $user->last_login = new Time();
                $user->last_login_ip = $this->request->clientIp();

                $this->Users->save($user);

                //Write in the session the virtual field.
                $this->request->session()->write('Auth.User.premium', $user->premium);

                //Event.
                $this->eventManager()->attach(new Badges($this));

                $user = new Event('Model.Users.register', $this, [
                    'user' => $user
                ]);
                $this->eventManager()->dispatch($user);
            } else {
                $this->Cookie->delete('CookieAuth');
            }
        }

        if (isset($this->request->params['prefix'])) {
            $prefix = explode('/', $this->request->params['prefix'])[0];

            switch($prefix) {
                case 'admin':
                    $this->layout = 'admin';
                    break;

                case 'forum':
                    $this->layout = 'forum';
                    break;
            }
        }

        $allowCookies = $this->Cookie->check('allowCookies');
        $this->set(compact('allowCookies'));
    }
}
