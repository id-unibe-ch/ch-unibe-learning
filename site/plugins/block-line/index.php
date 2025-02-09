<?php

Kirby::plugin('tfk/block-line', [
  'blueprints' => [
    'blocks/line' => __DIR__ . '/blueprints/line.yml'
  ],
  'snippets' => [
    'blocks/line' => __DIR__ . '/snippets/line.php'
  ]
]);