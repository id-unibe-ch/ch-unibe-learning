<?php

Kirby::plugin('tfk/block-timeline', [
  'blueprints' => [
    'blocks/timeline' => __DIR__ . '/blueprints/timeline.yml'
  ],
  'snippets' => [
    'blocks/timeline' => __DIR__ . '/snippets/timeline.php'
  ]
]);