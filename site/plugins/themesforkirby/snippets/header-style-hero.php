<?php

  if ($page->template() == 'product') {
    $backgroundHero = $page->parent()->postHeroBackground()->toStructure()->first();
  } else {
    $backgroundHero = $page->heroBackground()->toStructure()->first();
  }

  if ($backgroundHero) {
    $backgroundHeroColor = $backgroundHero->color()->toStructure()->first();
    $backgroundHeroGradient = $backgroundHero->gradient()->toStructure()->first();
    $backgroundHeroImage = $backgroundHero->image()->toStructure()->first();

    if ($backgroundHeroImage) {
      $backgroundHeroImageFile = $backgroundHeroImage->media()->toFile();
    }
  }

?>
<?php if ($backgroundHero): ?>
<?php if ($backgroundHero->type()->value() === 'image' && $backgroundHeroImage && $backgroundHeroImageFile): ?>
.hero {
  background-image: url(<?= $backgroundHeroImageFile->resize(1440)->url() ?>);
  background-position: <?= $backgroundHeroImage->positionHorizontal()->value() ?> <?= $backgroundHeroImage->positionVertical()->value() ?>;
}
@media only screen and (min-width: 960px) {
  .hero {
    background-image: url(<?= $backgroundHeroImageFile->resize(1920)->url() ?>);
  }
}
@media only screen and (min-width: 1440px) {
  .hero {
    background-image: url(<?= $backgroundHeroImageFile->resize(2880)->url() ?>);
  }
}
<?php if ($backgroundHeroImage->overlay()->value() === 'color' && $backgroundHeroImage->overlayColorFill()->value() === 'custom' && $backgroundHeroImage->overlayColorCustom()->isNotEmpty()): ?>
.hero.bg-overlay-color-custom:before {
  background: #<?= $backgroundHeroImage->overlayColorCustom() ?>;
  opacity: <?= $backgroundHeroImage->overlayColorOpacity() ?>;
}
<?php elseif ($backgroundHeroImage->overlay()->value() === 'gradient' && $backgroundHeroImage->overlayGradientFill()->value() === 'custom' && $backgroundHeroImage->overlayGradientCustom()->isNotEmpty()): ?>
.hero.bg-overlay-gradient-custom:before {
  background: #<?php if ($backgroundHero->brightness()->bool()): ?>000<?php else: ?>fff<?php endif ?>;
  background: -webkit-<?= $backgroundHeroImage->overlayGradientCustom() ?>;
  background: -moz-<?= $backgroundHeroImage->overlayGradientCustom() ?>;
  background: -ms-<?= $backgroundHeroImage->overlayGradientCustom() ?>;
  background: -o-<?= $backgroundHeroImage->overlayGradientCustom() ?>;
  background: <?= $backgroundHeroImage->overlayGradientCustom() ?>;
}
<?php endif ?>
<?php elseif ($backgroundHero->type()->value() === 'color' && $backgroundHeroColor && $backgroundHeroColor->fill()->value() === 'custom'): ?>
<?php if ($backgroundHeroColor->custom()->isNotEmpty()): ?>
.hero.bg-color-custom {
  background: #<?= $backgroundHeroColor->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundHeroColor->customDark()->isNotEmpty()): ?>
body.dark .hero.bg-color-custom {
  background: #<?= $backgroundHeroColor->customDark() ?> !important;
}
<?php endif ?>
<?php elseif ($backgroundHero->type()->value() === 'gradient' && $backgroundHeroGradient && $backgroundHeroGradient->fill()->value() === 'custom'): ?>
<?php if ($backgroundHeroGradient->custom()->isNotEmpty()): ?>
.hero.bg-gradient-custom {
  background: #<?php if ($backgroundHero->brightness()->bool()): ?>000<?php else: ?>fff<?php endif ?>;
  background: -webkit-<?= $backgroundHeroGradient->custom() ?>;
  background: -moz-<?= $backgroundHeroGradient->custom() ?>;
  background: -ms-<?= $backgroundHeroGradient->custom() ?>;
  background: -o-<?= $backgroundHeroGradient->custom() ?>;
  background: <?= $backgroundHeroGradient->custom() ?>;
}
<?php endif ?>
<?php if ($backgroundHeroGradient->customDark()->isNotEmpty()): ?>
body.dark .hero.bg-gradient-custom {
  background: #000 !important;
  background: -webkit-<?= $backgroundHeroGradient->customDark() ?> !important;
  background: -moz-<?= $backgroundHeroGradient->customDark() ?> !important;
  background: -ms-<?= $backgroundHeroGradient->customDark() ?> !important;
  background: -o-<?= $backgroundHeroGradient->customDark() ?> !important;
  background: <?= $backgroundHeroGradient->customDark() ?> !important;
}
<?php endif ?>
<?php endif ?>
<?php endif ?>
<?php if ($heroHeadingFill = $page->heroHeadingFill()->toStructure()->first()): ?>
<?php if ($heroHeadingFill->type()->value() === 'color' && $heroHeadingFill->color()->isNotEmpty()): ?>
.hero .title-fill-color {
  color: #<?= $heroHeadingFill->color() ?>;
}
<?php elseif ($heroHeadingFill->type()->value() === 'gradient' && $heroHeadingFill->gradient()->isNotEmpty()): ?>
.hero .title-fill-gradient {
  background-image: <?= $heroHeadingFill->gradient() ?>;
}
<?php endif ?>
<?php endif ?>
