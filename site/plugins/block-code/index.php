<?php

Kirby::plugin('tfk/block-code', [
  'blueprints' => [
    'blocks/code' => __DIR__ . '/blueprints/code.yml'
  ],
  'snippets' => [
    'blocks/code' => __DIR__ . '/snippets/code.php'
  ]
]);