<?php
namespace App\Model\Entity;

use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;

class Group extends Entity
{

    use TranslateTrait;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true
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
