<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\I18n;

/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
require dirname(__DIR__) . '/vendor/autoload.php';

require dirname(__DIR__) . '/config/bootstrap.php';

Configure::write('App.defaultLocale', 'en_US');
I18n::locale('en_US');

define('TEST_APP', TESTS . 'test_app' . DS);
define('TEST_TMP', TEST_APP . 'tmp' . DS);
define('TEST_WWW_ROOT', TEST_APP . 'webroot' . DS);

$_SERVER['PHP_SELF'] = '/';

/**
 * Clean the cache before the tests.
 */
 Cache::clear(false, 'database');
 Cache::clear(false, 'acl');

/**
 * Executed after all the tests.
 */
if (!function_exists('cleanup_after_tests')) {
    /**
     * Clean the data that was used in TestsCase.
     *
     * @return void
     */
    function cleanup_after_tests()
    {
        Cache::clear(false, 'analytics');
        Cache::clear(false, 'database');
        Cache::clear(false, 'acl');
    }
}

register_shutdown_function(function () {
    cleanup_after_tests();
});
