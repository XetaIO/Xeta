<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class ConversationsController extends AppController
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

        $this->Auth->deny();
    }

    /**
     * Display all conversations for the user.
     *
     * @return void
     */
    public function index()
    {
        $this->ConversationsUsers = $this->loadModel('ConversationsUsers');

        $this->paginate = [
            'maxLimit' => 10
        ];
        $conversations = $this->ConversationsUsers
            ->find()
            ->contain([
                'Users',
                'Conversations',
                'Conversations.LastMessage',
                'Conversations.LastMessageUser'
            ])
            ->where([
                'ConversationsUsers.user_id' => $this->request->session()->read('Auth.User.id'),
                'Conversations.conversation_open <>' => 2
            ])
            ->order([
                'ConversationsUsers.is_read' => 'ASC',
                'ConversationsUsers.is_star' => 'DESC',
                'Conversations.last_message_date' => 'DESC',
            ]);

        $conversations = $this->paginate($conversations);

        $this->set(compact('conversations'));
    }

    /**
     * Function to do an action when a user select a/many conversations.
     *
     * Action list :
     *      1 : Conversations Important
     *      2 : Make normal conversation
     *      3 : Exit conversations
     *
     * @return void
     *
     * @throws NotFoundException
     */
    public function action()
    {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $actionAllowed = ['star', 'normal', 'exit'];

        if (!array_key_exists('action', $this->request->data) || !in_array($this->request->data['action'], $actionAllowed)) {
            $json = [];
            $json['error'] = '1';
            $json['message'] = __d('conversations', 'Action unknown.');

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
        }

        if (!array_key_exists('conversations', $this->request->data)) {
            $json = [];
            $json['error'] = '1';
            $json['message'] = __d('conversations', 'You have not chosen any conversations.');

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
        }
    }
}
