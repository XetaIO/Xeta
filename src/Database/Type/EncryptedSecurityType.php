<?php
namespace App\Database\Type;

use Cake\Core\Configure;
use Cake\Database\Driver;
use Cake\Database\Type;
use Cake\Utility\Security;
use PDO;

class EncryptedSecurityType extends Type
{
    /**
     * Convert string values to PHP integers
     *
     * @param mixed $value The value to convert.
     * @param Driver $driver The driver instance to convert with.
     * @return string|null
     */
    public function toPHP($value, Driver $driver)
    {
        if ($value === null || empty($value)) {
            return null;
        }

        return Security::decrypt(base64_decode($value), Configure::read('Security.key'));
    }

    /**
     * Marshalls request data into PHP strings.
     *
     * @param mixed $value The value to convert.
     * @return mixed Converted value.
     */
    public function marshal($value)
    {
        if ($value === null) {
            return $value;
        }

        return base64_encode(Security::encrypt($value, Configure::read('Security.key')));
    }

    /**
     * Convert string data into the database format.
     *
     * @param mixed $value The value to convert.
     * @param Driver $driver The driver instance to convert with.
     * @return string|null
     */
    public function toDatabase($value, Driver $driver)
    {
        if ($value === null) {
            return null;
        }

        return $value;
    }

    /**
     * Get the correct PDO binding type for string data.
     *
     * @param mixed $value The value being bound.
     * @param Driver $driver The driver.
     * @return int
     */
    public function toStatement($value, Driver $driver)
    {
        if ($value === null) {
            return PDO::PARAM_NULL;
        }

        return PDO::PARAM_STR;
    }
}
