<?php
use Cake\Core\Configure;

?>
<?php $this->start('scriptBottom');

	echo $this->Html->script([
		'ckeditor/ckeditor',
		'chat.min'
	])
?>
	<script type="text/javascript">
		var config = {
			refreshTime : <?= Configure::read('Chat.refreshTime') ?> * 1000,
			maxMessages : <?= Configure::read('Chat.maxMessages') ?>,
			maxRetrying : <?= Configure::read('Chat.maxRetrying') ?>,
			floodRule : <?= Configure::read('Chat.floodRule') ?> * 1000,
			spamRule : <?= Configure::read('Chat.spamRule') ?>,
			messageMaxLength : <?= Configure::read('Chat.messageMaxLength') ?>,
			urlRefresh : '<?= $this->Url->build(['controller' => 'chat', 'action' => 'index', 'prefix' => 'chat']) ?>',
			urlDeleteMessage : '<?= $this->Url->build(['controller' => 'chat', 'action' => 'delete', 'prefix' => 'chat']) ?>',
			urlGetNotice : '<?= $this->Url->build(['controller' => 'chat', 'action' => 'getNotice', 'prefix' => 'chat']) ?>',
			locale : "<?= substr(\Cake\I18n\I18n::locale(), 0, 2) ?>",
		};
		var lang = {
			getServerResponse : "<?= __d('chat', 'There is a problem to get the server response. Please, contact an administrator.') ?>",
			unauthorizedAction : "<?= __d('chat', 'You\'re not authorize to execute this action.') ?>",
			userNotConnected : "<?= __d('chat', 'You need to be logged in to send a message in the chat.') ?>",
			floodRule : "<?= __d('chat', 'Please, don\'t flood the chat.') ?>",
			spamRule : "<?= __d('chat', 'Your last message is very similar, please change it.') ?>",
			emptyMessage : "<?= __d('chat', 'You can\'t send an empty message.') ?>",
			errorToShout : "<?= __d('chat', 'Error to post your message, please try again.') ?>",
			messageMaxLength : "<?= __d('chat', 'You can\'t send a message with more than {0} characters.', Configure::read('Chat.messageMaxLength')) ?>",
			errorToEditTheNotice : "<?= __d('chat', 'Error to edit the notice.') ?>",
			errorToDeleteMessage : "<?= __d('chat', 'Error to delete the message.') ?>",
			AFewSecondsAgo : "<?= __d('chat', 'A few seconds ago') ?>",
		};

		xetaChat.init(config, lang);

		moment.locale('<?= \Cake\I18n\I18n::locale() ?>');
	</script>
<?php $this->end() ?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-forum">
			<div class="panel-heading">
				<div class="categoryTitle">
					<?= __d('chat', "Chatbox") ?>
				</div>
			</div>
			<div class="panel-inner">

				<div class="chatbox" id="chatbox">
					<div class="chatboxHeader nodeInfo categoryNodeInfo">
						<h4 class="title">
							<?= __d('chat', 'Members') ?> (<span id="usersCount">0</span>)
						</h4>
						<blockquote class="description">
							<span id="chatboxNotice"></span>
						</blockquote>

						<div class="modal fade" id="noticeModal" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="<?= __d('chat', 'Close') ?>"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">
											<?= __d('chat', 'Change the Chat Notice') ?>
										</h4>
									</div>
									<?= $this->Form->create(null, [
										'url' => [
											'controller' => 'chat',
											'action' => 'editNotice',
											'prefix' => 'chat'
										],
										'id' => 'noticeForm'
									]) ?>
									<div class="modal-body">
										<div class="form-group">
											<?= $this->Form->textarea(
												'notice', [
													'label' => false,
													'class' => 'form-control noticeBox',
													'id' => 'noticeBox'
												]
											) ?>
										</div>
									</div>
									<div class="modal-footer">
										<?= $this->Form->button(__d('chat', 'Save Notice'), ['type' => 'submit', 'class' => 'btn btn-sm btn-primary']); ?>
										<?= $this->Form->button(__d('chat', 'Close'), ['class' => 'btn btn-sm btn-danger', 'data-dismiss' => 'modal']); ?>
									</div>
									<?= $this->Form->end(); ?>
								</div>
							</div>
						</div>
					</div>

					<div class="chatboxControls">
						<div class="chatboxToolbar">
							<button id="chatboxSmiliePicker" class="btn text-primary chatboxSmilie">
								<i class="xeta-smiley icon-smile"></i>
							</button>
						</div>
						<input id="chatboxMessage" class="message form-control" maxlength="400" placeholder="<?= __d('chat', 'Enter message...') ?>" type="text">
						<button id="chatboxSend" class="btn btn-primary send" data-url="<?= $this->Url->build(['controller' => 'chat', 'action' => 'shout', 'prefix' => 'chat']) ?>">></button>
						<div id="smiliesBox" class="smiliesBox"></div>
					</div>

					<div class="chatboxContent">
						<ol id="chatboxContent">
						</ol>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>
