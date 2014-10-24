<?php

/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */

require dirname(__DIR__) . '/config/bootstrap.php';

define('TEST_APP', TESTS . 'test_app' . DS);
define('TEST_WWW_ROOT', TEST_APP . 'webroot' . DS);
