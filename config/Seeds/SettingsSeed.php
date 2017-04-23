<?php

use Phinx\Seed\AbstractSeed;

class SettingsSeed extends AbstractSeed
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
            [
                'name' => 'User.Login.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => '1',
                'last_updated_user_id' => '1',
                'created' => '2015-12-08 01:00:00',
                'modified' => '2015-12-08 13:30:48'
            ],
            [
                'name' => 'Site.version',
                'value_int' => null,
                'value_str' => '3.1.1',
                'value_bool' => null,
                'last_updated_user_id' => '1',
                'created' => '2015-12-08 01:00:00',
                'modified' => '2015-12-08 10:52:48'
            ],
            [
                'name' => 'Conversations.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => '1',
                'last_updated_user_id' => '1',
                'created' => '2015-12-08 10:38:44',
                'modified' => '2015-12-08 15:34:40'
            ]
        ];

        $settings = $this->table('settings');
        $settings->insert($data)
            ->save();
    }
}
