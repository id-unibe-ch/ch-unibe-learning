.js-ready <?php if (isset($productSlider)): ?>.product #slider <?php else: ?><?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?><?php if (in_array($block->type(), ['gallery', 'image', 'imageurl', 'posts'])): ?> <?php endif ?><?php endif ?>.js-animation.js-a-type-custom {
<?php if ($animation->opacity()->bool()): ?>
  opacity: <?= $animation->opacityStart() ?>;
<?php endif ?>
<?php if ($animation->motion()->bool() || $animation->rotation()->bool() || $animation->scale()->bool()):

  // Transformation

  if ($animation->motion()->bool()) {
    $transformStart = 'translate(' . $animation->motionHorizontalStart() . '%, ' . $animation->motionVerticalStart() . '%)';
    $transformEnd = 'translate(' . $animation->motionHorizontalEnd() . '%, ' . $animation->motionVerticalEnd() . '%)';
    if ($animation->rotation()->bool()) {
      $transformStart = $transformStart . ' rotate(' . $animation->rotationStart() . 'deg)';
      $transformEnd = $transformEnd . ' rotate(' . $animation->rotationEnd() . 'deg)';
    }
    if ($animation->scale()->bool()) {
      $transformStart = $transformStart . ' scale(' . $animation->scaleStart() . ')';
      $transformEnd = $transformEnd . ' scale(' . $animation->scaleEnd() . ')';
    }
  } elseif ($animation->rotation()->bool()) {
    $transformStart = 'rotate(' . $animation->rotationStart() . 'deg)';
    $transformEnd = 'rotate(' . $animation->rotationEnd() . 'deg)';
    if ($animation->scale()->bool()) {
      $transformStart = $transformStart . ' scale(' . $animation->scaleStart() . ')';
      $transformEnd = $transformEnd . ' scale(' . $animation->scaleEnd() . ')';
    }
  } elseif ($animation->scale()->bool()) {
    $transformStart = 'scale(' . $animation->scaleStart() . ')';
    $transformEnd = 'scale(' . $animation->scaleEnd() . ')';
  }

?>
  -webkit-transform: <?= $transformStart ?>;
  -moz-transform: <?= $transformStart ?>;
  -ms-transform: <?= $transformStart ?>;
  -o-transform: <?= $transformStart ?>;
  transform: <?= $transformStart ?>;
<?php endif ?>
}
.js-ready <?php if (isset($productSlider)): ?>.product #slider <?php else: ?><?php if (isset($heroBlocks)): ?>.hero <?php endif ?>.block-<?php if (isset($numRow)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?><?php if (in_array($block->type(), ['gallery', 'image', 'imageurl', 'posts'])): ?> <?php endif ?><?php endif ?>.js-animation.js-a-type-custom.js-scrolled {
  -webkit-animation-duration: <?= $animation->duration() ?>s;
  -webkit-animation-fill-mode: both;
  -webkit-animation-name: <?php if (isset($productSlider)): ?>product-slider<?php else: ?><?php if (isset($heroBlocks)): ?>hero-<?php endif ?>block-<?php if (isset($numRow)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?><?php endif ?>;
  -webkit-animation-timing-function: ease-in-out;
  animation-duration: <?= $animation->duration() ?>s;
  animation-fill-mode: both;
  animation-name: <?php if (isset($productSlider)): ?>product-slider<?php else: ?><?php if (isset($heroBlocks)): ?>hero-<?php endif ?>block-<?php if (isset($numRow)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?><?php endif ?>;
  animation-timing-function: ease-in-out;
}
@keyframes <?php if (isset($productSlider)): ?>product-slider<?php else: ?><?php if (isset($heroBlocks)): ?>hero-<?php endif ?>block-<?php if (isset($numRow)): ?><?= $numRow ?>-<?= $numColumn ?>-<?php endif ?><?= $numBlock ?><?php endif ?> {
  0% {
<?php if ($animation->opacity()->bool()): ?>
    opacity: <?= $animation->opacityStart() ?>;
<?php else: ?>
    opacity: 0;
<?php endif ?>
<?php if ($animation->motion()->bool() || $animation->rotation()->bool() || $animation->scale()->bool()): ?>
    -webkit-transform: <?= $transformStart ?>;
    -moz-transform: <?= $transformStart ?>;
    -ms-transform: <?= $transformStart ?>;
    -o-transform: <?= $transformStart ?>;
    transform: <?= $transformStart ?>;
<?php endif ?>
  }
  100% {
<?php if ($animation->opacity()->bool()): ?>
    opacity: <?= $animation->opacityEnd() ?>;
<?php else: ?>
    opacity: 1;
<?php endif ?>
<?php if ($animation->motion()->bool() || $animation->rotation()->bool() || $animation->scale()->bool()): ?>
    -webkit-transform: <?= $transformEnd ?>;
    -moz-transform: <?= $transformEnd ?>;
    -ms-transform: <?= $transformEnd ?>;
    -o-transform: <?= $transformEnd ?>;
    transform: <?= $transformEnd ?>;
<?php endif ?>
  }
}
