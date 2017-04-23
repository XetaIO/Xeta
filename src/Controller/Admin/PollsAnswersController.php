<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

class PollsAnswersController extends AppController
{
    /**
     * Delete an answer from a poll.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {
        $this->loadModel('PollsAnswers');

        $answer = $this->PollsAnswers
            ->find()
            ->where([
                'id' => $this->request->getAttribute('params')['id']
            ])
            ->first();

        //Check if the answer is found.
        if (empty($answer)) {
            $this->Flash->error(__d('admin', 'This answer doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->PollsAnswers->delete($answer)) {
            $this->Flash->success(__d('admin', 'This answer has been deleted successfully.'));
        } else {
             $this->Flash->error(__d('admin', 'An error occured while deleting this answers.'));
        }

        return $this->redirect($this->referer());
    }
}
