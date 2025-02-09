<div class="max-width-<?= $page->width() ?>">

  <?php

    // Classes

    $class = 'full-width space-bottom-3x';

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

    <?php

      // Classes

      if ($posts->last()->is($post)) {
        $class = $class . ' space-bottom-none';
      }

    ?>
    <div class="<?= $class ?>">

      <?php if ($page->media()->bool() && $cover = $post->cover()->toFile()): ?>

        <?php if ($page->mediaFixedHeight()->bool() === false): ?>
          <a href="<?php if ($post->externalLink()->isNotEmpty()): ?><?= $post->externalLink() ?><?php else: ?><?= $post->url() ?><?php endif ?>" class="<?php if ($page->mediaBorder()->bool()): ?>border border-img <?php endif ?>full-width position-relative<?php if ($page->mediaRounded()->bool()): ?> rounded<?php endif ?><?php if ($page->mediaShadow()->value() !== 'none'): ?> shadow-<?= $page->mediaShadow() ?><?php endif ?> space-bottom-1x text-decoration-none"<?php if ($post->externalLink()->isNotEmpty()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>>
            <img class="full-width" loading="lazy" src="<?= $cover->url() ?>"<?php if ($cover->extension() !== 'svg'): ?> srcset="<?= $cover->srcset('half') ?>"<?php endif ?> width="<?= $cover->width() ?>" height="<?= $cover->height() ?>" alt="<?= $post->title() ?>">

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
        <?php else: ?>
          <a href="<?php if ($post->externalLink()->isNotEmpty()): ?><?= $post->externalLink() ?><?php else: ?><?= $post->url() ?><?php endif ?>" class="align-items-<?= $page->mediaPositionVertical() ?> <?php if ($page->mediaBorder()->bool()): ?>border border-img <?php endif ?>full-width max-height-sm position-relative<?php if ($page->mediaRounded()->bool()): ?> rounded<?php endif ?><?php if ($page->mediaShadow()->value() !== 'none'): ?> shadow-<?= $page->mediaShadow() ?><?php endif ?> space-bottom-1x text-decoration-none"<?php if ($post->externalLink()->isNotEmpty()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>>
            <img class="full-width object-position-<?= $page->mediaPositionHorizontal() ?>" loading="lazy" src="<?= $cover->url() ?>"<?php if ($cover->extension() !== 'svg'): ?> srcset="<?= $cover->srcset('half') ?>"<?php endif ?> width="<?= $cover->width() ?>" height="<?= $cover->height() ?>" alt="<?= $post->title() ?>">

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

      <?php endif ?>

      <a href="<?php if ($post->externalLink()->isNotEmpty()): ?><?= $post->externalLink() ?><?php else: ?><?= $post->url() ?><?php endif ?>" class="full-width text-decoration-none"<?php if ($post->externalLink()->isNotEmpty()): ?> target="_blank" rel="noopener noreferrer"<?php endif ?>><h2 class="title-h5"><?= $post->title() ?></h2></a>

      <?php if ($page->author()->bool() && $page->datePublished()->bool()): ?>
        <div class="space-top-025x"><span class="display-block font-size-md muted"><?= $post->date()->toDate(dateFormat($site)) ?> — <?php if ($author && $author->name()->isNotEmpty()): ?><?= $author->name() ?><?php else: ?><?= $site->title() ?><?php endif ?></span></div>
      <?php elseif ($page->author()->bool()): ?>
        <div class="space-top-025x"><span class="display-block font-size-md muted"><?php if ($author && $author->name()->isNotEmpty()): ?><?= $author->name() ?><?php else: ?><?= $site->title() ?><?php endif ?></span></div>
      <?php elseif ($page->datePublished()->bool()): ?>
        <div class="space-top-025x"><span class="display-block font-size-md muted"><?= $post->date()->toDate(dateFormat($site)) ?></span></div>
      <?php endif ?>

      <?php if ($post->text()->isNotEmpty()): ?>
        <p class="space-top-05x"><?= $post->text()->excerpt(160) ?></p>
      <?php elseif ($post->heroText()->isNotEmpty()): ?>
        <p class="space-top-05x"><?= $post->heroText()->excerpt(200) ?></p>
      <?php elseif ($blockFirst && $blockFirst->text()->isNotEmpty()): ?>
        <p class="space-top-05x"><?= $blockFirst->text()->excerpt(160) ?></p>
      <?php elseif ($featureFirst && $featureFirstBlockFirst && $featureFirstBlockFirst->text()->isNotEmpty()): ?>
        <p class="space-top-05x"><?= $featureFirstBlockFirst->text()->excerpt(160) ?></p>
      <?php endif ?>

    </div>

  <?php endforeach ?>

</div>
