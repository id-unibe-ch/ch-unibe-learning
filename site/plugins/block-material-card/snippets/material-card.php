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

<?php if ($clickable && $block->cardLink()->isNotEmpty()): ?>
<a href="<?= $block->cardLink() ?>" class="<?= $cardClass ?>" role="button">
<?php else: ?>
<div class="<?= $cardClass ?>">
<?php endif ?>

    <?php if ($hasImage && $block->image()->isNotEmpty() && ($image = $block->image()->toFile())): ?>
        <div class="material-card__media material-card__media--<?= $imagePosition ?>">
            <img 
                src="<?= $image->resize(400)->url() ?>" 
                <?php if ($image->extension() !== 'svg'): ?>
                srcset="<?= $image->srcset([400 => '1x', 800 => '2x']) ?>"
                <?php endif ?>
                alt="<?= $block->headline()->or($image->alt()) ?>"
                loading="lazy"
                class="material-card__image"
            >
        </div>
    <?php endif ?>

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

    <?php if ($hasActions && ($block->primaryAction()->isNotEmpty() || $block->secondaryAction()->isNotEmpty())): ?>
        <div class="material-card__actions">
            <?php if ($block->secondaryAction()->isNotEmpty() && $block->secondaryActionLink()->isNotEmpty()): ?>
                <a href="<?= $block->secondaryActionLink() ?>" class="material-card__action material-card__action--secondary">
                    <?= $block->secondaryAction() ?>
                </a>
            <?php endif ?>
            
            <?php if ($block->primaryAction()->isNotEmpty() && $block->primaryActionLink()->isNotEmpty()): ?>
                <a href="<?= $block->primaryActionLink() ?>" class="material-card__action material-card__action--primary">
                    <?= $block->primaryAction() ?>
                </a>
            <?php endif ?>
        </div>
    <?php endif ?>

<?php if ($clickable && $block->cardLink()->isNotEmpty()): ?>
</a>
<?php else: ?>
</div>
<?php endif ?>
