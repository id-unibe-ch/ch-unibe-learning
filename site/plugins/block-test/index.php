<?php
Kirby::plugin('unibe/block-test', [
  'blueprints' => [
    'blocks/test' => __DIR__ . '/blueprints/test.yml',
    // more blueprints
  ],
  'snippets' => [
    'blocks/test' => __DIR__ . '/snippets/test.php',
    // more snippets
  ]
//   'translations' => [
//     'en' => [
//       'field.blocks.awesomeblock.name' => 'My awesome block',
//       // more block names
//     ],
//     'de' => [
//        'field.blocks.awesomeblock.name' => 'Mein Superblock',
//       // more block names

//     ],
//     // more languages
//   ]
]);