<?php

Kirby::plugin('tfk/block-blurb', [
  'blueprints' => [
    'blocks/blurb' => __DIR__ . '/blueprints/blurb.yml'
  ],
  'snippets' => [
    'blocks/blurb' => __DIR__ . '/snippets/blurb.php'
  ]
]);