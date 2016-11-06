<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersTwoFactorAuthFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'users_two_factor_auth';

    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'secret' => ['type' => 'string'],
        'username' => ['type' => 'string'],
        'current_code' => ['type' => 'string', 'length' => 6],
        'recovery_code' => ['type' => 'string'],
        'recovery_code_used' => ['type' => 'boolean', 'default' => '0'],
        'session' => ['type' => 'text'],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
}
