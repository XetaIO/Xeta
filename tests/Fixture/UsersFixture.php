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
		'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
		'username' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'email' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'first_name' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'last_name' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'avatar' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '../img/avatar.png', 'comment' => '', 'precision' => null, 'fixed' => null],
		'biography' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
		'signature' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
		'facebook' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'twitter' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'role' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => 'member', 'comment' => '', 'precision' => null, 'fixed' => null],
		'slug' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'blog_articles_comment_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'blog_article_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'counter_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
		'register_ip' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'last_login_ip' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
		'last_login' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
		'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
		'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
		'_indexes' => [
			'slug' => ['type' => 'index', 'columns' => ['slug'], 'length' => []],
		],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
			'username' => ['type' => 'unique', 'columns' => ['username'], 'length' => []],
			'mail' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
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
