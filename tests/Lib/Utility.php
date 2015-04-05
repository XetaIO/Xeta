<?php
namespace App\Test\Lib;

class Utility
{

    /**
     * Extract keys on 2 levels.
     *
     * @param array $array The array to extract keys.
     *
     * @return array
     */
    public function getL2Keys(array $array)
    {
        foreach ($array as $key => $rules) {
            $vals[$key] = array_keys($rules);
        }

        return $vals;
    }

    /**
     * Generate a random string with a custom length.
     *
     * @param int $length The length of the string.
     *
     * @return string
     */
    public function generateRandomString($length = 10)
    {
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= 'z';
        }
        return $string;
    }

    /**
     * Call a protected method to test it.
     *
     * @param object $obj  The instance of the object.
     * @param string $name The protected method to call.
     * @param array  $args The arguments to pass to the method.
     *
     * @return mixed
     */
    public function callProtectedMethod($obj, $name, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}
