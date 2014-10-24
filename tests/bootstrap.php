<?php
use Cake\Datasource\ConnectionManager;

/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */

require dirname(__DIR__) . '/config/bootstrap.php';

define('TEST_APP', TESTS . 'test_app' . DS);
define('TEST_WWW_ROOT', TEST_APP . 'webroot' . DS);

if (!getenv('DB') && !getenv('db_class')) {
	putenv('db_class=Cake\Database\Driver\Mysql');
	putenv('db_dsn=mysql:host=localhost;dbname=xeta_test');
	putenv('db_database=xeta_test');
	putenv('db_login=root');
	putenv('db_password=');
}

ConnectionManager::config('test', [
	'className' => 'Cake\Database\Connection',
	'driver' => getenv('db_class'),
	'dsn' => getenv('db_dsn'),
	'database' => getenv('db_database'),
	'login' => getenv('db_login'),
	'password' => getenv('db_password'),
	'timezone' => 'UTC'
]);
