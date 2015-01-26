<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class GroupsFixture extends TestFixture
{

/**
 * Fields
 *
 * @var array
 */
	public $fields = [
		'id' => ['type' => 'integer'],
		'name' => ['type' => 'string', 'length' => 100],
		'created' => ['type' => 'datetime'],
		'modified' => ['type' => 'datetime'],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['id']],
		],
		'_options' => [
			'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
		]
	];

/**
 * Records
 *
 * @var array
 */
	public $records = [
		[
			'name' => 'Administrator',
			'created' => '2015-01-16 16:49:24',
			'modified' => '2015-01-16 16:49:24'
		],
		[
			'name' => 'Member',
			'created' => '2015-01-16 16:49:24',
			'modified' => '2015-01-16 16:49:24'
		],
	];
}
