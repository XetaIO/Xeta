<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class BlogAttachmentsTable extends Table
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
        $this->table('blog_attachments');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Xety/Cake3Upload.Upload', [
            'fields' => [
                'url' => [
                    'path' => 'upload/blog/attachment/:md5',
                    'overwrite' => true
                ]
            ]
        ]);

        $this->belongsTo('BlogArticles', [
            'foreignKey' => 'article_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('article_id', __("You must set an article."))
            ->add('article_id', 'numeric', [
                'rule' => 'numeric',
                'message' => __("The article must be numeric value.")
            ])
            ->notEmpty('url_file', __("You must upload a file."))
            ->add('url_file', [
                'mimeType' => [
                    'rule' => ['mimeType', ['application/octet-stream', 'application/zip']],
                    'message' => __("The mimeType is not allowed.")
                ],
                'fileExtension' => [
                    'rule' => ['extension', ['zip']],
                    'message' => __("The extension allowed are {0}.", '.zip')
                ],
                'fileSize' => [
                    'rule' => ['fileSize', '<', '13MB'],
                    'message' => __("The file exceeded the max allowed size of {0}.", '13MB')
                ]
            ]);

        return $validator;
    }
}
