<?php

  $backgroundHeader = $site->headerBackground()->toStructure()->first();
  $backgroundHero = $page->heroBackground()->toStructure()->first();
  $backgroundPage = $page->background()->toStructure()->first();

?>
<?php snippet('header') ?>

  <?php

    // Page background class

    if ($backgroundPage) {
      $backgroundPageClass = background($backgroundPage);
    }

    // Hero background class

    if ($backgroundHero) {
      $backgroundHeroClass = background($backgroundHero);
    }

    // Classes

    if ($backgroundPage && $backgroundPageClass) {
      $class = $backgroundPageClass . ' page-' . $page->slug() . ' products';
    } else {
      $class = 'page-' . $page->slug() . ' products';
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

    <?php if ($page->heroVisibility()->bool() || param('t')): ?>
      <?php snippet('hero') ?>
    <?php endif ?>

    <?php if ($page->blocks()->toBlocks()->first() && !param('t')): ?>

      <?php if ($page->heroVisibility()->bool() === false): ?>
        <div class="hero-none">
      <?php endif ?>

          <?php snippet('blocks', ['page' => $page->blocks()]) ?>

      <?php if ($page->heroVisibility()->bool() === false): ?>
        </div>
      <?php endif ?>

    <?php elseif ($page->hasListedChildren()): ?>

      <?php

        // Classes

        if ($page->heroVisibility()->bool() === false && !param('t')) {
          $class = 'hero-none padding';
        } else {
          $class = 'padding';
        }

        if ($page->heroVisibility()->bool() && !($backgroundHero && $backgroundHeroClass && $backgroundHeroClass !== 'bg-none') || ($page->heroVisibility()->bool() === false && param('t'))) {
          $class = $class . ' padding-top-none';
        }

      ?>
      <section id="products-<?= $page->slug() ?>" class="<?= $class ?>">

        <?php

          // Classes

          $class = 'align-' . $page->align() . ' products-' . $page->layout();

          if ($page->heroVisibility()->bool() === false && !param('t')) {
            $class = $class . ' space-hero space-top';
          }

        ?>
        <div class="<?= $class ?>">

          <?php snippet('posts') ?>

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