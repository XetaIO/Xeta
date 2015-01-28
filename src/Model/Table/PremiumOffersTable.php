<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PremiumOffersTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 *
 * @return void
 */
	public function initialize(array $config) {
		$this->table('premium_offers');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id'
		]);
		$this->hasMany('PremiumTransactions', [
			'foreignKey' => 'premium_offer_id'
		]);
		$this->hasMany('PremiumDiscounts', [
			'foreignKey' => 'premium_discount_id'
		]);
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator The Validator instance.
 *
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->notEmpty('period', __("You must set a period."))
			->add('period', 'numeric', [
				'rule' => 'numeric',
				'message' => __("The period must be numeric.")
			])
			->notEmpty('price', __("You must set a price."))
			->add('price', 'numeric', [
				'rule' => 'numeric',
				'message' => __("The price must be numeric.")
			])
			->notEmpty('tax', __("You must set a tax."))
			->add('tax', 'numeric', [
				'rule' => 'numeric',
				'message' => __("The tax must be numeric.")
			])
			->notEmpty('currency_code', __("You must set a currency code."))
			->add('currency_code', 'maxLength', [
				'rule' => ['maxLength', 10],
				'message' => __("The currency code can not be more than {0} characters.", 10)
			])
			->notEmpty('currency_symbol', __("You must set a currency symbol."))
			->add('currency_symbol', 'maxLength', [
				'rule' => ['maxLength', 5],
				'message' => __("The currency symbol can not be more than {0} characters.", 5)
			]);

		return $validator;
	}

/**
 * Custom finder for select all offers.
 *
 * @param \Cake\ORM\Query $query The query finder.
 *
 * @return \Cake\ORM\Query
 */
	public function findOffers(Query $query) {
		return $query
			->select([
				'period',
				'price',
				'tax',
				'currency_symbol'
			])
			->order([
				'price' => 'ASC'
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
	public function findOfferByPeriod(Query $query, array $options) {
		return $query
			->where([
				'period' => $options['period']
			])
			->select([
				'id',
				'period',
				'price',
				'tax',
				'currency_code',
				'currency_symbol'
			])
			->first();
	}

/**
 * Custom finder for select an offer by id and period.
 *
 * @param \Cake\ORM\Query $query The query finder.
 * @param array $options Options passed to the query.
 *
 * @return \Cake\ORM\Query
 */
	public function findOfferByIdAndPeriod(Query $query, array $options) {
		return $query
			->where([
				'id' => $options['id'],
				'period' => $options['period']
			])
			->select([
				'id',
				'period',
				'price',
				'tax',
				'currency_code',
				'currency_symbol'
			])
			->first();
	}
}
