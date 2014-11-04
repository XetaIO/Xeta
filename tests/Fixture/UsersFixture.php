<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = [
		'id' => ['type' => 'integer'],
		'username' => ['type' => 'string', 'length' => 20],
		'password' => ['type' => 'string', 'length' => 255],
		'email' => ['type' => 'string', 'length' => 50],
		'first_name' => ['type' => 'string', 'length' => 100],
		'last_name' => ['type' => 'string', 'length' => 100],
		'avatar' => ['type' => 'string', 'length' => 255, 'default' => '../img/avatar.png'],
		'biography' => ['type' => 'text'],
		'signature' => ['type' => 'text'],
		'facebook' => ['type' => 'string', 'length' => 200],
		'twitter' => ['type' => 'string', 'length' => 200],
		'role' => ['type' => 'string', 'length' => 20, 'default' => 'member'],
		'slug' => ['type' => 'string', 'length' => 20],
		'blog_articles_comment_count' => ['type' => 'integer', 'length' => 11, 'default' => '0'],
		'blog_article_count' => ['type' => 'integer', 'length' => 11, 'default' => '0'],
		'counter_id' => ['type' => 'integer', 'length' => 11, 'default' => '1'],
		'register_ip' => ['type' => 'string', 'length' => 15],
		'last_login_ip' => ['type' => 'string', 'length' => 15],
		'last_login' => ['type' => 'datetime'],
		'created' => ['type' => 'datetime'],
		'modified' => ['type' => 'datetime'],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['id']],
			'username' => ['type' => 'unique', 'columns' => ['username']],
			'mail' => ['type' => 'unique', 'columns' => ['email']],
		],
		'_options' => [
			'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
		],
	];

/**
 * Records
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
			'blog_articles_comment_count' => 2,
			'blog_article_count' => 2,
			'counter_id' => 1,
			'register_ip' => '192.168.0.1',
			'last_login_ip' => '192.168.0.1',
			'last_login' => '2014-03-17 01:23:31',
			'created' => '2014-03-17 01:16:23',
			'modified' => '2014-03-17 01:18:31'
		],
		[
			'username' => 'larry',
			'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
			'email' => 'larry@example.com',
			'first_name' => 'Larry',
			'last_name' => 'Page',
			'avatar' => '../img/avatar.png',
			'biography' => 'My awesome biography',
			'signature' => 'My awesome signature',
			'facebook' => 'larry',
			'twitter' => 'larry',
			'role' => 'member',
			'slug' => 'larry',
			'blog_articles_comment_count' => 0,
			'blog_article_count' => 0,
			'counter_id' => 1,
			'register_ip' => '192.168.0.2',
			'last_login_ip' => '192.168.0.2',
			'last_login' => '2014-03-18 01:23:31',
			'created' => '2014-03-18 01:16:23',
			'modified' => '2014-03-18 01:18:31'
		]
	];

}
