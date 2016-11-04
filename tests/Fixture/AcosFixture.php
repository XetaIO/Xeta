<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class AcosFixture extends TestFixture
{

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
        ['id' => '1', 'parent_id' => null, 'model' => null, 'foreign_key' => null, 'alias' => 'app', 'lft' => '1', 'rght' => '178'],
        ['id' => '2', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Conversations', 'lft' => '2', 'rght' => '35'],
        ['id' => '3', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '3', 'rght' => '4'],
        ['id' => '4', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'action', 'lft' => '5', 'rght' => '6'],
        ['id' => '5', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'create', 'lft' => '7', 'rght' => '8'],
        ['id' => '6', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'view', 'lft' => '9', 'rght' => '10'],
        ['id' => '7', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'inviteMember', 'lft' => '11', 'rght' => '12'],
        ['id' => '8', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'quote', 'lft' => '13', 'rght' => '14'],
        ['id' => '9', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'getEditMessage', 'lft' => '15', 'rght' => '16'],
        ['id' => '10', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'messageEdit', 'lft' => '17', 'rght' => '18'],
        ['id' => '11', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'go', 'lft' => '19', 'rght' => '20'],
        ['id' => '12', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'kick', 'lft' => '21', 'rght' => '22'],
        ['id' => '13', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'reply', 'lft' => '23', 'rght' => '24'],
        ['id' => '14', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '25', 'rght' => '26'],
        ['id' => '15', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'invite', 'lft' => '27', 'rght' => '28'],
        ['id' => '16', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'leave', 'lft' => '29', 'rght' => '30'],
        ['id' => '17', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'search', 'lft' => '31', 'rght' => '32'],
        ['id' => '18', 'parent_id' => '2', 'model' => null, 'foreign_key' => null, 'alias' => 'maintenance', 'lft' => '33', 'rght' => '34'],
        ['id' => '19', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Pages', 'lft' => '36', 'rght' => '45'],
        ['id' => '20', 'parent_id' => '19', 'model' => null, 'foreign_key' => null, 'alias' => 'home', 'lft' => '37', 'rght' => '38'],
        ['id' => '21', 'parent_id' => '19', 'model' => null, 'foreign_key' => null, 'alias' => 'acceptCookie', 'lft' => '39', 'rght' => '40'],
        ['id' => '22', 'parent_id' => '19', 'model' => null, 'foreign_key' => null, 'alias' => 'lang', 'lft' => '41', 'rght' => '42'],
        ['id' => '23', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Attachments', 'lft' => '46', 'rght' => '49'],
        ['id' => '24', 'parent_id' => '23', 'model' => null, 'foreign_key' => null, 'alias' => 'download', 'lft' => '47', 'rght' => '48'],
        ['id' => '25', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Groups', 'lft' => '50', 'rght' => '53'],
        ['id' => '26', 'parent_id' => '25', 'model' => null, 'foreign_key' => null, 'alias' => 'view', 'lft' => '51', 'rght' => '52'],
        ['id' => '27', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Contact', 'lft' => '54', 'rght' => '57'],
        ['id' => '28', 'parent_id' => '27', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '55', 'rght' => '56'],
        ['id' => '30', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Users', 'lft' => '58', 'rght' => '79'],
        ['id' => '31', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '59', 'rght' => '60'],
        ['id' => '32', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'login', 'lft' => '61', 'rght' => '62'],
        ['id' => '33', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'logout', 'lft' => '63', 'rght' => '64'],
        ['id' => '34', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'account', 'lft' => '65', 'rght' => '66'],
        ['id' => '35', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'settings', 'lft' => '67', 'rght' => '68'],
        ['id' => '36', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'profile', 'lft' => '69', 'rght' => '70'],
        ['id' => '37', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '71', 'rght' => '72'],
        ['id' => '38', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'notifications', 'lft' => '73', 'rght' => '74'],
        ['id' => '39', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'forgotPassword', 'lft' => '75', 'rght' => '76'],
        ['id' => '40', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'resetPassword', 'lft' => '77', 'rght' => '78'],
        ['id' => '42', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Notifications', 'lft' => '80', 'rght' => '83'],
        ['id' => '43', 'parent_id' => '42', 'model' => null, 'foreign_key' => null, 'alias' => 'markAsRead', 'lft' => '81', 'rght' => '82'],
        ['id' => '44', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Blog', 'lft' => '84', 'rght' => '109'],
        ['id' => '45', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '85', 'rght' => '86'],
        ['id' => '46', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'category', 'lft' => '87', 'rght' => '88'],
        ['id' => '47', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'article', 'lft' => '89', 'rght' => '90'],
        ['id' => '48', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'quote', 'lft' => '91', 'rght' => '92'],
        ['id' => '49', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'go', 'lft' => '93', 'rght' => '94'],
        ['id' => '50', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'archive', 'lft' => '95', 'rght' => '96'],
        ['id' => '51', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'search', 'lft' => '97', 'rght' => '98'],
        ['id' => '52', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'articleLike', 'lft' => '99', 'rght' => '100'],
        ['id' => '53', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'articleUnlike', 'lft' => '101', 'rght' => '102'],
        ['id' => '54', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'deleteComment', 'lft' => '103', 'rght' => '104'],
        ['id' => '55', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'getEditComment', 'lft' => '105', 'rght' => '106'],
        ['id' => '56', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'editComment', 'lft' => '107', 'rght' => '108'],
        ['id' => '58', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Admin', 'lft' => '110', 'rght' => '177'],
        ['id' => '59', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Categories', 'lft' => '111', 'rght' => '120'],
        ['id' => '60', 'parent_id' => '59', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '112', 'rght' => '113'],
        ['id' => '61', 'parent_id' => '59', 'model' => null, 'foreign_key' => null, 'alias' => 'add', 'lft' => '114', 'rght' => '115'],
        ['id' => '62', 'parent_id' => '59', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '116', 'rght' => '117'],
        ['id' => '63', 'parent_id' => '59', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '118', 'rght' => '119'],
        ['id' => '64', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Attachments', 'lft' => '121', 'rght' => '130'],
        ['id' => '65', 'parent_id' => '64', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '122', 'rght' => '123'],
        ['id' => '66', 'parent_id' => '64', 'model' => null, 'foreign_key' => null, 'alias' => 'add', 'lft' => '124', 'rght' => '125'],
        ['id' => '67', 'parent_id' => '64', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '126', 'rght' => '127'],
        ['id' => '68', 'parent_id' => '64', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '128', 'rght' => '129'],
        ['id' => '69', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Groups', 'lft' => '131', 'rght' => '140'],
        ['id' => '70', 'parent_id' => '69', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '132', 'rght' => '133'],
        ['id' => '71', 'parent_id' => '69', 'model' => null, 'foreign_key' => null, 'alias' => 'add', 'lft' => '134', 'rght' => '135'],
        ['id' => '72', 'parent_id' => '69', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '136', 'rght' => '137'],
        ['id' => '73', 'parent_id' => '69', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '138', 'rght' => '139'],
        ['id' => '74', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Users', 'lft' => '141', 'rght' => '152'],
        ['id' => '75', 'parent_id' => '74', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '142', 'rght' => '143'],
        ['id' => '76', 'parent_id' => '74', 'model' => null, 'foreign_key' => null, 'alias' => 'search', 'lft' => '144', 'rght' => '145'],
        ['id' => '77', 'parent_id' => '74', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '146', 'rght' => '147'],
        ['id' => '78', 'parent_id' => '74', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '148', 'rght' => '149'],
        ['id' => '79', 'parent_id' => '74', 'model' => null, 'foreign_key' => null, 'alias' => 'deleteAvatar', 'lft' => '150', 'rght' => '151'],
        ['id' => '80', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Admin', 'lft' => '153', 'rght' => '156'],
        ['id' => '81', 'parent_id' => '80', 'model' => null, 'foreign_key' => null, 'alias' => 'home', 'lft' => '154', 'rght' => '155'],
        ['id' => '82', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Articles', 'lft' => '157', 'rght' => '166'],
        ['id' => '83', 'parent_id' => '82', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '158', 'rght' => '159'],
        ['id' => '84', 'parent_id' => '82', 'model' => null, 'foreign_key' => null, 'alias' => 'add', 'lft' => '160', 'rght' => '161'],
        ['id' => '85', 'parent_id' => '82', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '162', 'rght' => '163'],
        ['id' => '86', 'parent_id' => '82', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '164', 'rght' => '165'],
        ['id' => '87', 'parent_id' => '19', 'model' => '', 'foreign_key' => null, 'alias' => 'terms', 'lft' => '43', 'rght' => '44'],
        ['id' => '88', 'parent_id' => '58', 'model' => '', 'foreign_key' => null, 'alias' => 'Settings', 'lft' => '167', 'rght' => '176'],
        ['id' => '89', 'parent_id' => '88', 'model' => '', 'foreign_key' => null, 'alias' => 'index', 'lft' => '168', 'rght' => '169'],
        ['id' => '90', 'parent_id' => '88', 'model' => '', 'foreign_key' => null, 'alias' => 'create', 'lft' => '170', 'rght' => '171'],
        ['id' => '91', 'parent_id' => '88', 'model' => '', 'foreign_key' => null, 'alias' => 'edit', 'lft' => '172', 'rght' => '173'],
        ['id' => '92', 'parent_id' => '88', 'model' => '', 'foreign_key' => null, 'alias' => 'delete', 'lft' => '174', 'rght' => '175']
    ];
}
