<?php
namespace App\Model\Entity;

use App\Model\Behavior\AppTranslateTrait;
use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;

class Group extends Entity
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
     * The parendNode for ACL.
     *
     * @return null
     */
    public function parentNode()
    {
        return null;
    }
}
