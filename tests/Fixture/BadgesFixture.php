<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class BadgesFixture extends TestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = [
		'id' => ['type' => 'integer'],
		'name' => ['type' => 'string', 'length' => 255],
		'picture' => ['type' => 'string', 'length' => 255],
		'type' => ['type' => 'string', 'length' => 255],
		'rule' => ['type' => 'integer'],
		'created' => ['type' => 'datetime'],
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
			'id' => 1,
			'name' => 'Badge1',
			'picture' => 'badge/badge1.png',
			'type' => 'comments',
			'rule' => 1,
			'created' => '2014-11-10 14:43:54'
		],
	];

}
