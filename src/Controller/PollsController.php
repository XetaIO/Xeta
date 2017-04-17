<?php
namespace App\Controller;

use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;

class PollsController extends AppController
{

    /**
     * An user vote to a poll.
     *
     * @return \Cake\Network\Exception\NotFoundException|\Cake\Network\Response
     */
    public function vote()
    {
        if (!$this->request->is('post') || is_null($this->request->getData('answer_id'))) {
            throw new NotFoundException();
        }

        $this->loadModel('PollsAnswers');
        $answer = $this->PollsAnswers
            ->find()
            ->contain([
                'Polls'
            ])
            ->where([
                'PollsAnswers.id' => $this->request->getData('answer_id'),
                'Polls.article_id' => $this->request->id
            ])
            ->first();

        if (is_null($answer)) {
            $this->Flash->error(__('This answer doesn\'t exist.'));

            return $this->redirect($this->referer());
        }

        if ($answer->poll->is_timed == true && $answer->poll->end_date < new Time()) {
            $this->Flash->error(__('This poll is expired, you can not vote anymore.'));

            return $this->redirect($this->referer());
        }

        $this->loadModel('PollsUsers');
        $hasVoted = $this->PollsUsers
            ->find()
            ->contain([
                'PollsAnswers'
            ])
            ->where([
                'PollsUsers.poll_id' => $answer->poll->id,
                'PollsUsers.user_id' => $this->Auth->user('id')
            ])
            ->first();

        if (!is_null($hasVoted)) {
            $this->Flash->error(__('You have already voted for this poll ! (You voted <strong>{0}</strong>).', h($hasVoted->polls_answer->response)));

            return $this->redirect($this->referer());
        }

        $this->request = $this->request
            ->withData('poll_id', $answer->poll->id)
            ->withData('user_id', $this->Auth->user('id'));
        $user = $this->PollsUsers->newEntity($this->request->getParsedBody());

        if ($this->PollsUsers->save($user)) {
            $this->Flash->success(__('Your have successfully voted for this poll ! (You voted <strong>{0}</strong>).', h($answer->response)));

            return $this->redirect($this->referer());
        }

        $this->Flash->error(__('An error occured while saving the vote !'));

        return $this->redirect($this->referer());
    }
}
