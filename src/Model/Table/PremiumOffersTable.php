<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PremiumOffers Model
 */
class PremiumOffersTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
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
			'foreignKey' => 'premium_offer_id'
		]);
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator The Validator instance.
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create');

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
