<?php
Kirby::plugin('unibe/block-test', [
  'blueprints' => [
    'blocks/test' => __DIR__ . '/blueprints/testblock.yml',
    // more blueprints
  ],
  'snippets' => [
    'blocks/test' => __DIR__ . '/snippets/testblock.php',
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