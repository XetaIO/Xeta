<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PollsAnswer Entity
 *
 * @property int $id
 * @property int $poll_id
 * @property string $response
 * @property int $user_count
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Poll $poll
 */
class PollsAnswer extends Entity
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

    /**
     * Get the percentage of the answer's vote relative to the total of vote.
     *
     * @return int
     */
    protected function _getPercentage()
    {
        if ($this->poll->user_count != 0) {
            return ($this->user_count * 100) / $this->poll->user_count;
        }

        return $this->poll->user_count;
    }
}
