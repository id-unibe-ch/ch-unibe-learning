<?= '<?xml version="1.0" encoding="utf-8"?>'; ?>
<?php if (kirby()->languages()->count() > 1): ?>
  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">

    <?php foreach ($pages as $p): ?>
      <?php if (in_array($p->uri(), $ignore)) continue ?>

        <?php foreach(kirby()->languages() as $language): ?>
          <url>
            <loc><?= html($p->url($language->code())) ?></loc>

            <?php foreach(kirby()->languages() as $languageAlt): ?>

              <xhtml:link rel="alternate" hreflang="<?= $languageAlt->code() ?>" href="<?= $p->url($languageAlt->code()) ?>"/>

            <?php endforeach ?>

            <?php if ($p->translation($language->code())->exists()): ?>
              <lastmod><?= F::modified($p->contentFile($language->code()), 'c') ?></lastmod>
            <?php else: ?>
              <lastmod><?= $p->modified('c') ?></lastmod>
            <?php endif ?>

          </url>
        <?php endforeach ?>

    <?php endforeach ?>

  </urlset>
<?php else: ?>
  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <?php foreach ($pages as $p): ?>
      <?php if (in_array($p->uri(), $ignore)) continue ?>
        <url>
          <loc><?= html($p->url()) ?></loc>
          <lastmod><?= $p->modified('c') ?></lastmod>
        </url>
    <?php endforeach ?>

  </urlset>
<?php endif ?>