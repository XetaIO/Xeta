<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\I18nHelper;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class I18nHelperTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.groups',
        'app.groups_i18n'
    ];

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $view = new View();
        $this->I18n = new I18nHelper($view);
    }

    /**
     * Test i18nInput method
     *
     * @return void
     */
    public function testI18nInput()
    {
        $groups = TableRegistry::get('Groups');
        $group = $groups->newEntity();

        $result = $this->I18n->i18nInput($group, 'name', ['class' => 'form-control']);
        $expected = [
            ['div' => ['class' => 'form-group']],
            ['div' => ['class' => 'col-sm-offset-2 col-sm-5']],
            ['div' => ['class' => 'input text']],
            'label' => [
                'for' => 'translations-en-us-name'
            ],
            'English',
            '/label',
            'input' => [
                'type' => 'text',
                'name' => 'translations[en_US][name]',
                'class' => 'form-control',
                'id' => 'translations-en-us-name'
            ],
            '/div',
            '/div',
            '/div'
        ];
        $this->assertHtml($expected, $result);

        $result = $this->I18n->i18nInput($group, 'name', ['data-test' => '123'], 'col-md-test');
        $expected = [
            ['div' => ['class' => 'form-group']],
            ['div' => ['class' => 'col-sm-offset-2 col-md-test']],
            ['div' => ['class' => 'input text']],
            'label' => [
                'for' => 'translations-en-us-name'
            ],
            'English',
            '/label',
            'input' => [
                'type' => 'text',
                'name' => 'translations[en_US][name]',
                'data-test' => '123',
                'id' => 'translations-en-us-name'
            ],
            '/div',
            '/div',
            '/div'
        ];
        $this->assertHtml($expected, $result);

        $result = $this->I18n->i18nInput($group, 'name', ['CkEditor' => true], 'col-sm-5');
        $expected = [
            ['div' => ['class' => 'form-group']],
            ['div' => ['class' => 'col-sm-offset-2 col-sm-5']],
            ['div' => ['class' => 'input text']],
            'label' => [
                'for' => 'CkEditorBox-1'
            ],
            'English',
            '/label',
            'input' => [
                'type' => 'text',
                'name' => 'translations[en_US][name]',
                'id' => 'CkEditorBox-1'
            ],
            '/div',
            '/div',
            '/div'
        ];
        $this->assertHtml($expected, $result);
    }

    /**
     * Test i18nInput method
     *
     * @return void
     */
    public function testI18nScript()
    {
        $result = $this->I18n->i18nScript();
        $this->assertTextContains('CkEditorBox-1', $result);
        $this->assertTextContains('config/article.js', $result);

        $result = $this->I18n->i18nScript(['file' => 'testFile', 'name' => 'TestName']);
        $this->assertTextContains('TestName-1', $result);
        $this->assertTextContains('config/testFile.js', $result);
    }
}
