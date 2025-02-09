<?php

  $blockFirst = $page->blocks()->toBlocks()->first();
  $cover = $page->cover()->toFile();
  $coverSite = $site->cover()->toFile();
  $socialProfiles = $site->social()->toStructure();

  include_once 'functions.php';

?>
<!doctype html>
<html lang="<?php if ($kirby->multilang()): ?><?= $kirby->language()->code() ?><?php elseif ($site->languageCode()->isNotEmpty()): ?><?= $site->languageCode() ?><?php else: ?>en<?php endif ?>">
<head>
<meta charset="utf-8">
<meta name="author" content="<?= $site->title() ?>">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<?php if ($page->isHomePage() && $site->tagline()->isNotEmpty()): ?>
<title><?= $site->title() ?> - <?= $site->tagline() ?></title>
<?php elseif ($page->isHomePage()): ?>
<title><?= $site->title() ?></title>
<?php else: ?>
<title><?= $page->title() ?> - <?= $site->title() ?></title>
<?php endif ?>
<?php if ($page->heroText()->isNotEmpty()): ?>
<meta name="description" content="<?= $page->heroText()->excerpt(150) ?>">
<?php elseif ($page->text()->isNotEmpty()): ?>
<meta name="description" content="<?= $page->text()->excerpt(150) ?>">
<?php elseif ($blockFirst && $blockFirst->text()->isNotEmpty()): ?>
<meta name="description" content="<?= $blockFirst->text()->excerpt(150) ?>">
<?php endif ?>
<?php if ($page->heroText()->isNotEmpty()): ?>
<meta property="og:description" content="<?= $page->heroText()->excerpt(150) ?>" />
<?php elseif ($page->text()->isNotEmpty()): ?>
<meta property="og:description" content="<?= $page->text()->excerpt(150) ?>" />
<?php elseif ($blockFirst && $blockFirst->text()->isNotEmpty()): ?>
<meta property="og:description" content="<?= $blockFirst->text()->excerpt(150) ?>" />
<?php endif ?>
<?php if ($cover): ?>
<meta property="og:image" content="<?= $cover->resize(1200, 800)->url() ?>" />
<?php elseif ($coverSite): ?>
<meta property="og:image" content="<?= $coverSite->resize(1200, 800)->url() ?>" />
<?php endif ?>
<meta property="og:site_name" content="<?= $site->title() ?>">
<?php if ($page->isHomePage() && $site->tagline()->isNotEmpty()): ?>
<meta property="og:title" content="<?= $site->title() ?> - <?= $site->tagline() ?>" />
<?php elseif ($page->isHomePage()): ?>
<meta property="og:title" content="<?= $site->title() ?>" />
<?php else: ?>
<meta property="og:title" content="<?= $page->title() ?> - <?= $site->title() ?>" />
<?php endif ?>
<?php if ($page->parents()->count()): ?>
<meta property="og:type" content="article" />
<?php else: ?>
<meta property="og:type" content="website" />
<?php endif ?>
<meta property="og:url" content="<?= $page->url() ?>" />
<meta name="twitter:card" content="summary" />
<?php if (socialTwitter($socialProfiles)): ?>
<meta name="twitter:creator" content="@<?= socialTwitter($socialProfiles) ?>" />
<?php endif ?>
<?php if ($page->heroText()->isNotEmpty()): ?>
<meta name="twitter:description" content="<?= $page->heroText()->excerpt(150) ?>" />
<?php elseif ($page->text()->isNotEmpty()): ?>
<meta name="twitter:description" content="<?= $page->text()->excerpt(150) ?>" />
<?php elseif ($blockFirst && $blockFirst->text()->isNotEmpty()): ?>
<meta name="twitter:description" content="<?= $blockFirst->text()->excerpt(150) ?>" />
<?php endif ?>
<?php if ($cover): ?>
<meta name="twitter:image" content="<?= $cover->resize(1200, 800)->url() ?>" />
<?php elseif ($coverSite): ?>
<meta name="twitter:image" content="<?= $coverSite->resize(1200, 800)->url() ?>" />
<?php endif ?>
<?php if (socialTwitter($socialProfiles)): ?>
<meta name="twitter:site" content="@<?= socialTwitter($socialProfiles) ?>" />
<?php endif ?>
<?php if ($page->isHomePage() && $site->tagline()->isNotEmpty()): ?>
<meta name="twitter:title" content="<?= $site->title() ?> - <?= $site->tagline() ?>" />
<?php elseif ($page->isHomePage()): ?>
<meta name="twitter:title" content="<?= $site->title() ?>" />
<?php else: ?>
<meta name="twitter:title" content="<?= $page->title() ?> - <?= $site->title() ?>" />
<?php endif ?>
<?php if ($icon = $site->icon()->toFile()): ?>
<link rel="apple-touch-icon-precomposed" href="<?= $icon->url() ?>">
<link rel="icon" href="<?= $icon->url() ?>">
<link rel="shortcut icon" href="<?= $icon->url() ?>">
<?php endif ?>
<?php if ($kirby->languages()->count() > 1): ?>
<?php foreach($kirby->languages() as $language): ?>
<link rel="alternate" hreflang="<?= $language->code() ?>" href="<?= $page->url($language->code()) ?>">
<?php endforeach ?>
<?php endif ?>
<?php if ($site->fontBody()->value() === 'custom' && $site->fontBodyEmbed()->isNotEmpty()): ?>
<?= $site->fontBodyEmbed() ?>

