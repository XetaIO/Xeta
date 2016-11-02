<?php
use Migrations\AbstractSeed;

class BadgesSeed extends AbstractSeed
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
                'name' => 'Premier Commentaire',
                'picture' => 'badges/comments-1.png',
                'type' => 'comments',
                'rule' => '1',
                'created' => '2014-11-10 14:00:00'
            ],
            [
                'name' => '10 Commentaires',
                'picture' => 'badges/comments-10.png',
                'type' => 'comments',
                'rule' => '10',
                'created' => '2014-11-10 14:00:00'
            ],
            [
                'name' => 'Inscrit depuis 1 an',
                'picture' => 'badges/registration-1.png',
                'type' => 'registration',
                'rule' => '1',
                'created' => '2014-11-10 16:00:00'
            ],
            [
                'name' => 'Inscrit depuis 2 ans',
                'picture' => 'badges/registration-2.png',
                'type' => 'registration',
                'rule' => '2',
                'created' => '2014-11-10 16:00:00'
            ],
            [
                'name' => 'Inscrit depuis 3 ans',
                'picture' => 'badges/registration-3.png',
                'type' => 'registration',
                'rule' => '3',
                'created' => '2014-11-10 16:00:00'
            ]
        ];

        $table = $this->table('badges');
        $table->insert($data)->save();
    }
}
