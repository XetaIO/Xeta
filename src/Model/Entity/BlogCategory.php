<?php
namespace App\Model\Entity;

use App\Model\Behavior\AppTranslateTrait;
use Cake\I18n\Number;
use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;

class BlogCategory extends Entity
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
     * Get the number of articles formatted.
     *
     * @return string
     */
    protected function _getArticleCountFormat()
    {
        return Number::format($this->article_count);
    }
}
