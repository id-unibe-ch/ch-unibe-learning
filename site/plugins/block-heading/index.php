<?php

Kirby::plugin('tfk/block-heading', [
  'blueprints' => [
    'blocks/heading' => __DIR__ . '/blueprints/heading.yml'
  ],
  'snippets' => [
    'blocks/heading' => __DIR__ . '/snippets/heading.php'
  ]
]);