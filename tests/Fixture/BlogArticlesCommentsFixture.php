<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class BlogArticlesCommentsFixture extends TestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = [
		'id' => ['type' => 'integer'],
		'article_id' => ['type' => 'integer'],
		'user_id' => ['type' => 'integer'],
		'content' => ['type' => 'text'],
		'created' => ['type' => 'datetime'],
		'modified' => ['type' => 'datetime'],
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
			'article_id' => 1,
			'user_id' => 1,
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2014-10-28 16:02:02',
			'modified' => '2014-10-28 16:02:02'
		],
		[
			'id' => 2,
			'article_id' => 1,
			'user_id' => 1,
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2014-10-29 16:02:02',
			'modified' => '2014-10-29 16:02:02'
		]
	];

}
