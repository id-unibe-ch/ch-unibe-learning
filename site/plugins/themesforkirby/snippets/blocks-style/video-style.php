<?php if ($block->height()->isNotEmpty()): ?>
<?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?> iframe,
<?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?> video {
  height: <?= $block->height() ?>px;
}
<?php endif ?>
<?php if ($block->height()->value() >= 600): ?>
@media only screen and (max-width: 767px) {
  <?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?> iframe,
  <?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?> video {
    height: <?= commaToDot($block->height()->value()/2) ?>px;
  }
}
<?php endif ?>