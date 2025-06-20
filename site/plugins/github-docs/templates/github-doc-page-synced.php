<?php 
snippet('header') ?>

<!-- GitHub Documentation Styles -->
<link rel="stylesheet" href="<?= url('site/plugins/github-docs/assets/css/github-docs.css') ?>">

<main class="github-docs-layout">
  <!-- Left Sidebar Navigation -->
  <aside class="github-docs-sidebar">
    <div class="github-docs-sidebar-header">
      <h2>
        <a href="<?= $page->parent()->url() ?>"><?= $page->parent()->title() ?></a>
      </h2>
    </div>
    
    <nav class="github-docs-nav">
      <?php 
      $docPages = $page->parent()->children()->filterBy('github_synced', true)->sortBy('title');
      ?>
      <?php foreach ($docPages as $docPage): ?>
        <a href="<?= $docPage->url() ?>" 
           class="github-docs-nav-link <?= $docPage->is($page) ? 'is-active' : '' ?>">
          <?= $docPage->title() ?>
        </a>
      <?php endforeach ?>
    </nav>
  </aside>

  <!-- Main Content -->
  <article class="github-docs-content">
    <header class="github-docs-header">
      <h1><?= $page->title() ?></h1>
      
      <?php if ($page->github_path()->isNotEmpty()): ?>
      <div class="github-docs-meta">
        <p>
          <a href="<?= $page->parent()->github_repo_url() ?>/blob/<?= $page->parent()->github_branch()->or('main') ?>/<?= $page->github_path() ?>" 
             target="_blank" 
             rel="noopener">
            📄 View on GitHub
          </a>
          <?php if ($page->github_last_sync()->isNotEmpty()): ?>
          | Last synced: <?= date('M j, Y g:i A', strtotime($page->github_last_sync())) ?>
          <?php endif ?>
        </p>
      </div>
      <?php endif ?>
    </header>

    <div class="github-docs-text">
      <?= $page->text()->kirbytext() ?>
    </div>
  </article>
</main>

<!-- Mermaid JS for diagrams -->
<script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
<script>
  mermaid.initialize({ 
    startOnLoad: true,
    theme: 'default'
  });
</script>

<?php snippet('footer') ?>
