<?php

  $backgroundHeader = $site->headerBackground()->toStructure()->first();
  $backgroundPage = $page->background()->toStructure()->first();

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

      <?php snippet('blocks', ['page' => $page->blocks()]) ?>

    <?php elseif ($page->blocks()->toBlocks()->first()): ?>
      <div class="hero-none">

        <?php snippet('blocks', ['page' => $page->blocks()]) ?>

      </div>
    <?php else: ?>
      <div class="hero-none">

        <?php snippet('empty') ?>

      </div>
    <?php endif ?>

  </main>

<?php snippet('footer') ?>