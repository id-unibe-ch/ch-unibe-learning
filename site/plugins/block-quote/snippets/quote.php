<?php if ($block->text()->isNotEmpty()): ?>
  <figure class="blockquote">
    <blockquote>
      <?= $block->text() ?>
    </blockquote>

    <?php if ($block->caption()->isNotEmpty()): ?>
      <figcaption><?= $block->caption() ?></figcaption>
    <?php endif ?>

  </figure>
<?php endif ?>
