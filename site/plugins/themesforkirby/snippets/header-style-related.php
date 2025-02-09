<?php

  $backgroundRelated = $page->parent()->postRelatedBackground()->toStructure()->first();

  if ($backgroundRelated) {
    $backgroundRelatedColor = $backgroundRelated->color()->toStructure()->first();
    $backgroundRelatedGradient = $backgroundRelated->gradient()->toStructure()->first();
  }

?>
<?php if ($backgroundRelated): ?>
<?php if ($backgroundRelated->type()->value() === 'color' && $backgroundRelatedColor && $backgroundRelatedColor->fill()->value() === 'custom'): ?>
<?php if ($backgroundRelatedColor->custom()->isNotEmpty()): ?>
.post #related.bg-color-custom,
.product #related.bg-color-custom {
  background: #<?= $backgroundRelatedColor->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundRelatedColor->customDark()->isNotEmpty()): ?>
body.dark .post #related.bg-color-custom,
body.dark .product #related.bg-color-custom {
  background: #<?= $backgroundRelatedColor->customDark() ?> !important;
}
<?php endif ?>
<?php elseif ($backgroundRelated->type()->value() === 'gradient' && $backgroundRelatedGradient && $backgroundRelatedGradient->fill()->value() === 'custom'): ?>
<?php if ($backgroundRelatedGradient->custom()->isNotEmpty()): ?>
.post #related.bg-gradient-custom,
.product #related.bg-gradient-custom {
  background: #<?php if ($backgroundRelated->brightness()->bool()): ?>000<?php else: ?>fff<?php endif ?>;
  background: -webkit-<?= $backgroundRelatedGradient->custom() ?>;
  background: -moz-<?= $backgroundRelatedGradient->custom() ?>;
  background: -ms-<?= $backgroundRelatedGradient->custom() ?>;
  background: -o-<?= $backgroundRelatedGradient->custom() ?>;
  background: <?= $backgroundRelatedGradient->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundRelatedGradient->customDark()->isNotEmpty()): ?>
body.dark .post #related.bg-gradient-custom,
body.dark .product #related.bg-gradient-custom {
  background: #000 !important;
  background: -webkit-<?= $backgroundRelatedGradient->customDark() ?> !important;
  background: -moz-<?= $backgroundRelatedGradient->customDark() ?> !important;
  background: -ms-<?= $backgroundRelatedGradient->customDark() ?> !important;
  background: -o-<?= $backgroundRelatedGradient->customDark() ?> !important;
  background: <?= $backgroundRelatedGradient->customDark() ?> !important;
}
<?php endif ?>
<?php endif ?>
<?php endif ?>
