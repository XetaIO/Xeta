<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\I18n;

class CategoriesController extends AppController
{

    /**
     * Display all categories.
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('BlogCategories');

        $this->paginate = [
            'maxLimit' => 15
        ];

        $categories = $this->BlogCategories
            ->find()
            ->order([
                'created' => 'desc'
            ]);

        $categories = $this->paginate($categories);
        $this->set(compact('categories'));
    }

    /**
     * Add a category.
     *
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
        $this->loadModel('BlogCategories');

        $this->BlogCategories->locale(I18n::defaultLocale());
        $category = $this->BlogCategories->newEntity($this->request->getParsedBody());

        if ($this->request->is('post')) {
            $category->setTranslations($this->request->getParsedBody());

            if ($this->BlogCategories->save($category)) {
                $this->Flash->success(__d('admin', 'The category has been created successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('category'));
    }

    /**
     * Edit a category.
     *
     * @return \Cake\Network\Response|void
     */
    public function edit()
    {
        $this->loadModel('BlogCategories');

        $this->BlogCategories->locale(I18n::defaultLocale());
        $category = $this->BlogCategories
            ->find('translations')
            ->where([
                'BlogCategories.id' => $this->request->id
            ])
            ->first();

        //Check if the category is found.
        if (empty($category)) {
            $this->Flash->error(__d('admin', 'This category doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('put')) {
            $this->BlogCategories->patchEntity($category, $this->request->getParsedBody());
            $category->setTranslations($this->request->getParsedBody());

            if ($this->BlogCategories->save($category)) {
                $this->Flash->success(__d('admin', 'This category has been updated successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('category'));
    }

    /**
     * Delete a category and all his comments and likes.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {
        $this->loadModel('BlogCategories');

        $category = $this->BlogCategories
            ->find()
            ->where([
                'BlogCategories.id' => $this->request->id
            ])
            ->first();

        //Check if the category is found.
        if (empty($category)) {
            $this->Flash->error(__d('admin', 'This category doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        //Check if the category has one article or more
        if ($category->article_count >= 1) {
            $this->Flash->error(__d('admin', 'You can not deleted this category because one article or more is assigned to this category.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->BlogCategories->delete($category)) {
            $this->Flash->success(__d('admin', 'This category has been deleted successfully !'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__d('admin', 'Unable to delete this category.'));

        return $this->redirect(['action' => 'index']);
    }
}
