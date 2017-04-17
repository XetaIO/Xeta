<?php
namespace App\Event;

use App\Event\Logs;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
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
     * An staff user failed to login. Send a mail to the user.
     *
     * @param Event $event The event that was fired.
     *
     * @return bool
     */
    public function usersLoginFailed(Event $event)
    {
        //Logs Event.
        EventManager::instance()->attach(new Logs());
        $logs = new Event('Log.User', $this, [
            'user_id' => $event->getData('user_id'),
            'username' => $event->getData('username'),
            'user_ip' => $event->getData('user_ip'),
            'user_agent' => $event->getData('user_agent'),
            'action' => 'user.connection.manual.failed'
        ]);
        EventManager::instance()->dispatch($logs);

        //Email.
        $this->Groups = TableRegistry::get('Groups');
        $group = $this->Groups
            ->find()
            ->where(['Groups.id' => $event->getData('group_id')])
            ->first();

        if (is_null($group) || (bool)$group->is_staff === false) {
            return true;
        }

        $viewVars = [
            'user_ip' => $event->getData('user_ip'),
            'username' => $event->getData('username'),
            'user_agent' => $event->getData('user_agent'),
            'email' => $event->getData('user_email')
        ];

        $this->getMailer('User')->send('login', [$viewVars]);

        return true;
    }
}
