<?php

Kirby::plugin('tfk/block-image', [
  'blueprints' => [
    'blocks/image' => __DIR__ . '/blueprints/image.yml'
  ],
  'snippets' => [
    'blocks/image' => __DIR__ . '/snippets/image.php'
  ]
]);