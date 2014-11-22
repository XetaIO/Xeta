<?php
namespace App\Controller\Component;

use App\Event\Badges;
use App\Utility\Arrayor;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\I18n\Number;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\Network\Request;
use Cake\ORM\Entity;
use Cake\Routing\Router;

class PaypalComponent extends Component {

/**
 * Sandbox prefix.
 */
	const SANDBOX = 'sandbox.';

/**
 * Request object.
 *
 * @var \Cake\Network\Request
 */
	protected $_request;

/**
 * Controller object.
 *
 * @var \Cake\Controller\Controller
 */
	protected $_controller;

/**
 * Action of the payment.
 *
 * @var string
 */
	protected $_action = 'new';

/**
 * Initialize properties.
 *
 * @param array $config The config data.
 *
 * @return void
 */
	public function initialize(array $config) {
		$this->_controller = $this->_registry->getController();
		$this->_request = $this->_controller->request;
	}

/**
 * [notify description]
 *
 * @return void
 */
	public function notify() {
		$response = $this->_sendResponse();

		if (!$response) {
			return false;
		}

		$this->_request->data = Arrayor::camelizeIndex($this->_request->data);

		extract($this->_request->data);

		parse_str($custom, $custom);

		if (strcmp($response, "VERIFIED") == 0) {

			if ($paymentStatus == "Completed") {

				if (!$this->_isTransactionNew($txnId)) {
					Log::error(__('The txn {0} has already been used.', $txnId), 'paypal');

					return false;
				}

				if (!$this->_isEmailValid($receiverEmail)) {
					Log::error(__('The Email {0} is not the same as the config Email {0}.', $receiverEmail, Configure::read('Paypal.mail')), 'paypal');

					return false;
				}

				if (!$this->_isPriceValid($custom, $mcGross, $tax, $discount)) {
					Log::error(__('The price does not match with the offer price.'), 'paypal');

					return false;
				}

				if (!$this->_isCurrencyValid($custom, $mcCurrency)) {
					Log::error(__('The currency offer does not match with the Paypal currency.'), 'paypal');

					return false;
				}

				if (!$this->_isDiscountValid($custom, $mcGross, $tax, $discount)) {
					Log::error(__('The discount offer does not match with the Paypal discount.'), 'paypal');

					return false;
				}

				//We update the end subscription date of the user.
				$user = $this->_updateUser($custom);

				if (!$user) {
					Log::error(__('Error to update the user.'), 'paypal');

					return false;
				}

				$custom['discount_id'] = isset($custom['discount_id']) ? $custom['discount_id'] : null;

				//We save the transaction.
				$transaction = $this->_insertTransaction($custom, $mcGross, $tax, $txnId,
					$firstName . ' ' . $lastName, $addressCountry, $addressCity, $addressStreet);

				//We save the premium Badge.
				EventManager::instance()->attach(new Badges($this->_controller));

				$premium = new Event('Model.Users.premium', $this->_controller, [
					'user' => $user
				]);
				EventManager::instance()->dispatch($premium);

				return true;
			} else {
				// Statut de paiement: Echec
				Log::error(__('Status Payment invalid : {0}', $paymentStatus), 'paypal');
				return false;
			}

		} elseif (strcmp($response, "INVALID") == 0) {
			Log::error(__('Response INVALID.'), 'paypal');
			return false;
		}
	}

/**
 * Update the end subscription date of the user.
 *
 * @param array $custom The custom data passed to Paypal.
 *
 * @return bool|\Cake\Model\Entity\User
 */
	protected function _updateUser(array $custom) {
		$this->_controller->loadModel('Users');

		$user = $this->_controller->Users->find()->where(['id' => $custom['user_id']])->first();

		if (!$user) {
			Log::error(__('This user does not exist.'), 'paypal');

			return false;
		}

		if ($user->premium) {
			$this->_action = 'extend';
			$end = $user->end_subscription;
			$date = new Time($end);
		} else {
			$date = new Time();
		}

		$date->addMonths($custom['period']);

		$data = [
			'end_subscription' => $date
		];

		$this->_controller->Users->patchEntity($user, $data);
		if ($this->_controller->Users->save($user)) {
			return $user;
		}

		return false;
	}

/**
 * Insert the transaction in the database.
 *
 * @param array $custom 	The customs fields passed to Paypal.
 * @param float $price 		The amount paid by the buyer.
 * @param float $tax 		The tax paid by the buyer.
 * @param string $txn 		The transaction ID.
 * @param string $name 		The fullname of the buyer.
 * @param string $country 	The country of the buyer.
 * @param string $city 		The city of the buyer.
 * @param string $address 	The address of the buyer.
 *
 * @return bool
 */
	protected function _insertTransaction(array $custom, $price, $tax, $txn, $name, $country, $city, $address) {
		$this->_controller->loadModel('PremiumTransactions');

		$data = [
			'user_id' => $custom['user_id'],
			'premium_offer_id' => $custom['offer_id'],
			'premium_discount_id' => $custom['discount_id'],
			'price' => $price,
			'tax' => $tax,
			'txn' => $txn,
			'action' => $this->_action,
			'period' => $custom['period'],
			'name' => $name,
			'country' => $country,
			'city' => $city,
			'address' => $address
		];

		$data = $this->_controller->PremiumTransactions->newEntity($data);

		if ($this->_controller->PremiumTransactions->save($data)) {
			return true;
		}

		return false;
	}

/**
 * Send the response to Paypal.
 *
 * @return bool|string
 */
	protected function _sendResponse() {
		$this->_request->data['cmd'] = '_notify-validate';

		$request = http_build_query($this->_request->data);

		$sandbox = Configure::read('Paypal.sandbox') ? self::SANDBOX : '';

		$curlOptions = [
			CURLOPT_URL => "https://www." . $sandbox . "paypal.com/cgi-bin/webscr",
			CURLOPT_POST => 1,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => $request,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_CONNECTTIMEOUT => 30
		];

		$ch = curl_init();

		if ($ch == false) {
			Log::error(__('Failed to initialize cURL : {0}', $ch), 'paypal');

			return false;
		}

		curl_setopt_array($ch, $curlOptions);
		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			curl_close($ch);
			Log::error(__('cURL falied to get the Paypal URL Button : {0}', $response), 'paypal');

			return false;
		} else {
			curl_close($ch);

			unset($this->_request->data['cmd']);
			return $response;
		}
	}

