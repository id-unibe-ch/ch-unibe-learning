<?php if ($block->media()->isNotEmpty() && $block->media()->toFile()): ?>

  <?php

    // Classes

    $class = 'row row-fill-empty-columns';

    if ($block->gutter()->bool()) {
      $class = $class . ' row-gutter-sm';
    } else {
      $class = $class . ' row-gutter-none';

      if ($block->border()->bool()) {
        $class = $class . ' border border-img';
      }

      if ($block->rounded()->bool()) {
        $class = $class . ' rounded';
      }

      if ($block->shadow()->value() !== 'none') {
        $class = $class . ' shadow-' . $block->shadow();
      }
    }

    if ($block->columnsResponsive()->value() === 'same') {
      $class = $class . ' row-keep-proportions';
    } elseif ($block->columnsResponsive()->value() === '2') {
      $class = $class . ' row-min-two-columns';
    }

  ?>
  <div class="<?= $class ?>">

    <?php foreach ($block->media()->toFiles() as $mediaFile): ?>

      <?php

        // Classes

        $class = 'col-1-' . $block->columns() . ' align-items-' . $block->mediaPositionVertical() . ' gallery-item';

        if ($block->gutter()->bool()) {
          if ($block->border()->bool()) {
            $class = $class . ' border border-img';
          }

          if ($block->rounded()->bool()) {
            $class = $class . ' rounded';
          }

          if ($block->shadow()->value() !== 'none') {
            $class = $class . ' shadow-' . $block->shadow();
          }
        }

      ?>
      <div class="<?= $class ?>">

        <?php

          // Classes

          $class = 'full-width object-position-' . $block->mediaPositionHorizontal();

          if ($animation = $block->animation()->toStructure()->first()) {
            $class = $class . ' js-animation js-a-type-' . $animation->type() . ' js-loading js-scrolled';
          }

        ?>
        <img<?php if (isset($animation)): ?> onload="this.classList.remove('js-loading')"<?php endif ?> class="<?= $class ?>" draggable="false" loading="lazy" src="<?= $mediaFile->url() ?>"<?php if ($mediaFile->extension() !== 'svg'): ?> srcset="<?= $mediaFile->srcset('half') ?>"<?php endif ?> width="<?= $mediaFile->width() ?>" height="<?= $mediaFile->height() ?>" alt="<?= $mediaFile->alt() ?>">
      </div>

    <?php endforeach ?>

  </div>
<?php endif ?>
