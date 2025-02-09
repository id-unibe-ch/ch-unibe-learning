<?php

Kirby::plugin('tfk/block-video', [
  'blueprints' => [
    'blocks/video' => __DIR__ . '/blueprints/video.yml'
  ],
  'snippets' => [
    'blocks/video' => __DIR__ . '/snippets/video.php'
  ]
]);