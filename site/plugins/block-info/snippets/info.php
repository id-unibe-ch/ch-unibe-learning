<?php if ($block->text()->isNotEmpty()): ?>
  <div class="align-left alert alert-<?= $block->context() ?> paragraph">
    <?= $block->text() ?>
  </div>
<?php endif ?>
