<?php

Kirby::plugin('tfk/block-pricing', [
  'blueprints' => [
    'blocks/pricing' => __DIR__ . '/blueprints/pricing.yml'
  ],
  'snippets' => [
    'blocks/pricing' => __DIR__ . '/snippets/pricing.php'
  ]
]);