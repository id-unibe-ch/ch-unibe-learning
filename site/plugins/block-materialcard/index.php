<?php
Kirby::plugin('unibe/block-materialcard', [
  'blueprints' => [
    'blocks/materialcard' => __DIR__ . '/blueprints/materialcard.yml'
  ],
  'snippets' => [
    'blocks/materialcard' => __DIR__ . '/snippets/materialcard.php'
  ]
]);
