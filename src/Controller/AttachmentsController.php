<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Error\ForbiddenException;
use Cake\Error\NotFoundException;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Network\Response;

class AttachmentsController extends AppController {

/**
 * BeforeFilter handle.
 *
 * @param Event $event The beforeFilter event that was fired.
 *
 * @return void
 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

/**
 * Download an attachment realated to an article.
 *
 * @throws \Cake\Error\NotFoundException When it missing an arguments or when the file doesn't exist.
 * @throws \Cake\Error\ForbiddenException When the user is not premium.
 *
 * @return \Cake\Error\ForbiddenException
 *         \Cake\Error\NotFoundException
 *         \Cake\Network\Response
 */
	public function download() {
		$this->loadModel('Users');

		$user = $this->Users->get($this->request->session()->read('Auth.User.id'));

		if (!$user->premium) {
			throw new ForbiddenException();
		}

		if (!isset($this->request->type)) {
			throw new NotFoundException();
		}

		switch($this->request->type) {
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
