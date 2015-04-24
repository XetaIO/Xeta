<?php
namespace App\Utility;

use Cake\Utility\Inflector;

class Arrayor
{

    /**
     * Camelize all index keys in the first level.
     *
     * Passed :
     * $array = [
     *     'Index key' => 1,
     *     'key-index' => 2
     * ];
     *
     * Return :
     * $array = [
     *     'indexKey' => 1,
     *     'keyIndex' => 2
     * ];
     *
     * @param array $array The array to be camelized.
     *
     * @return bool|array
     */
    public static function camelizeIndex($array)
    {
        if (!is_array($array)) {
            return false;
        }

        $array = array_combine(
            array_map(
                function ($key) {
                    return lcfirst(Inflector::camelize($key));
                },
                array_keys($array)
            ),
            array_values($array)
        );

        return $array;
    }
}
