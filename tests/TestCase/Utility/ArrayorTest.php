<?php
namespace Cake\Test\TestCase\Utility;

use App\Utility\Arrayor;
use Cake\TestSuite\TestCase;

class ArrayorTest extends TestCase
{

    /**
     * test camelizeIndex
     *
     * @return void
     */
    public function testCamelizeIndex()
    {
        $expected = ['keyIndex' => 1];

        $this->assertEquals(Arrayor::camelizeIndex(['key index' => 1]), $expected);
        $this->assertEquals(Arrayor::camelizeIndex(['key  index' => 1]), $expected);
        $this->assertEquals(Arrayor::camelizeIndex(['key_index' => 1]), $expected);

        $this->assertFalse(Arrayor::camelizeIndex(null));
        $this->assertFalse(Arrayor::camelizeIndex(false));
        $this->assertFalse(Arrayor::camelizeIndex('key index'));
    }
}
