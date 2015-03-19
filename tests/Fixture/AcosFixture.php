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
	/*public $records = [
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
	];*/

	public $records = array(
		array('id' => '1', 'parent_id' => null, 'model' => '', 'foreign_key' => null, 'alias' => 'app', 'lft' => '1', 'rght' => '252'),
		array('id' => '2', 'parent_id' => '1', 'model' => '', 'foreign_key' => null, 'alias' => 'Attachments', 'lft' => '4', 'rght' => '7'),
		array('id' => '3', 'parent_id' => '2', 'model' => '', 'foreign_key' => null, 'alias' => 'download', 'lft' => '5', 'rght' => '6'),
		array('id' => '4', 'parent_id' => '1', 'model' => '', 'foreign_key' => null, 'alias' => 'Blog', 'lft' => '8', 'rght' => '33'),
		array('id' => '5', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '9', 'rght' => '10'),
		array('id' => '6', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'category', 'lft' => '11', 'rght' => '12'),
		array('id' => '7', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'article', 'lft' => '13', 'rght' => '14'),
		array('id' => '8', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'quote', 'lft' => '15', 'rght' => '16'),
		array('id' => '9', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'go', 'lft' => '17', 'rght' => '18'),
		array('id' => '10', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'archive', 'lft' => '19', 'rght' => '20'),
		array('id' => '11', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'search', 'lft' => '21', 'rght' => '22'),
		array('id' => '12', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'articleLike', 'lft' => '23', 'rght' => '24'),
		array('id' => '13', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'articleUnlike', 'lft' => '25', 'rght' => '26'),
		array('id' => '14', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'deleteComment', 'lft' => '27', 'rght' => '28'),
		array('id' => '15', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'getEditComment', 'lft' => '29', 'rght' => '30'),
		array('id' => '16', 'parent_id' => '4', 'model' => '', 'foreign_key' => null, 'alias' => 'editComment', 'lft' => '31', 'rght' => '32'),
		array('id' => '17', 'parent_id' => '1', 'model' => '', 'foreign_key' => null, 'alias' => 'Contact', 'lft' => '34', 'rght' => '37'),
		array('id' => '18', 'parent_id' => '17', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '35', 'rght' => '36'),
		array('id' => '19', 'parent_id' => '1', 'model' => '', 'foreign_key' => null, 'alias' => 'Pages', 'lft' => '38', 'rght' => '45'),
		array('id' => '20', 'parent_id' => '19', 'model' => '', 'foreign_key' => null, 'alias' => 'home', 'lft' => '39', 'rght' => '40'),
		array('id' => '21', 'parent_id' => '19', 'model' => '', 'foreign_key' => null, 'alias' => 'acceptCookie', 'lft' => '41', 'rght' => '42'),
		array('id' => '22', 'parent_id' => '19', 'model' => '', 'foreign_key' => null, 'alias' => 'lang', 'lft' => '43', 'rght' => '44'),
		array('id' => '23', 'parent_id' => '1', 'model' => '', 'foreign_key' => null, 'alias' => 'Premium', 'lft' => '46', 'rght' => '57'),
		array('id' => '24', 'parent_id' => '23', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '47', 'rght' => '48'),
		array('id' => '25', 'parent_id' => '23', 'model' => '', 'foreign_key' => null, 'alias' => 'subscribe', 'lft' => '49', 'rght' => '50'),
		array('id' => '26', 'parent_id' => '23', 'model' => '', 'foreign_key' => null, 'alias' => 'notify', 'lft' => '51', 'rght' => '52'),
		array('id' => '27', 'parent_id' => '23', 'model' => '', 'foreign_key' => null, 'alias' => 'success', 'lft' => '53', 'rght' => '54'),
		array('id' => '28', 'parent_id' => '23', 'model' => '', 'foreign_key' => null, 'alias' => 'cancel', 'lft' => '55', 'rght' => '56'),
		array('id' => '29', 'parent_id' => '1', 'model' => '', 'foreign_key' => null, 'alias' => 'Users', 'lft' => '58', 'rght' => '75'),
		array('id' => '30', 'parent_id' => '29', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '59', 'rght' => '60'),
		array('id' => '31', 'parent_id' => '29', 'model' => '', 'foreign_key' => null, 'alias' => 'login', 'lft' => '61', 'rght' => '62'),
		array('id' => '32', 'parent_id' => '29', 'model' => '', 'foreign_key' => null, 'alias' => 'logout', 'lft' => '63', 'rght' => '64'),
		array('id' => '33', 'parent_id' => '29', 'model' => '', 'foreign_key' => null, 'alias' => 'account', 'lft' => '65', 'rght' => '66'),
		array('id' => '34', 'parent_id' => '29', 'model' => '', 'foreign_key' => null, 'alias' => 'settings', 'lft' => '67', 'rght' => '68'),
		array('id' => '35', 'parent_id' => '29', 'model' => '', 'foreign_key' => null, 'alias' => 'profile', 'lft' => '69', 'rght' => '70'),
		array('id' => '36', 'parent_id' => '29', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '71', 'rght' => '72'),
		array('id' => '37', 'parent_id' => '29', 'model' => '', 'foreign_key' => null, 'alias' => 'premium', 'lft' => '73', 'rght' => '74'),
		array('id' => '38', 'parent_id' => '1', 'model' => '', 'foreign_key' => null, 'alias' => 'Groups', 'lft' => '76', 'rght' => '87'),
		array('id' => '39', 'parent_id' => '38', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '77', 'rght' => '78'),
		array('id' => '40', 'parent_id' => '38', 'model' => '', 'foreign_key' => null, 'alias' => 'view', 'lft' => '79', 'rght' => '80'),
		array('id' => '41', 'parent_id' => '38', 'model' => '', 'foreign_key' => null, 'alias' => 'add', 'lft' => '81', 'rght' => '82'),
		array('id' => '42', 'parent_id' => '38', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '83', 'rght' => '84'),
		array('id' => '43', 'parent_id' => '38', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '85', 'rght' => '86'),
		array('id' => '44', 'parent_id' => '1', 'model' => '', 'foreign_key' => null, 'alias' => 'admin', 'lft' => '88', 'rght' => '179'),
		array('id' => '45', 'parent_id' => '44', 'model' => '', 'foreign_key' => null, 'alias' => 'premium', 'lft' => '89', 'rght' => '112'),
		array('id' => '46', 'parent_id' => '45', 'model' => '', 'foreign_key' => null, 'alias' => 'Offers', 'lft' => '90', 'rght' => '99'),
		array('id' => '47', 'parent_id' => '46', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '91', 'rght' => '92'),
		array('id' => '48', 'parent_id' => '46', 'model' => '', 'foreign_key' => null, 'alias' => 'add', 'lft' => '93', 'rght' => '94'),
		array('id' => '49', 'parent_id' => '46', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '95', 'rght' => '96'),
		array('id' => '50', 'parent_id' => '46', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '97', 'rght' => '98'),
		array('id' => '51', 'parent_id' => '45', 'model' => '', 'foreign_key' => null, 'alias' => 'Discounts', 'lft' => '100', 'rght' => '107'),
		array('id' => '52', 'parent_id' => '51', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '101', 'rght' => '102'),
		array('id' => '53', 'parent_id' => '51', 'model' => '', 'foreign_key' => null, 'alias' => 'add', 'lft' => '103', 'rght' => '104'),
		array('id' => '54', 'parent_id' => '51', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '105', 'rght' => '106'),
		array('id' => '55', 'parent_id' => '45', 'model' => '', 'foreign_key' => null, 'alias' => 'Premium', 'lft' => '108', 'rght' => '111'),
		array('id' => '56', 'parent_id' => '55', 'model' => '', 'foreign_key' => null, 'alias' => 'home', 'lft' => '109', 'rght' => '110'),
		array('id' => '57', 'parent_id' => '44', 'model' => '', 'foreign_key' => null, 'alias' => 'Articles', 'lft' => '117', 'rght' => '126'),
		array('id' => '58', 'parent_id' => '57', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '118', 'rght' => '119'),
		array('id' => '59', 'parent_id' => '57', 'model' => '', 'foreign_key' => null, 'alias' => 'add', 'lft' => '120', 'rght' => '121'),
		array('id' => '60', 'parent_id' => '57', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '122', 'rght' => '123'),
		array('id' => '61', 'parent_id' => '57', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '124', 'rght' => '125'),
		array('id' => '62', 'parent_id' => '44', 'model' => '', 'foreign_key' => null, 'alias' => 'Attachments', 'lft' => '127', 'rght' => '136'),
		array('id' => '63', 'parent_id' => '62', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '128', 'rght' => '129'),
		array('id' => '64', 'parent_id' => '62', 'model' => '', 'foreign_key' => null, 'alias' => 'add', 'lft' => '130', 'rght' => '131'),
		array('id' => '65', 'parent_id' => '62', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '132', 'rght' => '133'),
		array('id' => '66', 'parent_id' => '62', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '134', 'rght' => '135'),
		array('id' => '67', 'parent_id' => '44', 'model' => '', 'foreign_key' => null, 'alias' => 'Categories', 'lft' => '137', 'rght' => '146'),
		array('id' => '68', 'parent_id' => '67', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '138', 'rght' => '139'),
		array('id' => '69', 'parent_id' => '67', 'model' => '', 'foreign_key' => null, 'alias' => 'add', 'lft' => '140', 'rght' => '141'),
		array('id' => '70', 'parent_id' => '67', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '142', 'rght' => '143'),
		array('id' => '71', 'parent_id' => '67', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '144', 'rght' => '145'),
		array('id' => '72', 'parent_id' => '44', 'model' => '', 'foreign_key' => null, 'alias' => 'Users', 'lft' => '147', 'rght' => '158'),
		array('id' => '73', 'parent_id' => '72', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '148', 'rght' => '149'),
		array('id' => '74', 'parent_id' => '72', 'model' => '', 'foreign_key' => null, 'alias' => 'search', 'lft' => '150', 'rght' => '151'),
		array('id' => '75', 'parent_id' => '72', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '152', 'rght' => '153'),
		array('id' => '76', 'parent_id' => '72', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '154', 'rght' => '155'),
		array('id' => '77', 'parent_id' => '72', 'model' => '', 'foreign_key' => null, 'alias' => 'deleteAvatar', 'lft' => '156', 'rght' => '157'),
		array('id' => '78', 'parent_id' => '44', 'model' => '', 'foreign_key' => null, 'alias' => 'Admin', 'lft' => '159', 'rght' => '162'),
		array('id' => '79', 'parent_id' => '78', 'model' => '', 'foreign_key' => null, 'alias' => 'home', 'lft' => '160', 'rght' => '161'),
		array('id' => '80', 'parent_id' => '44', 'model' => '', 'foreign_key' => null, 'alias' => 'Groups', 'lft' => '165', 'rght' => '174'),
		array('id' => '81', 'parent_id' => '80', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '166', 'rght' => '167'),
		array('id' => '82', 'parent_id' => '80', 'model' => '', 'foreign_key' => null, 'alias' => 'add', 'lft' => '168', 'rght' => '169'),
		array('id' => '83', 'parent_id' => '80', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '170', 'rght' => '171'),
		array('id' => '84', 'parent_id' => '80', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '172', 'rght' => '173'),
		array('id' => '85', 'parent_id' => '1', 'model' => '', 'foreign_key' => null, 'alias' => 'forum', 'lft' => '180', 'rght' => '225'),
		array('id' => '86', 'parent_id' => '85', 'model' => '', 'foreign_key' => null, 'alias' => 'Forum', 'lft' => '181', 'rght' => '190'),
		array('id' => '87', 'parent_id' => '86', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '182', 'rght' => '183'),
		array('id' => '88', 'parent_id' => '86', 'model' => '', 'foreign_key' => null, 'alias' => 'categories', 'lft' => '184', 'rght' => '185'),
		array('id' => '89', 'parent_id' => '86', 'model' => '', 'foreign_key' => null, 'alias' => 'home', 'lft' => '186', 'rght' => '187'),
		array('id' => '90', 'parent_id' => '86', 'model' => '', 'foreign_key' => null, 'alias' => 'threads', 'lft' => '188', 'rght' => '189'),
		array('id' => '91', 'parent_id' => '85', 'model' => '', 'foreign_key' => null, 'alias' => 'Threads', 'lft' => '191', 'rght' => '206'),
		array('id' => '92', 'parent_id' => '91', 'model' => '', 'foreign_key' => null, 'alias' => 'close', 'lft' => '192', 'rght' => '193'),
		array('id' => '93', 'parent_id' => '91', 'model' => '', 'foreign_key' => null, 'alias' => 'new', 'lft' => '194', 'rght' => '195'),
		array('id' => '94', 'parent_id' => '85', 'model' => '', 'foreign_key' => null, 'alias' => 'Posts', 'lft' => '207', 'rght' => '224'),
		array('id' => '95', 'parent_id' => '94', 'model' => '', 'foreign_key' => null, 'alias' => 'new', 'lft' => '208', 'rght' => '209'),
		array('id' => '96', 'parent_id' => '91', 'model' => '', 'foreign_key' => null, 'alias' => 'reply', 'lft' => '196', 'rght' => '197'),
		array('id' => '97', 'parent_id' => '91', 'model' => '', 'foreign_key' => null, 'alias' => 'lock', 'lft' => '198', 'rght' => '199'),
		array('id' => '98', 'parent_id' => '91', 'model' => '', 'foreign_key' => null, 'alias' => 'unlock', 'lft' => '200', 'rght' => '201'),
		array('id' => '99', 'parent_id' => '94', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '210', 'rght' => '211'),
		array('id' => '100', 'parent_id' => '91', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '202', 'rght' => '203'),
		array('id' => '101', 'parent_id' => '94', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '212', 'rght' => '213'),
		array('id' => '102', 'parent_id' => '94', 'model' => '', 'foreign_key' => null, 'alias' => 'go', 'lft' => '214', 'rght' => '215'),
		array('id' => '103', 'parent_id' => '94', 'model' => '', 'foreign_key' => null, 'alias' => 'getEditPost', 'lft' => '216', 'rght' => '217'),
		array('id' => '104', 'parent_id' => '91', 'model' => '', 'foreign_key' => null, 'alias' => 'create', 'lft' => '204', 'rght' => '205'),
		array('id' => '105', 'parent_id' => '94', 'model' => '', 'foreign_key' => null, 'alias' => 'quote', 'lft' => '218', 'rght' => '219'),
		array('id' => '106', 'parent_id' => '94', 'model' => '', 'foreign_key' => null, 'alias' => 'like', 'lft' => '220', 'rght' => '221'),
		array('id' => '107', 'parent_id' => '94', 'model' => '', 'foreign_key' => null, 'alias' => 'unlike', 'lft' => '222', 'rght' => '223'),
		array('id' => '108', 'parent_id' => '1', 'model' => '', 'foreign_key' => null, 'alias' => 'chat', 'lft' => '226', 'rght' => '251'),
		array('id' => '109', 'parent_id' => '108', 'model' => '', 'foreign_key' => null, 'alias' => 'Chat', 'lft' => '227', 'rght' => '238'),
		array('id' => '110', 'parent_id' => '109', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '228', 'rght' => '229'),
		array('id' => '111', 'parent_id' => '109', 'model' => '', 'foreign_key' => null, 'alias' => 'getNotice', 'lft' => '230', 'rght' => '231'),
		array('id' => '112', 'parent_id' => '109', 'model' => '', 'foreign_key' => null, 'alias' => 'editNotice', 'lft' => '232', 'rght' => '233'),
		array('id' => '113', 'parent_id' => '109', 'model' => '', 'foreign_key' => null, 'alias' => 'shout', 'lft' => '234', 'rght' => '235'),
		array('id' => '114', 'parent_id' => '108', 'model' => '', 'foreign_key' => null, 'alias' => 'Permissions', 'lft' => '239', 'rght' => '250'),
		array('id' => '115', 'parent_id' => '114', 'model' => '', 'foreign_key' => null, 'alias' => 'canPrune', 'lft' => '240', 'rght' => '241'),
		array('id' => '116', 'parent_id' => '114', 'model' => '', 'foreign_key' => null, 'alias' => 'canBan', 'lft' => '242', 'rght' => '243'),
		array('id' => '117', 'parent_id' => '114', 'model' => '', 'foreign_key' => null, 'alias' => 'canUnban', 'lft' => '244', 'rght' => '245'),
		array('id' => '118', 'parent_id' => '114', 'model' => '', 'foreign_key' => null, 'alias' => 'canDelete', 'lft' => '246', 'rght' => '247'),
		array('id' => '119', 'parent_id' => '114', 'model' => '', 'foreign_key' => null, 'alias' => 'canNotice', 'lft' => '248', 'rght' => '249'),
		array('id' => '120', 'parent_id' => '109', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '236', 'rght' => '237')
	);

}
