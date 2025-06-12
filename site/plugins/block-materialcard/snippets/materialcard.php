<?php
// Material 3 Card Block Snippet
$cardType = $block->cardType()->value() ?: 'elevated';
$elevation = $block->elevation()->value() ?: 'level1';
$hasImage = $block->hasImage()->bool();
$imagePosition = $block->imagePosition()->value() ?: 'top';
$hasActions = $block->hasActions()->bool();
$clickable = $block->clickable()->bool();

// Build CSS classes
$cardClasses = ['material-card', 'material-card--' . $cardType];
if ($cardType === 'elevated') {
    $cardClasses[] = 'material-card--' . $elevation;
}
if ($hasImage) {
    $cardClasses[] = 'material-card--with-image';
    $cardClasses[] = 'material-card--image-' . $imagePosition;
}
if ($clickable) {
    $cardClasses[] = 'material-card--clickable';
}

$cardClass = implode(' ', $cardClasses);
?>

<div class="<?= $cardClass ?>">
    <div class="material-card__content">
        <?php if ($block->headline()->isNotEmpty()): ?>
            <h3 class="material-card__headline"><?= $block->headline() ?></h3>
        <?php endif ?>

        <?php if ($block->subhead()->isNotEmpty()): ?>
            <p class="material-card__subhead"><?= $block->subhead() ?></p>
        <?php endif ?>

        <?php if ($block->bodyText()->isNotEmpty()): ?>
            <div class="material-card__body"><?= $block->bodyText() ?></div>
        <?php endif ?>
    </div>
</div>