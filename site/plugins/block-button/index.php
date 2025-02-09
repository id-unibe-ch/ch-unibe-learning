<?php

Kirby::plugin('tfk/block-button', [
  'blueprints' => [
    'blocks/button' => __DIR__ . '/blueprints/button.yml'
  ],
  'snippets' => [
    'blocks/button' => __DIR__ . '/snippets/button.php'
  ]
]);