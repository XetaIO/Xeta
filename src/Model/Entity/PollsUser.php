<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PollsUser Entity
 *
 * @property int $id
 * @property int $poll_id
 * @property int $user_id
 * @property int $answer_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Poll $poll
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Answer $answer
 */
class PollsUser extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
