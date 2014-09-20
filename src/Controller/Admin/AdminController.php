<?php

namespace App\Controller\Admin;


use App\Controller\AppController;
use Cake\Error\NotFoundException;
use Cake\Event\Event;

class AdminController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if(!$this->Auth->user() || $this->Auth->user('role') != 'admin')
        {
            throw new NotFoundException;
        }

        $this->layout = 'admin';
    }

    public function home()
    {
        $this->loadModel('BlogArticles');

        $Articles = $this->BlogArticles->find('all')->toArray();

        //debug($Articles);
    }
} 
