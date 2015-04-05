<?php
namespace App\Test\TestCase\Model\Validation;

use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;

class PurifierValidatorTest extends TestCase
{

    /**
     * test maxLength validation.
     *
     * @return void
     */
    public function testMaxLength()
    {
        $validator = new Validator;
        $validator
            ->provider('purifier', 'App\Model\Validation\PurifierValidator')
            ->add('biography', 'maxLength', [
                'rule' => ['purifierMaxLength', 10],
                'provider' => 'purifier',
                'message' => 'You fail'
            ]);

        $expected = ['biography' => ['maxLength' => 'You fail']];

        $this->assertEquals($expected, $validator->errors(['biography' => 'more than 10 characteres']));
        $this->assertEquals($expected, $validator->errors(['biography' => false]));
        $this->assertEmpty($validator->errors(['biography' => 'LessThan9']));
    }

    /**
     * test minLength validation.
     *
     * @return void
     */
    public function testMinLength()
    {
        $validator = new Validator;
        $validator
            ->provider('purifier', 'App\Model\Validation\PurifierValidator')
            ->add('biography', 'minLength', [
                'rule' => ['purifierMinLength', 10],
                'provider' => 'purifier',
                'message' => 'You fail'
            ]);

        $expected = ['biography' => ['minLength' => 'You fail']];
        $this->assertEquals($expected, $validator->errors(['biography' => 'LessThan9']));
        $this->assertEquals($expected, $validator->errors(['biography' => false]));
        $this->assertEmpty($validator->errors(['biography' => 'more than 10 characteres']));
    }
}
