<?php if($block->text()->isNotEmpty()): ?>
  <div class="test test-<?= $block->boxType() ?>">
    <?= $block->text() ?>
  </div>
<?php endif; ?>