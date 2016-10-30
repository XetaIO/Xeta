<?php

namespace App\Error;

use Cake\Core\Configure;
use Cake\Error\ErrorHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsErrorHandler extends ErrorHandler
{
    /**
     * The Whoops instance.
     *
     * @var \Whoops\Run
     */
    protected $_whoops;

    /**
     * Get the Whoops instance.
     *
     * @return \Whoops\Run The Whoops instance.
     */
    public function getWhoopsInstance()
    {
        if (empty($this->_whoops)) {
            $this->_whoops = new Run();
        }

        return $this->_whoops;
    }

    /**
     * Display an error.
     *
     * Only when debug > 2 will a formatted error be displayed.
     *
     * @param array $error An array of error data.
     * @param bool $debug Whether or not the app is in debug mode.
     *
     * @return void
     */
    protected function _displayError($error, $debug)
    {
        if ($debug) {
            $whoops = $this->getWhoopsInstance();
            $whoops->pushHandler(new PrettyPageHandler());
            $whoops->handleError($error['level'], $error['description'], $error['file'], $error['line']);
        } else {
            parent::_displayError($error, $debug);
        }
    }

    /**
     * Displays an exception response body.
     *
     * @param \Exception $exception The exception to display
     *
     * @return void
     */
    protected function _displayException($exception)
    {
        if (Configure::read('debug')) {
            $whoops = $this->getWhoopsInstance();
            $whoops->pushHandler(new PrettyPageHandler());
            $whoops->handleException($exception);
        } else {
            parent::_displayException($exception);
        }
    }
}
