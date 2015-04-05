<?php
namespace App\Model\Validation;

use Cake\Validation\Validator;

class UploadValidator extends Validator
{

    /**
     * Check the dimensions of a file image.
     *
     * @param array $check  Value to check.
     * @param int   $height Max height dimension.
     * @param int   $width  Max width dimension.
     *
     * @return bool
     */
    public static function maxDimension($check, $height, $width)
    {
        if (is_array($check) && isset($check['error']) && (int)$check['error'] === UPLOAD_ERR_NO_FILE) {
            return true;
        }

        if (!is_file($check['tmp_name'])) {
            return false;
        }

        //@codingStandardsIgnoreStart
        $size = @getimagesize($check['tmp_name']);
        //@codingStandardsIgnoreEnd

        if (!is_array($size)) {
            return false;
        }

        return ($size[0] <= (int)$width && $size[1] <= (int)$height);
    }
}
