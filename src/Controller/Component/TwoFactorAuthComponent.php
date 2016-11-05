<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class TwoFactorAuthComponent extends Component
{
    /**
     * Check if the current user session is the same as the saved session.
     *
     * @param int $user The user id.
     *
     * @return bool
     */
    public function isAuthorized($user)
    {
        $session = $this->request->clientIp() . $this->request->header('User-Agent') . gethostbyaddr($this->request->clientIp());

        $this->UsersTwoFactorAuth = TableRegistry::get('UsersTwoFactorAuth');

        $tfa = $this->UsersTwoFactorAuth
            ->find()
            ->where([
                'user_id' => $user
            ])
            ->first();

        if (is_null($tfa)) {
            return false;
        }

        return $tfa->session === $session;
    }
}
