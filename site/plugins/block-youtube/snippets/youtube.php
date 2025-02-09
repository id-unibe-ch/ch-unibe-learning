<?php if ($block->url()->isNotEmpty()): ?>

  <?php

    // Classes

    $class = 'bg-color-dark max-width-' . $block->width() . ' max-width-' . $block->alignBlock();

    if ($block->border()->bool()) {
      $class = $class . ' border';
    }

    if ($block->height()->isNotEmpty()) {
      $class = $class . ' custom-height';
    }

    if ($block->rounded()->bool()) {
      $class = $class . ' rounded';
    }

    if ($block->shadow()->value() !== 'none') {
      $class = $class . ' shadow-' . $block->shadow();
    }

  ?>
  <div class="<?= $class ?>">
    <figure class="full-width">
      <?= video($block->url()) ?>
    </figure>
  </div>
<?php endif ?>
