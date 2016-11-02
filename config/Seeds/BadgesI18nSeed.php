<?php
use Migrations\AbstractSeed;

class BadgesI18nSeed extends AbstractSeed
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
                'model' => 'Badges',
                'foreign_key' => '1',
                'field' => 'name',
                'content' => 'First Comments'
            ],
            [
                'locale' => 'en_US',
                'model' => 'Badges',
                'foreign_key' => '2',
                'field' => 'name',
                'content' => '10 Comments'
            ],
            [
                'locale' => 'en_US',
                'model' => 'Badges',
                'foreign_key' => '3',
                'field' => 'name',
                'content' => '1 year old'
            ],
            [
                'locale' => 'en_US',
                'model' => 'Badges',
                'foreign_key' => '4',
                'field' => 'name',
                'content' => '2 years old'
            ],
            [
                'locale' => 'en_US',
                'model' => 'Badges',
                'foreign_key' => '5',
                'field' => 'name',
                'content' => '3 years old'
            ]
        ];

        $table = $this->table('badges_i18n');
        $table->insert($data)->save();
    }
}
