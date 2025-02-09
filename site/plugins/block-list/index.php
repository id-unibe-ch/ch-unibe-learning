<?php

Kirby::plugin('tfk/block-list', [
  'blueprints' => [
    'blocks/list' => __DIR__ . '/blueprints/list.yml'
  ],
  'snippets' => [
    'blocks/list' => __DIR__ . '/snippets/list.php'
  ]
]);