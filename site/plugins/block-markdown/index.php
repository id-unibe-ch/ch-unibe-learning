<?php

Kirby::plugin('tfk/block-markdown', [
  'blueprints' => [
    'blocks/markdown' => __DIR__ . '/blueprints/markdown.yml'
  ],
  'snippets' => [
    'blocks/markdown' => __DIR__ . '/snippets/markdown.php'
  ]
]);