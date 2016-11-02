<?php
namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;
use HTMLPurifier;
use HTMLPurifier_Config;

class BlogArticlesComment extends Entity
{

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
     * Get the comment content purified with HTMLPurifier.
     *
     * @param string $content The content to be purified.
     *
     * @return string
     */
    protected function _getContent($content)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.Blog.comment'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($content);
    }

    /**
     * Get the comment content purified with HTMLPurifier.
     *
     * @return string
     */
    protected function _getContentEmpty()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.Blog.comment_empty'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($this->content);
    }
}
