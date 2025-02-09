<?php

  $blockFirst = $page->blocks()->toBlocks()->first();
  $cover = $page->cover()->toFile();
  $coverSite = $site->cover()->toFile();
  $socialProfiles = $site->social()->toStructure();

?>
<script type="application/ld+json">
{
"@context": "https://schema.org",
"@graph": [
<?php if ($site->schemaType()->value() === 'person' && ($person = $site->schemaPerson()->toUser())): ?>
{
<?php if ($avatar = $person->avatar()): ?>
"image": {
"@type": "ImageObject",
"@id": "<?= $site->url() ?>/#personimage",
<?php if ($person->name()->isNotEmpty()): ?>
"caption": "<?= $person->name() ?>",
<?php endif ?>
"url": "<?= $avatar->resize(512, 512)->url() ?>",
"height": <?= $avatar->height() ?>,
"width": <?= $avatar->width() ?>
},
"logo": {
"@id": "<?= $site->url() ?>/#personimage"
},
<?php endif ?>
<?php if ($socialProfiles->isNotEmpty()): ?>
"sameAs": [
<?php foreach ($socialProfiles as $socialProfile): ?>
<?php if ($socialProfile->isLast()): ?>
<?php if ($socialProfile->account()->value() === 'dribbble' && $socialProfile->username()->isNotEmpty()): ?>
"https://dribbble.com/<?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'facebook' && $socialProfile->username()->isNotEmpty()): ?>
"https://www.facebook.com/<?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'github' && $socialProfile->username()->isNotEmpty()): ?>
"https://github.com/<?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'instagram' && $socialProfile->username()->isNotEmpty()): ?>
"https://www.instagram.com/<?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'linkedin' && $socialProfile->username()->isNotEmpty()): ?>
"<?php if ($socialProfile->company()->bool()): ?>https://www.linkedin.com/company/<?php else: ?>https://www.linkedin.com/in/<?php endif ?><?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'twitter' && $socialProfile->username()->isNotEmpty()): ?>
"https://twitter.com/<?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'youtube' && ($socialProfile->username()->isNotEmpty() || $socialProfile->url()->isNotEmpty())): ?>
<?php if ($socialProfile->username()->isNotEmpty()): ?>
"https://www.youtube.com/<?= $socialProfile->username() ?>"
<?php else: ?>
"<?= $socialProfile->url() ?>"
<?php endif ?>
<?php endif ?>
<?php else: ?>
<?php if ($socialProfile->account()->value() === 'dribbble' && $socialProfile->username()->isNotEmpty()): ?>
"https://dribbble.com/<?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'facebook' && $socialProfile->username()->isNotEmpty()): ?>
"https://www.facebook.com/<?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'github' && $socialProfile->username()->isNotEmpty()): ?>
"https://github.com/<?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'instagram' && $socialProfile->username()->isNotEmpty()): ?>
"https://www.instagram.com/<?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'linkedin' && $socialProfile->username()->isNotEmpty()): ?>
"<?php if ($socialProfile->company()->bool()): ?>https://www.linkedin.com/company/<?php else: ?>https://www.linkedin.com/in/<?php endif ?><?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'twitter' && $socialProfile->username()->isNotEmpty()): ?>
"https://twitter.com/<?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'youtube' && ($socialProfile->username()->isNotEmpty() || $socialProfile->url()->isNotEmpty())): ?>
<?php if ($socialProfile->username()->isNotEmpty()): ?>
"https://www.youtube.com/<?= $socialProfile->username() ?>",
<?php else: ?>
"<?= $socialProfile->url() ?>",
<?php endif ?>
<?php endif ?>
<?php endif ?>
<?php endforeach ?>
],
<?php endif ?>
"@type": "Person",
"@id": "<?= $site->url() ?>/#person",
<?php if ($person->name()->isNotEmpty()): ?>
"name": "<?= $person->name() ?>",
<?php endif ?>
"url": "<?= $site->url() ?>"
},
<?php else: ?>
{
<?php if ($icon = $site->icon()->toFile()): ?>
"logo": {
"@type": "ImageObject",
"@id": "<?= $site->url() ?>/#logo",
"caption": "<?= $site->title() ?>",
"url": "<?= $icon->resize(512, 512)->url() ?>",
"height": <?= $icon->height() ?>,
"width": <?= $icon->width() ?>
},
"image": {
"@id": "<?= $site->url() ?>/#logo"
},
<?php endif ?>
<?php if ($socialProfiles->isNotEmpty()): ?>
"sameAs": [
<?php foreach ($socialProfiles as $socialProfile): ?>
<?php if ($socialProfile->isLast()): ?>
<?php if ($socialProfile->account()->value() === 'dribbble' && $socialProfile->username()->isNotEmpty()): ?>
"https://dribbble.com/<?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'facebook' && $socialProfile->username()->isNotEmpty()): ?>
"https://www.facebook.com/<?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'github' && $socialProfile->username()->isNotEmpty()): ?>
"https://github.com/<?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'instagram' && $socialProfile->username()->isNotEmpty()): ?>
"https://www.instagram.com/<?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'linkedin' && $socialProfile->username()->isNotEmpty()): ?>
"<?php if ($socialProfile->company()->bool()): ?>https://www.linkedin.com/company/<?php else: ?>https://www.linkedin.com/in/<?php endif ?><?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'twitter' && $socialProfile->username()->isNotEmpty()): ?>
"https://twitter.com/<?= $socialProfile->username() ?>"
<?php elseif ($socialProfile->account()->value() === 'youtube' && ($socialProfile->username()->isNotEmpty() || $socialProfile->url()->isNotEmpty())): ?>
<?php if ($socialProfile->username()->isNotEmpty()): ?>
"https://www.youtube.com/<?= $socialProfile->username() ?>"
<?php else: ?>
"<?= $socialProfile->url() ?>"
<?php endif ?>
<?php endif ?>
<?php else: ?>
<?php if ($socialProfile->account()->value() === 'dribbble' && $socialProfile->username()->isNotEmpty()): ?>
"https://dribbble.com/<?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'facebook' && $socialProfile->username()->isNotEmpty()): ?>
"https://www.facebook.com/<?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'github' && $socialProfile->username()->isNotEmpty()): ?>
"https://github.com/<?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'instagram' && $socialProfile->username()->isNotEmpty()): ?>
"https://www.instagram.com/<?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'linkedin' && $socialProfile->username()->isNotEmpty()): ?>
"<?php if ($socialProfile->company()->bool()): ?>https://www.linkedin.com/company/<?php else: ?>https://www.linkedin.com/in/<?php endif ?><?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'twitter' && $socialProfile->username()->isNotEmpty()): ?>
"https://twitter.com/<?= $socialProfile->username() ?>",
<?php elseif ($socialProfile->account()->value() === 'youtube' && ($socialProfile->username()->isNotEmpty() || $socialProfile->url()->isNotEmpty())): ?>
<?php if ($socialProfile->username()->isNotEmpty()): ?>
"https://www.youtube.com/<?= $socialProfile->username() ?>",
<?php else: ?>
"<?= $socialProfile->url() ?>",
<?php endif ?>
<?php endif ?>
<?php endif ?>
<?php endforeach ?>
],
<?php endif ?>
"@type": "Organization",
"@id": "<?= $site->url() ?>/#organization",
"name": "<?= $site->title() ?>",
"url": "<?= $site->url() ?>"
},
<?php endif ?>
{
"@type": "WebSite",
"@id": "<?= $site->url() ?>/#website",
"name": "<?= $site->title() ?>",
"url": "<?= $site->url() ?>",
"publisher": {
<?php if ($site->schemaType()->value() === 'person' && $site->schemaPerson()->toUser()): ?>
"@id": "<?= $site->url() ?>/#person"
<?php else: ?>
"@id": "<?= $site->url() ?>/#organization"
<?php endif ?>
}
},
<?php if ($cover): ?>
{
"@type": "ImageObject",
"@id": "<?= $page->url() ?>/#primaryimage",
"url": "<?= $cover->resize(1200, 800)->url() ?>"
},
<?php elseif ($coverSite): ?>
{
"@type": "ImageObject",
"@id": "<?= $page->url() ?>/#primaryimage",
"url": "<?= $coverSite->resize(1200, 800)->url() ?>"
},
<?php endif ?>
<?php if ($page->parents()->count()): ?>
{
"@type": "Article",
"@id": "<?= $page->url() ?>/#article",
"isPartOf": {
"@id": "<?= $page->url() ?>/#webpage"
},
"author": {
<?php if ($site->schemaType()->value() === 'person' && ($person = $site->schemaPerson()->toUser()) && $page->author()->toUser() === $person): ?>
"@id": "<?= $site->url() ?>/#person"
<?php elseif ($author = $page->author()->toUser()): ?>
<?php if ($avatar = $author->avatar()): ?>
"image": {
"@type": "ImageObject",
<?php if ($author->name()->isNotEmpty()): ?>
"caption": "<?= $author->name() ?>",
<?php endif ?>
"url": "<?= $avatar->resize(512, 512)->url() ?>"
},
<?php endif ?>
<?php if ($author->name()->isNotEmpty()): ?>
"name": "<?= $author->name() ?>",
<?php endif ?>
"@type": "Person"
<?php elseif ($site->schemaType()->value() === 'person' && $site->schemaPerson()->toUser()): ?>
"@id": "<?= $site->url() ?>/#person"
<?php else: ?>
"@id": "<?= $site->url() ?>/#organization"
<?php endif ?>
},
"headline": "<?= str_replace('"', "”", $page->title()) ?> - <?= $site->title() ?>",
<?php if ($cover): ?>
"image": "<?= $cover->resize(1200, 800)->url() ?>",
<?php elseif ($coverSite): ?>
"image": "<?= $coverSite->resize(1200, 800)->url() ?>",
<?php endif ?>
<?php if ($page->date()->isNotEmpty()): ?>
"datePublished": "<?= $page->date('c') ?>",
<?php endif ?>
"dateModified": "<?= $page->modified('c') ?>",
"mainEntityOfPage": {
"@id": "<?= $page->url() ?>/#webpage"
},
"publisher": {
<?php if ($site->schemaType()->value() === 'person' && $site->schemaPerson()->toUser()): ?>
"@id": "<?= $site->url() ?>/#person"
<?php else: ?>
"@id": "<?= $site->url() ?>/#organization"
<?php endif ?>
},
"articleSection": "<?= html(str_replace('"', "”", $page->parent()->title())) ?>"
},
<?php endif ?>
{
"@type": "WebPage",
"@id": "<?= $page->url() ?>/#webpage",
"url": "<?= $page->url() ?>",
<?php if ($kirby->multilang()): ?>
"inLanguage": "<?= $kirby->language()->code() ?>",
<?php elseif ($site->languageCode()->isNotEmpty()): ?>
"inLanguage": "<?= $site->languageCode() ?>",
<?php else: ?>
"inLanguage": "en",
<?php endif ?>
<?php if ($page->isHomePage() && $site->tagline()->isNotEmpty()): ?>
"name": "<?= $site->title() ?> - <?= str_replace('"', "”", $site->tagline()) ?>",
<?php elseif ($page->isHomePage()): ?>
"name": "<?= $site->title() ?>",
<?php else: ?>
"name": "<?= str_replace('"', "”", $page->title()) ?> - <?= $site->title() ?>",
<?php endif ?>
"isPartOf": {
"@id": "<?= $site->url() ?>/#website"
},
<?php if ($page->isHomePage()): ?>
"about": {
<?php if ($site->schemaType()->value() === 'person' && $site->schemaPerson()->toUser()): ?>
"@id": "<?= $site->url() ?>/#person"
<?php else: ?>
"@id": "<?= $site->url() ?>/#organization"
<?php endif ?>
},
<?php endif ?>
<?php if ($page->cover()->toFile() || $site->cover()->toFile()): ?>
"primaryImageOfPage": {
"@id": "<?= $page->url() ?>/#primaryimage"
},
<?php endif ?>
<?php if ($page->heroText()->isNotEmpty()): ?>
"description": "<?= str_replace('"', "”", $page->heroText()->excerpt(150)) ?>",
<?php elseif ($page->text()->isNotEmpty()): ?>
"description": "<?= str_replace('"', "”", $page->text()->excerpt(150)) ?>",
<?php elseif ($blockFirst && $blockFirst->text()->isNotEmpty()): ?>
"description": "<?= str_replace('"', "”", $blockFirst->text()->excerpt(150)) ?>",
<?php endif ?>
<?php if ($page->date()->isNotEmpty()): ?>
"datePublished": "<?= $page->date('c') ?>",
<?php endif ?>
"dateModified": "<?= $page->modified('c') ?>"
}
]
}
</script>
