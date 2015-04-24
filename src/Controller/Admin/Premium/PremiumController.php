<?php
namespace App\Controller\Admin\Premium;

use App\Controller\AppController;
use Cake\I18n\Number;
use Cake\I18n\Time;
use Cake\Utility\Hash;

class PremiumController extends AppController
{

    /**
     * Index page.
     *
     * @return void
     */
    public function home()
    {
        $this->loadModel('Users');
        $this->loadModel('PremiumTransactions');

        $usersCount = Number::format(
            $this->Users
                ->find()
                ->where([
                    'end_subscription >' => new Time()
                ])
                ->count()
        );

        $premiumTransactions = $this->PremiumTransactions
            ->find()
            ->select([
                'price'
            ])
            ->hydrate(false)
            ->toArray();

        $amountTotal = array_sum(Hash::extract($premiumTransactions, '{n}.price'));

        $registeredDiscounts = $this->PremiumTransactions
            ->find()
            ->where(function ($exp) {
                return $exp->isNotNull('premium_discount_id');
            })
            ->count();

        $discounts = $this->PremiumTransactions
            ->find()
            ->contain([
                'PremiumDiscounts',
                'PremiumOffers'
            ])
            ->where(function ($exp) {
                return $exp->isNotNull('premium_discount_id');
            })
            ->toArray();

        $discountAmountTotal = [];

        foreach ($discounts as $discount) {
            array_push($discountAmountTotal, $discount->discount);
        }

        $discountAmountTotal = array_sum($discountAmountTotal);

        $this->set(compact('usersCount', 'amountTotal', 'registeredDiscounts', 'discountAmountTotal'));
    }
}
