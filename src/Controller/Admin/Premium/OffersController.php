<?php
namespace App\Controller\Admin\Premium;

use App\Controller\AppController;

class OffersController extends AppController {

/**
 * Display all offers.
 *
 * @return \Cake\Network\Response
 */
	public function index() {
		$this->loadModel('PremiumOffers');

		$offers = $this->PremiumOffers
			->find('all')
			->contain([
				'Users' => function ($q) {
					return $q->find('short');
				}
			]);

		$offers = $this->paginate($offers);

		$this->set(compact('offers'));
	}

/**
 * Add an offer.
 *
 * @return \Cake\Network\Response
 */
	public function add() {
		$this->loadModel('PremiumOffers');
		$offer = $this->PremiumOffers->newEntity($this->request->data);

		if ($this->request->is('post')) {
			$offer->user_id = $this->Auth->user('id');

			if ($this->PremiumOffers->save($offer)) {

				$this->Flash->success(__d('admin', 'Your offer has been created successfully !'));

				return $this->redirect(['action' => 'index']);
			}
		}

		$this->set(compact('offer'));
	}

/**
 * Edit an Offer.
 *
 * @return \Cake\Network\Response|void
 */
	public function edit() {
		$this->loadModel('PremiumOffers');

		$offer = $this->PremiumOffers
			->find()
			->where([
				'PremiumOffers.id' => $this->request->id
			])
			->contain([
				'Users' => function ($q) {
					return $q->find('short');
				}
			])
			->first();

		//Check if the offer is found.
		if (empty($offer)) {
			$this->Flash->error(__d('admin', 'This offer doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		if ($this->request->is('put')) {
			$this->PremiumOffers->patchEntity($offer, $this->request->data());

			if ($this->PremiumOffers->save($offer)) {

				$this->Flash->success(__d('admin', 'This offer has been updated successfully !'));

				return $this->redirect(['action' => 'index']);
			}
		}

		$this->set(compact('offer'));
	}

/**
 * Delete an Offer.
 *
 * @return \Cake\Network\Response
 */
	public function delete() {
		$this->loadModel('PremiumOffers');

		$offer = $this->PremiumOffers
			->find()
			->where([
				'id' => $this->request->id
			])
			->first();

		//Check if the offer is found.
		if (empty($offer)) {
			$this->Flash->error(__d('admin', 'This offer doesn\'t exist or has been deleted.'));

			return $this->redirect(['action' => 'index']);
		}

		if ($this->PremiumOffers->delete($offer)) {

			$this->Flash->success(__d('admin', 'This offer has been deleted successfully !'));

			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->error(__d('admin', 'Unable to delete this offer.'));

		return $this->redirect(['action' => 'index']);
	}
}
