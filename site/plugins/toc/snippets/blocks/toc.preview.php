<?php
// Preview for ToC block in the panel
$title = $block->title()->or('Table of Contents');
$levels = $block->levels()->split() ?: ['h2', 'h3'];
$style = $block->style()->or('nested');
?>

<div style="border: 1px solid #ddd; border-radius: 6px; padding: 16px; background: #f8f9fa;">
  <div style="display: flex; align-items: center; margin-bottom: 12px;">
    <svg width="16" height="16" viewBox="0 0 16 16" style="margin-right: 8px;">
      <path fill="#666" d="M2 4h12v1H2V4zm0 3h12v1H2V7zm0 3h12v1H2v-1z"/>
    </svg>
    <strong><?= esc($title) ?></strong>
  </div>
  
  <div style="font-size: 14px; color: #666;">
    <div>Levels: <?= implode(', ', array_map('strtoupper', $levels)) ?></div>
    <div>Style: <?= ucfirst($style) ?></div>
  </div>
  
  <div style="margin-top: 12px; padding: 8px; background: white; border-radius: 4px; font-size: 13px; color: #888;">
    📋 Table of Contents will be generated from page headings
  </div>
</div>
