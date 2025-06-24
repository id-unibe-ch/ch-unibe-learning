<?php
/**
 * Helper snippet to load ToC block assets
 * Include this in your header or footer template
 */

// Check if we have any ToC blocks on the current page
$hasTocBlocks = false;

if (isset($page) && $page->text()->isNotEmpty()) {
    $blocks = $page->text()->toBlocks();
    foreach ($blocks as $block) {
        if ($block->type() === 'toc') {
            $hasTocBlocks = true;
            break;
        }
    }
}

// Load assets only if needed
if ($hasTocBlocks): ?>
    <link rel="stylesheet" href="<?= url('media/plugins/unibe/toc/css/toc-block.css') ?>">
    <script src="<?= url('media/plugins/unibe/toc/js/toc-block.js') ?>" defer></script>
<?php endif; ?>
