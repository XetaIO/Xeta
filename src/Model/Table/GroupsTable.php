<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class GroupsTable extends Table {

/**
 * Initialize method.
 *
 * @param array $config The configuration for the Table.
 *
 * @return void
 */
	public function initialize(array $config) {
		$this->table('groups');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Acl.Acl', [
			'type' => 'requester'
		]);
		$this->addBehavior('Translate', [
			'fields' => ['name'],
			'translationTable' => 'GroupsI18n'
		]);

		$this->hasMany('Users', [
			'foreignKey' => 'group_id'
		]);
	}

}
