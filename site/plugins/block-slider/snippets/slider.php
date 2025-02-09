<?php

  if (isset($block)) {
    $animation = $block->animation();
    $autoPlay = $block->autoPlay();
    $autoPlayTime = $block->autoPlayTime();
    $border = $block->border();
    $caption = $block->caption();
    $draggable = $block->draggable();
    $height = $block->height();
    $media = $block->media();
    $mediaPositionHorizontal = $block->mediaPositionHorizontal();
    $mediaPositionVertical = $block->mediaPositionVertical();
    $pauseAutoPlayOnHover = $block->pauseAutoPlayOnHover();
    $prevNextButtons = $block->prevNextButtons();
    $rounded = $block->rounded();
    $shadow = $block->shadow();
    $spanAcross = $block->spanAcross();
    $thumbnails = $block->thumbnails();
    $width = $block->width();
    $wrapAround = $block->wrapAround();
  }

?>
<?php if ($media->isNotEmpty()): ?>

  <?php

    // Classes

    if (isset($heroBlocks)) {
      $class = 'main-carousel main-carousel-hero-' . $numRow . '-' . $numColumn . '-' . $numBlock;
    } elseif (isset($numRow)) {
      $class = 'main-carousel main-carousel-content-' . $numRow . '-' . $numColumn . '-' . $numBlock;
    } elseif (isset($numBlock)) {
      $class = 'main-carousel main-carousel-content-post-' . $numBlock;
    } else {
      $class = 'main-carousel';
    }

    if ($rounded->bool()) {
      $class = $class . ' rounded';
    }

    if ($spanAcross->bool()) {
      $class = $class . ' span-across';
    }

    if ($wrapAround->bool()) {
      $class = $class . ' wrap-around';
    }

    // Slider options

    $options = '';

    if ($autoPlay->bool() && $autoPlayTime->isNotEmpty()) {
      $options = $options . '"autoPlay":' . $autoPlayTime . ',"groupCells":false,';

      if ($pauseAutoPlayOnHover->bool()) {
        $options = $options . '"pauseAutoPlayOnHover":false,';
      }
    } elseif ($autoPlay->bool()) {
      $options = $options . '"autoPlay":1500,"groupCells":false,';

      if ($pauseAutoPlayOnHover->bool()) {
        $options = $options . '"pauseAutoPlayOnHover":false,';
      }
    } else {
      $options = $options . '"groupCells":true,';
    }

    if ($draggable->bool() === false) {
      $options = $options . '"draggable":false,';
    }

    if ($prevNextButtons->bool()) {
      $options = $options . '"prevNextButtons":false,';
    }

    if ($wrapAround->bool()) {
      $options = $options . '"wrapAround":true,';
    }

    $options = $options . '"cellAlign":"left","lazyLoad":3,"pageDots":false,"arrowShape":{"x0":20,"x1":60,"y1":40,"x2":70,"y2":30,"x3":40}';

  ?>
  <div class="<?= $class ?>" data-flickity='{<?= $options ?>}'>

    <?php

      // Define image srcset

      if (isset($width) && in_array($width->value(), ['xs', 'sm', 'md'])) {
        $srcset = 'half';
      } else {
        $srcset = '';
      }

      foreach ($media->toFiles() as $mediaFile):

    ?>
      <div class="carousel-cell max-width-<?= $width ?? 'lg' ?>">

        <?php

          // Classes

          $class = 'align-items-' . $mediaPositionVertical . ' carousel-media';

          if ($border->bool()) {
            $class = $class . ' border border-img';
          }

          if ($rounded->bool()) {
            $class = $class . ' rounded';
          }

          if ($shadow->value() !== 'none') {
            $class = $class . ' shadow-' . $shadow;
          }

        ?>
        <div class="<?= $class ?>">

          <?php if ($mediaFile->type() === 'image'): ?>

            <?php

              // Classes

              if (isset($width) && $width->value() === 'custom' && $block->widthCustom()->isNotEmpty()) {
                $class = 'custom-width object-position-' . $mediaPositionHorizontal;
                $widthCustom = $block->widthCustom()->value();
              } else {
                $class = 'object-position-' . $mediaPositionHorizontal;
              }

              if ($animation->toStructure()->first()) {
                $class = $class . ' js-animation js-a-type-fade-in js-loading js-scrolled';
              }

            ?>
            <img<?php if ($animation->toStructure()->first()): ?> onload="this.classList.remove('js-loading')"<?php endif ?> class="<?= $class ?>" loading="lazy" src="<?= $mediaFile->resize(null, 200)->url() ?>" data-flickity-lazyload-src="<?= $mediaFile->url() ?>"<?php if ($mediaFile->extension() !== 'svg'): ?> data-flickity-lazyload-srcset="<?= $mediaFile->srcset($srcset) ?>"<?php endif ?> width="<?= $mediaFile->width() ?>" height="<?= $mediaFile->height() ?>" <?php if (isset($widthCustom)): ?>style="width: <?= $widthCustom ?>px;" <?php endif ?>alt="<?= $mediaFile->alt() ?>">

          <?php elseif ($mediaFile->type() === 'video'): ?>
            <video class="object-position-<?= $mediaPositionHorizontal ?>"<?php if ($mediaFile->autoplay()->bool()): ?> autoplay<?php endif ?><?php if ($mediaFile->controls()->bool()): ?> controls<?php endif ?><?php if ($mediaFile->loop()->bool()): ?> loop<?php endif ?><?php if ($mediaFile->muted()->bool()): ?> muted<?php endif ?><?php if ($mediaFile->playsinline()->bool()): ?> playsinline<?php endif ?>>
              <source src="<?= $mediaFile->url() ?>" type="<?php if ($mediaFile->extension() === 'mp4'): ?>video/mp4<?php elseif ($mediaFile->extension() === 'ogg'): ?>video/ogg<?php elseif ($mediaFile->extension() === 'webm'): ?>video/webm<?php endif ?>">
              <p>Your browser does not support the video element.</p>
            </video>
          <?php endif ?>

        </div>

        <?php if ($caption->bool() && $mediaFile->caption()->isNotEmpty()): ?>
          <div class="align-left caption space-top-1x">

            <?= $mediaFile->caption() ?>

          </div>
        <?php endif ?>

      </div>
    <?php endforeach ?>

  </div>

  <?php if ($thumbnails->bool() && $media->toFiles()->count() > 1): ?>

    <?php

      // Classes

      $class = 'main-carousel-nav space-top-15x';

      if ($rounded->bool()) {
        $class = $class . ' rounded';
      }

      if ($spanAcross->bool()) {
        $class = $class . ' span-across';
      }

      // Thumbnails options

      if (isset($heroBlocks)) {
        $options = '"asNavFor":".main-carousel-hero-' . $numRow . '-' . $numColumn . '-' . $numBlock . '",';
      } elseif (isset($numRow)) {
        $options = '"asNavFor":".main-carousel-content-' . $numRow . '-' . $numColumn . '-' . $numBlock . '",';
      } elseif (isset($numBlock)) {
        $options = '"asNavFor":".main-carousel-content-post-' . $numBlock . '",';
      } else {
        $options = '"asNavFor":".main-carousel",';
      }

      $options = $options . '"contain":true,"draggable":false,"lazyLoad":99,"pageDots":false,"prevNextButtons":false';

    ?>
    <div class="<?= $class ?>" data-flickity='{<?= $options ?>}'>

      <?php foreach($media->toFiles() as $mediaFile): ?>

        <?php

          // Classes

          $class = 'align-items-' . $mediaPositionVertical . ' carousel-cell';

          if ($border->bool()) {
            $class = $class . ' border border-img';
          }

          if ($height->isNotEmpty()) {
            $class = $class . ' height-xs';
          }

          if ($rounded->bool()) {
            $class = $class . ' rounded';
          }

        ?>
        <div class="<?= $class ?>">
          <img class="full-width object-position-<?= $mediaPositionHorizontal ?>" src="<?= $mediaFile->resize(null, 160)->url() ?>" data-flickity-lazyload-src="<?= $mediaFile->resize(160)->url() ?>"<?php if ($mediaFile->extension() !== 'svg'): ?> data-flickity-lazyload-srcset="<?= $mediaFile->srcset([160, 320]) ?>"<?php endif ?> width="<?= $mediaFile->width() ?>" height="<?= $mediaFile->height() ?>" alt="<?= $mediaFile->alt() ?>">
        </div>
      <?php endforeach ?>

    </div>
  <?php endif ?>

<?php endif ?>
