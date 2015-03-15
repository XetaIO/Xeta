<?php
namespace App\Controller\Component\Chat;

use Acl\Auth\ActionsAuthorize;
use Cake\Cache\Cache;
use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Routing\Router;
use HTMLPurifier;
use HTMLPurifier_Config;

class ChatComponent extends Component {

/**
 * Components.
 *
 * @var array
 */
	public $components = ['Acl.Acl'];

/**
 * Request object
 *
 * @var \Cake\Network\Request
 */
	protected $_request;

/**
 * Instance of the Session object
 *
 * @return void
 */
	protected $_session;

/**
 * Instance of the Controller object
 *
 * @return void
 */
	protected $_controller;

/**
 * ActionsAuthorize Instance.
 *
 * @var object
 */
	public $Authorize;

/**
 * Initialize properties.
 *
 * @param array $config The config data.
 *
 * @return void
 */
	public function initialize(array $config) {
		$controller = $this->_registry->getController();
		$this->_controller = $controller;
		$this->_request = $controller->request;
		$this->_session = $controller->request->session();

		$this->Authorize = new ActionsAuthorize($this->_registry);
	}

/**
 * Get the Notice of the chat.
 *
 * @return string
 */
	public function getNotice() {
		$defaultNotice = __d('chat', 'Welcome on <strong>{0}</strong> ! :heart:', Configure::read('Site.name'));

		$notice = Cache::remember('notice', function () use ($defaultNotice){
			$config = HTMLPurifier_Config::createDefault();
			$config->loadArray(Configure::read('HtmlPurifier.Chat.notice'));

			$HTMLPurifier = new HTMLPurifier($config);

			return $HTMLPurifier->purify($defaultNotice);
		}, 'chat');

		return $notice;
	}

/**
 * Edit the notice.
 *
 * @param string $notice The notice to save.
 *
 * @return array
 */
	public function editNotice($notice) {
		$config = HTMLPurifier_Config::createDefault();
		$config->loadArray(Configure::read('HtmlPurifier.Chat.notice'));

		$HTMLPurifier = new HTMLPurifier($config);

		$notice = $HTMLPurifier->purify($notice);

		$json = [];
		if (Cache::write('notice', $notice, 'chat')) {
			$json['error'] = false;
			$json['notice'] = $notice;
		} else {
			$json['error'] = true;
			$json['errorText'] = __d('chat', 'Error to save the notice in the Cache.');
		}

		return $json;
	}

/**
 * Check all rules related to a post message.
 *
 * @param string $message The message to check.
 *
 * @return array
 */
	public function handleShoutRules($message) {
		$json = [];
		$this->_controller->loadModel('ChatMessages');

		//Flood rule.
		$lastMessage = $this->_controller->ChatMessages
			->find()
			->where(['ChatMessages.user_id' => $this->_controller->Auth->user('id')])
			->select([
				'ChatMessages.user_id',
				'ChatMessages.text',
				'ChatMessages.created'
			])
			->order(['ChatMessages.created' => 'DESC'])
			->first();
		if (!is_null($lastMessage) && $lastMessage->created->timestamp + Configure::read('Chat.floodRule') > (new Time())->timestamp) {
			$json['error'] = true;
			$json['message'] = __d('chat', 'Please, don\'t flood the chat.');

			return $json;
		}

		//Spam Rule.
		$percent = 0;
		$lastMessageText = (is_null($lastMessage)) ? null : $lastMessage->text;
		similar_text($lastMessageText, $message, $percent);
		if ($percent > Configure::read('Chat.spamRule')) {
			$json['error'] = true;
			$json['message'] = __d('chat', 'Your last message is very similar, please change it.');

			return $json;
		}

		//Empty Rule.
		if (strlen($message) == 0) {
			$json['error'] = true;
			$json['message'] = __d('chat', 'You can\'t send an empty message.');

			return $json;
		}

		//Max Length Rule.
		if (strlen($message) > Configure::read('Chat.messageMaxLength')) {
			$json['error'] = true;
			$json['message'] = __d('chat', 'You can\'t send a message with more than {0} characters.', Configure::read('Chat.messageMaxLength'));

			return $json;
		}

		return $json['error'] = false;
	}

/**
 * Checks if the given user has permission to perform an action.
 *
 * @param array $params The params to check.
 *
 * @return string
 */
	public function hasPermission(array $params = []) {
		$params += [
			'controller' => 'Permissions',
			'_base' => false,
			'prefix' => 'chat'
		];

		$url = Router::url($params);
		$params = Router::parse($url);

		$request = new Request();
		$request->addParams($params);

		$action = $this->Authorize->action($request);
		$user = [$this->Authorize->config('userModel') => $this->_session->read('Auth.User')];

		return $this->Acl->check($user, $action);
	}
}
