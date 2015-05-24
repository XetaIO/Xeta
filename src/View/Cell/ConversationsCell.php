<?php
namespace App\View\Cell;

use Cake\View\Cell;

class ConversationsCell extends Cell
{
    /**
     * Display the sidebar.
     *
     * @return void
     */
    public function sidebar()
    {
        $this->loadModel('ConversationsUsers');
        $this->loadModel('Conversations');

        $id = isset($this->request->id) ? $this->request->id : null;

        $participants = $this->ConversationsUsers
            ->find()
            ->contain([
                'Users' => function ($q) {
                    return $q->find('full');
                },
                'Users.Groups' => function ($q) {
                    return $q->select(['id', 'name', 'css', 'is_staff', 'is_member']);
                }
            ])
            ->where([
                'ConversationsUsers.conversation_id' => $id
            ])
            ->toArray();

        $conversation = $this->Conversations
            ->find()
            ->contain([
                'LastMessageUser'
            ])
            ->where([
                'Conversations.id' => $id
            ])
            ->first();

        //Current user.
        $this->loadModel('Users');
        $currentUser = $this->Users
            ->find()
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->where([
                'Users.id' => $this->request->session()->read('Auth.User.id')
            ])
            ->select(['id', 'group_id'])
            ->first();

        $this->set(compact('conversation', 'participants', 'currentUser'));
    }
}
