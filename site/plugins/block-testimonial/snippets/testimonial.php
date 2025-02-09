<?php if ($block->text()->isNotEmpty() && in_array($block->alignContent()->value(), ['left', 'right'])): ?>
  <figure class="blockquote">

    <?php

      $class = 'row';

      if ($block->media()->isNotEmpty() && $block->media()->toFile()) {
        $class = $class . ' row-keep-proportions';
      } else {
        $class = $class . ' row-fill-empty-columns';
      }

    ?>
    <div class="<?= $class ?>">

      <?php if ($block->media()->isNotEmpty() && $block->media()->toFile()): ?>
        <div class="col-1-4">
          <img class="full-width rounded" loading="lazy" src="<?= $block->media()->toFile()->resize(160)->url() ?>"<?php if ($block->media()->toFile()->extension() !== 'svg'): ?> srcset="<?= $block->media()->toFile()->srcset([160 => '1x', 320 => '2x']) ?>"<?php endif ?> width="<?= $block->media()->toFile()->width() ?>" height="<?= $block->media()->toFile()->height() ?>" alt="<?= $block->media()->toFile()->alt() ?>">
        </div>
      <?php endif ?>

      <div class="col-3-4">
        <blockquote>
          <?= $block->text() ?>
        </blockquote>

        <?php if ($block->caption()->isNotEmpty()): ?>
          <figcaption><?= $block->caption() ?></figcaption>
        <?php endif ?>

      </div>
    </div>
  </figure>
<?php elseif ($block->text()->isNotEmpty()): ?>
  <figure class="blockquote">

    <?php if ($block->media()->isNotEmpty() && $block->media()->toFile()): ?>
      <img class="actual-size full-width rounded space-bottom-15x" loading="lazy" src="<?= $block->media()->toFile()->resize(80)->url() ?>"<?php if ($block->media()->toFile()->extension() !== 'svg'): ?> srcset="<?= $block->media()->toFile()->srcset([80 => '1x', 160 => '2x']) ?>"<?php endif ?> width="<?= $block->media()->toFile()->width() ?>" height="<?= $block->media()->toFile()->height() ?>" alt="<?= $block->media()->toFile()->alt() ?>">
    <?php endif ?>

    <blockquote>
      <?= $block->text() ?>
    </blockquote>

    <?php if ($block->caption()->isNotEmpty()): ?>
      <figcaption><?= $block->caption() ?></figcaption>
    <?php endif ?>

  </figure>
<?php endif ?>
