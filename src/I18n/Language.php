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
            } else {
                //Get the locale by checking his language with his browser.
                $locale = $this->_getHttpLanguage();
                $this->_cookie->write('language', $locale);
                $this->_locale = $locale;
            }
        }

        //The user want to change his language.
        if (isset($this->_controller->request->params['lang']) && isset($this->_locales[$this->_controller->request->params['lang']])) {
            //If the user is connected, we need to save the new language in the database and refresh his session.
            if ($this->_controller->Auth->user()) {
                $this->_controller->loadModel('Users');

                $user = $this->_controller->Users
                    ->find()
                    ->where(['id' => $this->_session->read('Auth.User.id')])
                    ->first();

                $user->language = $this->_controller->request->params['lang'];
                $this->_controller->Users->save($user);
                $this->_session->write('Auth.User.language', $this->_controller->request->params['lang']);
            }

            //Save the new language in the cookie.
            $this->_cookie->write('language', $this->_controller->request->params['lang']);

            $this->_locale = $this->_controller->request->params['lang'];
        }

        //Set the locale.
        I18n::locale($this->_locale);
    }

    /**
     * Get the language of the user by his browser.
     *
     * @return string
     */
    protected function _getHttpLanguage()
    {
        $httpLanguage = strtolower(substr($this->_controller->request->env('HTTP_ACCEPT_LANGUAGE'), 0, 2));

        switch($httpLanguage){
            case "en":
            case "us":
            case "uk":
                $httpLanguage = "en_US";
                break;

            case "fr":
                $httpLanguage = "fr_FR";
                break;

            default:
                $httpLanguage = I18n::locale();
        }

        return $httpLanguage;
    }
}
