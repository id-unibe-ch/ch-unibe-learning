<?php

Kirby::plugin('tfk/themesforkirby', [

  // Load blueprints
  'blueprints' => [
    'site' => __DIR__ . '/blueprints/site.yml',

    // Fields
    'fields/animation' => __DIR__ . '/blueprints/fields/animation.yml',
    'fields/background-fill-shadow' => __DIR__ . '/blueprints/fields/background-fill-shadow.yml',
    'fields/background-fill' => __DIR__ . '/blueprints/fields/background-fill.yml',
    'fields/background' => __DIR__ . '/blueprints/fields/background.yml',
    'fields/blocks' => __DIR__ . '/blueprints/fields/blocks.yml',
    'fields/buttons' => __DIR__ . '/blueprints/fields/buttons.yml',
    'fields/cover' => __DIR__ . '/blueprints/fields/cover.yml',
    'fields/hero' => __DIR__ . '/blueprints/fields/hero.yml',
    'fields/layout-settings' => __DIR__ . '/blueprints/fields/layout-settings.yml',
    'fields/layout' => __DIR__ . '/blueprints/fields/layout.yml',
    'fields/social' => __DIR__ . '/blueprints/fields/social.yml',
    'fields/text-fill' => __DIR__ . '/blueprints/fields/text-fill.yml',

    // Files
    'files/default' => __DIR__ . '/blueprints/files/default.yml',
    'files/image' => __DIR__ . '/blueprints/files/image.yml',
    'files/video' => __DIR__ . '/blueprints/files/video.yml',

    // Pages
    'pages/default' => __DIR__ . '/blueprints/pages/default.yml',
    'pages/error' => __DIR__ . '/blueprints/pages/error.yml',
    'pages/post' => __DIR__ . '/blueprints/pages/post.yml',
    'pages/posts' => __DIR__ . '/blueprints/pages/posts.yml',
    'pages/product' => __DIR__ . '/blueprints/pages/product.yml',
    'pages/products' => __DIR__ . '/blueprints/pages/products.yml',
    'pages/s' => __DIR__ . '/blueprints/pages/s.yml',

    // Sections
    'sections/posts' => __DIR__ . '/blueprints/sections/posts.yml',
    'sections/products' => __DIR__ . '/blueprints/sections/products.yml',

    // Users
    'users/admin' => __DIR__ . '/blueprints/users/admin.yml',
    'users/author' => __DIR__ . '/blueprints/users/author.yml',
    'users/default' => __DIR__ . '/blueprints/users/default.yml',
    'users/editor' => __DIR__ . '/blueprints/users/editor.yml'
  ],

  // Load snippets
  'snippets' => [
    'blocks-style/gallery-style' => __DIR__ . '/snippets/blocks-style/gallery-style.php',
    'blocks-style/heading-style' => __DIR__ . '/snippets/blocks-style/heading-style.php',
    'blocks-style/slider-style' => __DIR__ . '/snippets/blocks-style/slider-style.php',
    'blocks-style/video-style' => __DIR__ . '/snippets/blocks-style/video-style.php',
    'blocks-style/vimeo-style' => __DIR__ . '/snippets/blocks-style/vimeo-style.php',
    'blocks-style/youtube-style' => __DIR__ . '/snippets/blocks-style/youtube-style.php',
    'blocks' => __DIR__ . '/snippets/blocks.php',
    'empty' => __DIR__ . '/snippets/empty.php',
    'footer' => __DIR__ . '/snippets/footer.php',
    'functions' => __DIR__ . '/snippets/functions.php',
    'header-nav' => __DIR__ . '/snippets/header-nav.php',
    'header-schema' => __DIR__ . '/snippets/header-schema.php',
    'header-style-animation-custom' => __DIR__ . '/snippets/header-style-animation-custom.php',
    'header-style-blocks-post' => __DIR__ . '/snippets/header-style-blocks-post.php',
    'header-style-blocks-product' => __DIR__ . '/snippets/header-style-blocks-product.php',
    'header-style-hero' => __DIR__ . '/snippets/header-style-hero.php',
    'header-style-layout' => __DIR__ . '/snippets/header-style-layout.php',
    'header-style-page' => __DIR__ . '/snippets/header-style-page.php',
    'header-style-related' => __DIR__ . '/snippets/header-style-related.php',
    'header-style' => __DIR__ . '/snippets/header-style.php',
    'header' => __DIR__ . '/snippets/header.php',
    'hero' => __DIR__ . '/snippets/hero.php',
    'posts-box' => __DIR__ . '/snippets/posts-box.php',
    'posts-cards' => __DIR__ . '/snippets/posts-cards.php',
    'posts-grid' => __DIR__ . '/snippets/posts-grid.php',
    'posts-list-compact' => __DIR__ . '/snippets/posts-list-compact.php',
    'posts-list-default' => __DIR__ . '/snippets/posts-list-default.php',
    'posts-list-wide' => __DIR__ . '/snippets/posts-list-wide.php',
    'posts-related' => __DIR__ . '/snippets/posts-related.php',
    'posts' => __DIR__ . '/snippets/posts.php',
    'share' => __DIR__ . '/snippets/share.php',
    'sitemap' => __DIR__ . '/snippets/sitemap.php'
  ],

  // Load templates
  'templates' => [
    'default' => __DIR__ . '/templates/default.php',
    'post' => __DIR__ . '/templates/post.php',
    'posts' => __DIR__ . '/templates/posts.php',
    'product' => __DIR__ . '/templates/product.php',
    'products' => __DIR__ . '/templates/products.php',
    's' => __DIR__ . '/templates/s.php'
  ]
]);