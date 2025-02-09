<?php if ($block->source()->isNotEmpty() && $block->source()->toPage()): ?>

  <?php

    if ($block->sort()->value() === 'date') {
      $posts = $site->find($block->source()->value())->children()->listed()->sortBy('date', 'desc');
    } elseif ($block->sort()->value() === 'random') {
      $posts = $site->find($block->source()->value())->children()->listed()->shuffle();
    } else {
      $posts = $site->find($block->source()->value())->children()->listed();
    }

    // If there are tags, compare arrays to filter the result

    if ($block->tags()->isNotEmpty()) {
      $posts = $posts->filterBy('tags', 'in', $block->tags()->split(','), ',');
    }

    $posts = $posts->limit(postsPerPage($block));

  ?>

  <?php if ($posts->count() === 0): ?>
    <div class="align-center-middle bg-color-light height-sm position-relative rounded">
      <svg class="muted" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="36" height="36" viewBox="0 0 18 18"><path d="M16 0H1.99C.88 0 .01.89.01 2L0 16c0 1.1.88 2 1.99 2H16c1.1 0 2-.9 2-2V2a2 2 0 00-2-2zm0 12h-4c0 1.66-1.35 3-3 3s-3-1.34-3-3H1.99V2H16v10z" fill="currentColor"></path></svg>
    </div>
  <?php elseif ($block->layout()->value() === 'list'): ?>
    <?php snippet('posts-list-' . $block->listStyle(), ['page' => $block, 'posts' => $posts]) ?>
  <?php elseif ($block->layout()->value() === 'box'): ?>
    <?php snippet('posts-box', ['page' => $block, 'posts' => $posts]) ?>
  <?php elseif ($block->layout()->value() === 'cards'): ?>
    <?php snippet('posts-cards', ['page' => $block, 'posts' => $posts]) ?>
  <?php else: ?>
    <?php snippet('posts-grid', ['page' => $block, 'posts' => $posts]) ?>
  <?php endif ?>

<?php else: ?>
  <div class="align-center-middle bg-color-light height-sm position-relative rounded">
    <svg class="muted" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="36" height="36" viewBox="0 0 18 18"><path d="M16 0H1.99C.88 0 .01.89.01 2L0 16c0 1.1.88 2 1.99 2H16c1.1 0 2-.9 2-2V2a2 2 0 00-2-2zm0 12h-4c0 1.66-1.35 3-3 3s-3-1.34-3-3H1.99V2H16v10z" fill="currentColor"></path></svg>
  </div>
<?php endif ?>
