<?php

  $backgroundFooter = $site->footerBackground()->toStructure()->first();
  $backgroundHero = $page->heroBackground()->toStructure()->first();

  if ($backgroundHero) {
    $backgroundHeroClass = background($backgroundHero);
  }

  // Classes

  $class = 'hero-lg padding';

  if (!($backgroundFooter && background($backgroundFooter)) && $site->footerPaddingTop()->bool()) {
    $class = $class . ' padding-bottom-none';
  }

  if (!($backgroundHero && $backgroundHeroClass && $backgroundHeroClass !== 'bg-none')) {
    $class = $class . ' padding-top-none';
  }

?>
<section class="<?= $class ?>">
  <div class="bg-color-light border max-width-lg padding rounded">

    <?php if ($site->find('error')->heroText()->isNotEmpty()): ?>
      <div class="align-center space-bottom space-top">
        <h1>:(</h1>
        <div class="paragraph"><?= $site->find('error')->heroText() ?></div>
      </div>
    <?php else: ?>
      <div class="overflow-auto space-bottom space-top">
        <span class="align-center-middle muted">
          <svg class="muted" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="36" height="36" viewBox="0 0 18 18"><path d="M16 0H1.99C.88 0 .01.89.01 2L0 16c0 1.1.88 2 1.99 2H16c1.1 0 2-.9 2-2V2a2 2 0 00-2-2zm0 12h-4c0 1.66-1.35 3-3 3s-3-1.34-3-3H1.99V2H16v10z" fill="currentColor"></path></svg>
        </span>
      </div>
    <?php endif ?>

  </div>
</section>
