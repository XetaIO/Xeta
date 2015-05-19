<?= $this->element('meta', [
    'title' => __("Conversations")
]) ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li class="active">
                    <?= __("Conversations") ?>
                </li>
            </ol>
            <?= $this->Flash->render() ?>
        </div>
    </div>

    <div class="row">
        <section class="col-md-3">
            <?= $this->element('/Users/sidebar') ?>
        </section>
        <section class="col-md-9">

            <div class="section">
                <h4>
                    <?= __("Conversations") ?>
                </h4>

                <div class="conversation-search">
                    <?= $this->Form->create(null, [
                        'url' => ['controller' => 'conversations', 'action' => 'search'],
                        'role'=>'search'
                    ]);?>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                </span>
                                <?= $this->Form->input('search',array(
                                    'class' =>'form-control',
                                    'type' =>'text',
                                    'placeholder' =>__('Search a conversation by his name..'),
                                    'label' => false,
                                    'div' => false
                                ));?>
                            </div>
                            <span class="input-group-btn">
                                <?= $this->Form->button(__('Search {0}', '<i class="fa fa-arrow-right"></i>'), [
                                    'class'     => 'btn btn-primary'
                                ]);?>
                            </span>
                        </div>
                    </div>
                    <?= $this->Form->end();?>
                </div>

                <?= $this->Html->link(__("New Conversation"),array('controller'=>'conversations','action'=>'add'),array('class'=>'btn btn-primary conversation-new'));?>

                <?php if (!empty($conversations->toArray())) : ?>
                    <table class="table tableCategories table-striped table-primary table-hover">
                        <tbody>
                            <?php foreach ($conversations as $conversation): ?>
                                <tr>
                                    <td class="forumInfo">

                                    </td>
                                    <td class="hidden-xs">

                                    </td>

                                    <td class="hidden-xs">

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="pagination-centered">
                        <ul class="pagination">
                            <?php if ($this->Paginator->hasPrev()): ?>
                                <?= $this->Paginator->prev('«'); ?>
                            <?php endif; ?>
                            <?= $this->Paginator->numbers(['modulus' => 5]); ?>
                            <?php if ($this->Paginator->hasNext()): ?>
                                <?= $this->Paginator->next('»'); ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php else: ?>

                <?php endif; ?>

            </div>

        </section>
    </div>
</div>
