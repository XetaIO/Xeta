<?php
namespace App\Controller;

use Cake\Event\Event;

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
     * Display all conversations for the users.
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
                'ConversationsUsers.important' => 'DESC',
                'Conversations.last_message_date' => 'DESC',
            ]);

        $conversations = $this->paginate($conversations);

        $this->set(compact('conversations'));
    }
}
