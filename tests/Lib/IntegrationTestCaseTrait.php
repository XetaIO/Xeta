<?php
namespace App\Test\Lib;

trait IntegrationTestCaseTrait
{

    /**
     * Assert that a JSON as the same value for a given key.
     *
     * @param mixed $value The value of the key.
     * @param mixed $key The key to search the value from.
     * @param string $message The failure message that will be appended to the generated message.
     *
     * @return void
     */
    public function assertEqualsJson($value, $key, $message = '')
    {
        if (!$this->_response) {
            $this->fail('No response set, cannot assert content-type. ' . $message);
        }
        $json = json_decode($this->_response->body(), true);
        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($json));
        $result = null;

        foreach ($iterator as $iteratorKey => $iteratorValue) {
            if ($key == $iteratorKey && $iteratorValue !== '') {
                $result = $iteratorValue;

                break;
            }
        }
        $this->assertEquals($value, $result, $message);
    }
}
