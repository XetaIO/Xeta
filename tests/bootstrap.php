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
define('TEST_TMP', TEST_APP . 'tmp' . DS);
define('TEST_WWW_ROOT', TEST_APP . 'webroot' . DS);

if (!getenv('db_class')) {
    putenv('db_dsn=sqlite:///:memory:');
}
ConnectionManager::config('test', ['url' => getenv('db_dsn')]);
