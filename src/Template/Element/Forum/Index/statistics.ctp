<div class="panel panel-forum forum-stats">
	<div class="panel-heading">
		<?= __('Statistics') ?>
	</div>

	<div class="panel-body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="col-md-2 col-sm-2 col-xs-4 text-center">
					<span class="output text-acqua">
						<?= \Cake\I18n\Number::format($online['total']) ?>
						<a class="collapsed" data-toggle="collapse" data-target=".sorting" href="javascript:void(0);" title="<?= __('Toggle list') ?>">
							<i class="fa fa-angle-double-down"></i>
						</a>
					</span>
					<strong>
						<?= __('Users Online') ?>
					</strong>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-4 text-center">
					<span class="output text-seppia">
						16
					</span>
					<strong>
						<?= __('Most Users Online') ?>
					</strong>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-4 text-center">
					<span class="output text-melograno">
						<?= $statistics['TotalPosts'] ?>
					</span>
					<strong>
						<?= __('Total Posts') ?>
					</strong>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-4 text-center">
					<span class="output text-drank">
						<?= $statistics['TotalThreads'] ?>
					</span>
					<strong>
						<?= __('Total Threads') ?>
					</strong>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-4 text-center">
					<span class="output text-yellow">
						<?= $statistics['Users']['TotalUsers'] ?>
					</span>
					<strong>
						<?= __('Total Members') ?>
					</strong>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-4 text-center">
					<span class="output text-danger">
						<?= $this->Html->link($statistics['Users']['LastRegistered']->username, ['_name' => 'users-profile', 'slug' => $statistics['Users']['LastRegistered']->slug, 'prefix' => false]) ?>
					</span>
					<strong>
						<?= __('Newest Member') ?>
					</strong>
				</div>
			</div>
		</div>
	</div>

	<div style="height: 21px;" class="panel-footer sorting collapse">
		<div class="clearfix">
			<span class="stats-heading">
				<?= __n('In total there is <strong>{0}</strong> user online :', 'In total there are <strong>{0}</strong> users online :', $online['total'], $online['total']) ?>
				<?= __('{0} registered and {1} guests (based on users active over the past 5 minutes)', $online['members'], $online['guests']) ?>
				<?php //echo $this->Html->link('<i class="fa fa-question-circle"></i>', ['controller' => 'forum', 'action' => 'viewonline'], ['title' => __('Who is online'), 'escape' => false]) ?>
			</span>
			<br>
			<span>
				<?= __('Legend : ') ?>
				<?php
				$lastGroup = $statistics['Groups'];
				?>
				<?php foreach ($statistics['Groups'] as $group): ?>
					<?= $this->Html->link((\Cake\I18n\I18n::locale() == \Cake\I18n\I18n::defaultLocale()) ? $group->name : $group->translation(\Cake\I18n\I18n::locale())->name, ['controller' => 'groups', 'action' => 'view', 'id' => $group->id], ['style' => h($group->css)]) ?><?= ($lastGroup[count($lastGroup) - 1]->id == $group->id) ? '' : ',' ?>
				<?php endforeach; ?>
			</span>
			<?php if (!empty($online['records'])): ?>
				<p>
					<?= __n('Registered user :', 'Registered users :', $online['members'], $online['members']) ?>
					<?php foreach ($online['records'] as $key => $record): ?>
						<?= $this->Html->link($record->user->username, ['_name' => 'users-profile', 'slug' => $record->user->slug, 'prefix' => false], ['style' => h($record->user->group_css)]) ?><?= ($online['records'][count($online['records']) - 1]->user->slug == $record->user->slug) ? '' : ',' ?>
					<?php endforeach; ?>
				</p>
			<?php endif; ?>
		</div>
	</div>

</div>
