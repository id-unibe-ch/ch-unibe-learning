<?php if ($block->heading()->isNotEmpty()): ?>
  <h3 class="title-<?= $block->fontSize() ?>"><?= $block->heading() ?></h3>
<?php endif ?>

<?php if ($block->text()->isNotEmpty()): ?>
  <div class="paragraph">
    <?= $block->text() ?>
  </div>
<?php endif ?>

<?php if ($block->form()->value() === 'default' && $site->newsletterCode()->isNotEmpty()): ?>
  <div class="space-top-2x">
    <?= $site->newsletterCode() ?>
  </div>
<?php elseif ($block->form()->value() === 'custom' && $block->formCustom()->isNotEmpty()): ?>
  <div class="space-top-2x">
    <?= $block->formCustom() ?>
  </div>
<?php endif ?>
