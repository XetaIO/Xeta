<?php if (!is_null($poll)) : ?>
<div class="threadPoll">
    <div class="panel">
        <div class="panel-heading">
            <div class="hr-divider hr-divider-panel">
                <h3 class="hr-divider-content hr-divider-heading">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i> <?= h($poll->name) ?>
                </h3>
            </div>
        </div>
        <div class="panel-body">
            <?php foreach ($poll->polls_answers as $answer) : ?>
                <div>
                    <?php if (
                        is_null($hasVoted) &&
                        (($poll->is_timed == true && $poll->end_date >= new \Cake\I18n\Time()) || $poll->is_timed == false)
                    ) : ?>
                        <div class="clearfix pull-left" style="margin: 15px 10px 0 0;">
                            <?= $this->Form->create(null, [
                                    'url' => [
                                        '_name' => 'polls-vote',
                                        'slug' => h($article->title),
                                        'id' => $article->id
                                    ]
                            ]) ?>
                            <?= $this->Form->hidden('answer_id', ['value' => $answer->id]) ?>
                            <?= $this->Form->button(__('{0} Vote', '<i class="fa fa-check"></i>'), ['class' => 'btn btn-sm btn-primary-outline', 'escape' => false]) ?>
                            <?= $this->Form->end() ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <div lass="clearfix">
                            <label>
                                <?= h($answer->response) ?>
                            </label>
                            <div class="pull-right">
                                <span class="badge">
                                    <?= h($answer->user_count) ?>
                                </span>
                            </div>
                        </div>
                        <div class="progress progress-striped active">
                            <div role="progressbar" aria-valuenow="<?= h($answer->percentage) ?>%" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-primary" style="width:<?= h($answer->percentage) ?>%">
                                <?= h($answer->percentage) ?>%
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if ($poll->is_timed == true) : ?>
                <?php if ($poll->end_date >= new \Cake\I18n\Time()) : ?>
                    <div class="expire">
                        <?= __('This poll expire in') ?>
                        <?= $poll->end_date->timeAgoInWords([
                            'accuracy' => 'second',
                            'end' => '+1 week'
                        ]) ?>
                    </div>
                <?php else : ?>
                    <div class="expire">
                        <?= __('This poll is expired !') ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="panel-footer">
            <div class="clearfix">
                <ul class="list-unstyled">
                    <li class="pull-left"><?= __('Total votes : {0}', h($poll->user_count)) ?></li>
                    <?php if (!is_null($hasVoted)) : ?>
                        <li class="pull-right" style="margin-left: 5px;">
                            <?= __('You have already voted ! (You voted <strong>{0}</strong>)', h($hasVoted->polls_answer->response)) ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
