<?php

Kirby::plugin('tfk/block-newsletter', [
  'blueprints' => [
    'blocks/newsletter' => __DIR__ . '/blueprints/newsletter.yml'
  ],
  'snippets' => [
    'blocks/newsletter' => __DIR__ . '/snippets/newsletter.php'
  ]
]);