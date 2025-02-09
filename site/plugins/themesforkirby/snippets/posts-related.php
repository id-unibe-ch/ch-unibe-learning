<?php

  $backgroundRelated = $page->parent()->postRelatedBackground()->toStructure()->first();
  $related = '';

  if ($page->parent()->layout()->value() === 'box') {
    $posts = $page->parent()->children()->listed()->not($page)->shuffle()->limit($page->parent()->boxColumns()->value());
  } elseif ($page->parent()->layout()->value() === 'cards') {
    $posts = $page->parent()->children()->listed()->not($page)->shuffle()->limit($page->parent()->cardsColumns()->value());
  } elseif ($page->parent()->layout()->value() === 'grid') {
    $posts = $page->parent()->children()->listed()->not($page)->shuffle()->limit($page->parent()->gridColumns()->value());
  } else {
    $posts = $page->parent()->children()->listed()->not($page)->shuffle()->limit(2);
  }

  // Classes

  if ($backgroundRelated && background($backgroundRelated)) {
    $class = background($backgroundRelated) . ' padding';
  } else {
    $class = 'padding';
  }

  if ($backgroundRelated && $backgroundRelated->brightness()->bool()) {
    $class = $class . ' dark';
  }

?>
<section id="related" class="<?= $class ?>">

  <?php if ($page->parent()->postRelatedTitle()->isNotEmpty()): ?>
    <div class="row row-keep-proportions max-width-lg space-bottom-3x">
      <div class="col-2-3">
        <h3><?= $page->parent()->postRelatedTitle() ?></h3>
      </div>
      <div class="col-1-3 align-middle">
        <a href="<?= $page->parent()->url() ?>" class="align-right muted text-decoration-none"><?= $page->parent()->title() ?> ›</a>
      </div>
    </div>
  <?php endif ?>

  <div class="max-width-lg">

    <?php if ($page->parent()->layout()->value() === 'box'): ?>
      <?php snippet('posts-box', ['page' => $page->parent(), 'posts' => $posts, 'related' => $related]) ?>
    <?php elseif ($page->parent()->layout()->value() === 'cards'): ?>
      <?php snippet('posts-cards', ['page' => $page->parent(), 'posts' => $posts, 'related' => $related]) ?>
    <?php else: ?>
      <?php snippet('posts-grid', ['page' => $page->parent(), 'posts' => $posts, 'related' => $related]) ?>
    <?php endif ?>

  </div>
</section>
