<?php
use Migrations\AbstractSeed;

class ArosSeed extends AbstractSeed
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
                'parent_id' => null,
                'model' => 'Groups',
                'foreign_key' => '1',
                'alias' => '',
                'lft' => '9',
                'rght' => '10'
            ],
            [
                'parent_id' => null,
                'model' => 'Groups',
                'foreign_key' => '2',
                'alias' => '',
                'lft' => '7',
                'rght' => '8'
            ],
            [
                'parent_id' => null,
                'model' => 'Groups',
                'foreign_key' => '3',
                'alias' => '',
                'lft' => '5',
                'rght' => '6'
            ],
            [
                'parent_id' => null,
                'model' => 'Groups',
                'foreign_key' => '4',
                'alias' => '',
                'lft' => '3',
                'rght' => '4'
            ],
            [
                'parent_id' => null,
                'model' => 'Groups',
                'foreign_key' => '5',
                'alias' => '',
                'lft' => '1',
                'rght' => '2'
            ]
        ];

        $table = $this->table('aros');
        $table->insert($data)->save();
    }
}
