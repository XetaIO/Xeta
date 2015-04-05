<?php
namespace App\Test\TestCase\Model\Validation;

use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;

class UploadValidatorTest extends TestCase
{

    /**
     * setup
     *
     * @return void
     */
    public function setUp()
    {
        $this->validator = new Validator;
        $this->validator
            ->provider('upload', 'App\Model\Validation\UploadValidator')
            ->allowEmpty('avatar_file')
            ->add('avatar_file', 'maxDimension', [
                'rule' => ['maxDimension', 140, 140],
                'provider' => 'upload',
                'message' => 'You fail'
            ]);
    }

    /**
     * test maxDimension with no file.
     *
     * @return void
     */
    public function testMaxDimensionNoFile()
    {
        $file = [
            'name' => '',
            'tmp_name' => TEST_WWW_ROOT . 'img/avatar.png',
            'error' => UPLOAD_ERR_NO_FILE,
            'type' => '',
            'size' => 0
        ];

        $this->assertEmpty($this->validator->errors(['avatar_file' => $file]));
    }

    /**
     * test maxDimension with no tmp_name file.
     *
     * @return void
     */
    public function testMaxDimensionNoTmpFile()
    {
        $file = [
            'name' => '',
            'tmp_name' => TEST_WWW_ROOT . 'img/imageDoesntExist.png',
            'error' => UPLOAD_ERR_OK,
            'type' => '',
            'size' => 0
        ];

        $expected = ['avatar_file' => ['maxDimension' => 'You fail']];
        $this->assertEquals($expected, $this->validator->errors(['avatar_file' => $file]));
    }

    /**
     * test maxDimension with a fake image.
     *
     * @return void
     */
    public function testMaxDimensionFakeImage()
    {
        $file = [
            'name' => 'fakeImage.png',
            'tmp_name' => TEST_WWW_ROOT . 'img/fakeImage.png',
            'error' => UPLOAD_ERR_OK,
            'type' => 'text/plain',
            'size' => 201
        ];
        $expected = ['avatar_file' => ['maxDimension' => 'You fail']];
        $this->assertEquals($expected, $this->validator->errors(['avatar_file' => $file]));
    }

    /**
     * test maxDimension with success validation.
     *
     * @return void
     */
    public function testMaxDimensionSuccess()
    {
        $file = [
            'name' => 'avatar.png',
            'tmp_name' => TEST_WWW_ROOT . 'img/avatar.png',
            'error' => UPLOAD_ERR_OK,
            'type' => 'image/png',
            'size' => 201
        ];

        $expected = ['avatar_file' => ['maxDimension' => 'You fail']];
        $this->assertEquals($expected, $this->validator->errors(['avatar_file' => $file]));

        $validator = new Validator;
        $validator
            ->provider('upload', 'App\Model\Validation\UploadValidator')
            ->add('avatar_file', 'maxDimension', [
                'rule' => ['maxDimension', 160, 160],
                'provider' => 'upload',
                'message' => 'You fail'
            ]);

        $this->assertEmpty($validator->errors(['avatar_file' => $file]));
    }
}
