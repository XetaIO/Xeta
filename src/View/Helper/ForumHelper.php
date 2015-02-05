<?php
namespace App\View\Helper;

use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\View;

class ForumHelper extends Helper {

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
 * Construct method.
 *
 * @param \Cake\View\View $view The view that was fired.
 * @param array $config The config passed to the class.
 *
 * @return void
 */
	public function __construct(View $view, $config = []) {
		parent::__construct($view, $config);
	}

	public function generateCategories(array $categories = []) {
		if (empty($categories)) {
			return;
		}

		$this->html .= '<ul style="list-style: outside none none;box-sizing: content-box;min-width: 160px;">';

		foreach ($categories as $index => $child) {
			$this->html .= '<li class="main-cat-child">';
			$this->html .= $this->Html->link($child->title, [
				'_name' => 'forum-categories',
				'id' => $child->id,
				'slug' => strtolower(Inflector::slug($child->title, '-'))
			]);
			$this->html .= '</li>';
			if(is_array($child->children) && !empty($child->children)) {
				$this->generateCategories($child->children);
			}
		}

		$this->html .= '</ul>';

		return $this->html;
	}
}
