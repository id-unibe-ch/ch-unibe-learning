<?php if ($block->url()->isNotEmpty()): ?>

  <?php

    // Classes

    if ($block->width()->value() === 'custom' && $block->widthCustom()->isNotEmpty()) {
      $class = 'custom-width';
      $widthCustom = $block->widthCustom()->value();
    } else {
      $class = 'full-width';
    }

    if ($block->border()->bool()) {
      $class = $class . ' border border-img';
    }

    if ($block->rounded()->bool()) {
      $class = $class . ' rounded';
    }

    if ($block->shadow()->value() !== 'none') {
      $class = $class . ' shadow-' . $block->shadow();
    }

    if ($animation = $block->animation()->toStructure()->first()) {
      $class = $class . ' js-animation js-a-type-' . $animation->type() . ' js-loading js-scrolled';
    }

  ?>
  <?php if ($block->link()->value() === 'page' && $block->linkPage()->isNotEmpty() && $block->linkPage()->toPage()): ?>
    <a href="<?= $block->linkPage()->toPage()->url() ?>" class="full-width">
      <img<?php if (isset($animation)): ?> onload="this.classList.remove('js-loading')"<?php endif ?> class="<?= $class ?>" loading="lazy" src="<?= $block->url() ?>" <?php if (isset($widthCustom)): ?>style="width: <?= $widthCustom ?>px;" <?php endif ?>alt="">
    </a>
  <?php elseif ($block->link()->value() === 'url' && $block->linkUrl()->isNotEmpty()): ?>
    <a href="<?= $block->linkUrl() ?>" class="full-width"<?php if ($block->linkTarget()->bool()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>>
      <img<?php if (isset($animation)): ?> onload="this.classList.remove('js-loading')"<?php endif ?> class="<?= $class ?>" loading="lazy" src="<?= $block->url() ?>" <?php if (isset($widthCustom)): ?>style="width: <?= $widthCustom ?>px;" <?php endif ?>alt="">
    </a>
  <?php else: ?>
    <img<?php if (isset($animation)): ?> onload="this.classList.remove('js-loading')"<?php endif ?> class="<?= $class ?>" loading="lazy" src="<?= $block->url() ?>" <?php if (isset($widthCustom)): ?>style="width: <?= $widthCustom ?>px;" <?php endif ?>alt="">
  <?php endif ?>

<?php endif ?>
