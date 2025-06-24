<?php
/**
 * Table of Contents Block
 * Generates a ToC based on anchors created by the ToC plugin
 */

// Get block configuration
$title = $block->title()->value();
$levels = $block->levels()->split() ?: ['h2', 'h3'];
$style = $block->style()->or('nested');
$collapsed = $block->collapsed()->toBool();

// Get the current page content
$pageContent = $page->text()->kirbytext();

// Extract headings with anchors
$headings = [];
$headlinePattern = implode('|', $levels);

preg_match_all('!<(' . $headlinePattern . ')\s+id="([^"]+)"[^>]*><a href="#[^"]+">([^<]+)</a></\\1>!', $pageContent, $matches, PREG_SET_ORDER);

foreach ($matches as $match) {
    $level = $match[1]; // h2, h3, etc.
    $id = $match[2];    // the anchor id
    $text = $match[3];  // the heading text
    
    $headings[] = [
        'level' => $level,
        'id' => $id,
        'text' => trim($text),
        'level_num' => (int) substr($level, 1) // Convert h2 to 2, h3 to 3, etc.
    ];
}

// Only render if we have headings
if (empty($headings)): ?>
    <div class="toc-block toc-empty">
        <p><em>No headings found on this page.</em></p>
    </div>
<?php return; endif; ?>

<div class="toc-block toc-style-<?= $style ?><?= $collapsed ? ' toc-collapsed' : '' ?>" data-toc-style="<?= $style ?>">
    <?php if ($title): ?>
        <h3 class="toc-title">
            <?= esc($title) ?>
            <?php if ($collapsed): ?>
                <button class="toc-toggle" aria-expanded="false" aria-controls="toc-content">
                    <span class="toc-toggle-icon">▼</span>
                </button>
            <?php endif ?>
        </h3>
    <?php endif ?>
    
    <div class="toc-content" id="toc-content"<?= $collapsed ? ' style="display: none;"' : '' ?>>
        <?php if ($style === 'nested'): ?>
            <?= renderNestedToc($headings) ?>
        <?php elseif ($style === 'numbered'): ?>
            <?= renderNumberedToc($headings) ?>
        <?php else: ?>
            <?= renderFlatToc($headings) ?>
        <?php endif ?>
    </div>
</div>

<?php
/**
 * Render nested ToC as nested lists
 */
function renderNestedToc($headings) {
    if (empty($headings)) return '';
    
    $html = '<ul class="toc-list toc-nested">';
    $stack = []; // Keep track of nesting levels
    
    foreach ($headings as $heading) {
        $level = $heading['level_num'];
        
        // Close lists if we're going to a higher level
        while (!empty($stack) && end($stack) > $level) {
            $html .= '</ul></li>';
            array_pop($stack);
        }
        
        // Open new nested list if needed
        if (empty($stack) || end($stack) < $level) {
            if (!empty($stack)) {
                $html .= '<ul class="toc-sublist">';
            }
            $stack[] = $level;
        }
        
        $html .= '<li class="toc-item toc-level-' . $heading['level'] . '">';
        $html .= '<a href="#' . esc($heading['id']) . '" class="toc-link">';
        $html .= esc($heading['text']);
        $html .= '</a>';
        
        // Check if next item is at same level to close this item
        $nextKey = array_search($heading, $headings) + 1;
        if (!isset($headings[$nextKey]) || $headings[$nextKey]['level_num'] <= $level) {
            $html .= '</li>';
        }
    }
    
    // Close remaining open lists
    while (!empty($stack)) {
        $html .= '</ul></li>';
        array_pop($stack);
    }
    
    $html .= '</ul>';
    return $html;
}

/**
 * Render flat ToC as simple list
 */
function renderFlatToc($headings) {
    $html = '<ul class="toc-list toc-flat">';
    
    foreach ($headings as $heading) {
        $html .= '<li class="toc-item toc-level-' . $heading['level'] . '">';
        $html .= '<a href="#' . esc($heading['id']) . '" class="toc-link">';
        $html .= esc($heading['text']);
        $html .= '</a>';
        $html .= '</li>';
    }
    
    $html .= '</ul>';
    return $html;
}

/**
 * Render numbered ToC
 */
function renderNumberedToc($headings) {
    $html = '<ol class="toc-list toc-numbered">';
    
    foreach ($headings as $heading) {
        $html .= '<li class="toc-item toc-level-' . $heading['level'] . '">';
        $html .= '<a href="#' . esc($heading['id']) . '" class="toc-link">';
        $html .= esc($heading['text']);
        $html .= '</a>';
        $html .= '</li>';
    }
    
    $html .= '</ol>';
    return $html;
}
?>
