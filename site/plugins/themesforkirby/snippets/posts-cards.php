<div class="row row-fill-empty-columns<?php if (!isset($related)): ?> max-width-<?= $page->width() ?><?php endif ?>">

  <?php

    // Classes

    $class = 'col-1-' . $page->cardsColumns() . ' bg-color-white border card card-content';

    if ($page->readMore()->bool()) {
      $class = $class . ' read-more';
    }

    if ($animation = $page->animation()->toStructure()->first()) {
      $class = $class . ' js-animation js-a-type-' . $animation->type() . ' js-scrolled';
    }

  ?>
  <?php foreach ($posts as $post):

    $author = $post->author()->toUser();
    $blockFirst = $post->blocks()->toBlocks()->first();
    $featureFirst = $post->features()->toStructure()->first();

    if ($featureFirst) {
      $featureFirstBlockFirst = $featureFirst->blocks()->toBlocks()->first();
    }

  ?>
    <div class="<?= $class ?>">

      <?php if ($page->media()->bool() && $cover = $post->cover()->toFile()): ?>

        <?php if ($page->mediaFixedHeight()->bool() === false): ?>
          <div class="<?php if ($page->mediaBorder()->bool()): ?>border <?php endif ?>full-width<?php if ($page->mediaRounded()->bool()): ?> rounded<?php endif ?><?php if ($page->mediaShadow()->value() !== 'none'): ?> shadow-<?= $page->mediaShadow() ?><?php endif ?> space-bottom-15x">
            <a href="<?php if ($post->externalLink()->isNotEmpty()): ?><?= $post->externalLink() ?><?php else: ?><?= $post->url() ?><?php endif ?>" class="full-width position-relative text-decoration-none"<?php if ($post->externalLink()->isNotEmpty()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>>
              <img class="full-width" loading="lazy" src="<?= $cover->resize(720)->url() ?>"<?php if ($cover->extension() !== 'svg'): ?> srcset="<?= $cover->srcset('thumb') ?>"<?php endif ?> width="<?= $cover->width() ?>" height="<?= $cover->height() ?>" alt="<?= $post->title() ?>">

              <?php if ($post->comingSoon()->bool()): ?>
                <span class="align-center align-top-left bg-color-yellow<?php if ($page->mediaBorder()->bool()): ?> border-bottom<?php endif ?> font-size-sm font-weight-bold full-width label label-coming-soon padding-05x shadow-md"><?php if ($post->comingSoonText()->isNotEmpty()): ?><?= $post->comingSoonText() ?><?php elseif ($page->comingSoonText()->isNotEmpty()): ?><?= $page->comingSoonText() ?><?php elseif ($page->source()->isNotEmpty() && $page->source()->toPage() && $site->find($page->source()->value())->comingSoonText()->isNotEmpty()): ?><?= $site->find($page->source()->value())->comingSoonText() ?><?php else: ?>Coming Soon<?php endif ?></span>
              <?php endif ?>

              <?php if ($page->price()->bool() && $post->price()->isNotEmpty()): ?>
                <div class="align-bottom-left position-absolute space-bottom-1x space-left-1x tag tag-size-md tag-style-price">
                  <span><?= $site->currencySymbol()->or('$') ?><?= $post->price() ?></span>

                  <?php if ($post->priceDetails()->isNotEmpty()): ?>
                    <span class="font-size-sm muted"> <?= $post->priceDetails() ?></span>
                  <?php endif ?>

                </div>
              <?php endif ?>

              <?php if ($post->soldOut()->bool()): ?>
                <div class="align-bottom-right font-regular label label-sold-out position-absolute space-bottom-1x space-right-1x tag tag-size-md tag-style-new"><?php if ($page->soldOutText()->isNotEmpty()): ?><?= $page->soldOutText() ?><?php elseif ($page->source()->isNotEmpty() && $page->source()->toPage() && $site->find($page->source()->value())->soldOutText()->isNotEmpty()): ?><?= $site->find($page->source()->value())->soldOutText() ?><?php else: ?>Sold Out<?php endif ?></div>
              <?php endif ?>

            </a>
          </div>
        <?php else: ?>
          <div class="<?php if ($page->mediaBorder()->bool()): ?>border <?php endif ?>full-width<?php if ($page->mediaRounded()->bool()): ?> rounded<?php endif ?><?php if ($page->mediaShadow()->value() !== 'none'): ?> shadow-<?= $page->mediaShadow() ?><?php endif ?> space-bottom-15x">
            <a href="<?php if ($post->externalLink()->isNotEmpty()): ?><?= $post->externalLink() ?><?php else: ?><?= $post->url() ?><?php endif ?>" class="bg-cover bg-cover-background bg-cover-center full-width height-sm position-relative text-decoration-none" style="background-image: url(<?= $cover->resize(960)->url() ?>); background-position: <?= $page->mediaPositionHorizontal()->value() ?> <?= $page->mediaPositionVertical()->value() ?>;"<?php if ($post->externalLink()->isNotEmpty()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>>
              <span><?= $post->title() ?></span>

              <?php if ($post->comingSoon()->bool()): ?>
                <span class="align-center align-top-left bg-color-yellow<?php if ($page->mediaBorder()->bool()): ?> border-bottom<?php endif ?> font-size-sm font-weight-bold full-width label label-coming-soon padding-05x shadow-md"><?php if ($post->comingSoonText()->isNotEmpty()): ?><?= $post->comingSoonText() ?><?php elseif ($page->comingSoonText()->isNotEmpty()): ?><?= $page->comingSoonText() ?><?php elseif ($page->source()->isNotEmpty() && $page->source()->toPage() && $site->find($page->source()->value())->comingSoonText()->isNotEmpty()): ?><?= $site->find($page->source()->value())->comingSoonText() ?><?php else: ?>Coming Soon<?php endif ?></span>
              <?php endif ?>

              <?php if ($page->price()->bool() && $post->price()->isNotEmpty()): ?>
                <div class="align-bottom-left position-absolute space-bottom-1x space-left-1x tag tag-size-md tag-style-price">
                  <span><?= $site->currencySymbol()->or('$') ?><?= $post->price() ?></span>

                  <?php if ($post->priceDetails()->isNotEmpty()): ?>
                    <span class="font-size-sm muted"> <?= $post->priceDetails() ?></span>
                  <?php endif ?>

                </div>
              <?php endif ?>

              <?php if ($post->soldOut()->bool()): ?>
                <div class="align-bottom-right font-regular label label-sold-out position-absolute space-bottom-1x space-right-1x tag tag-size-md tag-style-new"><?php if ($page->soldOutText()->isNotEmpty()): ?><?= $page->soldOutText() ?><?php elseif ($page->source()->isNotEmpty() && $page->source()->toPage() && $site->find($page->source()->value())->soldOutText()->isNotEmpty()): ?><?= $site->find($page->source()->value())->soldOutText() ?><?php else: ?>Sold Out<?php endif ?></div>
              <?php endif ?>

            </a>
          </div>
        <?php endif ?>

      <?php elseif ($page->media()->bool()): ?>
        <a href="<?php if ($post->externalLink()->isNotEmpty()): ?><?= $post->externalLink() ?><?php else: ?><?= $post->url() ?><?php endif ?>" class="bg-cover <?php if ($page->mediaBorder()->bool()): ?>border <?php endif ?>full-width height-sm position-relative<?php if ($page->mediaRounded()->bool()): ?> rounded<?php endif ?><?php if ($page->mediaShadow()->value() !== 'none'): ?> shadow-<?= $page->mediaShadow() ?><?php endif ?> space-bottom-15x text-decoration-none"<?php if ($post->externalLink()->isNotEmpty()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>>
          <span class="align-center-middle bg-color-light full-width">
            <svg class="muted" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48" height="42" viewBox="0 0 16 14"><path d="M10 13a1 1 0 00-1-1H1a1 1 0 100 2h8a1 1 0 001-1zm6-8a1 1 0 00-1-1H1a1 1 0 100 2h14a1 1 0 001-1zM0 9a1 1 0 001 1h14a1 1 0 100-2H1a1 1 0 00-1 1zm1-9a1 1 0 100 2h14a1 1 0 100-2H1z" fill="currentColor"></path></svg>
          </span>
          <span><?= $post->title() ?></span>

          <?php if ($post->comingSoon()->bool()): ?>
            <span class="align-center align-top-left bg-color-yellow<?php if ($page->mediaBorder()->bool()): ?> border-bottom<?php endif ?> font-size-sm font-weight-bold full-width label label-coming-soon padding-05x shadow-md"><?php if ($post->comingSoonText()->isNotEmpty()): ?><?= $post->comingSoonText() ?><?php elseif ($page->comingSoonText()->isNotEmpty()): ?><?= $page->comingSoonText() ?><?php elseif ($page->source()->isNotEmpty() && $page->source()->toPage() && $site->find($page->source()->value())->comingSoonText()->isNotEmpty()): ?><?= $site->find($page->source()->value())->comingSoonText() ?><?php else: ?>Coming Soon<?php endif ?></span>
          <?php endif ?>

          <?php if ($page->price()->bool() && $post->price()->isNotEmpty()): ?>
            <div class="align-bottom-left position-absolute space-bottom-1x space-left-1x tag tag-size-md tag-style-price">
              <span><?= $site->currencySymbol()->or('$') ?><?= $post->price() ?></span>

              <?php if ($post->priceDetails()->isNotEmpty()): ?>
                <span class="font-size-sm muted"> <?= $post->priceDetails() ?></span>
              <?php endif ?>

            </div>
          <?php endif ?>

          <?php if ($post->soldOut()->bool()): ?>
            <div class="align-bottom-right font-regular label label-sold-out position-absolute space-bottom-1x space-right-1x tag tag-size-md tag-style-new"><?php if ($page->soldOutText()->isNotEmpty()): ?><?= $page->soldOutText() ?><?php elseif ($page->source()->isNotEmpty() && $page->source()->toPage() && $site->find($page->source()->value())->soldOutText()->isNotEmpty()): ?><?= $site->find($page->source()->value())->soldOutText() ?><?php else: ?>Sold Out<?php endif ?></div>
          <?php endif ?>

        </a>
      <?php endif ?>

      <?php if ($page->author()->bool() && $page->datePublished()->bool()): ?>
        <span class="display-block font-size-md muted"><?= $post->date()->toDate(dateFormat($site)) ?> — <?php if ($author && $author->name()->isNotEmpty()): ?><?= $author->name() ?><?php else: ?><?= $site->title() ?><?php endif ?></span>
      <?php elseif ($page->author()->bool()): ?>
        <span class="display-block font-size-md muted"><?php if ($author && $author->name()->isNotEmpty()): ?><?= $author->name() ?><?php else: ?><?= $site->title() ?><?php endif ?></span>
      <?php elseif ($page->datePublished()->bool()): ?>
        <span class="display-block font-size-md muted"><?= $post->date()->toDate(dateFormat($site)) ?></span>
      <?php endif ?>

      <a href="<?php if ($post->externalLink()->isNotEmpty()): ?><?= $post->externalLink() ?><?php else: ?><?= $post->url() ?><?php endif ?>" class="full-width<?php if ($post->text()->isEmpty() && $post->heroText()->isEmpty() && (!$blockFirst || ($blockFirst && $blockFirst->text()->isEmpty())) && $page->readMore()->bool()): ?> space-bottom-15x<?php endif ?><?php if ($page->author()->bool() || $page->datePublished()->bool()): ?> space-top-05x<?php endif ?> text-decoration-none"<?php if ($post->externalLink()->isNotEmpty()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>><h2 class="title-h4"><?= $post->title() ?></h2></a>

      <?php if ($post->text()->isNotEmpty()): ?>
        <p class="paragraph space-top-05x<?php if ($page->readMore()->bool()): ?> space-bottom-15x<?php endif ?>"><?php if ($page->gridColumns()->value() === '3'): ?><?= $post->text()->excerpt(80) ?><?php else: ?><?= $post->text()->excerpt(160) ?><?php endif ?></p>
      <?php elseif ($post->heroText()->isNotEmpty()): ?>
        <p class="paragraph space-top-05x<?php if ($page->readMore()->bool()): ?> space-bottom-15x<?php endif ?>"><?php if ($page->gridColumns()->value() === '3'): ?><?= $post->heroText()->excerpt(80) ?><?php else: ?><?= $post->heroText()->excerpt(160) ?><?php endif ?></p>
      <?php elseif ($blockFirst && $blockFirst->text()->isNotEmpty()): ?>
        <p class="paragraph space-top-05x<?php if ($page->readMore()->bool()): ?> space-bottom-15x<?php endif ?>"><?php if ($page->gridColumns()->value() === '3'): ?><?= $blockFirst->text()->excerpt(80) ?><?php else: ?><?= $blockFirst->text()->excerpt(160) ?><?php endif ?></p>
      <?php elseif ($featureFirst && $featureFirstBlockFirst && $featureFirstBlockFirst->text()->isNotEmpty()): ?>
        <p class="paragraph space-top-05x<?php if ($page->readMore()->bool()): ?> space-bottom-15x<?php endif ?>"><?php if ($page->gridColumns()->value() === '3'): ?><?= $featureFirstBlockFirst->text()->excerpt(80) ?><?php else: ?><?= $featureFirstBlockFirst->text()->excerpt(160) ?><?php endif ?></p>
      <?php endif ?>

      <?php if ($page->readMore()->bool()): ?>
        <a href="<?php if ($post->externalLink()->isNotEmpty()): ?><?= $post->externalLink() ?><?php else: ?><?= $post->url() ?><?php endif ?>" class="button button-style-tertiary full-width"<?php if ($post->externalLink()->isNotEmpty()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>><?php if ($page->readMoreText()->isNotEmpty()): ?><?= $page->readMoreText() ?><?php elseif ($page->source()->isNotEmpty() && $page->source()->toPage() && $site->find($page->source()->value())->readMoreText()->isNotEmpty()): ?><?= $site->find($page->source()->value())->readMoreText() ?><?php else: ?>Read More<?php endif ?></a>
      <?php endif ?>

    </div>

  <?php endforeach ?>

</div>
