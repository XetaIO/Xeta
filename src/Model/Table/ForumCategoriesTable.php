<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ForumCategoriesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('forum_categories');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('ParentForumCategories', [
            'className' => 'ForumCategories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildForumCategories', [
            'className' => 'ForumCategories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ForumThreads', [
            'foreignKey' => 'category_id'
        ]);
        $this->belongsTo('LastPost', [
            'className' => 'ForumPosts',
            'foreignKey' => 'last_post_id'
        ]);
    }
}
