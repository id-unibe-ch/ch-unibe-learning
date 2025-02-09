<?php

Kirby::plugin('tfk/block-testimonial', [
  'blueprints' => [
    'blocks/testimonial' => __DIR__ . '/blueprints/testimonial.yml'
  ],
  'snippets' => [
    'blocks/testimonial' => __DIR__ . '/snippets/testimonial.php'
  ]
]);