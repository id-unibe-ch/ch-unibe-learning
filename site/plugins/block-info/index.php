<?php

Kirby::plugin('tfk/block-info', [
  'blueprints' => [
    'blocks/info' => __DIR__ . '/blueprints/info.yml'
  ],
  'snippets' => [
    'blocks/info' => __DIR__ . '/snippets/info.php'
  ]
]);