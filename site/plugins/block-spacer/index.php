<?php

Kirby::plugin('tfk/block-spacer', [
  'blueprints' => [
    'blocks/spacer' => __DIR__ . '/blueprints/spacer.yml'
  ],
  'snippets' => [
    'blocks/spacer' => __DIR__ . '/snippets/spacer.php'
  ]
]);