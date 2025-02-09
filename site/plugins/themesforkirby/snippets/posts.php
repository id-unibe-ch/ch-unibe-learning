<?php

  $posts = $page->children()->listed();

  if (param('t')) {
    $posts = $posts->filterBy('tags', urldecode(param('t')), ',');
  }

  if ($page->postsPerPage()->isNotEmpty()) {
    $posts = $posts->paginate(postsPerPage($page->postsPerPage()));
  } else {
    $posts = $posts->paginate(postsPerPage($site));
  }

?>
<div class="max-width-lg">

  <?php if ($page->layout()->value() === 'list'): ?>
    <?php snippet('posts-list-' . $page->listStyle(), ['posts' => $posts]) ?>
  <?php elseif ($page->layout()->value() === 'box'): ?>
    <?php snippet('posts-box', ['posts' => $posts]) ?>
  <?php elseif ($page->layout()->value() === 'cards'): ?>
    <?php snippet('posts-cards', ['posts' => $posts]) ?>
  <?php else: ?>
    <?php snippet('posts-grid', ['posts' => $posts]) ?>
  <?php endif ?>

</div>

<?php if ($posts->pagination()->hasPages()): ?>
  <nav class="max-width-lg pagination space-top">

    <?php if ($posts->pagination()->hasPrevPage()): ?>
      <a href="<?= $posts->pagination()->prevPageURL() ?>" class="button button-style-secondary float-left">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16"><path d="M16 7H3.83l5.59-5.59L8 0 0 8l8 8 1.41-1.41L3.83 9H16z" fill="currentColor"></path></svg>
      </a>
    <?php endif ?>

    <?php if ($posts->pagination()->hasNextPage()): ?>
      <a href="<?= $posts->pagination()->nextPageURL() ?>" class="button button-style-secondary float-right">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16"><path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8z" fill="currentColor"></path></svg>
      </a>
    <?php endif ?>

  </nav>
<?php endif ?>
