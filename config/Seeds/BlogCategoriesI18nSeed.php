<?php
use Migrations\AbstractSeed;

class BlogCategoriesI18nSeed extends AbstractSeed
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
                'model' => 'BlogCategories',
                'foreign_key' => '1',
                'field' => 'title',
                'content' => 'XetaEn'
            ],
            [
                'locale' => 'en_US',
                'model' => 'BlogCategories',
                'foreign_key' => '1',
                'field' => 'description',
                'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit en.'
            ]
        ];

        $table = $this->table('blog_categories_i18n');
        $table->insert($data)->save();
    }
}
