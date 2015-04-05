<?php
namespace App\Model\Validation;

use Cake\Validation\Validator;
use HTMLPurifier;
use HTMLPurifier_Config;

class PurifierValidator extends Validator
{

    /**
     * The default configuration for the HTMLPurifier_Config.
     *
     * @var array
     */
    protected static $_purifierEmptyConfig = [
        'Core.Encoding' => 'UTF-8',
        'HTML.Allowed' => ''
    ];

    /**
     * Check if the length of a HTML string is smaller or equal to a maximal length.
     *
     * @param string $check The value to check.
     * @param int    $max   The maximal string length.
     *
     * @return bool
     */
    public static function purifierMaxLength($check, $max)
    {
        $check = static::_purifyEmpty($check);

        if ($check === false) {
            return false;
        }

        return mb_strlen($check) <= $max;
    }

    /**
     * Check if the length of a HTML string is greater or equal to a minimal length.
     *
     * @param string $check The value to check.
     * @param int    $min   The minimal string length.
     *
     * @return bool
     */
    public static function purifierMinLength($check, $min)
    {
        $check = static::_purifyEmpty($check);

        if ($check === false) {
            return false;
        }

        return mb_strlen($check) >= $min;
    }

    /**
     * Parse a HTML string with HTMLPurifier to remove all/special HTML tags.
     *
     * @param bool|string $text The string to be parsed.
     *
     * @return bool|string
     */
    protected static function _purifyEmpty($text = false)
    {
        if ($text === false) {
            return false;
        }

        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(static::$_purifierEmptyConfig);

        return (new HTMLPurifier($config))->purify(trim($text));
    }
}
