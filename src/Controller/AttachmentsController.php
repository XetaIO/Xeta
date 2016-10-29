<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Response;

class AttachmentsController extends AppController
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
     * Download an attachment realated to an article.
     *
     * @throws \Cake\Network\Exception\NotFoundException When it missing an arguments or when the file doesn't exist.
     * @throws \Cake\Network\Exception\ForbiddenException When the user is not premium.
     *
     * @return \Cake\Network\Exception\ForbiddenException
     *         \Cake\Network\Exception\NotFoundException
     *         \Cake\Network\Response
     */
    public function download()
    {
        $this->loadModel('Users');

        $user = $this->Users->find()->where(['id' => $this->request->session()->read('Auth.User.id')])->first();

        if (is_null($user) || !$user->premium) {
            throw new ForbiddenException();
        }

        if (!isset($this->request->type)) {
            throw new NotFoundException();
        }

        switch ($this->request->type) {
            case "blog":
                $this->loadModel('BlogAttachments');

                $attachment = $this->BlogAttachments->get($this->request->id);

                if (!$attachment) {
                    throw new NotFoundException();
                }

                $file = new File($attachment->url);

                if (!$file->exists()) {
                    throw new NotFoundException();
                }

                $this->response->file(
                    $file->path,
                    ['download' => true, 'name' => $attachment->name]
                );

                $this->BlogAttachments->patchEntity($attachment, ['download' => $attachment->download + 1]);
                $this->BlogAttachments->save($attachment);
                break;

            default:
                throw new NotFoundException();
        }

        return $this->response;
    }
}
