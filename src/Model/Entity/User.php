<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use HTMLPurifier;
use HTMLPurifier_Config;

class User extends Entity
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
     * Hash the password before to save.
     *
     * @param string $password Password to be hashed.
     *
     * @return string
     */
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    /**
     * Get the full name of the user. If empty, return the username.
     *
     * @return string
     */
    protected function _getFullName()
    {
        $fullName = trim($this->first_name . ' ' . $this->last_name);
        return (!empty($fullName)) ? $fullName : $this->username;
    }

    /**
     * Purify the biography.
     *
     * @param string $biography The biography to be purify.
     *
     * @return string
     */
    protected function _getBiography($biography)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.User.biography'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($biography);
    }

    /**
     * Purify the signature.
     *
     * @param string $signature The signature to be purify.
     *
     * @return string
     */
    protected function _getSignature($signature)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->loadArray(Configure::read('HtmlPurifier.User.signature'));

        $HTMLPurifier = new HTMLPurifier($config);

        return $HTMLPurifier->purify($signature);
    }

    /**
     * Set if the user is premium or not.
     *
     * @return bool
     */
    protected function _getPremium()
    {
        return $this->end_subscription > new Time();
    }

    /**
     * Set the user group name.
     *
     * @return string
     *
     * @throws \Exception\Execption
     */
    protected function _getGroupName()
    {
        if (!isset($this->group)) {
            throw new \Exception(__('You must select the Groups for the function User::_getGroupName().'));
        }

        if ($this->group->is_member == true && $this->premium === true) {
            return __('Premium');
        }

        return $this->group->name;
    }

    /**
     * Set the user group css.
     *
     * @return string
     *
     * @throws \Exception\Execption
     */
    protected function _getGroupCss()
    {
        if (!isset($this->group)) {
            throw new \Exception(__('You must select the Groups for the function User::_getGroupCss().'));
        }

        if ($this->group->is_member == true && $this->premium === true) {
            return 'color:' . Configure::read('Premium.color') . ';font-weight: bold;';
        }

        return $this->group->css;
    }

    /**
     * The parendNode for ACL.
     *
     * @return null|array
     */
    public function parentNode()
    {
        if (!$this->id) {
            return null;
        }
        if (isset($this->group_id)) {
            $groupId = $this->group_id;
        } else {
            $Users = TableRegistry::get('Users');
            $user = $Users->find('all', ['fields' => ['group_id']])->where(['id' => $this->id])->first();
            $groupId = $user->group_id;
        }

        if (!$groupId) {
            return null;
        }

        return ['Groups' => ['id' => $groupId]];
    }

    /**
     * The bindNode method for ACL.
     *
     * @param array $user The current user.
     *
     * @return array The model and foreign_key to check.
     */
    public function bindNode($user)
    {
        return ['model' => 'Groups', 'foreign_key' => $user['Users']['group_id']];
    }
}
