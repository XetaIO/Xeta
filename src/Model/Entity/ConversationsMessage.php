<?php
namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;
use HTMLPurifier;
use HTMLPurifier_Config;

class ConversationsMessage extends Entity
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
     * Purify the message for display the message.
     *
     * @param string $content The message to be purified.
     *
     * @return string
     */
    protected function _getMessage($content)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.Conversations.message'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($content);
    }

    /**
     * Purify the message for display the message.
     *
     * @return string
     */
    protected function _getMessageEmpty()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.Conversations.message_empty'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($this->message);
    }
}
