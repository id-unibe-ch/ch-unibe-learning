<?php snippet('header') ?>

<main class="main" role="main">
  <article class="github-docs-container">
    <header class="github-docs-header">
      <h1><?= $page->title()->html() ?></h1>
      
      <?php if ($page->description()->isNotEmpty()): ?>
        <div class="github-docs-description">
          <?= $page->description()->kt() ?>
        </div>
      <?php endif ?>

      <div class="github-docs-meta">
        <span class="github-repo">
          <strong>Repository:</strong> 
          <a href="<?= $page->github_repo_url() ?>" target="_blank" rel="noopener">
            <?= $page->github_repo_url() ?>
          </a>
        </span>
        <span class="github-branch">
          <strong>Branch:</strong> <?= $page->github_branch()->or('main') ?>
        </span>
        <span class="github-path">
          <strong>Documentation Path:</strong> <?= $page->github_docs_path()->or('docs') ?>
        </span>
      </div>
    </header>    <div class="github-docs-content">
      <?php 
      // Get virtual documentation pages using the new GitHubClient
      $repoUrl = $page->github_repo_url()->value();
      $branch = $page->github_branch()->or('main')->value();
      $docsPath = $page->github_docs_path()->or('docs')->value();
      $token = $page->github_api_token()->value();
      
      if (!empty($repoUrl)):
        try {
          $client = new \GitHubDocs\GitHubClient($repoUrl, $branch, $token);
          $markdownFiles = $client->getMarkdownFiles($docsPath);
          
          if (!empty($markdownFiles)): ?>
            <div class="github-docs-navigation">
              <h2>Documentation</h2>
              <ul class="github-docs-list">
                <?php foreach ($markdownFiles as $file): 
                  $docPath = str_replace('.md', '', basename($file['path']));
                  $docUrl = $page->url() . '/github-docs/' . \Kirby\Toolkit\Str::slug($docPath);
                ?>
                  <li class="github-docs-item">
                    <a href="<?= $docUrl ?>" class="github-docs-link">
                      <h3><?= ucfirst(str_replace(['-', '_'], ' ', $docPath)) ?></h3>
                      <p class="github-docs-size">
                        <?= number_format($file['size'] / 1024, 1) ?>KB
                      </p>
                      <?php if (isset($file['path']) && strpos($file['path'], '/') !== false): ?>
                        <p class="github-docs-path"><?= dirname($file['path']) ?></p>
                      <?php endif ?>
                    </a>
                  </li>
                <?php endforeach ?>
              </ul>
            </div>
          <?php else: ?>
            <div class="github-docs-empty">
              <p>No documentation files found in the specified path.</p>
            </div>
          <?php endif ?>
        <?php } catch (Exception $e) { ?>
          <div class="github-docs-error">
            <p>Error connecting to GitHub: <?= $e->getMessage() ?></p>
            <p>Please check the repository URL and access permissions.</p>
          </div>
        <?php } ?>  
      <?php else: ?>
        <div class="github-docs-empty">
          <p>Please configure a GitHub repository URL in the panel.</p>
        </div>
      <?php endif ?>
    </div>
  </article>
</main>

<style>
.github-docs-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.github-docs-header {
  margin-bottom: 3rem;
  border-bottom: 1px solid #e1e4e8;
  padding-bottom: 2rem;
}

.github-docs-header h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  color: #24292e;
}

.github-docs-description {
  font-size: 1.2rem;
  color: #586069;
  margin-bottom: 1.5rem;
}

.github-docs-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  font-size: 0.9rem;
  color: #586069;
}

.github-docs-meta a {
  color: #0366d6;
  text-decoration: none;
}

.github-docs-meta a:hover {
  text-decoration: underline;
}

.github-docs-navigation h2 {
  font-size: 1.8rem;
  margin-bottom: 1.5rem;
  color: #24292e;
}

.github-docs-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
  list-style: none;
  padding: 0;
}

.github-docs-item {
  border: 1px solid #e1e4e8;
  border-radius: 6px;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.github-docs-item:hover {
  border-color: #0366d6;
  box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}

.github-docs-link {
  display: block;
  padding: 1.5rem;
  text-decoration: none;
  color: inherit;
}

.github-docs-item h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.2rem;
  color: #0366d6;
}

.github-docs-size {
  margin: 0;
  color: #586069;
  font-size: 0.9rem;
}

.github-docs-path {
  margin: 0.25rem 0 0 0;
  color: #586069;
  font-size: 0.8rem;
  font-style: italic;
}

.github-docs-error,
.github-docs-empty {
  text-align: center;
  padding: 3rem;
  color: #586069;
  background: #f6f8fa;
  border-radius: 6px;
}

@media (max-width: 768px) {
  .github-docs-container {
    padding: 1rem;
  }
  
  .github-docs-meta {
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .github-docs-list {
    grid-template-columns: 1fr;
  }
}
</style>

<?php snippet('footer') ?>
