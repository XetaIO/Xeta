<?php
use Migrations\AbstractSeed;

class AcosSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => '1', 'parent_id' => null, 'model' => null, 'foreign_key' => null, 'alias' => 'app', 'lft' => '1', 'rght' => '166'],
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
            ['id' => '19', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Pages', 'lft' => '36', 'rght' => '43'],
            ['id' => '20', 'parent_id' => '19', 'model' => null, 'foreign_key' => null, 'alias' => 'home', 'lft' => '37', 'rght' => '38'],
            ['id' => '21', 'parent_id' => '19', 'model' => null, 'foreign_key' => null, 'alias' => 'acceptCookie', 'lft' => '39', 'rght' => '40'],
            ['id' => '22', 'parent_id' => '19', 'model' => null, 'foreign_key' => null, 'alias' => 'lang', 'lft' => '41', 'rght' => '42'],
            ['id' => '23', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Attachments', 'lft' => '44', 'rght' => '47'],
            ['id' => '24', 'parent_id' => '23', 'model' => null, 'foreign_key' => null, 'alias' => 'download', 'lft' => '45', 'rght' => '46'],
            ['id' => '25', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Groups', 'lft' => '48', 'rght' => '51'],
            ['id' => '26', 'parent_id' => '25', 'model' => null, 'foreign_key' => null, 'alias' => 'view', 'lft' => '49', 'rght' => '50'],
            ['id' => '27', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Contact', 'lft' => '52', 'rght' => '55'],
            ['id' => '28', 'parent_id' => '27', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '53', 'rght' => '54'],
            ['id' => '30', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Users', 'lft' => '56', 'rght' => '77'],
            ['id' => '31', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '57', 'rght' => '58'],
            ['id' => '32', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'login', 'lft' => '59', 'rght' => '60'],
            ['id' => '33', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'logout', 'lft' => '61', 'rght' => '62'],
            ['id' => '34', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'account', 'lft' => '63', 'rght' => '64'],
            ['id' => '35', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'settings', 'lft' => '65', 'rght' => '66'],
            ['id' => '36', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'profile', 'lft' => '67', 'rght' => '68'],
            ['id' => '37', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '69', 'rght' => '70'],
            ['id' => '38', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'notifications', 'lft' => '71', 'rght' => '72'],
            ['id' => '39', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'forgotPassword', 'lft' => '73', 'rght' => '74'],
            ['id' => '40', 'parent_id' => '30', 'model' => null, 'foreign_key' => null, 'alias' => 'resetPassword', 'lft' => '75', 'rght' => '76'],
            ['id' => '42', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Notifications', 'lft' => '78', 'rght' => '81'],
            ['id' => '43', 'parent_id' => '42', 'model' => null, 'foreign_key' => null, 'alias' => 'markAsRead', 'lft' => '79', 'rght' => '80'],
            ['id' => '44', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'Blog', 'lft' => '82', 'rght' => '107'],
            ['id' => '45', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '83', 'rght' => '84'],
            ['id' => '46', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'category', 'lft' => '85', 'rght' => '86'],
            ['id' => '47', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'article', 'lft' => '87', 'rght' => '88'],
            ['id' => '48', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'quote', 'lft' => '89', 'rght' => '90'],
            ['id' => '49', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'go', 'lft' => '91', 'rght' => '92'],
            ['id' => '50', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'archive', 'lft' => '93', 'rght' => '94'],
            ['id' => '51', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'search', 'lft' => '95', 'rght' => '96'],
            ['id' => '52', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'articleLike', 'lft' => '97', 'rght' => '98'],
            ['id' => '53', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'articleUnlike', 'lft' => '99', 'rght' => '100'],
            ['id' => '54', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'deleteComment', 'lft' => '101', 'rght' => '102'],
            ['id' => '55', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'getEditComment', 'lft' => '103', 'rght' => '104'],
            ['id' => '56', 'parent_id' => '44', 'model' => null, 'foreign_key' => null, 'alias' => 'editComment', 'lft' => '105', 'rght' => '106'],
            ['id' => '58', 'parent_id' => '1', 'model' => null, 'foreign_key' => null, 'alias' => 'admin', 'lft' => '108', 'rght' => '165'],
            ['id' => '59', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Categories', 'lft' => '109', 'rght' => '118'],
            ['id' => '60', 'parent_id' => '59', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '110', 'rght' => '111'],
            ['id' => '61', 'parent_id' => '59', 'model' => null, 'foreign_key' => null, 'alias' => 'add', 'lft' => '112', 'rght' => '113'],
            ['id' => '62', 'parent_id' => '59', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '114', 'rght' => '115'],
            ['id' => '63', 'parent_id' => '59', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '116', 'rght' => '117'],
            ['id' => '64', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Attachments', 'lft' => '119', 'rght' => '128'],
            ['id' => '65', 'parent_id' => '64', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '120', 'rght' => '121'],
            ['id' => '66', 'parent_id' => '64', 'model' => null, 'foreign_key' => null, 'alias' => 'add', 'lft' => '122', 'rght' => '123'],
            ['id' => '67', 'parent_id' => '64', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '124', 'rght' => '125'],
            ['id' => '68', 'parent_id' => '64', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '126', 'rght' => '127'],
            ['id' => '69', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Groups', 'lft' => '129', 'rght' => '138'],
            ['id' => '70', 'parent_id' => '69', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '130', 'rght' => '131'],
            ['id' => '71', 'parent_id' => '69', 'model' => null, 'foreign_key' => null, 'alias' => 'add', 'lft' => '132', 'rght' => '133'],
            ['id' => '72', 'parent_id' => '69', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '134', 'rght' => '135'],
            ['id' => '73', 'parent_id' => '69', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '136', 'rght' => '137'],
            ['id' => '74', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Users', 'lft' => '139', 'rght' => '150'],
            ['id' => '75', 'parent_id' => '74', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '140', 'rght' => '141'],
            ['id' => '76', 'parent_id' => '74', 'model' => null, 'foreign_key' => null, 'alias' => 'search', 'lft' => '142', 'rght' => '143'],
            ['id' => '77', 'parent_id' => '74', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '144', 'rght' => '145'],
            ['id' => '78', 'parent_id' => '74', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '146', 'rght' => '147'],
            ['id' => '79', 'parent_id' => '74', 'model' => null, 'foreign_key' => null, 'alias' => 'deleteAvatar', 'lft' => '148', 'rght' => '149'],
            ['id' => '80', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Admin', 'lft' => '151', 'rght' => '154'],
            ['id' => '81', 'parent_id' => '80', 'model' => null, 'foreign_key' => null, 'alias' => 'home', 'lft' => '152', 'rght' => '153'],
            ['id' => '82', 'parent_id' => '58', 'model' => null, 'foreign_key' => null, 'alias' => 'Articles', 'lft' => '155', 'rght' => '164'],
            ['id' => '83', 'parent_id' => '82', 'model' => null, 'foreign_key' => null, 'alias' => 'index', 'lft' => '156', 'rght' => '157'],
            ['id' => '84', 'parent_id' => '82', 'model' => null, 'foreign_key' => null, 'alias' => 'add', 'lft' => '158', 'rght' => '159'],
            ['id' => '85', 'parent_id' => '82', 'model' => null, 'foreign_key' => null, 'alias' => 'edit', 'lft' => '160', 'rght' => '161'],
            ['id' => '86', 'parent_id' => '82', 'model' => null, 'foreign_key' => null, 'alias' => 'delete', 'lft' => '162', 'rght' => '163']
        ];

        $table = $this->table('acos');
        $table->insert($data)->save();
    }
}
