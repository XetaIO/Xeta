<h2 style="text-align:center">
	<?= \Cake\Core\Configure::read('Site.name') . ' Contact' ?>
</h2>
<p>
	Name : <?= h($name) ?>
</p>
<p>
	Email : <?= h($email) ?>
</p>
<p>
	Subject : <?= h($subject) ?>
</p>
<p>
	IP : <?= h($ip) ?>
</p>
<p>
	Message :
</p>
<div>
	<?= nl2br(h($message)) ?>
</div>
