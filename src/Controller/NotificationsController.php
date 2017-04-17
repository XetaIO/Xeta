<?php
namespace App\Controller;

use Cake\Network\Exception\NotFoundException;

class NotificationsController extends AppController
{

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
    }

    /**
     * Mark a notification as readed.
     *
     * @return void|\Cake\Network\Response
     */
    public function markAsRead()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $this->Notifications = $this->loadModel('Notifications');

        $json = [
            'error' => false
        ];

        $notification = $this->Notifications
            ->find()
            ->where([
                'id' => $this->request->getData('id')
            ])
            ->first();

        //If the notification doesn't exist or if the owner of the
        //notification is not the current user, return an error.
        if (is_null($notification) || $notification->user_id != $this->Auth->user('id')) {
            $json['error'] = true;

            $this->set(compact('json'));

            $this->set('_serialize', 'json');

            return;
        }

        if ($notification->is_read) {
            $this->set(compact('json'));
            $this->set('_serialize', 'json');

            return;
        }

        $notification->is_read = 1;
        $this->Notifications->save($notification);

        $this->set(compact('json'));
        $this->set('_serialize', ['json']);
    }
}