/**
 * Check if the txn is new or has already been used.
 *
 * @param string $txn The txn to check.
 *
 * @return bool
 */
	protected function _isTransactionNew($txn) {
		$this->_controller->loadModel('PremiumTransactions');

		$transaction = $this->_controller->PremiumTransactions->find('transactionByTxn', [
			'txn' => $txn
		]);
		Log::debug($transaction, 'paypal');
		if (!$transaction) {
			return true;
		}

		return false;
	}

/**
 * Check if the receiver email is the same as the email setup in the configuration.
 *
 * @param string $receiverEmail The Email to check.
 *
 * @return bool
 */
	protected function _isEmailValid($receiverEmail) {
		return Configure::read('Paypal.mail') == $receiverEmail;
	}

/**
 * Check if the price match with the offer price.
 *
 * @param array $custom The custom data passed to Paypal.
 * @param float $mcGross Price paid by the buyer.
 * @param float $tax The tax added to the price.
 * @param float $discount The discount applied to the price without taxes.
 *
 * @return bool
 */
	protected function _isPriceValid(array $custom, $mcGross, $tax, $discount) {
		$this->_controller->loadModel('PremiumOffers');

		$offer = $this->_controller->PremiumOffers->find('offerByIdAndPeriod', [
			'id' => $custom['offer_id'],
			'period' => $custom['period']
		]);

		if (!$offer) {
			Log::error(__('Unable to get the offer with the ID {0} and the period {1}.', $custom['offer_id'], $custom['period']), 'paypal');

			return false;
		}

		$total = Number::format(($mcGross - $tax) + $discount, ['precision' => 2, 'locale' => 'en_US']);

		$offer->price = Number::format($offer->price, ['precision' => 2, 'locale' => 'en_US']);

		if ($offer->price != floatval($total)) {
			Log::error(__('The price of the offer {0} is not the same as the Paypal price {1}.', $offer->price, $total), 'paypal');

			return false;
		}

		return true;
	}

/**
 * Check if the discount is valid.
 *
 * @param array $custom The custom data passed to Paypal.
 * @param float $mcGross Price paid by the buyer.
 * @param float $tax The tax added to the price.
 * @param float $discount The discount applied to the price without taxes.
 *
 * @return bool
 */
	protected function _isDiscountValid($custom, $mcGross, $tax, $discount) {
		$discount = Number::format($discount, ['precision' => 2, 'locale' => 'en_US']);

		if ($discount == 0.00 && !isset($custom['discount_id'])) {
			return true;
		}

		$this->_controller->loadModel('PremiumDiscounts');

		$checkDiscount = $this->_controller->PremiumDiscounts->find('discountByIdAndOffer', [
			'id' => $custom['discount_id'],
			'offer_id' => $custom['offer_id']
		]);

		if (!$checkDiscount) {
			return false;
		}

		$total = ($mcGross - $tax) + $discount;

		$offerDiscount = Number::format(round($checkDiscount->discount / 100, 2) * $total, ['precision' => 2, 'locale' => 'en_US']);

		if ($offerDiscount != $discount) {
			Log::error(__('The discount offer {0} does not match with the Paypal discount {1}.', $offerDiscount, $discount), 'paypal');

			return false;
		}

		//Update the discount.
		$update = $this->_updateDiscount($checkDiscount);

		if ($update) {
			return true;
		}

		return false;
	}

/**
 * Update the discount code.
 *
 * @param \Cake\ORM\Entity $discount The Entity to update.
 *
 * @return bool
 */
	protected function _updateDiscount(Entity $discount) {
		$this->_controller->loadModel('PremiumDiscounts');

		$data = [
			'used' => $discount->used + 1
		];

		$this->_controller->PremiumDiscounts->patchEntity($discount, $data);

		if ($this->_controller->PremiumDiscounts->save($discount)) {
			return true;
		}

		Log::error(__('Unable to update the discount code.'), 'paypal');

		return false;
	}

/**
 * Check if the currency match with the offer currency.
 *
 * @param array $custom The custom data passed to Paypal.
 * @param string $mcCurrency The currency to check.
 *
 * @return bool
 */
	protected function _isCurrencyValid(array $custom, $mcCurrency) {
		$this->_controller->loadModel('PremiumOffers');

		$offer = $this->_controller->PremiumOffers->find('offerByIdAndPeriod', [
			'id' => $custom['offer_id'],
			'period' => $custom['period']
		]);

		if ($offer->currency_code != $mcCurrency) {
			Log::error(__('The currency offer {0} does not match with the Paypal currency {1}.', $offer->currency, $mcCurrency), 'paypal');

			return false;
		}

		return true;
	}
}
