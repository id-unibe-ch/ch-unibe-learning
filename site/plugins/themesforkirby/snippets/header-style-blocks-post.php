<?php $numBlock = 0; foreach ($page->blocks()->toBlocks() as $block): $numBlock = ++$numBlock; ?>
<?php if (in_array($block->type(), ['gallery', 'heading', 'slider', 'video', 'vimeo', 'youtube'])): ?>
<?php snippet('blocks-style/' . $block->type() . '-style', ['block' => $block, 'numBlock' => $numBlock]) ?>
<?php endif ?>
<?php if ($backgroundBlock = $block->background()->toStructure()->first()):

  $backgroundBlockColor = $backgroundBlock->color()->toStructure()->first();
  $backgroundBlockGradient = $backgroundBlock->gradient()->toStructure()->first();

?>
<?php if ($backgroundBlock->type()->value() === 'color' && $backgroundBlockColor && $backgroundBlockColor->fill()->value() === 'custom'): ?>
<?php if ($backgroundBlockColor->custom()->isNotEmpty()): ?>
.bg-color-custom.block-<?= $numBlock ?> {
  background: #<?= $backgroundBlockColor->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundBlockColor->customDark()->isNotEmpty()): ?>
body.dark .bg-color-custom.block-<?= $numBlock ?> {
  background: #<?= $backgroundBlockColor->customDark() ?> !important;
}
<?php endif ?>
<?php elseif ($backgroundBlock->type()->value() === 'gradient' && $backgroundBlockGradient && $backgroundBlockGradient->fill()->value() === 'custom'): ?>
<?php if ($backgroundBlockGradient->custom()->isNotEmpty()): ?>
.bg-gradient-custom.block-<?= $numBlock ?> {
  background: #<?php if ($backgroundBlock->brightness()->bool()): ?>000<?php else: ?>fff<?php endif ?>;
  background: -webkit-<?= $backgroundBlockGradient->custom() ?>;
  background: -moz-<?= $backgroundBlockGradient->custom() ?>;
  background: -ms-<?= $backgroundBlockGradient->custom() ?>;
  background: -o-<?= $backgroundBlockGradient->custom() ?>;
  background: <?= $backgroundBlockGradient->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundBlockGradient->customDark()->isNotEmpty()): ?>
body.dark .bg-gradient-custom.block-<?= $numBlock ?> {
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
<?php snippet('header-style-animation-custom', ['animation' => $animation, 'block' => $block, 'numBlock' => $numBlock]) ?>
<?php endif ?>
<?php endforeach ?>
