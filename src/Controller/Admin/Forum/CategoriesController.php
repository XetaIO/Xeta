<?php
namespace App\Controller\Admin\Forum;

use App\Controller\AppController;

class CategoriesController extends AppController
{

    /**
     * Display all categories.
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('ForumCategories');
        $categories = $this->ForumCategories
            ->find('treeList', [
                'spacer' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
            ])
            ->toArray();

        $this->set(compact('categories'));
    }

    /**
     * Add a category.
     *
     * @return \Cake\Network\Response
     */
    public function add()
    {
        $this->loadModel('ForumCategories');
        $category = $this->ForumCategories->newEntity($this->request->data, ['validate' => 'create']);

        if ($this->request->is('post')) {
            if ($category->parent_id === 0) {
                $category->parent_id = null;
            }

            if ($this->ForumCategories->save($category)) {
                $this->Flash->success(__d('admin', 'Your category has been created successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        //Categories list.
        $categories = $this->ForumCategories
            ->find('treeList', [
                'spacer' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
            ])
            ->toArray();

        //Add the Root category.
        $categories = [0 => __d('admin', 'Root')] + $categories;

        //Apply a map fonction to add a correct indentation for the categories.
        $map = function ($value) {
            if ($value !== __d('admin', 'Root')) {
                return '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $value;
            }
            return $value;
        };
        $categories = array_map($map, $categories);

        $this->set(compact('category', 'categories'));
    }

    /**
     * Move up a category.
     *
     * @return \Cake\Network\Response
     */
    public function moveUp()
    {
        $this->loadModel('ForumCategories');
        $category = $this->ForumCategories
            ->find()
            ->where([
                'ForumCategories.id' => $this->request->id
            ])
            ->first();

        if (empty($category)) {
            $this->Flash->error(__d('admin', 'This category doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->ForumCategories->moveUp($category);

        $this->redirect($this->referer());
    }

    /**
     * Move down a category.
     *
     * @return \Cake\Network\Response
     */
    public function moveDown()
    {
        $this->loadModel('ForumCategories');
        $category = $this->ForumCategories
            ->find()
            ->where([
                'ForumCategories.id' => $this->request->id
            ])
            ->first();

        if (empty($category)) {
            $this->Flash->error(__d('admin', 'This category doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->ForumCategories->moveDown($category);

        $this->redirect($this->referer());
    }

    /**
     * Edit a category.
     *
     * @return \Cake\Network\Response
     */
    public function edit()
    {
        $this->loadModel('ForumCategories');
        $category = $this->ForumCategories
            ->find()
            ->where([
                'ForumCategories.id' => $this->request->id
            ])
            ->first();

        if (empty($category)) {
            $this->Flash->error(__d('admin', 'This category doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('put')) {
            $this->ForumCategories->patchEntity($category, $this->request->data());

            if ($category->parent_id === 0) {
                $category->parent_id = null;
            }

            if ($this->ForumCategories->save($category)) {
                $this->Flash->success(__d('admin', 'This category has been updated successfully !'));

                return $this->redirect(['action' => 'index']);
            }
        }

        //Categories list.
        $categories = $this->ForumCategories
            ->find('treeList', [
                'spacer' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                'keyPath' => 'id'
            ])
            ->toArray();

        //Add the Root category.
        $categories = [0 => __d('admin', 'Root')] + $categories;

        //Apply a map fonction to add a correct indentation for the categories.
        $map = function ($value) {
            if ($value !== __d('admin', 'Root')) {
                return '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $value;
            }
            return $value;
        };
        $categories = array_map($map, $categories);

        $this->set(compact('category', 'categories'));
    }

    /**
     * Delete a category.
     *
     * @return \Cake\Network\Response
     */
    public function delete()
    {
        $this->loadModel('ForumCategories');
        $category = $this->ForumCategories
            ->find()
            ->where([
                'ForumCategories.id' => $this->request->id
            ])
            ->first();

        if (empty($category)) {
            $this->Flash->error(__d('admin', 'This category doesn\'t exist or has been deleted.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('ForumThreads');
        $threads = $this->ForumThreads
            ->find()
            ->where([
                'ForumThreads.category_id' => $category->id
            ])
            ->count();

        if ($threads > 0) {
            $this->Flash->error(__d('admin', 'This category is not empty, you must delete/transfer all the threads assigned to this category before to delete it.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->ForumCategories->delete($category)) {
            $this->Flash->success(__d('admin', 'This category has been delete successfully !'));

            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__d('admin', 'There was an error while deleting this category.'));

            return $this->redirect(['action' => 'index']);
        }
    }
}
