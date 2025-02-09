<?php

  $heroBlocks = '';
  $productSlider = '';

?>
<style>
.preload a,.preload .header-main .header-controls label.switch:after,.preload .header-main .header-controls label.switch:before,.preload label.switch:after,.preload label.switch:before,.transition-none *,.transition-none :after,.transition-none :before{-webkit-transition:none!important;-moz-transition:none!important;-ms-transition:none!important;-o-transition:none!important;transition:none!important}
.js-not-ready .js-animation{-webkit-animation:none!important;animation:none!important}
.js-animation.js-loading{-webkit-animation-play-state:paused!important;animation-play-state:paused!important}
<?php

  // Page style

?>
<?php snippet('header-style-page') ?>
<?php

  // Hero style

?>
<?php snippet('header-style-hero') ?>
<?php snippet('header-style-layout', ['heroBlocks' => $heroBlocks, 'page' => $page->heroBlocks()]) ?>
<?php

  // Layout and blocks style

?>
<?php if ($page->template() == 'post'): ?>
<?php snippet('header-style-blocks-post') ?>
<?php elseif ($page->template() == 'product'): ?>
<?php snippet('header-style-blocks-product') ?>
<?php else: ?>
<?php snippet('header-style-layout', ['page' => $page->blocks()]) ?>
<?php endif ?>
<?php if ($page->parent() && $page->parent()->postWidth()->isNotEmpty()): ?>
.max-width-none {
  width: <?= $page->parent()->postWidth() ?>px;
}
<?php endif ?>
<?php

  // Product page

?>
<?php if ($page->template() == 'product'): ?>
<?php foreach ($page->features()->toStructure() as $feature): ?>
<?php snippet('header-style-layout', ['page' => $feature->blocks()]) ?>
<?php endforeach ?>
<?php if ($page->sliderMedia()->isNotEmpty()): ?>
<?php snippet('blocks-style/slider-style', ['height' => $page->parent()->postSliderHeight(), 'spanAcross' => $page->parent()->postSliderSpanAcross(), 'productSlider' => $productSlider]) ?>
<?php if ($animation = $page->parent()->postSliderAnimation()->toStructure()->first()): ?>
.js-ready .product #slider .js-animation.js-scrolled {
  -webkit-animation-delay: <?= $animation->delay() ?>s;
  animation-delay: <?= $animation->delay() ?>s;
}
<?php if ($animation->type()->value() === 'custom'): ?>
<?php snippet('header-style-animation-custom', ['animation' => $animation, 'productSlider' => $productSlider]) ?>
<?php endif ?>
<?php endif ?>
<?php endif ?>
<?php endif ?>
<?php

  // Related posts style

?>
<?php if ($page->parent() && $page->parent()->postRelated()->bool() && $page->parent()->children()->listed()->count() > 2): ?>
<?php snippet('header-style-related') ?>
<?php endif ?>
<?php

  // Custom CSS

?>
<?php if ($page->customCss()->isNotEmpty()): ?>
<?= $page->customCss() ?>
<?php endif ?>
<?php if ($page->parents()->count() && $page->parent()->customCss()->isNotEmpty()): ?>
<?= $page->parent()->customCss() ?>
<?php endif ?>
</style>
