<?php
namespace App\View;

use Cake\View\View;

class AppView extends View
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadHelper('Form', [
            'templates' => 'form-templates'
        ]);
        $this->loadHelper('Paginator', [
            'templates' => 'paginator-templates'
        ]);
    }
}
