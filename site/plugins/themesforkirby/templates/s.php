<?php

  $backgroundHeader = $site->headerBackground()->toStructure()->first();
  $backgroundPage = $page->background()->toStructure()->first();

  if ($site->postsPerPage()->isNotEmpty()) {
    $postsPerPage = $site->postsPerPage()->toInt();
  } else {
    $postsPerPage = 20;
  }

  $query   = get('q');
  $results = $site->search($query);
  $results = $results->paginate($postsPerPage);

?>
<?php snippet('header') ?>

  <?php

    // Page background class

    if ($backgroundPage) {
      $backgroundPageClass = background($backgroundPage);
    }

    // Classes

    if ($backgroundPage && $backgroundPageClass) {
      $class = $backgroundPageClass . ' page-' . $page->slug();
    } else {
      $class = 'page-' . $page->slug();
    }

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

    if ($backgroundPage && $backgroundPage->brightness()->bool()) {
      $class = $class . ' dark';
    }

  ?>
  <main class="<?= $class ?>">

    <?php if ($page->heroVisibility()->bool()): ?>
      <?php snippet('hero') ?>
    <?php endif ?>

    <?php if ($results->count()): ?>

      <?php

        // Classes

        if ($page->heroVisibility()->bool() === false) {
          $class = 'hero-none padding';
        } else {
          $class = 'padding';
        }

        if ($page->heroBackground()->isEmpty()) {
          $class = $class . ' padding-top-none';
        }

      ?>
      <section id="results" class="<?= $class ?>">
        <div class="max-width-lg">
          <div class="row row-fill-empty-columns row-gutter-lg">

            <?php foreach ($results as $result):

              $cover = $result->cover()->toFile();

            ?>

              <div class="col-1-2">

                <?php if ($cover): ?>
                  <div class="border border-img rounded space-bottom-1x">
                    <a href="<?= $result->url() ?>" class="bg-cover bg-cover-background height-sm" style="background-image: url(<?= $cover->resize(960)->url() ?>);">
                      <span><?= $result->title() ?></span>
                    </a>
                  </div>
                <?php else: ?>
                  <a href="<?= $result->url() ?>" class="bg-cover border border-img full-width height-sm rounded space-bottom-1x">
                    <span class="align-center-middle bg-color-light full-width">
                      <svg class="muted" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48" height="42" viewBox="0 0 16 14"><path d="M10 13a1 1 0 00-1-1H1a1 1 0 100 2h8a1 1 0 001-1zm6-8a1 1 0 00-1-1H1a1 1 0 100 2h14a1 1 0 001-1zM0 9a1 1 0 001 1h14a1 1 0 100-2H1a1 1 0 00-1 1zm1-9a1 1 0 100 2h14a1 1 0 100-2H1z" fill="currentColor"></path></svg>
                    </span>
                    <span><?= $result->title() ?></span>
                  </a>
                <?php endif ?>

                <span class="font-size-md muted"><?= $result->modified(dateFormat($site)) ?></span>
                <a href="<?= $result->url() ?>" class="full-width text-decoration-none"><h2 class="title-h4"><?php if ($result->heroHeading()->isNotEmpty()): ?><?= $result->heroHeading() ?><?php else: ?><?= $result->title() ?><?php endif ?></h2></a>
              </div>

            <?php endforeach ?>

          </div>

          <?php if ($results->pagination()->hasPages()): ?>
            <nav class="pagination space-top">

              <?php if ($results->pagination()->hasPrevPage()): ?>
                <a href="<?= $results->pagination()->prevPageURL() ?>" class="button button-style-secondary float-left">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16"><path d="M16 7H3.83l5.59-5.59L8 0 0 8l8 8 1.41-1.41L3.83 9H16z" fill="currentColor"></path></svg>
                </a>
              <?php endif ?>

              <?php if ($results->pagination()->hasNextPage()): ?>
                <a href="<?= $results->pagination()->nextPageURL() ?>" class="button button-style-secondary float-right">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16"><path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8z" fill="currentColor"></path></svg>
                </a>
              <?php endif ?>

            </nav>
          <?php endif ?>

        </div>
      </section>
    <?php else: ?>

      <?php if ($page->heroVisibility()->bool() === false): ?>
        <div class="hero-none">
      <?php endif ?>

          <?php snippet('empty') ?>

      <?php if ($page->heroVisibility()->bool() === false): ?>
        </div>
      <?php endif ?>

    <?php endif ?>

  </main>

<?php snippet('footer') ?>