<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class SettingsController extends AppController
{

    /**
     * Display all settings.
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'maxLimit' => 20
        ];

        $settings = $this->Settings
            ->find()
            ->contain([
                'LastUpdatedUser' => function ($q) {
                    return $q->find('medium');
                }
            ])
            ->order([
                'Settings.name' => 'ASC'
            ]);

        $settings = $this->paginate($settings);

        $this->set(compact('settings'));
    }

    /**
     * Create a setting.
     *
     * @return \Cake\Network\Response|void
     */
    public function create()
    {
        $setting = $this->Settings->newEntity($this->request->getParsedBody());

        if ($this->request->is('post')) {
            $setting->last_updated_user_id = $this->Auth->user('id');

            if ($this->Settings->save($setting)) {
                Cache::delete('settings', 'database');
                $this->Flash->success(__d('admin', 'This setting has been created successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('setting'));
    }

    /**
     * Edit a setting.
     *
     * @return \Cake\Network\Response|void
     */
    public function edit()
    {
        $setting = $this->Settings
            ->find()
            ->where([
                'Settings.id' => $this->request->id
            ])
            ->first();

        if (is_null($setting)) {
            $this->Flash->error(__d('admin', 'This setting doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            $this->Settings->patchEntity($setting, $this->request->getParsedBody());

            $setting->last_updated_user_id = $this->Auth->user('id');

            if ($this->Settings->save($setting)) {
                Cache::delete('settings', 'database');
                $this->Flash->success(__d('admin', 'This setting has been edited successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('setting'));
    }

    /**
     * Delete a setting.
     *
     * @return \Cake\Network\Response|void
     */
    public function delete()
    {
        $setting = $this->Settings
            ->find()
            ->where([
                'Settings.id' => $this->request->id
            ])
            ->first();

        if (is_null($setting)) {
            $this->Flash->error(__d('admin', 'This setting doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Settings->delete($setting)) {
            $this->Flash->success(__d('admin', 'This setting has been deleted successfully !'));

            return $this->redirect(['action' => 'index']);
        }

        return $this->redirect(['action' => 'index']);
    }
}
