<?php
namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PremiumDiscountsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('premium_discounts');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsToMany('PremiumTransactions', [
            'foreignKey' => 'premium_discount_id'
        ]);
        $this->belongsTo('PremiumOffers', [
            'foreignKey' => 'premium_offer_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('premium_offer_id', __("You must set an offer."))
            ->add('premium_offer_id', 'numeric', [
                'rule' => 'numeric',
                'message' => __("The offer must be numeric value.")
            ])
            ->notEmpty('code', __("You must set a code."))
            ->add('code', 'maxLength', [
                'rule' => ['maxLength', 50],
                'message' => __("The code can not be more than {0} characters.", 50)
            ])
            ->notEmpty('discount', __("You must set a discount."))
            ->add('discount', 'numeric', [
                'rule' => 'numeric',
                'message' => __("The discount must be numeric value.")
            ])
            ->notEmpty('used', __("You must set the used number."))
            ->add('used', 'numeric', [
                'rule' => 'numeric',
                'message' => __("The used value must be numeric value.")
            ])
            ->notEmpty('max_use', __("You must set the max use for the discount."))
            ->add('max_use', 'numeric', [
                'rule' => 'numeric',
                'message' => __("The max use value must be numeric value.")
            ]);

        return $validator;
    }

    /**
     * Custom finder for select an offer by period.
     *
     * @param \Cake\ORM\Query $query The query finder.
     * @param array $options Options passed to the query.
     *
     * @return \Cake\ORM\Query
     */
    public function findDiscountByCodeAndOffer(Query $query, array $options)
    {
        return $query
            ->where([
                'code' => $options['code'],
                'premium_offer_id' => $options['offer_id']
            ])
            ->select([
                'id',
                'code',
                'discount',
                'used',
                'max_use'
            ])
            ->first();
    }

    /**
     * Custom finder for select an offer by period.
     *
     * @param \Cake\ORM\Query $query The query finder.
     * @param array $options Options passed to the query.
     *
     * @return \Cake\ORM\Query
     */
    public function findDiscountByIdAndOffer(Query $query, array $options)
    {
        return $query
        ->where([
            'id' => $options['id'],
            'premium_offer_id' => $options['offer_id']
        ])
        ->select([
            'id',
            'code',
            'discount',
            'used',
            'max_use'
        ])
        ->first();
    }

    /**
     * Verify if the discount code is valid or not.
     *
     * @param Entity $entity The Entity to check.
     *
     * @return bool
     */
    public function isDiscountValid(Entity $entity)
    {
        return $entity->max_use > $entity->used;
    }
}
