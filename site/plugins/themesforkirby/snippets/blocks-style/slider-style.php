<?php

  if (isset($block)) {
    $height = $block->height();
    $spanAcross = $block->spanAcross();
    $width = $block->width();
    $widthCustom = $block->widthCustom();
  }

?>
<?php if (isset($height) && $height->isNotEmpty()): ?>
<?php if (isset($productSlider)): ?>.product #slider<?php else: ?><?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?><?php endif ?> .carousel-media {
  height: <?= $height ?>px;
}
<?php if ($height->value() >= 600): ?>
@media only screen and (max-width: 767px) {
  <?php if (isset($productSlider)): ?>.product #slider<?php else: ?><?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?><?php endif ?> .carousel-media {
    height: <?= commaToDot($height->value()/2) ?>px;
  }
}
<?php endif ?>
<?php endif ?>
<?php if (isset($width) && $width->value() === 'custom' && $widthCustom->isNotEmpty()): ?>
<?php if (isset($productSlider)): ?>.product #slider<?php else: ?><?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow) && isset($numColumn)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?><?php endif ?> .carousel-cell.max-width-custom {
  max-width: <?= $widthCustom ?>px;
}
<?php endif ?>
<?php if (isset($spanAcross) && $spanAcross->bool()): ?>
<?php if (isset($productSlider)): ?>.product #slider<?php elseif (isset($heroBlocks)): ?>.hero<?php endif ?><?php if (!isset($heroBlocks) && isset($numRow)): ?> .blocks-<?= $numRow ?><?php endif ?> {
  padding-left: 0 !important;
  padding-right: 0 !important;
}
<?php if (isset($productSlider)): ?>.product #slider<?php elseif (isset($heroBlocks)): ?>.hero<?php endif ?><?php if (!isset($heroBlocks) && isset($numRow)): ?> .blocks-<?= $numRow ?><?php endif ?> > [class*="max-width-"] {
  max-width: 100% !important;
}
<?php endif ?>