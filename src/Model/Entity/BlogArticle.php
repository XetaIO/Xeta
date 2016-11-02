<?php
namespace App\Model\Entity;

use App\Model\Behavior\AppTranslateTrait;
use Cake\Core\Configure;
use Cake\I18n\Number;
use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;
use HTMLPurifier;
use HTMLPurifier_Config;

class BlogArticle extends Entity
{

    use AppTranslateTrait;
    use TranslateTrait;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Purify the content for display the article.
     *
     * @param string $content The content to be purified.
     *
     * @return string
     */
    protected function _getContent($content)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.Blog.article'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($content);
    }

    /**
     * Purify the content for display the article on category/archives/index blog page.
     *
     * @return string
     */
    protected function _getContentEmpty()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.Blog.article_empty'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($this->content);
    }

    /**
     * Purify the content for display the article in meta tags.
     *
     * @return string
     */
    protected function _getContentMeta()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.Blog.article_meta'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($this->content);
    }

    /**
     * Get the last page of an article.
     *
     * @return int
     */
    protected function _getLastPage()
    {
        $page = ceil($this->comment_count / Configure::read('Blog.comment_per_page'));

        return ($page) ? $page : 1;
    }

    /**
     * Get the number of comments formatted.
     *
     * @return string
     */
    protected function _getCommentCountFormat()
    {
        return Number::format($this->comment_count);
    }

    /**
     * Get the number of likes formatted.
     *
     * @return string
     */
    protected function _getLikeCountFormat()
    {
        return Number::format($this->like_count);
    }
}
