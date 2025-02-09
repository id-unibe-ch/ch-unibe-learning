<?php

Kirby::plugin('tfk/block-imageurl', [
  'blueprints' => [
    'blocks/imageurl' => __DIR__ . '/blueprints/imageurl.yml'
  ],
  'snippets' => [
    'blocks/imageurl' => __DIR__ . '/snippets/imageurl.php'
  ]
]);