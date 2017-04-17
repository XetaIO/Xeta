<?php
namespace App\I18n;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\I18n\I18n;

class Language
{

    /**
     * The Cookie instance.
     *
     * @var \Cake\Network\Session
     */
    protected $_session;

    /**
     * The Cookie instance.
     *
     * @var \Cake\Controller\Component\CookieComponent
     */
    protected $_cookie;

    /**
     * The Controller instance.
     *
     * @var \Cake\Controller\Controller
     */
    protected $_controller;

    /**
     * All locales allowed to be used.
     *
     * @var array
     */
    protected $_locales = [];

    /**
     * The locale to be used.
     *
     * @var string
     */
    protected $_locale;

    /**
     * Construct method.
     *
     * @param \Cake\Controller\Controller $controller The controller that was fired.
     */
    public function __construct(Controller $controller)
    {
        $this->_controller = $controller;
        $this->_session = $controller->request->session();
        $this->_cookie = $controller->Cookie;
        $this->_locales = Configure::read('I18n.locales');
        $this->_locale = I18n::locale();

        $this->_cookie->configKey('language', [
            'expires' => '+1 year',
            'httpOnly' => true
        ]);
    }

    /**
     * Set the language for the user.
     *
     * @return void
     */
    public function setLanguage()
    {
        if ($this->_controller->Auth->user()) {
            //The user has already a valid language defined in the database.
            if ($this->_session->read('Auth.User.language') && isset($this->_locales[$this->_session->read('Auth.User.language')])) {
                //If the user has not the cookie, we set the cookie.
                if (!$this->_cookie->check('language') || $this->_cookie->read('language') != $this->_session->read('Auth.User.language')) {
                    $this->_cookie->write('language', $this->_session->read('Auth.User.language'));
                }
                //Stock the locale of the user.
                $this->_locale = $this->_session->read('Auth.User.language');
            }
        } else {
            //The user has a valid cookie.
            if ($this->_cookie->check('language') && isset($this->_locales[$this->_cookie->read('language')])) {
                $this->_locale = $this->_cookie->read('language');
            }
        }

        //The user want to change his language.
        if (!is_null($this->_controller->request->getParam('lang')) && isset($this->_locales[$this->_controller->request->getParam('lang')])) {
            //If the user is connected, we need to save the new language in the database and refresh his session.
            if ($this->_controller->Auth->user()) {
                $this->_controller->loadModel('Users');

                $user = $this->_controller->Users
                    ->find()
                    ->where(['id' => $this->_session->read('Auth.User.id')])
                    ->first();

                $user->language = $this->_controller->request->getParam('lang');
                $this->_controller->Users->save($user);
                $this->_session->write('Auth.User.language', $this->_controller->request->getParam('lang'));
            }

            //Save the new language in the cookie.
            $this->_cookie->write('language', $this->_controller->request->getParam('lang'));

            $this->_locale = $this->_controller->request->getParam('lang');
        }

        //Set the locale.
        I18n::locale($this->_locale);
    }
}
