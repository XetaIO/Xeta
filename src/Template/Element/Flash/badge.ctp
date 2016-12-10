<div class="infobox infobox-badge infobox-primary text-center">
	<p>
		<?= $message ?>
	</p>
    <?= $this->Html->image(
        $params['badge']['picture'],
        ['alt' => h($params['badge']['name']), 'height' => '100px', 'width' => '100px']
    ) ?>
</div>
