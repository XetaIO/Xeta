<?php if (!empty($staffOnline)): ?>
	<div class="sidebox widget">
		<div class="panel panel-forum panel-staff-online">
			<div class="panel-heading">
				<?= __('Staff Online') ?>
			</div>
			<div class="panel-body">
				<ul>
					<?php foreach ($staffOnline as $staff): ?>
						<li>
							<?= $this->Html->link(
								$this->Html->image($staff->user->avatar, ['class' => 'img-thumbnail']),
								['_name' => 'users-profile', 'slug' => $staff->user->slug, 'prefix' => false],
								['class' => 'avatar', 'escape' => false]
							) ?>
							<?= $this->Html->link(
								$staff->user->username,
								['_name' => 'users-profile', 'slug' => $staff->user->slug, 'prefix' => false],
								['class' => 'username']
							) ?>
							<small class="userGroup" style="<?= h($staff->user->group_css) ?>">
								<?= h($staff->user->group_name) ?>
							</small>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php $params = $this->request->params; ?>
<?php if(\Cake\Core\Configure::read('Chat.enabled') === true &&
		($params['controller'] === 'Forum' && $params['action'] === 'index' && $params['prefix'] === 'forum')
): ?>
	<div class="sidebox widget">
		<div class="panel panel-forum panel-chat-online">
			<div class="panel-heading">
				<?= __d('chat', 'Members in Chat') ?>
			</div>
			<div class="panel-body">
				<ul id="chatboxOnline">
				</ul>
			</div>
		</div>
	</div>
<?php endif; ?>
