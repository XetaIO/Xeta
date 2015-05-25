<?php foreach ($params['errors'] as $error): ?>
    <?php if(is_array($error)): ?>
        <?php foreach ($error as $key => $value): ?>
            <div class="infobox infobox-danger">
                <?= $value ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>
