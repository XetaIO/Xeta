<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Routing\Router;

class TransactionComponent extends Component {

/**
 * Sandbox prefix.
 */
	const SANDBOX = 'sandbox.';

/**
 * Get the Paypal URL to redirect the user on Paypal.
 *
 * @param float $price The price of the offer.
 * @param float $tax The tax of the offer..
 * @param string $name The name of the offer.
 * @param string $custom The custom fields to pass to Paypal.
 * @param float $discount The percentage of the discount.
 *
 * @return bool|string
 */
	public function getPaypalUrl($price, $tax, $name, $custom, $discount) {
		$request = [
			'METHOD' => 'BMCreateButton',
			'VERSION'	=> '87',
			'USER'	=> Configure::read('Paypal.user'),
			'PWD'	=> Configure::read('Paypal.pwd'),
			'SIGNATURE'	=> Configure::read('Paypal.signature'),
			'BUTTONCODE' => 'HOSTED',
			'BUTTONTYPE' => 'BUYNOW',
			'BUTTONSUBTYPE' => 'SERVICES',
			'L_BUTTONVAR0' => 'business=' . Configure::read('Paypal.mail'),
			'L_BUTTONVAR1' => "item_name=$name",
			'L_BUTTONVAR2' => "amount=$price",
			'L_BUTTONVAR3' => "tax_rate=$tax",
			'L_BUTTONVAR4' => "discount_rate=$discount",
			'L_BUTTONVAR5' => "currency_code=EUR",
			'L_BUTTONVAR6' => "no_note=1",
			'L_BUTTONVAR7' => "notify_url=" . Router::url(['controller' => 'premium', 'action' => 'notify'], true),
			'L_BUTTONVAR8' => "return=" . Router::url(['controller' => 'premium', 'action' => 'success'], true),
			'L_BUTTONVAR9' => "cancel_return=" . Router::url(['controller' => 'premium', 'action' => 'cancel'], true),
			'L_BUTTONVAR10' => "custom=$custom",
			'L_BUTTONVAR11' => "cpp_header_image=" . Router::url('/' . Configure::read('App.imageBaseUrl') . 'paypal_header.png', true),
			'L_BUTTONVAR12' => "cpp_cart_border_color=506A85"
		];

		$request = http_build_query($request);

		$sandbox = Configure::read('Paypal.sandbox') ? self::SANDBOX : '';

		$curlOptions = [
			CURLOPT_URL => "https://api-3t." . $sandbox . "paypal.com/nvp",
			//CURLOPT_VERBOSE => 1,
			CURLOPT_POST => 1,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => 2,
			//CURLOPT_CAINFO => APP . 'config' . DS . 'cacert.pem',
			//CURLOPT_CAPATH => APP . 'config' . DS,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => $request,
			CURLOPT_CONNECTTIMEOUT => 30
		];

		$ch = curl_init();
		curl_setopt_array($ch, $curlOptions);
		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			return false;
		} else {
			curl_close($ch);
			parse_str($response, $responseArray);

			if (!isset($responseArray['EMAILLINK'])) {
				return false;
			}

			return $responseArray['EMAILLINK'];
		}
	}
}
