<?php
use Migrations\AbstractMigration;

class AddTwoFactorAuthEnabledToUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('two_factor_auth_enabled', 'boolean', [
            'default' => 0,
            'limit' => null,
            'null' => false,
        ]);
        $table->update();
    }
}
