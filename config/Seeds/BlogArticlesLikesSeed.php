<?php
use Migrations\AbstractSeed;

class BlogArticlesLikesSeed extends AbstractSeed
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
                'article_id' => '1',
                'user_id' => '2',
                'created' => '2014-09-22 10:21:34',
                'modified' => '2014-09-22 10:21:34'
            ],
            [
                'article_id' => '1',
                'user_id' => '1',
                'created' => '2016-10-29 22:29:07',
                'modified' => '2016-10-29 22:29:07'
            ]
        ];

        $table = $this->table('blog_articles_likes');
        $table->insert($data)->save();
    }
}
