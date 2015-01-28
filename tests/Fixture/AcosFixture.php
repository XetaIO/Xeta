<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class AcosFixture extends TestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = [
		'id' => ['type' => 'integer'],
		'parent_id' => ['type' => 'integer'],
		'model' => ['type' => 'string', 'length' => 255],
		'foreign_key' => ['type' => 'integer'],
		'alias' => ['type' => 'string', 'length' => 255],
		'lft' => ['type' => 'integer'],
		'rght' => ['type' => 'integer'],
		'_indexes' => [
			'idx_acos_lft_rght' => ['type' => 'index', 'columns' => ['lft', 'rght']],
			'idx_acos_alias' => ['type' => 'index', 'columns' => ['alias']],
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
			'parent_id' => null,
			'model' => '',
			'foreign_key' => null,
			'alias' => 'app',
			'lft' => 1,
			'rght' => 10
		],
		[
			'parent_id' => 1,
			'model' => '',
			'foreign_key' => null,
			'alias' => 'Blog',
			'lft' => 2,
			'rght' => 5
		],
		[
			'parent_id' => 2,
			'model' => '',
			'foreign_key' => null,
			'alias' => 'index',
			'lft' => 3,
			'rght' => 4
		],
		[
			'parent_id' => 1,
			'model' => '',
			'foreign_key' => null,
			'alias' => 'Pages',
			'lft' => 6,
			'rght' => 9
		],
		[
			'parent_id' => 4,
			'model' => '',
			'foreign_key' => null,
			'alias' => 'home',
			'lft' => 7,
			'rght' => 8
		]
	];
}
