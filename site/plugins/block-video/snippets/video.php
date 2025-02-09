<?php if ($block->media()->isNotEmpty() && $block->media()->toFile()): ?>

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
      <video class="full-width"<?php if ($block->media()->toFile()->autoplay()->bool()): ?> autoplay<?php endif ?><?php if ($block->media()->toFile()->controls()->bool()): ?> controls<?php endif ?><?php if ($block->media()->toFile()->loop()->bool()): ?> loop<?php endif ?><?php if ($block->media()->toFile()->muted()->bool()): ?> muted<?php endif ?><?php if ($block->media()->toFile()->playsinline()->bool()): ?> playsinline<?php endif ?>>
        <source src="<?= $block->media()->toFile()->url() ?>" type="<?php if ($block->media()->toFile()->extension() === 'mp4'): ?>video/mp4<?php elseif ($block->media()->toFile()->extension() === 'ogg'): ?>video/ogg<?php elseif ($block->media()->toFile()->extension() === 'webm'): ?>video/webm<?php endif ?>">
        <p>Your browser does not support the video element.</p>
      </video>
    </figure>
  </div>
<?php endif ?>
