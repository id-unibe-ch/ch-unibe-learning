<?php

Kirby::plugin('tfk/block-text', [
  'blueprints' => [
    'blocks/text' => __DIR__ . '/blueprints/text.yml'
  ],
  'snippets' => [
    'blocks/text' => __DIR__ . '/snippets/text.php'
  ]
]);