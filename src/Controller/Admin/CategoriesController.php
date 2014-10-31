<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

class CategoriesController extends AppController {

/**
 * Display all categories.
 *
 * @return void
 */
	public function index() {
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
 * @return void
 */
	public function add() {
		$this->loadModel('BlogCategories');
		$category = $this->BlogCategories->newEntity($this->request->data);

		if ($this->request->is('post')) {

			if ($this->BlogCategories->save($category)) {

				$this->Flash->success(__("The category has been created successfully !"));

				return $this->redirect(['action' => 'index']);
			}
		}

		$this->set(compact('category'));
	}

/**
 * Edit a category.
 *
 * @return void
 */
	public function edit() {
		$this->loadModel('BlogCategories');

		$category = $this->BlogCategories
			->find('slug', [
				'slug' => $this->request->slug,
				'slugField' => 'BlogCategories.slug'
			])
			->first();

		//Check if the category is found.
		if (empty($category)) {
			$this->Flash->error(__('This category doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		if ($this->request->is('put')) {
			$this->BlogCategories->patchEntity($category, $this->request->data());

			if ($this->BlogCategories->save($category)) {

				$this->Flash->success(__("This category has been updated successfully !"));

				return $this->redirect(['action' => 'index']);
			}
		}

		$this->set(compact('category'));
	}

/**
 * Delete a category and all his comments and likes.
 *
 * @return void
 */
	public function delete() {
		$this->loadModel('BlogCategories');

		$category = $this->BlogCategories
			->find('slug', [
				'slug' => $this->request->slug,
				'slugField' => 'BlogCategories.slug'
			])
			->first();

		//Check if the category is found.
		if (empty($category)) {
			$this->Flash->error(__('This category doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		//Check if the category has one article or more
		if ($category->article_count >= 1) {
			$this->Flash->error(__('You can not deleted this category because one article or more is assigned to this category.'));

			return $this->redirect(['action' => 'index']);
		}

		if ($this->BlogCategories->delete($category)) {

			$this->Flash->success(__("This category has been deleted successfully !"));

			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->error(__("Unable to delete this category."));

		return $this->redirect(['action' => 'index']);
	}
}
