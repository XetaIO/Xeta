<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ForumCategoriesTrackersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('forum_categories_trackers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('ForumCategories', [
            'foreignKey' => 'category_id'
        ]);
    }
}
