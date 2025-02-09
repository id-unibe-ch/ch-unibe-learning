<?php

Kirby::plugin('tfk/block-products', [
  'blueprints' => [
    'blocks/products' => __DIR__ . '/blueprints/products.yml'
  ],
  'snippets' => [
    'blocks/products' => __DIR__ . '/snippets/products.php'
  ]
]);