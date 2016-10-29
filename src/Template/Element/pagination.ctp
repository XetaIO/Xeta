<div class="pagination-centered">
    <ul class="pagination">
        <?php if ($this->Paginator->hasPrev()): ?>
            <?= $this->Paginator->prev('«'); ?>
        <?php endif; ?>
        <?= $this->Paginator->numbers(['modulus' => 2, 'first' => '1', 'last' => (string)$this->Paginator->counter('{{pages}}')]); ?>
        <?php if ($this->Paginator->hasNext()): ?>
            <?= $this->Paginator->next('»'); ?>
        <?php endif; ?>
    </ul>
</div>
