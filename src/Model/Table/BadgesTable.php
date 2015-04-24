<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BadgesTable extends Table
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
        $this->table('badges');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Xety/Cake3Upload.Upload', [
            'fields' => [
                'picture' => [
                    'path' => 'img/badges/:md5',
                    'overwrite' => true
                ]
            ]
        ]);
        $this->addBehavior('Translate', [
            'fields' => ['name'],
            'translationTable' => 'BadgesI18n'
        ]);

        $this->belongsToMany('Users', [
            'foreignKey' => 'badge_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'badges_users',
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
            ->provider('upload', 'App\Model\Validation\UploadValidator')
            ->notEmpty('name', __("You must select a name."))
            ->add('name', 'minLength', [
                'rule' => ['minLength', 5],
                'message' => __("Please, {0} characters minimum for the name.", 5)
            ])
            ->allowEmpty('picture_file')
            ->add('picture_file', [
                'mimeType' => [
                    'rule' => ['mimeType', ['image/jpeg', 'image/png']],
                    'message' => __("The mimeType is not allowed."),
                    'on' => function ($context) {
                            return !empty($context['data']['picture_file']['name']);
                    }
                ],
                'fileExtension' => [
                    'rule' => ['extension', ['jpg', 'jpeg', 'png']],
                    'message' => __("The extension allowed are {0}.", '.jpg, .jpeg and .png'),
                    'on' => function ($context) {
                            return !empty($context['data']['picture_file']['name']);
                    }
                ],
                'fileSize' => [
                    'rule' => ['fileSize', '<', '500KB'],
                    'message' => __("The file exceeded the max allowed size of {0}", '500KB'),
                    'on' => function ($context) {
                            return !empty($context['data']['picture_file']['name']);
                    }
                ],
                'maxDimension' => [
                    'rule' => ['maxDimension', 130, 130],
                    'provider' => 'upload',
                    'message' => __(
                        "The file exceeded the max allowed dimension. Max height : {0} Max width : {1}",
                        130,
                        130
                    ),
                ]
            ])
            ->notEmpty('type', __("You must select a type."))
            ->add('type', 'inList', [
                'rule' => ['inList', ['comments', 'registration']],
                'message' => __("This type is not allowed. Allowed types : {0}", implode(", ", ['comments', 'registration'])),
            ])
            ->notEmpty('rule', __("You must select a rule."))
            ->add('rule', 'numeric', [
                'rule' => 'numeric'
            ]);

        return $validator;
    }
}
