<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ForumPostsLikesTable extends Table {

/**
 * Initialize method.
 *
 * @param array $config The configuration for the Table.
 *
 * @return void
 */
	public function initialize(array $config) {
		$this->table('forum_posts_likes');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('CounterCache', [
			'ForumPosts' => ['like_count'],
			'ReceiversUsers' => ['forum_like_received']
		]);

		$this->belongsTo('ForumPosts', [
			'foreignKey' => 'post_id'
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id'
		]);
		$this->belongsTo('ReceiversUsers', [
			'className' => 'Users',
			'foreignKey' => 'receiver_id'
		]);
	}
}
