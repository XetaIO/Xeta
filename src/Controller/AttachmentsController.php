<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Filesystem\File;
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
     *
     * @return \Cake\Network\Exception\NotFoundException
     *         \Cake\Network\Response
     */
    public function download()
    {
        $this->loadModel('Users');
        $user = $this->Users
            ->find()
            ->where([
                'Users.id' => $this->Auth->user('id')
            ])
            ->contain([
                'Groups' => function ($q) {
                    return $q->select(['id', 'is_staff']);
                }
            ])
            ->first();

        if (!isset($this->request->type) || is_null($user)) {
            throw new NotFoundException();
        }

        // To add a new case, you must add it to the route regex :
        // See config/Routes/base.php#L125
        switch (strtolower($this->request->type)) {
            case "blog":
                $this->loadModel('BlogAttachments');
                $attachment = $this->BlogAttachments->get($this->request->id);

                $file = new File($attachment->url);

                if (!$file->exists()) {
                    throw new NotFoundException();
                }

                $this->BlogAttachments->patchEntity($attachment, ['download' => $attachment->download + 1]);
                $this->BlogAttachments->save($attachment);

                return $this->response->withFile(
                    $file->path,
                    ['download' => true, 'name' => $attachment->name]
                );
        }

        return $this->response;
    }
}
