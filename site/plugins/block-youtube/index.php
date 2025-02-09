<?php

Kirby::plugin('tfk/block-youtube', [
  'blueprints' => [
    'blocks/youtube' => __DIR__ . '/blueprints/youtube.yml'
  ],
  'snippets' => [
    'blocks/youtube' => __DIR__ . '/snippets/youtube.php'
  ]
]);