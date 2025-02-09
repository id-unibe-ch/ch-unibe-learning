<?php

Kirby::plugin('tfk/block-quote', [
  'blueprints' => [
    'blocks/quote' => __DIR__ . '/blueprints/quote.yml'
  ],
  'snippets' => [
    'blocks/quote' => __DIR__ . '/snippets/quote.php'
  ]
]);