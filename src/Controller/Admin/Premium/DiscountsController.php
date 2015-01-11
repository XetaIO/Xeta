<?php
namespace App\Controller\Admin\Premium;

use App\Controller\AppController;

class DiscountsController extends AppController {

/**
 * Display all discounts.
 *
 * @return \Cake\Network\Response
 */
	public function index() {
		$this->loadModel('PremiumDiscounts');

		$discounts = $this->PremiumDiscounts
		->find('all')
		->contain([
			'PremiumOffers',
			'Users' => function ($q) {
				return $q->find('short');
			}
		]);

		$discounts = $this->paginate($discounts);

		$this->set(compact('discounts'));
	}

/**
 * Add a discount.
 *
 * @return \Cake\Network\Response
 */
	public function add() {
		$this->loadModel('PremiumDiscounts');
		$discount = $this->PremiumDiscounts->newEntity($this->request->data);

		if ($this->request->is('post')) {
			$discount->user_id = $this->Auth->user('id');

			if ($this->PremiumDiscounts->save($discount)) {

				$this->Flash->success(__d('admin', 'Your discount has been created successfully !'));

				return $this->redirect(['action' => 'index']);
			}
		}

		$offers = $this->PremiumDiscounts->PremiumOffers->find('list', [
			'valueField' => 'price'
		]);

		$this->set(compact('discount', 'offers'));
	}

/**
 * Edit a discount.
 *
 * @return \Cake\Network\Response
 */
	public function edit() {
		$this->loadModel('PremiumDiscounts');

		$discount = $this->PremiumDiscounts
			->find()
			->where([
				'PremiumDiscounts.id' => $this->request->id
			])
			->contain([
				'Users' => function ($q) {
					return $q->find('short');
				}
			])
			->first();

		//Check if the discount is found.
		if (empty($discount)) {
			$this->Flash->error(__d('admin', 'This discount doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		if ($this->request->is('put')) {
			$this->PremiumDiscounts->patchEntity($discount, $this->request->data());

			if ($this->PremiumDiscounts->save($discount)) {

				$this->Flash->success(__d('admin', 'This discount has been updated successfully !'));

				return $this->redirect(['action' => 'index']);
			}
		}

		$offers = $this->PremiumDiscounts->PremiumOffers->find('list', [
			'valueField' => 'price'
		]);

		$this->set(compact('discount', 'offers'));
	}
}
