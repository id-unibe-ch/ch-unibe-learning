<?php

Kirby::plugin('unibe/toc', [
  'blueprints' => [
    'blocks/toc' => __DIR__ . '/blueprints/blocks/toc.yml'
  ],
  'snippets' => [
    'blocks/toc' => __DIR__ . '/snippets/blocks/toc.php'
  ],
  'assets' => [
    'css/toc-block.css' => __DIR__ . '/assets/css/toc-block.css',
    'js/toc-block.js' => __DIR__ . '/assets/js/toc-block.js'
  ],
  'hooks' => [
    'kirbytext:after' => [

      function($text) {

        // get the headline levels to convert from a config option, we use h2 as the default
        // $headlines = $page->text()->toBlocks()->filterBy('type', 'heading')->filterby('level', 'h2');
        $headlines = option('unibe.toc.headlines', 'h2|h3');

        // create the regex pattern to be used as first argument in `preg_replace_callback()`
        $headlinesPattern = is_array($headlines) ? implode('|', $headlines) : $headlines;

        // use `preg_replace_callback()` to replace matches with anchors
        $text = preg_replace_callback('!<(' . $headlinesPattern . ')>(.*?)</\\1>!s', function ($match) {

            // create the id from the headline text
            $id = Str::slug(Str::unhtml($match[2]));

            // return the modified headline:
            // $match[1] contains the match for the first subpattern, i.e. `h2`, `h3` etc.
            // $match[2] contains the match for the second subpattern, i.e. the actual headline text
            return '<' . $match[1] . ' id="' . $id . '"><a href="#' . $id . '">' . $match[2] . '</a></' . $match[1] . '>';

        }, $text);

        return $text;
      },
    ]
  ]
]);