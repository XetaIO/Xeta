<?php
namespace App\Controller;

use App\Event\Logs;
use Cake\Core\Configure;
use Cake\Event\Event;
use Endroid\QrCode\QrCode;
use RobThree\Auth\TwoFactorAuth;

class TfaController extends AppController
{
    /**
     * Display the index action.
     *
     * @return void
     */
    public function index()
    {
    }

    /**
     * Display an intro to the Two-factor Authentication.
     *
     * @return \Cake\Network\Response|void
     */
    public function intro()
    {
        $this->loadModel('Users');

        $user = $this->Users
            ->find()
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select([
                'id',
                'two_factor_auth_enabled'
            ])
            ->first();

        if ($user->two_factor_auth_enabled == true) {
            $this->Flash->error(__('You have already set-up the Two-factor authentication.'));

            return $this->redirect(['controller' => 'users', 'action' => 'security']);
        }
    }

    /**
     * Configure the Two-factor Authentication.
     *
     * @return \Cake\Network\Response|void
     */
    public function configure()
    {
        $this->loadModel('Users');

        $user = $this->Users
            ->find()
            ->contain([
                'UsersTwoFactorAuth'
            ])
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select([
                'Users.id',
                'Users.username',
                'Users.two_factor_auth_enabled',
                'UsersTwoFactorAuth.id',
                'UsersTwoFactorAuth.user_id',
                'UsersTwoFactorAuth.secret',
                'UsersTwoFactorAuth.username'
            ])
            ->first();

        if ($user->two_factor_auth_enabled == true) {
            $this->Flash->error(__('You have already set-up the Two-factor authentication.'));

            return $this->redirect(['controller' => 'users', 'action' => 'security']);
        }

        $tfa = new TwoFactorAuth('Xeta');

        if (!is_null($user->users_two_factor_auth)) {
            $secret = $user->users_two_factor_auth->secret;
        } else {
            $this->loadModel('UsersTwoFactorAuth');
            $secret = $tfa->createSecret();

            $data = [
                'user_id' => $this->Auth->user('id'),
                'secret' => $secret,
                'username' => $user->username
            ];

            $entity = $this->UsersTwoFactorAuth->newEntity($data);
            $this->UsersTwoFactorAuth->save($entity);
        }

        $imgSrc = $tfa->getQRCodeImageAsDataUri($user->username, $secret);
        $secretCode = chunk_split($secret, 4, ' ');

        $this->set(compact('imgSrc', 'secretCode'));
    }

    /**
     * Enable the Two-factor Authentication.
     *
     * @return \Cake\Network\Response|void
     */
    public function enable()
    {
        if (!$this->request->is('post')) {
            return $this->redirect(['action' => 'configure']);
        }

        $this->loadModel('UsersTwoFactorAuth');

        $userTfa = $this->UsersTwoFactorAuth
            ->find()
            ->where([
                'UsersTwoFactorAuth.user_id' => $this->Auth->user('id')
            ])
            ->first();

        if (is_null($userTfa) || empty($userTfa->secret) || is_null($this->request->getData('code'))) {
            $this->Flash->error(__('Two-factor secret verification failed. Please verify your secret and try again.'));

            return $this->redirect(['action' => 'configure']);
        }

        $tfa = new TwoFactorAuth('Xeta');

        if ($tfa->verifyCode($userTfa->secret, $this->request->getData('code')) === true && $this->request->getData('code') != $userTfa->current_code) {
            $this->loadModel('Users');

            $user = $this->Users
                ->find()
                ->where([
                    'Users.id' => $this->Auth->user('id')
                ])
                ->select([
                    'id',
                    'username',
                    'two_factor_auth_enabled'
                ])
                ->first();

            $user->two_factor_auth_enabled = true;
            $this->Users->save($user);

            $data = [
                'session' => $this->request->clientIp() . $this->request->header('User-Agent') . gethostbyaddr($this->request->clientIp()),
                'current_code' => $this->request->getData('code'),
                'recovery_code' => $this->_generateNewRecoveryCode($userTfa->username)
            ];

            $this->UsersTwoFactorAuth->patchEntity($userTfa, $data);
            $this->UsersTwoFactorAuth->save($userTfa);

            //Logs Event.
            $this->eventManager()->attach(new Logs());
            $event = new Event('Log.User', $this, [
                'user_id' => $user->id,
                'username' => $user->username,
                'user_ip' => $this->request->clientIp(),
                'user_agent' => $this->request->header('User-Agent'),
                'action' => '2FA.enabled'
            ]);
            $this->eventManager()->dispatch($event);

            $this->Flash->success(__('Two-factor authentication successfully enabled !'));

            $this->set(compact('user', 'userTfa'));
        } else {
            $this->Flash->error(__('Two-factor secret verification failed. Please verify your secret and try again.'));

            return $this->redirect(['action' => 'configure']);
        }
    }

