<?php

  if ($product = $page->template() == 'product') {
    $author = $page->author()->toUser();
    $backgroundHero = $page->parent()->postHeroBackground()->toStructure()->first();
    $buttons = $page->parent()->postButtons()->toStructure();
    $cover = $page->cover()->toFile();
  } else {
    $backgroundHero = $page->heroBackground()->toStructure()->first();
    $buttons = $page->heroButtons()->toStructure();
  }

  if ($backgroundHero) {
    $backgroundHeroClass = background($backgroundHero);
    $backgroundHeroSvg = $backgroundHero->svg()->toStructure()->first();
  }

  $heroBlocks = '';
  $srcsetHalf = '';

?>
<?php if ($backgroundHero && $backgroundHeroClass && $backgroundHero->size()->value() === 'lg'): ?>

  <?php

    // Classes

    $class = 'hero-lg padding';

    if ($product && $page->parent()->postHeroPaddingBottom()->bool() === false) {
      $class = $class . ' padding-bottom-none';
    } elseif (!$product && $page->heroPaddingBottom()->bool() === false) {
      $class = $class . ' padding-bottom-none';
    }

  ?>
  <div class="<?= $class ?>">
<?php endif ?>

    <?php

      // Classes

      $class = 'hero padding';

      if ($backgroundHero && $backgroundHeroClass) {
        $class = $class . ' ' . $backgroundHeroClass;

        if ($backgroundHero->size()->value() === 'full-screen') {
          $class = $class . ' full-screen';
        }

        if ($backgroundHero->size()->value() === 'lg') {
          $class = $class . ' hero-lg max-width-lg rounded';
        } elseif ($product && $page->parent()->postHeroPaddingBottom()->bool() === false) {
          $class = $class . ' padding-bottom-none';
        } elseif (!$product && $page->heroPaddingBottom()->bool() === false) {
          $class = $class . ' padding-bottom-none';
        }
      } elseif ($product && $page->parent()->postHeroPaddingBottom()->bool() === false) {
        $class = $class . ' padding-bottom-none';
      } elseif (!$product && $page->heroPaddingBottom()->bool() === false) {
        $class = $class . ' padding-bottom-none';
      }

      if ($page->heroBlocks()->toBlocks()->first()) {
        $class = $class . ' hero-blocks';
      } elseif ($product && $cover) {
        $class = $class . ' hero-blocks';
      }

      if ($page->heroColumns()->value() === '2' || ($product && $page->parent()->postHeroColumns()->value() === '2')) {
        $class = $class . ' hero-columns';

        if (($product && $cover) || $page->heroBlocks()->toBlocks()->first()) {
          $class = $class . ' hero-padding-top';
        }
      }

      if ($backgroundHero && $backgroundHero->brightness()->bool()) {
        $class = $class . ' dark';
      }

    ?>
    <section class="<?= $class ?>">

      <?php if ($backgroundHero && $backgroundHeroSvg && $backgroundHeroSvg->code()->isNotEmpty()): ?>
        <div class="bg-svg bg-svg-position-<?= $backgroundHeroSvg->positionHorizontal() ?> bg-svg-position-<?= $backgroundHeroSvg->positionVertical() ?>"><?= $backgroundHeroSvg->code() ?></div>
      <?php endif ?>

      <?php

        // Classes

        if ($page->heroColumns()->value() === '2' || ($product && $page->parent()->postHeroColumns()->value() === '2')) {
          if ($product) {
            $class = 'row row-gutter-lg max-width-' . $page->parent()->postHeroWidth();
          } else {
            $class = 'row row-gutter-lg max-width-' . $page->heroWidth();
          }
        } else {
          $class = 'max-width-lg';
        }

      ?>
      <div class="<?= $class ?>">

        <?php if ($page->heroColumns()->value() === '2' || ($product && $page->parent()->postHeroColumns()->value() === '2')): ?>

          <?php

            // Classes

            if ($page->heroColumnWidth()->value() === 'equal' || ($product && $page->parent()->postHeroColumnWidth()->value() === 'equal')) {
              $class = 'col-1-2';
            } elseif ($page->heroColumnWidth()->value() === 'right' || ($product && $page->parent()->postHeroColumnWidth()->value() === 'right')) {
              $class = 'col-2-5';
            } else {
              $class = 'col-3-5';
            }

            if ($page->heroBlocks()->toBlocks()->first()) {
              $class = $class . ' align-middle';
            }

          ?>
          <div class="<?= $class ?>">
        <?php endif ?>

            <?php

              // Classes

              if ($product) {
                $class = 'align-' . $page->parent()->postHeroAlign();
              } else {
                $class = 'align-' . $page->heroAlign();
              }

              if (($page->heroColumns()->value() === '1' && $page->heroWidth()->value() !== 'lg') || ($product && $page->parent()->postHeroColumns()->value() === '1' && $page->parent()->postHeroWidth()->value() !== 'lg')) {
                if ($product) {
                  $class = $class . ' max-width-' . $page->parent()->postHeroWidth();
                } else {
                  $class = $class . ' max-width-' . $page->heroWidth();
                }
              }

              if ($page->heroBlocks()->toBlocks()->first() || ($product && $cover)) {
                if ($page->heroColumns()->value() === '1' || ($product && $page->parent()->postHeroColumns()->value() === '1')) {
                  if ($page->heroBlocks()->toBlocks()->first() && in_array($page->heroBlocks()->toBlocks()->first()->width()->value(), ['xs', 'sm'])) {
                    $class = $class . ' space-bottom-3x space-hero space-top';
                  } else {
                    $class = $class . ' space-bottom space-hero space-top';
                  }
                } else {
                  if ($page->heroBlocks()->toBlocks()->first() && in_array($page->heroBlocks()->toBlocks()->first()->width()->value(), ['xs', 'sm'])) {
                    $class = $class . ' space-bottom space-hero space-top';
                  } else {
                    $class = $class . ' space-bottom--md space-hero space-top--md';
                  }
                }
              } else {
                $class = $class . ' space-bottom space-hero space-top';
              }

            ?>
            <div class="<?= $class ?>">

              <?php if (param('t')): ?>
                <h1 class="space-bottom-1x title-<?= $page->heroHeadingFontSize()->or('h2') ?>"><?= urldecode(param('t')) ?></h1>
                <span class="button button-style-secondary button-tag margin-auto-<?php if ($product): ?><?= $page->parent()->postHeroAlign() ?><?php else: ?><?= $page->heroAlign() ?><?php endif ?> muted"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="32" viewBox="0 0 16 16"><path d="M15.528 7.664l-7.2-7.2A1.59 1.59 0 007.2 0H1.6C.72 0 0 .72 0 1.6v5.6c0 .44.176.84.472 1.136l7.2 7.2A1.59 1.59 0 008.8 16c.44 0 .84-.176 1.128-.472l5.6-5.6C15.824 9.64 16 9.24 16 8.8c0-.44-.184-.848-.472-1.136zM2.8 4c-.664 0-1.2-.536-1.2-1.2 0-.664.536-1.2 1.2-1.2.664 0 1.2.536 1.2 1.2C4 3.464 3.464 4 2.8 4z" fill="currentColor"></path></svg></span>
              <?php else: $heroHeadingFill = $page->heroHeadingFill()->toStructure()->first(); ?>
                <h1 class="title-fill-<?php if ($heroHeadingFill && (($heroHeadingFill->type()->value() === 'color' && $heroHeadingFill->color()->isNotEmpty()) || ($heroHeadingFill->type()->value() === 'gradient' && $heroHeadingFill->gradient()->isNotEmpty()))): ?><?= $heroHeadingFill->type() ?><?php else: ?>none<?php endif ?> title-<?php if ($product && $page->parent()->postHeroColumns()->value() === '1'): ?>h1<?php else: ?><?= $page->heroHeadingFontSize()->or('h2') ?><?php endif ?>"><?= $page->heroHeading()->or($page->title()) ?></h1>

                <?php if ($product && $page->parent()->author()->bool() && $author && $author->name()->isNotEmpty()): ?>
                  <div class="muted space-bottom-075x"><?= $author->name() ?></div>
                <?php endif ?>

                <?php if ($product && $page->parent()->postHeroPrice()->bool() && $page->price()->isNotEmpty()): ?>
                  <div class="space-bottom-075x">
                    <span class="font-regular title-h4"><?= $site->currencySymbol()->or('$') ?><?= $page->price() ?></span>

                    <?php if ($page->priceDetails()->isNotEmpty()): ?>
                      <span class="font-size-lg muted"><?= $page->priceDetails() ?></span>
                    <?php endif ?>

                    <?php if ($page->soldOut()->bool()): ?>
                      <span class="display-inline-block font-regular space-left-05x tag tag-size-lg tag-style-new"><?= $page->parent()->soldOutText()->or('Sold Out') ?></span>
                    <?php endif ?>

                  </div>
                <?php endif ?>

                <?php if ($page->heroText()->isNotEmpty()): ?>
                  <div class="paragraph-2x<?php if ($buttons->isNotEmpty()): ?> space-bottom-1x<?php endif ?>"><?= $page->heroText() ?></div>
                <?php elseif ($product && $page->text()->isNotEmpty()): ?>
                  <div class="paragraph-2x<?php if ($buttons->isNotEmpty()): ?> space-bottom-1x<?php endif ?>"><?= $page->text() ?></div>
                <?php elseif ($product && ($featureFirst = $page->features()->toStructure()->first()) && ($featureFirstBlockFirst = $featureFirst->blocks()->toBlocks()->first()) && $featureFirstBlockFirst->text()->isNotEmpty()): ?>
                  <div class="paragraph-2x<?php if ($buttons->isNotEmpty()): ?> space-bottom-1x<?php endif ?>"><?= $featureFirstBlockFirst->text()->excerpt(160) ?></div>
                <?php endif ?>

              <?php endif ?>

              <?php if ($buttons->isNotEmpty() || ($product && ($page->comingSoon()->bool() || ($page->buttonPurchaseType()->value() === 'url' && $page->buttonPurchaseLink()->isNotEmpty()) || ($page->buttonPurchaseType()->value() === 'code' && $page->buttonPurchaseCode()->isNotEmpty()) || $page->buttonDemoLink()->isNotEmpty()))): ?>
                <ul class="list <?php if ($product && $page->parent()->postHeroColumns()->value() === '2'): ?>list-style-none<?php else: ?>list-inline <?php if ($product): ?>list--md<?php else: ?>list--sm<?php endif ?><?php endif ?>">

                  <?php foreach ($buttons as $button): ?>

                    <?php if ($button->link()->value() === 'page' && $button->page()->isNotEmpty() && $button->page()->toPage()): ?>
                      <li class="<?php if ($product && $page->parent()->postHeroColumns()->value() === '2'): ?>full-width<?php else: ?><?php if ($product): ?>full-width--md<?php else: ?>full-width--sm<?php endif ?><?php endif ?> space-top-1x"><a href="<?= $button->page()->toPage()->url() ?>" class="button <?php if ($page->soldOut()->bool()): ?>button-style-disabled<?php else: ?>button-style-<?= $button->style() ?><?php endif ?> full-width" role="button"><?= $button->text() ?></a></li>
                    <?php elseif ($button->link()->value() === 'url' && $button->url()->isNotEmpty()): ?>
                      <li class="<?php if ($product && $page->parent()->postHeroColumns()->value() === '2'): ?>full-width<?php else: ?><?php if ($product): ?>full-width--md<?php else: ?>full-width--sm<?php endif ?><?php endif ?> space-top-1x"><a href="<?= $button->url() ?>" class="button <?php if ($page->soldOut()->bool()): ?>button-style-disabled<?php else: ?>button-style-<?= $button->style() ?><?php endif ?> full-width" role="button"<?php if ($button->target()->bool()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>><?= $button->text() ?><?php if ($button->target()->bool()): ?><span class="icon-external-link"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="24" viewBox="0 0 16 16"><path d="M14 14H2V2h5V0H2a2 2 0 00-2 2v12a2 2 0 002 2h12c1.1 0 2-.9 2-2V9h-2v5zM9 0v2h3.59L4.76 9.83l1.41 1.41L14 3.41V7h2V0H9z" fill="currentColor"></path></svg></span><?php endif ?></a></li>
                    <?php endif ?>

                  <?php endforeach ?>

                  <?php if ($page->comingSoon()->bool()): ?>
                    <li class="<?php if ($page->parent()->postHeroColumns()->value() === '2'): ?>full-width<?php else: ?>full-width--md<?php endif ?>"><a class="button button-style-disabled full-width space-top-1x" role="button"><?php if ($page->comingSoonText()->isNotEmpty()): ?><?= $page->comingSoonText() ?><?php elseif ($page->parent()->comingSoonText()->isNotEmpty()): ?><?= $page->parent()->comingSoonText() ?><?php else: ?>Coming Soon<?php endif ?></a></li>
                  <?php elseif ($page->buttonPurchaseType()->value() === 'url' && $page->buttonPurchaseLink()->isNotEmpty()): ?>
                    <li class="<?php if ($page->parent()->postHeroColumns()->value() === '2'): ?>full-width<?php else: ?>full-width--md<?php endif ?>"><a href="<?= $page->buttonPurchaseLink() ?>" class="button button-style-<?= $page->parent()->postButtonPurchaseStyle() ?> full-width space-top-1x" role="button"><?= $page->parent()->postButtonPurchaseText()->or('Purchase') ?></a></li>
                  <?php elseif ($page->buttonPurchaseType()->value() === 'code' && $page->buttonPurchaseCode()->isNotEmpty()): ?>
                    <li class="<?php if ($page->parent()->postHeroColumns()->value() === '2'): ?>full-width<?php else: ?>full-width--md<?php endif ?>"><div class="position-relative space-top-1x"><?= $page->buttonPurchaseCode() ?></div></li>
                  <?php endif ?>

                  <?php if ($page->buttonDemoLink()->isNotEmpty()): ?>
                    <li class="<?php if ($page->parent()->postHeroColumns()->value() === '2'): ?>full-width<?php else: ?>full-width--md<?php endif ?>"><a href="<?= $page->buttonDemoLink() ?>" class="button button-style-<?= $page->parent()->postButtonDemoStyle() ?> full-width space-top-1x" role="button" target="_blank" rel="noopener noreferrer"><?= $page->parent()->postButtonDemoText()->or('View Demo') ?><span class="icon-external-link"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="24" viewBox="0 0 16 16"><path d="M14 14H2V2h5V0H2a2 2 0 00-2 2v12a2 2 0 002 2h12c1.1 0 2-.9 2-2V9h-2v5zM9 0v2h3.59L4.76 9.83l1.41 1.41L14 3.41V7h2V0H9z" fill="currentColor"></path></svg></span></a></li>
                  <?php endif ?>

                </ul>
              <?php endif ?>

            </div>

            <?php if ($page->heroColumns()->value() === '1' && $page->heroBlocks()->toBlocks()->first()): ?>

              <?php snippet('blocks', ['heroBlocks' => $heroBlocks, 'page' => $page->heroBlocks()]) ?>

            <?php elseif ($product && $page->parent()->postHeroColumns()->value() === '1' && $page->sliderMedia()->isEmpty() && $cover): ?>

              <?php

                // Classes

                $class = 'full-width';

                if ($page->parent()->postHeroMediaBorder()->bool()) {
                  $class = $class . ' border border-img';
                }

                if ($page->parent()->postHeroMediaRounded()->bool()) {
                  $class = $class . ' rounded';
                }

                if ($page->parent()->postHeroMediaShadow()->value() !== 'none') {
                  $class = $class . ' shadow-' . $page->parent()->postHeroMediaShadow();
                }

              ?>
              <img class="<?= $class ?>" loading="lazy" src="<?= $cover->url() ?>"<?php if ($cover->extension() !== 'svg'): ?> srcset="<?= $cover->srcset() ?>"<?php endif ?> width="<?= $cover->width() ?>" height="<?= $cover->height() ?>" alt="<?= $cover->alt() ?>">

            <?php endif ?>

        <?php if ($page->heroColumns()->value() === '2' || ($product && $page->parent()->postHeroColumns()->value() === '2')): ?>
          </div>
        <?php endif ?>

        <?php if (($page->heroColumns()->value() === '2' && $page->heroBlocks()->toBlocks()->first()) || ($product && $page->parent()->postHeroColumns()->value() === '2' && $cover)): ?>

          <?php

            // Classes

            if ($page->heroColumnWidth()->value() === 'equal' || ($product && $page->parent()->postHeroColumnWidth()->value() === 'equal')) {
              $class = 'col-1-2';
            } elseif ($page->heroColumnWidth()->value() === 'right' || ($product && $page->parent()->postHeroColumnWidth()->value() === 'right')) {
              $class = 'col-3-5';
            } elseif ($page->heroColumnWidth()->value() === 'left' || ($product && $page->parent()->postHeroColumnWidth()->value() === 'left')) {
              $class = 'col-2-5';
            }

            $class = $class . ' align-middle space-top-none--md';

          ?>
          <div class="<?= $class ?>">

            <?php if ($product): ?>

              <?php

                // Classes

                $class = 'full-width';

                if ($page->parent()->postHeroMediaBorder()->bool()) {
                  $class = $class . ' border border-img';
                }

                if ($page->parent()->postHeroMediaRounded()->bool()) {
                  $class = $class . ' rounded';
                }

                if ($page->parent()->postHeroMediaShadow()->value() !== 'none') {
                  $class = $class . ' shadow-' . $page->parent()->postHeroMediaShadow();
                }

              ?>
              <img class="<?= $class ?>" loading="lazy" src="<?= $cover->url() ?>"<?php if ($cover->extension() !== 'svg'): ?> srcset="<?= $cover->srcset('half') ?>"<?php endif ?> width="<?= $cover->width() ?>" height="<?= $cover->height() ?>" alt="<?= $cover->alt() ?>">
            <?php else: ?>

              <?php snippet('blocks', ['heroBlocks' => $heroBlocks, 'srcsetHalf' => $srcsetHalf, 'page' => $page->heroBlocks()]) ?>

            <?php endif ?>

          </div>
        <?php endif ?>

      </div>
    </section>

<?php if ($backgroundHero && $backgroundHeroClass && $backgroundHero->size()->value() === 'lg'): ?>
  </div>
<?php endif ?>
