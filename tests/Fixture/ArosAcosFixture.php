<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ArosAcosFixture extends TestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = [
		'id' => ['type' => 'integer'],
		'aro_id' => ['type' => 'integer'],
		'aco_id' => ['type' => 'integer'],
		'_create' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'default' => '0'],
		'_read' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'default' => '0'],
		'_update' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'default' => '0'],
		'_delete' => ['type' => 'string', 'fixed' => true, 'length' => 2, 'default' => '0'],
		'_indexes' => [
			'idx_aco_id' => ['type' => 'index', 'columns' => ['aco_id']],
		],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['id']],
		],
		'_options' => [
			'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
		],
	];

/**
 * Records
 *
 * @var array
 */
	public $records = [
		[
			'aro_id' => 1,
			'aco_id' => 1,
			'_create' => '1',
			'_read' => '1',
			'_update' => '1',
			'_delete' => '1'
		],
		[
			'aro_id' => 2,
			'aco_id' => 1,
			'_create' => '-1',
			'_read' => '-1',
			'_update' => '-1',
			'_delete' => '-1'
		],
		[
			'aro_id' => 2,
			'aco_id' => 4,
			'_create' => '1',
			'_read' => '1',
			'_update' => '1',
			'_delete' => '1'
		]
	];
}
