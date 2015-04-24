<?php
namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;
use HTMLPurifier;
use HTMLPurifier_Config;

class ForumPost extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true
    ];

    /**
     * Purify the message for display the post.
     *
     * @param string $content The message to be purified.
     *
     * @return string
     */
    protected function _getMessage($content)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.Forum.post'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($content);
    }

    /**
     * Purify the message for display the post in suggestion.
     *
     * @return string
     */
    protected function _getMessageEmpty()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.Forum.post_empty'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($this->message);
    }

    /**
     * Purify the message for display the post in meta tags.
     *
     * @return string
     */
    protected function _getMessageMeta()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.Forum.post_meta'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($this->message);
    }
}
