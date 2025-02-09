<?php

Kirby::plugin('tfk/block-vimeo', [
  'blueprints' => [
    'blocks/vimeo' => __DIR__ . '/blueprints/vimeo.yml'
  ],
  'snippets' => [
    'blocks/vimeo' => __DIR__ . '/snippets/vimeo.php'
  ]
]);