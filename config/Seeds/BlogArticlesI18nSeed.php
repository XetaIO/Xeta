<?php
use Migrations\AbstractSeed;

class BlogArticlesI18nSeed extends AbstractSeed
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
                'model' => 'BlogArticles',
                'foreign_key' => '1',
                'field' => 'title',
                'content' => 'Title in english'
            ],
            [
                'locale' => 'en_US',
                'model' => 'BlogArticles',
                'foreign_key' => '1',
                'field' => 'content',
                'content' => '<p>Content in english</p>'
            ]
        ];

        $table = $this->table('blog_articles_i18n');
        $table->insert($data)->save();
    }
}
