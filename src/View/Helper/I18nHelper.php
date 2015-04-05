<?php
namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\View;

class I18nHelper extends Helper
{

    /**
     * Helpers used.
     *
     * @var array
     */
    public $helpers = ['Form'];

    /**
     * Default config.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'locales' => null
    ];

    /**
     * The locales used in the application.
     *
     * @var array
     */
    protected $_locales = [];

    /**
     * Construct method.
     *
     * @param \Cake\View\View $view The view that was fired.
     * @param array $config The config passed to the class.
     */
    public function __construct(View $view, $config = [])
    {
        parent::__construct($view, $config);

        $this->_locales = (is_array($this->config('locales'))) ? $this->config('locales') : Configure::read('I18n.locales');
    }

    /**
     * Generate inputs in all locales.
     *
     * @param \Cake\ORM\Entity $entity The entity that was fired.
     * @param string $field The field to process.
     * @param array $options The options to pass to the input.
     * @param string $divClass The class to set to the div before the input.
     * @param string $id The id of the input.
     *
     * @return string
     */
    public function i18nInput(Entity $entity, $field, $options = [], $divClass = 'col-sm-5', $id = 'CkEditorBox')
    {
        $html = '';
        $options['CkEditor'] = (isset($options['CkEditor'])) ? $options['CkEditor'] : false;

        $i = 0;

        foreach ($this->_locales as $locale => $lang) {
            if ($locale == I18n::defaultLocale()) {
                continue;
            }

            $i ++;
            $options['label'] = Inflector::humanize($lang);
            $options['value'] = $entity->translation($locale)->{$field};

            if ($options['CkEditor'] === true) {
                $options['id'] = $id . '-' . $i;
                unset($options['CkEditor']);
            }

            $html .= '<div class="form-group">';
            $html .= '<div class="col-sm-offset-2 ' . $divClass . '">';
            $html .= $this->Form->input('translations.' . $locale . '.' . $field, $options);
            $html .= '</div></div>';
        }

        return $html;
    }

    /**
     * Generate the script tag to initialize CkEditor for textarea.
     *
     * @param array $options The options passed to the function.
     *
     * @return string
     */
    public function i18nScript($options = [])
    {
        $html = '';
        $file = (isset($options['file'])) ? $options['file'] : 'article';
        $name = (isset($options['name'])) ? $options['name'] : 'CkEditorBox';
        $i = 0;

        foreach ($this->_locales as $locale => $lang) {
            if ($locale == I18n::defaultLocale()) {
                continue;
            }

            $i ++;
            $html .= '
            <script type="text/javascript">
            CKEDITOR.replace(\'' . $name . '-' . $i . '\', {
                customConfig: \'config/' . $file . '.js\'
            });
            </script>';
        }

        return $html;
    }
}
