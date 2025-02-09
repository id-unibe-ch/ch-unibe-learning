<?php

  $backgroundHeader = $site->headerBackground()->toStructure()->first();
  $backgroundHero = $page->parent()->postHeroBackground()->toStructure()->first();
  $backgroundSlider = $page->parent()->postSliderBackground()->toStructure()->first();
  $productBlocks = '';

?>
<?php snippet('header') ?>

  <?php

    if ($backgroundHero) {
      $backgroundHeroClass = background($backgroundHero);
    }

    // Classes

    $class = 'product';

    if ($backgroundHeader && background($backgroundHeader)) {
      $class = $class . ' header-bg';

      if ($site->headerPosition()->value() === 'default') {
        $class = $class . ' header-default';
      } elseif ($site->headerPosition()->value() === 'fixed') {
        $class = $class . ' header-fixed';
      } elseif ($site->headerPosition()->value() === 'fixed--sm') {
        $class = $class . ' header-fixed header-fixed--sm';
      }
    } elseif ($site->headerPosition()->value() === 'default') {
      $class = $class . ' header-default';
    } elseif (in_array($site->headerPosition()->value(), ['fixed', 'fixed--sm'])) {
      $class = $class . ' header-fixed header-fixed--sm';
    }

  ?>
  <main class="<?= $class ?>">

    <?php snippet('hero') ?>

    <?php if ($page->sliderMedia()->isNotEmpty()): ?>

      <?php

        // Classes

        if ($backgroundSlider && background($backgroundSlider)) {
          $class = background($backgroundSlider) . ' padding';
        } elseif ($page->features()->isNotEmpty()) {
          $class = 'padding padding-bottom-none';
        } else {
          $class = 'padding';
        }

        if ($page->parent()->postSliderPaddingTop()->bool() === false) {
          $class = $class . ' padding-top-none';
        }

        if ($backgroundSlider && $backgroundSlider->brightness()->bool()) {
          $class = $class . ' dark';
        }

      ?>
      <section id="slider" class="<?= $class ?>">

        <?php

          // Classes

          $class = 'display-block full-width';

          if ($animation = $page->parent()->postSliderAnimation()->toStructure()->first()) {
            $class = $class . ' js-animation js-a-type-' . $animation->type() . ' js-scrolled';
          }

        ?>
        <div class="<?= $class ?>">

          <?php snippet('blocks/slider', [
            'animation' => $page->parent()->postSliderAnimation(),
            'autoPlay' => $page->parent()->postSliderAutoPlay(),
            'autoPlayTime' => $page->parent()->postSliderAutoPlayTime(),
            'border' => $page->parent()->postSliderBorder(),
            'caption' => $page->parent()->postSliderCaption(),
            'draggable' => $page->parent()->postSliderDraggable(),
            'height' => $page->parent()->postSliderHeight(),
            'media' => $page->sliderMedia(),
            'mediaPositionHorizontal' => $page->parent()->postSliderMediaPositionHorizontal(),
            'mediaPositionVertical' => $page->parent()->postSliderMediaPositionVertical(),
            'pauseAutoPlayOnHover' => $page->parent()->postSliderPauseAutoPlayOnHover(),
            'prevNextButtons' => $page->parent()->postSliderPrevNextButtons(),
            'rounded' => $page->parent()->postSliderRounded(),
            'shadow' => $page->parent()->postSliderShadow(),
            'spanAcross' => $page->parent()->postSliderSpanAcross(),
            'thumbnails' => $page->parent()->postSliderThumbnails(),
            'wrapAround' => $page->parent()->postSliderWrapAround()
          ]) ?>

        </div>
      </section>
    <?php endif ?>

    <?php if (($features = $page->features()->toStructure()) && $features->first() && $features->first()->category()->isNotEmpty()): ?>
      <section id="features" class="overflow-visible padding<?php if ($page->parent()->postShare()->bool()): ?> padding-bottom-none<?php endif ?><?php if (!($backgroundHero && $backgroundHeroClass) && $page->sliderMedia()->isEmpty() && $page->parent()->postHeroPaddingBottom()->bool()): ?> padding-top-none<?php endif ?>">

        <?php $numFeature = 0; foreach ($features as $feature): $numFeature = ++$numFeature; ?>

          <?php if ($feature->category()->isNotEmpty()): ?>
            <div class="row row-gutter-lg row-keep-proportions row-one-column--md feature-<?= $numFeature ?> max-width-lg<?php if (!$feature->isLast()): ?> space-bottom-3x<?php endif ?>">
              <div class="col-1-5">

                <?php

                  // Classes

                  $class = 'muted position-sticky title-h6';

                  if ($backgroundHeader && background($backgroundHeader) && $site->headerPosition()->value() === 'fixed') {
                    $class = $class . ' header-fixed';
                  }

                ?>
                <h3 class="<?= $class ?>"><?= $feature->category() ?></h3>
              </div>
              <div class="col-4-5">

                <?php snippet('blocks', ['page' => $feature->blocks(), 'productBlocks' => $productBlocks]) ?>

              </div>
            </div>
          <?php endif ?>

        <?php endforeach ?>

      </section>
    <?php endif ?>

    <?php if ($page->parent()->postShare()->bool()): ?>
      <section id="share" class="padding">
        <div class="align-center bg-color-gray-dark border max-width-lg padding rounded share">
          <div class="font-size-sm muted space-bottom-1x text-uppercase">Share <strong><?= $page->title() ?></strong>:</div>

            <?php snippet('share') ?>

        </div>
      </section>
    <?php endif ?>

    <?php if ($page->parent()->postRelated()->bool() && $page->parent()->children()->listed()->count() > 2): ?>

      <?php snippet('posts-related') ?>

    <?php endif ?>

  </main>

<?php snippet('footer') ?>