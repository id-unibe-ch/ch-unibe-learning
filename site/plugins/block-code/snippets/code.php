<?php if ($block->text()->isNotEmpty()): ?>
  <pre><code><?= $block->text()->html() ?></code></pre>
<?php endif ?>
