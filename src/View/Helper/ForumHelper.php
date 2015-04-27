<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

class ForumHelper extends Helper
{

    /**
     * Helpers used.
     *
     * @var array
     */
    public $helpers = ['Html'];

    /**
     * The HTML to output.
     *
     * @var string
     */
    public $html;

    /**
     * The thread counter for sub categories.
     *
     * @var int
     */
    public $threadCount = 0;

    /**
     * Construct method.
     *
     * @param \Cake\View\View $view The view that was fired.
     * @param array $config The config passed to the class.
     */
    public function __construct(View $view, $config = [])
    {
        parent::__construct($view, $config);
    }

    /**
     * Generate all the sub-categories.
     *
     * @param array $categories The categories to generate.
     * @param bool $reset Reset the HTML and the thread counter.
     *
     * @return void|string
     */
    public function generateCategories(array $categories = [], $reset = false)
    {
        if (empty($categories)) {
            return;
        }

        if ($reset === true) {
            $this->html = '';
            $this->threadCount = 0;
        }

        $this->html .= '<ul style="list-style: outside none none;box-sizing: content-box;min-width: 160px;">';

        foreach ($categories as $index => $child) {
            $this->threadCount += $child->thread_count;

            $this->html .= '<li class="main-cat-child">';
            $this->html .= $this->Html->link($child->title, [
                '_name' => 'forum-categories',
                'id' => $child->id,
                'slug' => $child->title
            ]);
            $this->html .= '</li>';
            if (is_array($child->children) && !empty($child->children)) {
                $this->generateCategories($child->children);
            }
        }

        $this->html .= '</ul>';

        $data = [];
        $data['thread_count'] = $this->threadCount;
        $data['html'] = $this->html;

        return $data;
    }
}
