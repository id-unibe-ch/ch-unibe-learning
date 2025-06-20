<?php snippet('header') ?>

<main class="github-docs-layout">
  <!-- Left Sidebar Navigation -->
  <aside class="github-docs-sidebar">
    <div class="github-docs-sidebar-header">
      <h2><?= $page->title()->html() ?></h2>
      <div class="github-docs-repo-info">
        <a href="<?= $page->github_repo_url() ?>" target="_blank" rel="noopener" class="github-docs-repo-link">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
          </svg>
          View Repository
        </a>
      </div>
    </div>
    
    <nav class="github-docs-navigation">
      <?php 
      // Get navigation tree using the new GitHubClient
      $repoUrl = $page->github_repo_url()->value();
      $branch = $page->github_branch()->or('main')->value();
      $docsPath = $page->github_docs_path()->or('docs')->value();
      $token = $page->github_api_token()->value();
      
      if (!empty($repoUrl)):
        try {
          $client = new \GitHubDocs\GitHubClient($repoUrl, $branch, $token);
          $markdownFiles = $client->getMarkdownFiles($docsPath);
          $navigationTree = $client->buildNavigationTree($markdownFiles, $docsPath);
          
          function renderNavigation($tree, $currentPage, $level = 0) {
            if (empty($tree)) return;
            
            echo '<ul class="github-docs-nav-list" data-level="' . $level . '">';
            
            foreach ($tree as $key => $item) {
              if ($item['type'] === 'directory') {
                echo '<li class="github-docs-nav-item github-docs-nav-directory">';
                echo '<span class="github-docs-nav-directory-title">' . htmlspecialchars($item['title']) . '</span>';
                renderNavigation($item['children'], $currentPage, $level + 1);
                echo '</li>';
              } else {
                $docUrl = $currentPage->url() . '/github-docs/' . \Kirby\Toolkit\Str::slug($item['slug']);
                $isActive = false; // We'll implement active state detection later
                
                echo '<li class="github-docs-nav-item github-docs-nav-file' . ($isActive ? ' is-active' : '') . '">';
                echo '<a href="' . $docUrl . '" class="github-docs-nav-link">';
                echo htmlspecialchars($item['title']);
                echo '</a>';
                echo '</li>';
              }
            }
            
            echo '</ul>';
          }
          
          renderNavigation($navigationTree, $page);
          
        } catch (Exception $e) {
          echo '<div class="github-docs-nav-error">Error loading navigation: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
      else:
        echo '<div class="github-docs-nav-empty">Please configure a GitHub repository URL.</div>';
      endif;
      ?>
    </nav>
  </aside>

  <!-- Main Content Area -->
  <div class="github-docs-main">
    <div class="github-docs-content">
      <?php if ($page->description()->isNotEmpty()): ?>
        <div class="github-docs-intro">
          <?= $page->description()->kt() ?>
        </div>
      <?php endif ?>

      <div class="github-docs-welcome">
        <h1>Documentation</h1>
        <p>Select a topic from the navigation to get started, or browse the available documentation sections below.</p>
        
        <?php 
        // Show overview of top-level sections
        if (!empty($repoUrl)):
          try {
            $client = new \GitHubDocs\GitHubClient($repoUrl, $branch, $token);
            $markdownFiles = $client->getMarkdownFiles($docsPath);
            $navigationTree = $client->buildNavigationTree($markdownFiles, $docsPath);
            
            if (!empty($navigationTree)): ?>
              <div class="github-docs-sections">
                <?php foreach ($navigationTree as $key => $item): 
                  if ($item['type'] === 'directory' && !empty($item['children'])): ?>
                    <div class="github-docs-section-card">
                      <h3><?= htmlspecialchars($item['title']) ?></h3>
                      <ul class="github-docs-section-files">
                        <?php 
                        $fileCount = 0;
                        foreach ($item['children'] as $childKey => $child):
                          if ($child['type'] === 'file' && $fileCount < 5):
                            $docUrl = $page->url() . '/github-docs/' . \Kirby\Toolkit\Str::slug($child['slug']);
                        ?>
                          <li><a href="<?= $docUrl ?>"><?= htmlspecialchars($child['title']) ?></a></li>
                        <?php 
                            $fileCount++;
                          endif;
                        endforeach;
                        if (count($item['children']) > 5):
                        ?>
                          <li class="github-docs-more">... and <?= count($item['children']) - 5 ?> more</li>
                        <?php endif ?>
                      </ul>
                    </div>
                  <?php endif ?>
                <?php endforeach ?>
              </div>
            <?php endif ?>
          <?php } catch (Exception $e) { ?>
            <div class="github-docs-error">
              <p>Error loading documentation: <?= htmlspecialchars($e->getMessage()) ?></p>
            </div>
          <?php } ?>
        <?php endif ?>
      </div>
    </div>
  </div>
</main>

<style>
.github-docs-layout {
  display: flex;
  min-height: calc(100vh - 120px);
  max-width: 1400px;
  margin: 0 auto;
}

/* Sidebar Styles */
.github-docs-sidebar {
  width: 280px;
  background: #f8f9fa;
  border-right: 1px solid #e1e4e8;
  padding: 2rem 0;
  position: sticky;
  top: 0;
  height: fit-content;
  max-height: 100vh;
  overflow-y: auto;
}

.github-docs-sidebar-header {
  padding: 0 1.5rem 1.5rem;
  border-bottom: 1px solid #e1e4e8;
  margin-bottom: 1.5rem;
}

.github-docs-sidebar-header h2 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #24292e;
  margin: 0 0 0.75rem 0;
}

