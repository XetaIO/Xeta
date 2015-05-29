<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ForumThreadsTrackersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('forum_threads_trackers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ForumCategories', [
            'foreignKey' => 'category_id'
        ]);
        $this->belongsTo('ForumThreads', [
            'foreignKey' => 'thread_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }
}