<?php endif ?>
<?php if ($site->fontHeader()->value() === 'custom' && $site->fontHeaderEmbed()->isNotEmpty()): ?>
<?= $site->fontHeaderEmbed() ?>

<?php endif ?>
<?php $ver = filemtime('assets/build/css/main.min.css'); echo css(['assets/build/css/main.min.css?ver=' . $ver . '', '@auto']); ?>
<?php $ver = filemtime('assets/css/custom.min.css'); echo css(['assets/css/custom.min.css?ver=' . $ver . '', '@auto']); ?>
<?php snippet('header-schema') ?>
<?php snippet('header-style') ?>
<?php if ($site->codeHeader()->isNotEmpty()): ?>
<?= $site->codeHeader() ?>
<?php endif ?>
<?php if ($page->parents()->count() && $page->parent()->codeHeader()->isNotEmpty()): ?>
<?= $page->parent()->codeHeader() ?>
<?php endif ?>
<?php if ($page->codeHeader()->isNotEmpty()): ?>
<?= $page->codeHeader() ?>
<?php endif ?>

</head>
<body class="<?php if ($site->colorPrimaryDark() == 'white'): ?>primary-white <?php endif ?>page preload js-not-ready">
  <script>
    document.body.classList.remove('js-not-ready');
    document.body.classList.add('js-ready');
    setTimeout(function() {
      document.body.classList.remove('preload');
    }, 100);
  </script>

  <?php if ($site->appearance()->value() === 'dark' && $site->headerAppearanceSwitch()->bool()): ?>
    <script>
      if (localStorage.getItem('<?= Str::slug(site()->title()) ?>-appearance') === null || localStorage.getItem('<?= Str::slug(site()->title()) ?>-appearance') === 'true') {
        document.body.classList.toggle('dark');
      }
    </script>
  <?php elseif ($site->appearance()->value() === 'dark'): ?>
    <script>
      document.body.classList.toggle('dark');
    </script>
  <?php elseif ($site->headerAppearanceSwitch()->bool()): ?>
    <script>
      if (localStorage.getItem('<?= Str::slug(site()->title()) ?>-appearance') === 'true') {
        document.body.classList.toggle('dark');
      }
    </script>
  <?php endif ?>

  <?php if ($site->headerSearch()->bool()):

    $query   = get('q');

  ?>
    <form action="<?= ($p = page('s')) ? $p->url() : '' ?>" autocomplete="off" class="form search" method="get">
      <div class="form-group">
        <input id="search" name="q" onfocus="this.value=''" placeholder="Search..." type="search" value="<?= html($query) ?>">
      </div>
    </form>
    <div class="search-overlay"></div>
  <?php endif ?>

  <?php snippet('header-nav') ?>
