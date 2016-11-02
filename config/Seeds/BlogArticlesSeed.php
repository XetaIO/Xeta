<?php
use Migrations\AbstractSeed;

class BlogArticlesSeed extends AbstractSeed
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
                'category_id' => '1',
                'user_id' => '1',
                'title' => 'Lorem ipsum dolor sit amet',
                'content' => '<p><strong>Lorem ipsum</strong> dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>

<blockquote>
<p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
</blockquote>

<p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat : </p>

<ul><li>vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto</li>
    <li>odio dignissim qui blandit praesent luptatum zzril</li>
    <li>delenit augue duis dolore te feugait nulla facilisi</li>
</ul><p> </p>

<p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. <img alt="heureux" src="https://xeta.io/js/ckeditor/plugins/smiley/images/heureux.png" style="height:19px;width:19px;" title="heureux" /></p>',
                'comment_count' => '2',
                'like_count' => '2',
                'is_display' => '1',
                'created' => '2014-09-22 10:10:00',
                'modified' => '2014-09-22 10:10:00'
            ]
        ];

        $table = $this->table('blog_articles');
        $table->insert($data)->save();
    }
}
