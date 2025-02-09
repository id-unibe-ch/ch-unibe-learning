<?php if ($block->text()->isNotEmpty()): ?>
  <div class="paragraph">
    <?= $block->text()->kirbytext() ?>
  </div>
<?php endif ?>
