<?php
namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Table;

class SettingsTable extends Table
{

    /**
     * Initialize method.
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('settings');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LastUpdatedUser', [
            'className' => 'Users',
            'foreignKey' => 'last_updated_user_id'
        ]);
    }

    /**
     * Set the settings from the database.
     *
     * @return void
     */
    public function setSettings()
    {
        $settings = $this->find()
            ->select([
                'id',
                'name',
                'value_int',
                'value_str',
                'value_bool'
            ])
            ->cache('settings', 'database');

        if (empty($settings)) {
            return;
        }

        foreach ($settings as $setting) {
            Configure::write($setting->name, $setting->value);
        }
    }

    /**
     * Handle the beforeSave event.
     *
     * @param \Cake\Event\Event $event The beforeSave event that was fired.
     * @param \Cake\ORM\Entity $entity The entity that is going to be saved.
     *
     * @return void
     */
    public function beforeSave(Event $event, Entity $entity)
    {
        $this->_setValue($entity);
    }

    /**
     * Assign the right value for each `value_*` fields regarding to the value.
     *
     * @param \Cake\ORM\Entity $entity The entity that is going to be saved.
     *
     * @return \Cake\ORM\Entity
     */
    protected function _setValue(Entity $entity)
    {
        if (empty($entity->value_str)) {
            $entity->value_str = null;
        }

        if (!is_numeric($entity->value_int)) {
            $entity->value_int = null;
        }

        if (is_null($entity->value_str) && is_null($entity->value_int) && $entity->value_bool == false) {
            $entity->value_bool = 0;
        } elseif ((!is_null($entity->value_str) || !is_null($entity->value_int)) && $entity->value_bool == false) {
            $entity->value_bool = null;
        }

        return $entity;
    }
}
