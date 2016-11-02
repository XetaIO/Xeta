<?php
namespace App\Routing\Route;

use Cake\Routing\Route\Route;
use Cake\Utility\Inflector;

class SlugRoute extends Route
{

    /**
     * Flag for tracking whether or not the defaults have been sluged.
     *
     * Default values need to be sluged so that they match the inflections that
     * match() will create.
     *
     * @var bool
     */
    protected $_slugedDefaults = false;

    /**
     * Parses a string URL into an array. If it matches, it will convert the slug keys to their slugerize form
     *
     * @param string $url The URL to parse.
     * @param string $method The HTTP method.
     *
     * @return false|array False on failure, or an array of request parameters.
     */
    public function parse($url, $method = '')
    {
        $params = parent::parse($url, $method);
        if (!$params) {
            return false;
        }
        if (!empty($params['slug'])) {
            $params['slug'] = strtolower(Inflector::slug($params['slug']));
        }
        if (!empty($params['controller'])) {
            $params['controller'] = Inflector::camelize($params['controller']);
        }
        if (!empty($params['plugin'])) {
            $params['plugin'] = Inflector::camelize($params['plugin']);
        }

        return $params;
    }

    /**
     * Slug the prefix, controller and plugin params before passing them on to the
     * parent class
     *
     * @param array $url Array of parameters to convert to a string.
     * @param array $context An array of the current request context.
     *   Contains information such as the current host, scheme, port, and base
     *   directory.
     *
     * @return false|string Either false or a string URL.
     */
    public function match(array $url, array $context = [])
    {
        $url = $this->_slugerize($url);
        if (!$this->_slugedDefaults) {
            $this->_slugedDefaults = true;
            $this->defaults = $this->_slugerize($this->defaults);
        }

        return parent::match($url, $context);
    }

    /**
     * Helper method for slugerizing keys in a URL array.
     *
     * @param array $url An array of URL keys.
     *
     * @return array
     */
    protected function _slugerize($url)
    {
        if (isset($url['slug']) && !empty($url['slug'])) {
            $url['slug'] = strtolower(Inflector::slug($url['slug']));
        }
        if (!empty($url['controller'])) {
            $url['controller'] = Inflector::underscore($url['controller']);
        }
        if (!empty($url['plugin'])) {
            $url['plugin'] = Inflector::underscore($url['plugin']);
        }

        return $url;
    }
}
