<?php
use Migrations\AbstractSeed;

class BlogCategoriesSeed extends AbstractSeed
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
                'title' => 'XetaFr',
                'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit fr.',
                'article_count' => '1',
                'created' => '2014-09-22 10:00:00',
                'modified' => '2016-11-01 08:12:19'
            ]
        ];

        $table = $this->table('blog_categories');
        $table->insert($data)->save();
    }
}
