<?php

Kirby::plugin('tfk/block-gallery', [
  'blueprints' => [
    'blocks/gallery' => __DIR__ . '/blueprints/gallery.yml'
  ],
  'snippets' => [
    'blocks/gallery' => __DIR__ . '/snippets/gallery.php'
  ]
]);