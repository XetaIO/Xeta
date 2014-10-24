<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture {

	public $import = ['table' => 'users'];

/**
 * records property
 *
 * @var array
 */
	public $records = [
		[
			'username' => 'mariano',
			'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
			'email' => 'mariano@example.com',
			'first_name' => 'Maria',
			'last_name' => 'Riano',
			'avatar' => '../img/avatar.png',
			'biography' => 'My awesome biography',
			'signature' => 'My awesome signature',
			'facebook' => 'mariano',
			'twitter' => 'mariano',
			'role' => 'admin',
			'slug' => 'mariano',
			'blog_articles_comment_count' => 0,
			'blog_article_count' => 0,
			'counter_id' => 1,
			'register_ip' => '192.168.0.1',
			'last_login_ip' => '192.168.0.1',
			'last_login' => '2014-03-17 01:23:31',
			'created' => '2014-03-17 01:16:23',
			'modified' => '2014-03-17 01:18:31'
		]
	];
}
