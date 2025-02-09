<?php

  $items = $block->items()->toStructure();

?>
<?php if ($items->first()): ?>
  <div class="row timeline">

    <?php foreach ($items as $item): ?>
      <div class="col-1-<?= $block->items()->toStructure()->count() ?>">

        <?php if ($item->heading()->isNotEmpty()): ?>
          <h3 class="title-h5"><?= $item->heading() ?><?php if ($item->tag()->isNotEmpty()): ?><span class="space-left-05x tag tag-size-sm tag-style-new"><?= $item->tag() ?></span><?php endif ?></h3>
        <?php endif ?>

        <?php if ($item->text()->isNotEmpty()): ?>
          <div class="paragraph<?php if ($item->buttonText()->isNotEmpty()): ?> space-button<?php endif ?>">
            <?= $item->text() ?>
          </div>
        <?php endif ?>

        <?php if ($item->buttonText()->isNotEmpty()): ?>

          <?php if ($item->link()->value() === 'page' && $item->linkPage()->isNotEmpty() && $item->linkPage()->toPage()): ?>
            <a href="<?= $item->linkPage()->toPage()->url() ?>" class="button button-style-<?= $item->buttonStyle() ?><?php if ($item->buttonFullWidth()->bool()): ?> full-width<?php endif ?> space-top-1x" role="button"><?= $item->buttonText() ?></a>
          <?php elseif ($item->link()->value() === 'url' && $item->linkUrl()->isNotEmpty()): ?>
            <a href="<?= $item->linkUrl() ?>" class="button button-style-<?= $item->buttonStyle() ?><?php if ($item->buttonFullWidth()->bool()): ?> full-width<?php endif ?> space-top-1x" role="button"<?php if ($item->linkTarget()->bool()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>><?= $item->buttonText() ?><?php if ($item->linkTarget()->bool()): ?><span class="icon-external-link"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="24" viewBox="0 0 16 16"><path d="M14 14H2V2h5V0H2a2 2 0 00-2 2v12a2 2 0 002 2h12c1.1 0 2-.9 2-2V9h-2v5zM9 0v2h3.59L4.76 9.83l1.41 1.41L14 3.41V7h2V0H9z" fill="currentColor"></path></svg></span><?php endif ?></a>
          <?php endif ?>

        <?php endif ?>

      </div>
    <?php endforeach ?>

  </div>
<?php endif ?>
