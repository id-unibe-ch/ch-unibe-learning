<?php
// Project Block Snippet with Material Design Progress Indicators
$projectName = $block->projectName()->value();
$projectOwner = $block->projectOwner()->value();
$progress = $block->progress()->toInt();
$progressType = $block->progressType()->value() ?: 'linear';
$showPercentage = $block->showPercentage()->bool();
$description = $block->description()->value();
$status = $block->status()->value() ?: 'active';
$priority = $block->priority()->value() ?: 'medium';
$dueDate = $block->dueDate()->value();

// Ensure progress is within valid range
$progress = max(0, min(100, $progress));

// Status color mapping
$statusColors = [
    'planning' => '#6c757d',
    'active' => '#007bff',
    'onhold' => '#ffc107',
    'completed' => '#28a745',
    'cancelled' => '#dc3545'
];

$statusColor = $statusColors[$status] ?? '#007bff';

// Priority class mapping
$priorityClasses = [
    'low' => 'project-block--priority-low',
    'medium' => 'project-block--priority-medium',
    'high' => 'project-block--priority-high',
    'critical' => 'project-block--priority-critical'
];

$priorityClass = $priorityClasses[$priority] ?? 'project-block--priority-medium';
?>

<div class="project-block <?= $priorityClass ?>" data-status="<?= $status ?>">
    <div class="project-block__header">
        <div class="project-block__info">
            <h3 class="project-block__name"><?= esc($projectName) ?></h3>
            <p class="project-block__owner">Owner: <?= esc($projectOwner) ?></p>
            <?php if ($dueDate): ?>
                <p class="project-block__due-date">Due: <?= date('M j, Y', strtotime($dueDate)) ?></p>
            <?php endif ?>
        </div>
        <div class="project-block__status">
            <span class="project-block__status-badge project-block__status-badge--<?= $status ?>" style="background-color: <?= $statusColor ?>">
                <?= ucfirst($status) ?>
            </span>
        </div>
    </div>

    <?php if ($description): ?>
        <div class="project-block__description">
            <?= esc($description) ?>
        </div>
    <?php endif ?>

    <div class="project-block__progress">
        <div class="project-block__progress-header">
            <span class="project-block__progress-label">Progress</span>
            <?php if ($showPercentage): ?>
                <span class="project-block__progress-percentage"><?= $progress ?>%</span>
            <?php endif ?>
        </div>

        <?php if ($progressType === 'circular'): ?>
            <!-- Circular Progress Indicator -->
            <div class="progress-circular" role="progressbar" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                <svg class="progress-circular__svg" viewBox="0 0 48 48" aria-hidden="true">
                    <circle class="progress-circular__track" cx="24" cy="24" r="18" stroke-width="4"></circle>
                    <circle class="progress-circular__indicator" cx="24" cy="24" r="18" stroke-width="4"
                            style="stroke-dasharray: <?= 2 * pi() * 18 ?>; stroke-dashoffset: <?= 2 * pi() * 18 * (1 - $progress / 100) ?>; stroke: <?= $statusColor ?>"></circle>
                </svg>
                <?php if ($showPercentage): ?>
                    <span class="progress-circular__label"><?= $progress ?>%</span>
                <?php endif ?>
            </div>
        <?php else: ?>
            <!-- Linear Progress Indicator -->
            <div class="progress-linear" role="progressbar" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-linear__track">
                    <div class="progress-linear__indicator" style="transform: scaleX(<?= $progress / 100 ?>); background-color: <?= $statusColor ?>"></div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
