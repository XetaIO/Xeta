<?php
use Migrations\AbstractSeed;

class GroupsI18nSeed extends AbstractSeed
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
                'locale' => 'en_US',
                'model' => 'Groups',
                'foreign_key' => '1',
                'field' => 'name',
                'content' => 'Banned'
            ],
            [
                'locale' => 'en_US',
                'model' => 'Groups',
                'foreign_key' => '2',
                'field' => 'name',
                'content' => 'Member'
            ],
            [
                'locale' => 'en_US',
                'model' => 'Groups',
                'foreign_key' => '3',
                'field' => 'name',
                'content' => 'Editor'
            ],
            [
                'locale' => 'en_US',
                'model' => 'Groups',
                'foreign_key' => '4',
                'field' => 'name',
                'content' => 'Moderator'
            ],
            [
                'locale' => 'en_US',
                'model' => 'Groups',
                'foreign_key' => '5',
                'field' => 'name',
                'content' => 'Administrator'
            ]
        ];

        $table = $this->table('groups_i18n');
        $table->insert($data)->save();
    }
}
