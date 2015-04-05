<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PremiumTransactionsTable extends Table
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
        $this->table('premium_transactions');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('PremiumDiscounts', [
            'foreignKey' => 'premium_discount_id'
        ]);
        $this->belongsTo('PremiumOffers', [
            'foreignKey' => 'premium_offer_id'
        ]);
    }

    /**
     * Custom finder for select an offer by period.
     *
     * @param \Cake\ORM\Query $query The query finder.
     * @param array $options Options passed to the query.
     *
     * @return \Cake\ORM\Query
     */
    public function findTransactionByTxn(Query $query, array $options)
    {
        return $query
            ->where([
                'txn' => $options['txn']
            ])
            ->select([
                'id',
                'txn'
            ])
            ->first();
    }
}
