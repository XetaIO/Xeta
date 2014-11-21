<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Number;
use Cake\Log\Log;
use Cake\Network\Response;

class PremiumController extends AppController {

/**
 * BeforeFilter handle.
 *
 * @param Event $event The beforeFilter event that was fired.
 *
 * @return void
 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow(['index', 'notify']);
	}

/**
 * Download an attachment realated to an article.
 *
 * @return \Cake\Network\Response
 */
	public function index() {
		$this->loadModel('Users');
		$this->loadModel('PremiumOffers');

		$user = null;

		if ($this->request->session()->read('Auth.User.id')) {
			$user = $this->Users->get($this->request->session()->read('Auth.User.id'));
		}

		$offers = $this->PremiumOffers->find('offers');

		$this->set(compact('offers', 'user'));
	}

/**
 * Subscribe to a Premium offer.
 *
 * @return \Cake\Network\Response
 */
	public function subscribe() {
		$this->loadComponent('Transaction');
		$this->loadModel('PremiumOffers');
		$this->loadModel('PremiumDiscounts');

		$offer = $this->PremiumOffers->find('offerByPeriod', [
			'period' => $this->request->data['period']
		]);

		if (!$offer) {
			$this->Flash->error(__("This offer does not exist."));

			$this->redirect(['action' => 'index']);
		}

		//Check the discount code.
		$discountPercentage = null;

		if (!empty($this->request->data['discount'])) {
			$discount = $this->PremiumDiscounts->find('discountByCodeAndOffer', [
				'code' => $this->request->data['discount'],
				'offer_id' => $offer->id
			]);

			if (is_null($discount) || !$this->PremiumDiscounts->isDiscountValid($discount)) {
				$this->Flash->error(__("Your discount code isn't valid or has already been used."));

				$this->redirect(['action' => 'index']);
			} else {
				$discountPercentage = $discount->discount;
			}
		}

		$price = Number::format($offer->price, ['locale' => 'en_US']);
		$tax = Number::format($offer->tax, ['locale' => 'en_US']);
		$custom = [
			'user_id' => $this->request->session()->read('Auth.User.id'),
			'offer_id' => $offer->id,
			'period' => $offer->period,
			'discount_id' => isset($discount) ? $discount->id : null
		];

		$paypalUrl = $this->Transaction->getPaypalUrl(
			$price,
			$tax,
			__n('Premium {0} month', 'Premium {0} months', $offer->period, $offer->period),
			http_build_query($custom),
			$discountPercentage
		);

		if (!$paypalUrl) {
			$this->Flash->error(__("Unable to get the Paypal URL, please contact an administrator or try again later."));

			$this->redirect(['action' => 'index']);
		}

		$this->redirect($paypalUrl);
	}

/**
 * [notify description]
 *
 * @return void
 */
	public function notify() {
		$this->loadComponent('Paypal');

		$this->Paypal->notify();
	}

/**
 * [success description]
 *
 * @return void
 */
	public function success() {
		//Refresh the user Cookies.
	}
}
