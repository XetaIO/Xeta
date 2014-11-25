<?php
namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PremiumDiscountsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
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
		$this->belongsToMany('PremiumOffers', [
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
 * Custom finder for select an offer by period.
 *
 * @param \Cake\ORM\Query $query The query finder.
 * @param array $options Options passed to the query.
 *
 * @return \Cake\ORM\Query
 */
	public function findDiscountByCodeAndOffer(Query $query, array $options) {
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
	public function findDiscountByIdAndOffer(Query $query, array $options) {
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
	public function isDiscountValid(Entity $entity) {
		return $entity->max_use > $entity->used;
	}
}
