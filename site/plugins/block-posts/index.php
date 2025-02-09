<?php

Kirby::plugin('tfk/block-posts', [
  'blueprints' => [
    'blocks/posts' => __DIR__ . '/blueprints/posts.yml'
  ],
  'snippets' => [
    'blocks/posts' => __DIR__ . '/snippets/posts.php'
  ]
]);