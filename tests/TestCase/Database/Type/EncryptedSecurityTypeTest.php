<?php
namespace App\Test\TestCase\Database\Type;

use Cake\Core\Configure;
use Cake\Database\Type;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;
use PDO;

class EncryptedSecurityTypeTest extends TestCase
{
    /**
     * Setup
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->type = Type::build('encryptedsecurity');
        $this->driver = $this->getMockBuilder('Cake\Database\Driver')->getMock();

        $this->crypted = base64_encode(Security::encrypt('string', Configure::read('Security.key')));
    }

    /**
     * Test toPHP
     *
     * @return void
     */
    public function testToPHP()
    {
        $this->assertNull($this->type->toPHP(null, $this->driver));
        $this->assertSame('string', $this->type->toPHP($this->crypted, $this->driver));
        $this->assertNotSame('stringFail', $this->type->toPHP($this->crypted, $this->driver));
    }

    /**
     * Test converting to database format
     *
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertNull($this->type->toDatabase(null, $this->driver));
        $this->assertSame('word', $this->type->toDatabase('word', $this->driver));
    }

    /**
     * Test marshalling
     *
     * @return void
     */
    public function testMarshal()
    {
        $this->assertNull($this->type->marshal(null));

        $encrypted = $this->type->marshal('string');
        $this->assertSame(128, strlen($encrypted));
        $decrypted = Security::decrypt(base64_decode($encrypted), Configure::read('Security.key'));
        $this->assertSame('string', $decrypted);
    }

    /**
     * Test that the PDO binding type is correct.
     *
     * @return void
     */
    public function testToStatement()
    {
        $this->assertEquals(PDO::PARAM_NULL, $this->type->toStatement(null, $this->driver));
        $this->assertEquals(PDO::PARAM_STR, $this->type->toStatement('', $this->driver));
    }
}
