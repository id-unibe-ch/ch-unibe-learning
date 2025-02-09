<?php $numRow = 0; foreach ($page->toLayouts() as $row):

  $backgroundRow = $row->background()->toStructure()->first();

  if ($backgroundRow) {
    $backgroundRowColor = $backgroundRow->color()->toStructure()->first();
    $backgroundRowGradient = $backgroundRow->gradient()->toStructure()->first();
    $backgroundRowImage = $backgroundRow->image()->toStructure()->first();

    if ($backgroundRowImage) {
      $backgroundRowImageFile = $backgroundRowImage->media()->toFile();
    }
  }
  $numRow = ++$numRow;

?>
<?php if ($row->visibility()->bool()): ?>
<?php if ($backgroundRow): ?>
<?php if ($backgroundRow->type()->value() === 'image' && $backgroundRowImage && $backgroundRowImageFile): ?>
.blocks-<?= $numRow ?><?php if (isset($heroBlocks)): ?>.blocks-hero<?php else: ?>.blocks-content<?php endif ?> {
  background-image: url(<?= $backgroundRowImageFile->resize(1440)->url() ?>);
  background-position: <?= $backgroundRowImage->positionHorizontal()->value() ?> <?= $backgroundRowImage->positionVertical()->value() ?>;
}
@media only screen and (min-width: 960px) {
  .blocks-<?= $numRow ?><?php if (isset($heroBlocks)): ?>.blocks-hero<?php else: ?>.blocks-content<?php endif ?> {
    background-image: url(<?= $backgroundRowImageFile->resize(1920)->url() ?>);
  }
}
@media only screen and (min-width: 1440px) {
  .blocks-<?= $numRow ?><?php if (isset($heroBlocks)): ?>.blocks-hero<?php else: ?>.blocks-content<?php endif ?> {
    background-image: url(<?= $backgroundRowImageFile->resize(2880)->url() ?>);
  }
}
<?php if ($backgroundRowImage->overlay()->value() === 'color' && $backgroundRowImage->overlayColorFill()->value() === 'custom' && $backgroundRowImage->overlayColorCustom()->isNotEmpty()): ?>
.bg-overlay-color-custom.blocks-<?= $numRow ?><?php if (isset($heroBlocks)): ?>.blocks-hero<?php else: ?>.blocks-content<?php endif ?>:before {
  background: #<?= $backgroundRowImage->overlayColorCustom() ?>;
  opacity: <?= $backgroundRowImage->overlayColorOpacity() ?>;
}
<?php elseif ($backgroundRowImage->overlay()->value() === 'gradient' && $backgroundRowImage->overlayGradientFill()->value() === 'custom' && $backgroundRowImage->overlayGradientCustom()->isNotEmpty()): ?>
.bg-overlay-gradient-custom.blocks-<?= $numRow ?><?php if (isset($heroBlocks)): ?>.blocks-hero<?php else: ?>.blocks-content<?php endif ?>:before {
  background: #<?php if ($backgroundRow->brightness()->bool()): ?>000<?php else: ?>fff<?php endif ?>;
  background: -webkit-<?= $backgroundRowImage->overlayGradientCustom() ?>;
  background: -moz-<?= $backgroundRowImage->overlayGradientCustom() ?>;
  background: -ms-<?= $backgroundRowImage->overlayGradientCustom() ?>;
  background: -o-<?= $backgroundRowImage->overlayGradientCustom() ?>;
  background: <?= $backgroundRowImage->overlayGradientCustom() ?>;
}
<?php endif ?>
<?php elseif ($backgroundRow->type()->value() === 'color' && $backgroundRowColor && $backgroundRowColor->fill()->value() === 'custom'): ?>
<?php if ($backgroundRowColor->custom()->isNotEmpty()): ?>
.bg-color-custom.blocks-<?= $numRow ?><?php if (isset($heroBlocks)): ?>.blocks-hero<?php else: ?>.blocks-content<?php endif ?> {
  background: #<?= $backgroundRowColor->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundRowColor->customDark()->isNotEmpty()): ?>
body.dark .bg-color-custom.blocks-<?= $numRow ?><?php if (isset($heroBlocks)): ?>.blocks-hero<?php else: ?>.blocks-content<?php endif ?> {
  background: #<?= $backgroundRowColor->customDark() ?> !important;
}
<?php endif ?>
<?php elseif ($backgroundRow->type()->value() === 'gradient' && $backgroundRowGradient && $backgroundRowGradient->fill()->value() === 'custom'): ?>
<?php if ($backgroundRowGradient->custom()->isNotEmpty()): ?>
.bg-gradient-custom.blocks-<?= $numRow ?><?php if (isset($heroBlocks)): ?>.blocks-hero<?php else: ?>.blocks-content<?php endif ?> {
  background: #<?php if ($backgroundRow->brightness()->bool()): ?>000<?php else: ?>fff<?php endif ?>;
  background: -webkit-<?= $backgroundRowGradient->custom() ?>;
  background: -moz-<?= $backgroundRowGradient->custom() ?>;
  background: -ms-<?= $backgroundRowGradient->custom() ?>;
  background: -o-<?= $backgroundRowGradient->custom() ?>;
  background: <?= $backgroundRowGradient->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundRowGradient->customDark()->isNotEmpty()): ?>
body.dark .bg-gradient-custom.blocks-<?= $numRow ?><?php if (isset($heroBlocks)): ?>.blocks-hero<?php else: ?>.blocks-content<?php endif ?> {
  background: #000 !important;
  background: -webkit-<?= $backgroundRowGradient->customDark() ?> !important;
  background: -moz-<?= $backgroundRowGradient->customDark() ?> !important;
  background: -ms-<?= $backgroundRowGradient->customDark() ?> !important;
  background: -o-<?= $backgroundRowGradient->customDark() ?> !important;
  background: <?= $backgroundRowGradient->customDark() ?> !important;
}
<?php endif ?>
<?php endif ?>
<?php endif ?>
<?php

  // Blocks style

?>
<?php $numColumn = 0; foreach ($row->columns() as $column): $numColumn = ++$numColumn; ?><?php $numBlock = 0; foreach ($column->blocks() as $block): $numBlock = ++$numBlock; ?>
<?php if (isset($heroBlocks) && in_array($block->type(), ['gallery', 'heading', 'slider', 'video', 'vimeo', 'youtube'])): ?>
<?php snippet('blocks-style/' . $block->type() . '-style', ['block' => $block, 'heroBlocks' => $heroBlocks, 'numRow' => $numRow, 'numColumn' => $numColumn, 'numBlock' => $numBlock]) ?>
<?php elseif (in_array($block->type(), ['gallery', 'heading', 'slider', 'video', 'vimeo', 'youtube'])): ?>
<?php snippet('blocks-style/' . $block->type() . '-style', ['block' => $block, 'numRow' => $numRow, 'numColumn' => $numColumn, 'numBlock' => $numBlock]) ?>
<?php endif ?>
<?php if ($backgroundBlock = $block->background()->toStructure()->first()):

  $backgroundBlockColor = $backgroundBlock->color()->toStructure()->first();
  $backgroundBlockGradient = $backgroundBlock->gradient()->toStructure()->first();

?>
<?php if ($backgroundBlock->type()->value() === 'color' && $backgroundBlockColor && $backgroundBlockColor->fill()->value() === 'custom'): ?>
<?php if ($backgroundBlockColor->custom()->isNotEmpty()): ?>
<?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.bg-color-custom.block-<?= $numRow ?>-<?= $numColumn ?>-<?= $numBlock ?> {
  background: #<?= $backgroundBlockColor->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundBlockColor->customDark()->isNotEmpty()): ?>
body.dark <?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.bg-color-custom.block-<?= $numRow ?>-<?= $numColumn ?>-<?= $numBlock ?> {
  background: #<?= $backgroundBlockColor->customDark() ?> !important;
}
<?php endif ?>
<?php elseif ($backgroundBlock->type()->value() === 'gradient' && $backgroundBlockGradient && $backgroundBlockGradient->fill()->value() === 'custom'): ?>
<?php if ($backgroundBlockGradient->custom()->isNotEmpty()): ?>
<?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.bg-gradient-custom.block-<?= $numRow ?>-<?= $numColumn ?>-<?= $numBlock ?> {
  background: #<?php if ($backgroundBlock->brightness()->bool()): ?>000<?php else: ?>fff<?php endif ?>;
  background: -webkit-<?= $backgroundBlockGradient->custom() ?>;
  background: -moz-<?= $backgroundBlockGradient->custom() ?>;
  background: -ms-<?= $backgroundBlockGradient->custom() ?>;
  background: -o-<?= $backgroundBlockGradient->custom() ?>;
  background: <?= $backgroundBlockGradient->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundBlockGradient->customDark()->isNotEmpty()): ?>
body.dark <?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.bg-gradient-custom.block-<?= $numRow ?>-<?= $numColumn ?>-<?= $numBlock ?> {
  background: #000 !important;
  background: -webkit-<?= $backgroundBlockGradient->customDark() ?> !important;
  background: -moz-<?= $backgroundBlockGradient->customDark() ?> !important;
  background: -ms-<?= $backgroundBlockGradient->customDark() ?> !important;
  background: -o-<?= $backgroundBlockGradient->customDark() ?> !important;
  background: <?= $backgroundBlockGradient->customDark() ?> !important;
}
<?php endif ?>
<?php endif ?>
<?php endif ?>
<?php

  // Animation style

?>
<?php if ($animation = $block->animation()->toStructure()->first()): ?>
.js-ready <?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?><?php if (in_array($block->type(), ['gallery', 'image', 'imageurl', 'posts'])): ?> <?php endif ?>.js-animation.js-scrolled {
  -webkit-animation-delay: <?= $animation->delay() ?>s;
  animation-delay: <?= $animation->delay() ?>s;
}
<?php if (isset($heroBlocks) && $animation->type()->value() === 'custom'): ?>
<?php snippet('header-style-animation-custom', ['animation' => $animation, 'block' => $block, 'heroBlocks' => $heroBlocks, 'numRow' => $numRow, 'numColumn' => $numColumn, 'numBlock' => $numBlock]) ?>
<?php elseif ($animation->type()->value() === 'custom'): ?>
<?php snippet('header-style-animation-custom', ['animation' => $animation, 'block' => $block, 'numRow' => $numRow, 'numColumn' => $numColumn, 'numBlock' => $numBlock]) ?>
<?php endif ?>
<?php endif ?>
<?php endforeach ?><?php endforeach ?>
<?php endif ?>
<?php endforeach ?>
