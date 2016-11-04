<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Setting extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Get the value of the setting. If empty, return null.
     *
     * @return int|string|null
     */
    protected function _getValue()
    {
        if (!is_null($this->value_int)) {
            return $this->value_int;
        }

        if (!is_null($this->value_bool)) {
            return (bool)$this->value_bool;
        }

        if (!is_null($this->value_str)) {
            return $this->value_str;
        }

        return null;
    }

    /**
     * Get the value of the boolean.
     *
     * @param null|int $value The value of the boolean.
     *
     * @return null|int
     */
    protected function _getValueBool($value)
    {
        if (is_null($value)) {
            return null;
        }

        if ((bool)$value === false) {
            return 0;
        }

        return 1;
    }
}
