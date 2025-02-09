<?php if ($block->text()->isNotEmpty()): ?>

  <?php if ($block->link()->value() === 'page' && $block->linkPage()->isNotEmpty() && $block->linkPage()->toPage()): ?>
    <a href="<?= $block->linkPage()->toPage()->url() ?>" class="button button-style-<?= $block->style() ?><?php if ($block->fullWidth()->bool()): ?> full-width<?php endif ?>" role="button"><?= $block->text() ?></a>
  <?php elseif ($block->link()->value() === 'url' && $block->linkUrl()->isNotEmpty()): ?>
    <a href="<?= $block->linkUrl() ?>" class="button button-style-<?= $block->style() ?><?php if ($block->fullWidth()->bool()): ?> full-width<?php endif ?>" role="button"<?php if ($block->linkTarget()->bool()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>><?= $block->text() ?><?php if ($block->linkTarget()->bool()): ?><span class="icon-external-link"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="24" viewBox="0 0 16 16"><path d="M14 14H2V2h5V0H2a2 2 0 00-2 2v12a2 2 0 002 2h12c1.1 0 2-.9 2-2V9h-2v5zM9 0v2h3.59L4.76 9.83l1.41 1.41L14 3.41V7h2V0H9z" fill="currentColor"></path></svg></span><?php endif ?></a>
  <?php endif ?>

<?php endif ?>
