<?php
Kirby::plugin('unibe/block-material-card', [
  'blueprints' => [
    'blocks/material-card' => __DIR__ . '/blueprints/material-card.yml'
  ],
  'snippets' => [
    'blocks/material-card' => __DIR__ . '/snippets/material-card.php'
  ]
]);
