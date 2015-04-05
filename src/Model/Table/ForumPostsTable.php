<?php
namespace App\Model\Table;

use App\Event\Badges;
use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ForumPostsTable extends Table
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
        $this->table('forum_posts');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Users' => ['forum_post_count'],
            'ForumThreads' => ['reply_count']
        ]);

        $this->belongsTo('ForumThreads', [
            'foreignKey' => 'thread_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('LastEditUsers', [
            'className' => 'Users',
            'foreignKey' => 'last_edit_user_id'
        ]);
        $this->hasMany('ForumPostsLikes', [
            'foreignKey' => 'post_id',
            'dependent' => true
        ]);
    }

    /**
     * Create validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationCreate(Validator $validator)
    {
        $validator
            ->provider('purifier', 'App\Model\Validation\PurifierValidator')
            ->notEmpty('message', __('You must specify a message for your response.'))
            ->add('message', [
                'purifierMinLength' => [
                    'rule' => ['purifierMinLength', 5],
                    'provider' => 'purifier',
                    'message' => __('Your message must contain at least {0} characters.', 5)
                ]
            ]);

        return $validator;
    }

    /**
     * AfterSave callback.
     *
     * @param \Cake\Event\Event $event   The afterSave event that was fired.
     * @param \Cake\ORM\Entity $entity  The entity that was saved.
     * @param \ArrayObject $options The options passed to the callback.
     *
     * @return bool
     */
    public function afterSave(Event $event, Entity $entity, ArrayObject $options)
    {
        if ($entity->isNew()) {
            $this->eventManager()->attach(new Badges());
            $event = new Event('Model.ForumPosts.reply', $this, [
                'post' => $entity
            ]);
            $this->eventManager()->dispatch($event);
        }

        return true;
    }
}
