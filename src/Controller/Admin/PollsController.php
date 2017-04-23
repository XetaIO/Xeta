<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Routing\Router;

class PollsController extends AppController
{
    /**
     * Display all Polls.
     *
     * @return \Cake\Network\Response
     */
    public function index()
    {
        $this->loadModel('Polls');

        $this->paginate = [
            'maxLimit' => 15
        ];

        $polls = $this->Polls
            ->find()
            ->contain([
                'Users' => function ($q) {
                    return $q->find('short');
                },
                'PollsAnswers',
                'BlogArticles'
            ])
            ->order([
                'Polls.created' => 'desc'
            ]);

        $polls = $this->paginate($polls);
        $this->set(compact('polls'));
    }

    /**
     * Create a Poll.
     *
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
        $this->loadModel('BlogArticles');
        $this->loadModel('Polls');

        $poll = $this->Polls->newEntity($this->request->getParsedBody());
        $articles = $this->Polls->BlogArticles->find('list');

        if ($this->request->is('post')) {
            $article = $this->BlogArticles
                ->find()
                ->contain([
                    'Polls'
                ])
                ->where([
                    'BlogArticles.id' => $poll->article_id
                ])
                ->first();

            //Check if the article has already a poll
            if (!is_null($article->poll)) {
                $this->Flash->error(
                    __d(
                        'admin',
                        'This article has already a poll, you can edit it <a href="{0}" class="btn btn-sm btn-danger-outline">here</a>.',
                        Router::url(['_name' => 'polls-edit', 'id' => $article->poll->id, 'slug' => $article->poll->name])
                    )
                );

                return $this->redirect(['action' => 'index']);
            }

            $pollAnswers = [];

            foreach ($poll->answers as $answers => $answer) {
                $answer = trim($answer);

                if (!empty($answer)) {
                    $entity = $this->Polls->PollsAnswers->newEntity();
                    $entity->response = $answer;
                    array_push($pollAnswers, $entity);
                }
            }

            if (empty($pollAnswers)) {
                $this->Flash->error(__d('admin', 'You must add at least one answer for this poll.'));
                $this->set(compact('poll', 'articles'));

                return;
            }
            $poll->user_id = $this->Auth->user('id');
            $poll->polls_answers = $pollAnswers;
            $poll->unsetProperty('anwsers');

            if ($poll = $this->Polls->save($poll)) {
                $this->Flash->success(__d('admin', 'Your poll has been created successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('poll', 'articles'));
    }

    /**
     * Edit a Poll.
     *
     * @return \Cake\Network\Response
     */
    public function edit()
    {
        $this->loadModel('Polls');
        $this->loadModel('BlogArticles');

        $poll = $this->Polls
            ->find()
            ->contain([
                'PollsAnswers'
            ])
            ->where([
                'id' => $this->request->getAttribute('params')['id']
            ])
            ->first();

        //Check if the poll is found.
        if (empty($poll)) {
            $this->Flash->error(__d('admin', 'This poll doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['put', 'post'])) {
            $this->Polls->patchEntity($poll, $this->request->getParsedBody());
            $articles = $this->Polls->BlogArticles->find('list');

            $article = $this->BlogArticles
                ->find()
                ->contain([
                    'Polls'
                ])
                ->where([
                    'BlogArticles.id' => $poll->article_id
                ])
                ->first();

            //Check if the article has already a poll
            if (!is_null($article->poll) && $article->poll->id != $this->request->getAttribute('params')['id']) {
                $this->Flash->error(
                    __d(
                        'admin',
                        'This article has already a poll, you can edit it <a href="{0}" class="btn btn-sm btn-danger-outline">here</a>.',
                        Router::url(['_name' => 'polls-edit', 'id' => $article->poll->id, 'slug' => $article->poll->name])
                    )
                );

                return $this->redirect(['action' => 'index']);
            }

            $poll->polls_answers = [];

            foreach ($poll->answers as $answers => $answer) {
                $answer = trim($answer);

                if (!empty($answer)) {
                    $entity = $this->Polls->PollsAnswers->newEntity();
                    $entity->response = $answer;
                    array_push($poll->polls_answers, $entity);
                }
            }

            if (empty($poll->polls_answers)) {
                $this->Flash->error(__d('admin', 'You must add at least one answer for this poll.'));
                $this->set(compact('poll', 'articles'));

                return;
            }

            $poll->user_id = $this->Auth->user('id');
            $poll->unsetProperty('anwsers');

            if ($poll = $this->Polls->save($poll)) {
                $this->Flash->success(__d('admin', 'Your poll has been edited successfully !'));
            } else {
                $this->Flash->error(__d('admin', 'An error occurred while editing the poll.'));
            }

            return $this->redirect(['action' => 'index']);
        }

        $articles = $this->Polls->BlogArticles->find('list');
        $this->set(compact('poll', 'articles'));
    }

    /**
     * Delete a Poll.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {
        $this->loadModel('Polls');

        $poll = $this->Polls
            ->find()
            ->where([
                'id' => $this->request->getAttribute('params')['id']
            ])
            ->first();

        //Check if the poll is found.
        if (empty($poll)) {
            $this->Flash->error(__d('admin', 'This poll doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Polls->delete($poll)) {
            $this->Flash->success(__d('admin', 'This poll has been deleted successfully !'));
        } else {
            $this->Flash->error(__d('admin', 'Unable to delete this poll.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
