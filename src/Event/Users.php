<?php
namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\TableRegistry;

class Users implements EventListenerInterface
{
    use MailerAwareTrait;

    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Users.login.failed' => 'usersLoginFailed'
        ];
    }

    /**
     * An user failed to login.
     *
     * @param Event $event The event that was fired.
     *
     * @return bool
     */
    public function usersLoginFailed(Event $event)
    {
        //Email.
        $this->Groups = TableRegistry::get('Groups');
        $group = $this->Groups
            ->find()
            ->where(['id' => $event->data['group_id']])
            ->first();

        if (is_null($group) || (bool)$group->is_staff === false) {
            return true;
        }

        $viewVars = [
            'user_ip' => $event->data['user_ip'],
            'username' => $event->data['username'],
            'user_agent' => $event->data['user_agent'],
            'email' => $event->data['user_email']
        ];

        $this->getMailer('User')->send('login', [$viewVars]);

        return true;
    }
}
