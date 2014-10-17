<?php
use \Cake\Core\Configure;

$this->assign('title', (isset($title)) ? h($title) : __("Welcome on Xeta"));
$this->start('meta');
/**
 * Basic tags.
 */
	echo $this->Html->meta(['name' => 'author', 'content' => (isset($author)) ? h($author) : Configure::read('Author.pseudo')]);
	echo $this->Html->meta(['name' => 'copyright', 'content' => (isset($copyright)) ? h($copyright) : Configure::read('Author.full_name')]);
	echo $this->Html->meta('description', (isset($description)) ? $this->Text->truncate(
		h($description),
		250,
		[
			'ellipsis' => '...',
			'exact' => false
		]
	) : Configure::read('Site.description'));

/**
 * Facebook tags.
 */
	echo $this->Html->meta(['property' => 'og:site_name', 'content' => Configure::read('Site.name')]);
	echo $this->Html->meta(['property' => 'og:title', 'content' => (isset($title)) ? h($title) : __("Welcome on Xeta")]);
	echo $this->Html->meta(['property' => 'og:url', 'content' => $this->Url->build(null, true)]);
	echo $this->Html->meta(['property' => 'og:image', 'content' => $this->Url->build('/' . Configure::read('App.imageBaseUrl') . 'logo.png', true)]);
	echo $this->Html->meta(['property' => 'og:description', 'content' => (isset($description)) ? $this->Text->truncate(
		h($description),
		250,
		[
			'ellipsis' => '...',
			'exact' => false
		]
	) : Configure::read('Site.description')]);

/**
 * Twitter tags.
 */
	echo $this->Html->meta(['name' => 'twitter:site', 'content' => Configure::read('Site.name')]);
	echo $this->Html->meta(['name' => 'twitter:title', 'content' => (isset($title)) ? h($title) : __("Welcome on Xeta")]);
	echo $this->Html->meta(['name' => 'twitter:url', 'content' => $this->Url->build(null, true)]);
	echo $this->Html->meta(['name' => 'twitter:image', 'content' => $this->Url->build('/' . Configure::read('App.imageBaseUrl') . 'logo.png', true)]);
	echo $this->Html->meta(['name' => 'twitter:description', 'content' => (isset($description)) ? $this->Text->truncate(
		h($description),
		250,
		[
			'ellipsis' => '...',
			'exact' => false
		]
	) : Configure::read('Site.description')]);
$this->end();