    /**
     * Disable the Two-factor Authentication.
     *
     * @return \Cake\Network\Response
     */
    public function disable()
    {
        $this->loadModel('Users');

        $user = $this->Users
            ->find()
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select([
                'id',
                'username',
                'two_factor_auth_enabled'
            ])
            ->first();

        if (is_null($user) || $user->two_factor_auth_enabled == false) {
            $this->Flash->error(__('The Two-factor authentication is not enabled !'));

            return $this->redirect(['controller' => 'users', 'action' => 'security']);
        }

        $user->two_factor_auth_enabled = false;
        $this->Users->save($user);

        $this->loadModel('UsersTwoFactorAuth');

        $userTfa = $this->UsersTwoFactorAuth
            ->find()
            ->where([
                'UsersTwoFactorAuth.user_id' => $this->Auth->user('id')
            ])
            ->first();

        $this->UsersTwoFactorAuth->delete($userTfa);

        //Logs Event.
        $this->eventManager()->attach(new Logs());
        $event = new Event('Log.User', $this, [
            'user_id' => $user->id,
            'username' => $user->username,
            'user_ip' => $this->request->clientIp(),
            'user_agent' => $this->request->header('User-Agent'),
            'action' => '2FA.disabled'
        ]);
        $this->eventManager()->dispatch($event);

        $this->Flash->success(__('The Two-factor authentication has been disabled !'));

        return $this->redirect(['controller' => 'users', 'action' => 'security']);
    }

    /**
     * Display the recovery code and the status of the code.
     *
     * @return \Cake\Network\Response|void
     */
    public function recoveryCode()
    {
        $this->loadModel('Users');

        $user = $this->Users
            ->find()
            ->contain([
                'UsersTwoFactorAuth'
            ])
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select([
                'Users.id',
                'Users.two_factor_auth_enabled',
                'UsersTwoFactorAuth.user_id',
                'UsersTwoFactorAuth.recovery_code',
                'UsersTwoFactorAuth.recovery_code_used'
            ])
            ->first();

        if (is_null($user) || $user->two_factor_auth_enabled == false) {
            $this->Flash->error(__('The Two-factor authentication is not enabled !'));

            return $this->redirect(['controller' => 'users', 'action' => 'security']);
        }

        $this->set(compact('user'));
    }

    /**
     * Generate a new recovery code.
     *
     * @return \Cake\Network\Response
     */
    public function generateRecoveryCode()
    {
        $this->loadModel('Users');
        $this->loadModel('UsersTwoFactorAuth');

        $user = $this->Users
            ->find()
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->select([
                'Users.id',
                'Users.username',
                'Users.two_factor_auth_enabled'
            ])
            ->first();

        if (is_null($user) || $user->two_factor_auth_enabled == false) {
            $this->Flash->error(__('The Two-factor authentication is not enabled !'));

            return $this->redirect(['controller' => 'users', 'action' => 'security']);
        }

        $tfa = $this->UsersTwoFactorAuth
            ->find()
            ->where([
                'UsersTwoFactorAuth.user_id' => $this->Auth->user('id')
            ])
            ->select([
                'UsersTwoFactorAuth.id',
                'UsersTwoFactorAuth.user_id',
                'UsersTwoFactorAuth.username',
                'UsersTwoFactorAuth.recovery_code',
                'UsersTwoFactorAuth.recovery_code_used'
            ])
            ->first();

        $data = [
            'recovery_code' => $this->_generateNewRecoveryCode($tfa->username),
            'recovery_code_used' => false
        ];

        $this->UsersTwoFactorAuth->patchEntity($tfa, $data);

        if ($this->UsersTwoFactorAuth->save($tfa)) {
            //Logs Event.
            $this->eventManager()->attach(new Logs());
            $event = new Event('Log.User', $this, [
                'user_id' => $user->id,
                'username' => $user->username,
                'user_ip' => $this->request->clientIp(),
                'user_agent' => $this->request->header('User-Agent'),
                'action' => '2FA.recovery_code.regenerate'
            ]);
            $this->eventManager()->dispatch($event);

            $this->Flash->success(__('New two-factor recovery code successfully generated.'));

            return $this->redirect(['action' => 'recoveryCode']);
        } else {
            $this->Flash->error(__('Error to generate two-factor recovery code.'));

            return $this->redirect(['action' => 'recoveryCode']);
        }
    }

    /**
     * Function to generate a recovery code.
     *
     * Generate a code into this format :
     * XXXX-XXXX-XXXX-XXXX
     *
     * @param string $user The username of the user.
     *
     * @return string
     */
    protected function _generateNewRecoveryCode($user)
    {
        $code = md5(rand() . uniqid() . time() . $user);

        //Split the code into smaller chunks
        $code = chunk_split(substr($code, 0, 16), 4, '-');

        //Remove the last string added by chunk_split().
        $code = substr($code, 0, -1);

        return $code;
    }
}
