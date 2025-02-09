<?php if ($block->iconType()->value() === 'image' && ($icon = $block->iconImage()->toFile())): ?>
  <img class="space-bottom-05x" loading="lazy" src="<?= $icon->resize(72)->url() ?>"<?php if ($icon->extension() !== 'svg'): ?> srcset="<?= $icon->srcset([72 => '1x', 144 => '2x']) ?>"<?php endif ?> width="<?= $icon->width() ?>" height="<?= $icon->height() ?>" alt="<?= $block->heading() ?>">
<?php elseif ($block->iconType()->value() === 'svg' && $block->iconSvg()->isNotEmpty()): ?>
  <div class="margin-auto-<?= $block->alignContent() ?> space-bottom-05x"><?= $block->iconSvg() ?></div>
<?php endif ?>

<?php if ($block->heading()->isNotEmpty()): ?>
  <h3 class="title-h5"><?= $block->heading() ?><?php if ($block->tag()->isNotEmpty()): ?><span class="tag tag-size-sm tag-style-new"><?= $block->tag() ?></span><?php endif ?></h3>
<?php endif ?>

<?php if ($block->text()->isNotEmpty()): ?>
  <div class="paragraph<?php if ($block->buttonText()->isNotEmpty()): ?> space-button<?php endif ?>">
    <?= $block->text() ?>
  </div>
<?php endif ?>

<?php if ($block->buttonText()->isNotEmpty()): ?>

  <?php if ($block->link()->value() === 'page' && $block->linkPage()->isNotEmpty() && $block->linkPage()->toPage()): ?>
    <a href="<?= $block->linkPage()->toPage()->url() ?>" class="button button-style-<?= $block->buttonStyle() ?><?php if ($block->buttonFullWidth()->bool()): ?> full-width<?php endif ?> space-top-1x" role="button"><?= $block->buttonText() ?></a>
  <?php elseif ($block->link()->value() === 'url' && $block->linkUrl()->isNotEmpty()): ?>
    <a href="<?= $block->linkUrl() ?>" class="button button-style-<?= $block->buttonStyle() ?><?php if ($block->buttonFullWidth()->bool()): ?> full-width<?php endif ?> space-top-1x" role="button"<?php if ($block->linkTarget()->bool()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>><?= $block->buttonText() ?><?php if ($block->linkTarget()->bool()): ?><span class="icon-external-link"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="24" viewBox="0 0 16 16"><path d="M14 14H2V2h5V0H2a2 2 0 00-2 2v12a2 2 0 002 2h12c1.1 0 2-.9 2-2V9h-2v5zM9 0v2h3.59L4.76 9.83l1.41 1.41L14 3.41V7h2V0H9z" fill="currentColor"></path></svg></span><?php endif ?></a>
  <?php endif ?>

<?php endif ?>
