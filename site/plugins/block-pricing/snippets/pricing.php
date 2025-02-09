<?php if ($block->iconType()->value() === 'image' && ($icon = $block->iconImage()->toFile())): ?>
  <img class="space-bottom-1x" loading="lazy" src="<?= $icon->resize(72)->url() ?>"<?php if ($icon->extension() !== 'svg'): ?> srcset="<?= $icon->srcset([72 => '1x', 144 => '2x']) ?>"<?php endif ?> width="<?= $icon->width() ?>" height="<?= $icon->height() ?>" alt="<?= $block->heading() ?>">
<?php elseif ($block->iconType()->value() === 'svg' && $block->iconSvg()->isNotEmpty()): ?>
  <div class="margin-auto-<?= $block->alignContent() ?> space-bottom-1x"><?= $block->iconSvg() ?></div>
<?php endif ?>

<?php if ($block->heading()->isNotEmpty()): ?>
  <h3 class="title-h5"><?= $block->heading() ?><?php if ($block->tag()->isNotEmpty()): ?><span class="space-left-05x tag tag-size-sm tag-style-new"><?= $block->tag() ?></span><?php endif ?></h3>
<?php endif ?>

<?php if ($block->price()->isNotEmpty()): ?>
  <div class="title-h3 space-bottom-1x">
    <span class="pricing-price"><?= $block->price() ?></span>

    <?php if ($block->priceDetails()->isNotEmpty()): ?>
      <span class="font-size-lg muted"><?= $block->priceDetails() ?></span>
    <?php endif ?>

  </div>
<?php endif ?>

<?php if ($block->text()->isNotEmpty()): ?>

  <?php

    $class = 'paragraph';

    if ($block->features()->isNotEmpty()) {
      $class = $class . ' space-bottom-1x';
    } else {
      $class = $class . ' space-bottom-15x';
    }

  ?>
  <div class="<?= $class ?>">
    <?= $block->text() ?>
  </div>
<?php endif ?>

<?php if ($block->features()->isNotEmpty()): ?>
  <div class="paragraph space-bottom-15x">
    <?= $block->features() ?>
  </div>
<?php endif ?>

<?php if ($block->buttonText()->isNotEmpty()): ?>

  <?php if ($block->link()->value() === 'page' && $block->linkPage()->isNotEmpty() && $block->linkPage()->toPage()): ?>
    <a href="<?= $block->linkPage()->toPage()->url() ?>" class="button button-style-<?= $block->buttonStyle() ?><?php if ($block->buttonFullWidth()->bool()): ?> full-width<?php endif ?> space-top-15x" role="button"><?= $block->buttonText() ?></a>
  <?php elseif ($block->link()->value() === 'url' && $block->linkUrl()->isNotEmpty()): ?>
    <a href="<?= $block->linkUrl() ?>" class="button button-style-<?= $block->buttonStyle() ?><?php if ($block->buttonFullWidth()->bool()): ?> full-width<?php endif ?> space-top-15x" role="button"<?php if ($block->linkTarget()->bool()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>><?= $block->buttonText() ?></a>
  <?php endif ?>

<?php endif ?>
