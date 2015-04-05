<?php
namespace App\Model\Entity;

use Cake\I18n\Number;
use Cake\ORM\Entity;

class PremiumTransaction extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
    ];

    /**
     * Get the discount of the transaction.
     *
     * @return float
     */
    protected function _getDiscount()
    {
        return Number::format(
            $this->premium_discount->discount * $this->premium_offer->price / 100,
            ['precision' => 2, 'locale' => 'en_US']
        );
    }
}
