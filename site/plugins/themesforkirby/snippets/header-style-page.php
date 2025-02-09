<?php

  $backgroundPage = $page->background()->toStructure()->first();

  if ($backgroundPage) {
    $backgroundPageColor = $backgroundPage->color()->toStructure()->first();
    $backgroundPageGradient = $backgroundPage->gradient()->toStructure()->first();
  }

?>
<?php if ($backgroundPage): ?>
<?php if ($backgroundPage->type()->value() === 'color' && $backgroundPageColor && $backgroundPageColor->fill()->value() === 'custom'): ?>
<?php if ($backgroundPageColor->custom()->isNotEmpty()): ?>
main.bg-color-custom {
  background: #<?= $backgroundPageColor->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundPageColor->customDark()->isNotEmpty()): ?>
body.dark main.bg-color-custom {
  background: #<?= $backgroundPageColor->customDark() ?> !important;
}
<?php endif ?>
<?php elseif ($backgroundPage->type()->value() === 'gradient' && $backgroundPageGradient && $backgroundPageGradient->fill()->value() === 'custom'): ?>
<?php if ($backgroundPageGradient->custom()->isNotEmpty()): ?>
main.bg-gradient-custom {
  background: #<?php if ($backgroundPage->brightness()->bool()): ?>000<?php else: ?>fff<?php endif ?>;
  background: -webkit-<?= $backgroundPageGradient->custom() ?>;
  background: -moz-<?= $backgroundPageGradient->custom() ?>;
  background: -ms-<?= $backgroundPageGradient->custom() ?>;
  background: -o-<?= $backgroundPageGradient->custom() ?>;
  background: <?= $backgroundPageGradient->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundPageGradient->customDark()->isNotEmpty()): ?>
body.dark main.bg-gradient-custom {
  background: #000 !important;
  background: -webkit-<?= $backgroundPageGradient->customDark() ?> !important;
  background: -moz-<?= $backgroundPageGradient->customDark() ?> !important;
  background: -ms-<?= $backgroundPageGradient->customDark() ?> !important;
  background: -o-<?= $backgroundPageGradient->customDark() ?> !important;
  background: <?= $backgroundPageGradient->customDark() ?> !important;
}
<?php endif ?>
<?php endif ?>
<?php endif ?>