.github-docs-repo-info {
  font-size: 0.875rem;
}

.github-docs-repo-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: #586069;
  text-decoration: none;
  padding: 0.375rem 0;
}

.github-docs-repo-link:hover {
  color: #0366d6;
}

/* Navigation Styles */
.github-docs-navigation {
  padding: 0 1rem;
}

.github-docs-nav-list {
  list-style: none;
  margin: 0;
  padding: 0;
}

.github-docs-nav-list[data-level="0"] {
  padding: 0;
}

.github-docs-nav-list[data-level="1"] {
  padding-left: 1rem;
  margin-top: 0.5rem;
}

.github-docs-nav-item {
  margin: 0;
}

.github-docs-nav-directory {
  margin-bottom: 1rem;
}

.github-docs-nav-directory-title {
  display: block;
  font-weight: 600;
  color: #24292e;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  padding: 0.5rem 0.75rem;
  border-radius: 6px;
  background: #e1e4e8;
}

.github-docs-nav-file {
  margin-bottom: 2px;
}

.github-docs-nav-link {
  display: block;
  padding: 0.5rem 0.75rem;
  color: #586069;
  text-decoration: none;
  font-size: 0.875rem;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.github-docs-nav-link:hover {
  background: #f3f4f6;
  color: #24292e;
}

.github-docs-nav-file.is-active .github-docs-nav-link {
  background: #0366d6;
  color: white;
  font-weight: 500;
}

.github-docs-nav-error,
.github-docs-nav-empty {
  padding: 1rem 0.75rem;
  color: #6a737d;
  font-size: 0.875rem;
  font-style: italic;
}

/* Main Content Styles */
.github-docs-main {
  flex: 1;
  padding: 2rem 3rem;
  min-width: 0;
}

.github-docs-intro {
  background: #f6f8fa;
  border: 1px solid #e1e4e8;
  border-radius: 6px;
  padding: 1.5rem;
  margin-bottom: 2rem;
  font-size: 1.1rem;
  line-height: 1.6;
}

.github-docs-welcome h1 {
  font-size: 2.5rem;
  font-weight: 600;
  color: #24292e;
  margin: 0 0 1rem 0;
}

.github-docs-welcome > p {
  font-size: 1.1rem;
  color: #586069;
  margin-bottom: 2rem;
  line-height: 1.6;
}

.github-docs-sections {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 1.5rem;
  margin-top: 2rem;
}

.github-docs-section-card {
  background: white;
  border: 1px solid #e1e4e8;
  border-radius: 6px;
  padding: 1.5rem;
  transition: border-color 0.2s ease;
}

.github-docs-section-card:hover {
  border-color: #0366d6;
}

.github-docs-section-card h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #24292e;
  margin: 0 0 1rem 0;
}

.github-docs-section-files {
  list-style: none;
  margin: 0;
  padding: 0;
}

.github-docs-section-files li {
  margin-bottom: 0.5rem;
}

.github-docs-section-files a {
  color: #0366d6;
  text-decoration: none;
  font-size: 0.925rem;
}

.github-docs-section-files a:hover {
  text-decoration: underline;
}

.github-docs-more {
  color: #6a737d;
  font-style: italic;
  font-size: 0.875rem;
}

.github-docs-error {
  background: #fff5f5;
  border: 1px solid #feb2b2;
  color: #c53030;
  padding: 1rem;
  border-radius: 6px;
  margin: 1rem 0;
}

/* Mobile Responsive */
@media (max-width: 1024px) {
  .github-docs-layout {
    flex-direction: column;
  }
  
  .github-docs-sidebar {
    width: 100%;
    position: static;
    max-height: none;
    border-right: none;
    border-bottom: 1px solid #e1e4e8;
  }
  
  .github-docs-main {
    padding: 1.5rem;
  }
  
  .github-docs-sections {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .github-docs-sidebar {
    padding: 1rem 0;
  }
  
  .github-docs-sidebar-header {
    padding: 0 1rem 1rem;
  }
  
  .github-docs-navigation {
    padding: 0 0.75rem;
  }
  
  .github-docs-main {
    padding: 1rem;
  }
  
  .github-docs-welcome h1 {
    font-size: 2rem;
  }
}
</style>

<?php snippet('footer') ?>
