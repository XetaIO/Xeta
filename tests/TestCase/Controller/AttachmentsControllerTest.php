<?php
namespace App\Test\TestCase\Controller;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

class AttachmentsControllerTest extends IntegrationTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = [
		'app.users',
		'app.groups',
		'app.groups_i18n',
		'app.aros',
		'app.acos',
		'app.aros_acos',
		'app.sessions',
		'app.blog_articles',
		'app.blog_attachments'
	];

/**
 * Test download method unauthorized
 *
 * @return void
 */
	public function testDownloadUnauthorized() {
		$this->get(['controller' => 'attachments', 'action' => 'download']);
		$this->assertResponseSuccess();
		$this->assertRedirect(['controller' => 'users', 'action' => 'login']);
	}

/**
 * Test download method without been premium
 *
 * @return void
 */
	public function testDownloadNotPremium() {
		$this->session([
			'Auth' => [
				'User' => [
					'id' => 1,
					'username' => 'mariano',
					'avatar' => '../img/avatar.png',
					'group_id' => 5,
				]
			]
		]);

		$this->get(['_name' => 'attachment-download', 'type' => 'blog', 'id' => 1]);
		$this->assertResponseCode(403);
	}

/**
 * Test download method without type
 *
 * @return void
 */
	public function testDownloadWithoutType() {
		$this->_setUserPremium();

		$this->session([
			'Auth' => [
				'User' => [
					'id' => 1,
					'username' => 'mariano',
					'avatar' => '../img/avatar.png',
					'group_id' => 5,
				]
			]
		]);

		$this->get(['controller' => 'attachments', 'action' => 'download']);
		$this->assertResponseCode(404);
	}

/**
 * Test download method without type
 *
 * @return void
 */
	public function testDownloadWithNonExistentFile() {
		$this->_setUserPremium();

		$this->session([
			'Auth' => [
				'User' => [
					'id' => 1,
					'username' => 'mariano',
					'avatar' => '../img/avatar.png',
					'group_id' => 5,
				]
			]
		]);

		$this->get(['_name' => 'attachment-download', 'type' => 'blog', 'id' => 1]);
		$this->assertResponseCode(404);
	}

/**
 * Update the user to a premium member
 *
 * @return void
 */
	protected function _setUserPremium() {
		$Users = TableRegistry::get('Users');
		$user = $Users->get(1);

		$time = new Time('+5 days');
		$user->end_subscription = $time;
		$Users->save($user);
	}
}
