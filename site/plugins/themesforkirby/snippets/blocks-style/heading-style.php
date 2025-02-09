<?php if ($block->text()->isNotEmpty() && $textFill = $block->textFill()->toStructure()->first()): ?>
<?php if ($textFill->type()->value() === 'color' && $textFill->color()->isNotEmpty()): ?>
<?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?> .title-fill-color {
  color: #<?= $textFill->color() ?>;
}
<?php elseif ($textFill->type()->value() === 'gradient' && $textFill->gradient()->isNotEmpty()): ?>
<?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?> .title-fill-gradient {
  background-image: <?= $textFill->gradient() ?>;
}
<?php endif ?>
<?php endif ?>