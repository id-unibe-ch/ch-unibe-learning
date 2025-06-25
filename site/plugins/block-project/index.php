<?php
Kirby::plugin('unibe/block-project', [
  'blueprints' => [
    'blocks/project' => __DIR__ . '/blueprints/project.yml'
  ],
  'snippets' => [
    'blocks/project' => __DIR__ . '/snippets/project.php'
  ]
]);
