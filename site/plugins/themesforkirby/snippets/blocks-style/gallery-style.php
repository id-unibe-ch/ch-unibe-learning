<?php if ($block->height()->isNotEmpty()): ?>
<?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?> .gallery-item {
  height: <?= $block->height() ?>px;
}
@media only screen and (max-width: 767px) {
  <?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?> .gallery-item {
    height: auto;
  }
}
<?php endif ?>