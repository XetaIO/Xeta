<?php
use Migrations\AbstractSeed;

class BlogArticlesCommentsSeed extends AbstractSeed
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
                'user_id' => '1',
                'content' => '<p>Lorem i<strong>psum dolor sit amet,</strong> consectetuer adipiscing elit, sed diam nonummy nibh <u>euismod tincidunt </u>ut laoreet dolore <em>magna aliquam </em>erat volutpat.</p>',
                'created' => '2014-09-22 10:16:21',
                'modified' => '2014-09-22 10:16:21'
            ],
            [
                'article_id' => '1',
                'user_id' => '2',
                'content' => '<p><a href="/blog/go/1"><strong>Admin has said :</strong> </a></p>

<blockquote>
<p>Lorem i<strong>psum dolor sit amet,</strong> consectetuer adipiscing elit, sed diam nonummy nibh <u>euismod tincidunt </u>ut laoreet dolore <em>magna aliquam </em>erat volutpat.</p>
</blockquote>

<p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse <strong>molestie consequat,</strong> vel illum dolore eu feugiat nulla facilisis <em>at vero eros</em> et accumsan et iusto odio dignissim qui blandit praesent <u>luptatum zzril delenit</u> augue duis dolore te feugait nulla facilisi.</p>',
                'created' => '2014-09-22 10:19:30',
                'modified' => '2014-09-22 10:19:30'
            ]
        ];

        $table = $this->table('blog_articles_comments');
        $table->insert($data)->save();
    }
}
