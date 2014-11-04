<?php
namespace App\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Utility\Inflector;

class SluggableBehavior extends Behavior {

/**
 * Default config.
 *
 * @var array
 */
	protected $_defaultConfig = [
		'field' => 'title',
		'slug' => 'slug',
		'replacement' => '-',
	];

/**
 * Slug a field passed in the default config with its replacement.
 *
 * @param \Cake\ORM\Entity $entity The entity that is going to be updated.
 *
 * @return void
 */
	public function slug(Entity $entity) {
		$config = $this->config();
		$value = $entity->get($config['field']);
		$entity->set($config['slug'], strtolower(Inflector::slug($value, $config['replacement'])));
	}

/**
 * BeforeSave handle.
 *
 * @param \Cake\Event\Event  $event  The beforeSave event that was fired.
 * @param \Cake\ORM\Entity $entity The entity that is going to be saved.
 *
 * @return void
 */
	public function beforeSave(Event $event, Entity $entity) {
		$this->slug($entity);
	}

/**
 * Custom finder by slug.
 *
 * @param \Cake\ORM\Query $query The query finder.
 * @param array $options The options passed in the query builder.
 *
 * @return \Cake\ORM\Query
 */
	public function findSlug(Query $query, array $options) {
		return $query->where([
			$options['slugField'] => $options['slug']
		]);
	}
}
