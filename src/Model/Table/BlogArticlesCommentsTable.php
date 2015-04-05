<?php
namespace App\Model\Table;

use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class BlogArticlesCommentsTable extends Table
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
        $this->table('blog_articles_comments');
        $this->displayField('comment');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Users' => ['blog_articles_comment_count'],
            'BlogArticles' => ['comment_count']
        ]);

        $this->belongsTo('BlogArticles', [
            'foreignKey' => 'article_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Create validation rules.
     *
     * @param \Cake\Validation\Validator $validator Instance of the validator.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationCreate(Validator $validator)
    {
        $validator
            ->notEmpty('content')
            ->add('content', [
                'minLength' => [
                    'rule' => ['minLength', 5],
                    'message' => __("Please, {0} characters minimum for your comment.", 5)
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
            $comment = new Event('Model.BlogArticlesComments.add', $this, [
                'comment' => $entity
            ]);
            $this->eventManager()->dispatch($comment);
        }

        return true;
    }
}
