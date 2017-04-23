<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Routing\Router;

class AttachmentsController extends AppController
{

    /**
     * Display all attachments.
     *
     * @return \Cake\Network\Response
     */
    public function index()
    {
        $this->loadModel('BlogAttachments');

        $this->paginate = [
            'maxLimit' => 15
        ];

        $attachments = $this->BlogAttachments
            ->find()
            ->contain([
                'BlogArticles' => function ($q) {
                    return $q->select([
                        'id',
                        'title'
                    ]);
                },
                'Users' => function ($q) {
                    return $q->find('short');
                }
            ])
            ->order([
                'BlogArticles.created' => 'desc'
            ]);

        $attachments = $this->paginate($attachments);
        $this->set(compact('attachments'));
    }

    /**
     * Add an attachment to an article.
     *
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
        $this->loadModel('BlogAttachments');
        $this->loadModel('BlogArticles');
        $attachment = $this->BlogAttachments->newEntity($this->request->getParsedBody());

        if ($this->request->is('post')) {
            $article = $this->BlogArticles
                ->find()
                ->contain([
                    'BlogAttachments'
                ])
                ->where([
                    'BlogArticles.id' => $this->request->getData('article_id')
                ])
                ->first();

            //Check if the article has already an attachment
            if (!is_null($article->blog_attachment)) {
                $this->Flash->error(
                    __d(
                        'admin',
                        'This article has already an attachment, you can edit it <a href="{0}" class="btn btn-sm btn-danger">here</a>.',
                        Router::url(['_name' => 'attachments-edit', 'id' => $article->blog_attachment->id])
                    )
                );

                return $this->redirect(['action' => 'index']);
            }

            $attachment->user_id = $this->Auth->user('id');
            $attachment->accessible('url_file', true);

            if ($newAttachment = $this->BlogAttachments->save($attachment)) {
                $file = new File(WWW_ROOT . $newAttachment->url);

                $newAttachment->name = $file->name;
                $newAttachment->extension = '.' . $file->info()['extension'];
                $newAttachment->size = $file->info()['filesize'];

                $this->BlogAttachments->save($newAttachment);

                $this->Flash->success(__d('admin', 'Your attachment has been created successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $articles = $this->BlogAttachments->BlogArticles->find('list');
        $this->set(compact('attachment', 'articles'));
    }

    /**
     * Edit an attachment.
     *
     * @return \Cake\Network\Response|void
     */
    public function edit()
    {
        $this->loadModel('BlogAttachments');
        $this->loadModel('BlogArticles');

        $attachment = $this->BlogAttachments
            ->find()
            ->where([
                'id' => $this->request->getAttribute('params')['id']
            ])
            ->first();

        //Check if the attachment is found.
        if (empty($attachment)) {
            $this->Flash->error(__d('admin', 'This attachment doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['put', 'post'])) {
            $this->BlogAttachments->patchEntity($attachment, $this->request->getParsedBody());

            //Check if the article has already an attachment
            $article = $this->BlogArticles
                ->find()
                ->contain([
                    'BlogAttachments'
                ])
                ->where([
                    'BlogArticles.id' => $this->request->getData('article_id')
                ])
                ->first();

            if (!is_null($article->blog_attachment) && $article->blog_attachment->id != $this->request->id) {
                $this->Flash->error(
                    __d(
                        'admin',
                        'This article has already an attachment, you can edit it <a href="{0}" class="btn btn-sm btn-danger">here</a>.',
                        Router::url(['_name' => 'attachments-edit', 'id' => $article->blog_attachment->id])
                    )
                );

                return $this->redirect(['action' => 'index']);
            }

            $attachment->user_id = $this->Auth->user('id');
            $attachment->accessible('url_file', true);

            if ($editedAttachment = $this->BlogAttachments->save($attachment)) {
                $file = new File(WWW_ROOT . $editedAttachment->url);

                $editedAttachment->name = $file->name;
                $editedAttachment->extension = '.' . $file->info()['extension'];
                $editedAttachment->size = $file->info()['filesize'];

                $this->BlogAttachments->save($editedAttachment);

                $this->Flash->success(__d('admin', 'Your attachment has been edited successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $articles = $this->BlogAttachments->BlogArticles->find('list');
        $this->set(compact('attachment', 'articles'));
    }

    /**
     * Delete an Attachment.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {
        $this->loadModel('BlogAttachments');

        $attachment = $this->BlogAttachments
            ->find()
            ->where([
                'id' => $this->request->getAttribute('params')['id']
            ])
            ->first();

        //Check if the attachment is found.
        if (empty($attachment)) {
            $this->Flash->error(__d('admin', 'This attachment doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->BlogAttachments->delete($attachment)) {
            $this->Flash->success(__d('admin', 'This attachment has been deleted successfully !'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__d('admin', 'Unable to delete this attachment.'));

        return $this->redirect(['action' => 'index']);
    }
}
