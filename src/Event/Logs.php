<?php
namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;

/**
 * Events descriptions.
 *
 * user.connection.manual.success : Triggered when the user login on the login page.
 * user.connection.manual.failed : Triggered when the user failed to login on the login page.
 * user.connection.auto : Triggered when the user is automated login with Cookies.
 * user.account.modify : Triggered when the user has modified his account.
 * user.email : Triggered when the user has changed his Email.
 * user.password.change : Triggered when the user has changed his password.
 * user.password.reset : Triggered when the user has asked a password reset.
 * user.password.reset.successful : Triggered when an user has successfully reset his password with the Email.
 * 2FA.enabled : Triggered when an user enbale the 2FA mode.
 * 2FA.disabled : Triggered when an user disable the 2FA mode.
 * 2FA.recovery_code.regenerate : Triggered when an user regenerate a new recovery code.
 * 2FA.recovery_code.used : Triggered when an user use his recovery code.
 */

class Logs implements EventListenerInterface
{
    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Log.User' => 'userLog'
        ];
    }

    /**
     * An user has doing an important action, we log it.
     *
     * @param Event $event The event that was fired.
     *
     * @return bool
     */
    public function userLog(Event $event)
    {
        $this->UsersLogs = TableRegistry::get('UsersLogs');

        $data = [
            'user_id' => $event->getData('user_id'),
            'username' => $event->getData('username'),
            'user_ip' => $event->getData('user_ip'),
            'user_agent' => $event->getData('user_agent'),
            'action' => $event->getData('action')
        ];

        $entity = $this->UsersLogs->newEntity($data);
        $this->UsersLogs->save($entity);

        return true;
    }
}
