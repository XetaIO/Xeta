<?php
use Migrations\AbstractSeed;

class GroupsSeed extends AbstractSeed
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
                'name' => 'Banni',
                'css' => 'color:#A1705D;font-weight:bold;',
                'is_staff' => '0',
                'is_member' => '0',
                'created' => '2015-01-16 16:51:12',
                'modified' => '2015-01-21 02:03:10'
            ],
            [
                'name' => 'Membre',
                'css' => 'font-weight:bold;',
                'is_staff' => '0',
                'is_member' => '1',
                'created' => '2015-01-16 16:51:22',
                'modified' => '2015-01-21 02:02:21'
            ],
            [
                'name' => 'Éditeur',
                'css' => 'color:#9ADD7D;font-weight:bold;',
                'is_staff' => '1',
                'is_member' => '0',
                'created' => '2015-01-16 16:51:30',
                'modified' => '2015-01-21 02:02:12'
            ],
            [
                'name' => 'Modérateur',
                'css' => 'color:#FF6B43;font-weight:bold;',
                'is_staff' => '1',
                'is_member' => '0',
                'created' => '2015-01-16 16:51:51',
                'modified' => '2015-01-21 02:02:03'
            ],
            [
                'name' => 'Administrateur',
                'css' => 'color:#FF4A43;font-weight:bold;',
                'is_staff' => '1',
                'is_member' => '0',
                'created' => '2015-01-16 16:52:00',
                'modified' => '2016-11-01 08:28:26'
            ]
        ];

        $table = $this->table('groups');
        $table->insert($data)->save();
    }
}
