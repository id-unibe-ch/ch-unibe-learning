<?php snippet('header') ?>

<!-- GitHub Documentation Styles -->
<link rel="stylesheet" href="<?= url('site/plugins/github-docs/assets/css/github-docs.css') ?>">

<main class="github-docs-layout">
  <!-- Left Sidebar Navigation -->
  <aside class="github-docs-sidebar">
    <div class="github-docs-sidebar-header">
      <h2>
        <a href="<?= $page->parent()->url() ?>" class="github-docs-breadcrumb">
          <?= $page->parent()->title()->html() ?>
        </a>
      </h2>
      <div class="github-docs-repo-info">
        <a href="<?= $page->parent()->github_repo_url() ?>" target="_blank" rel="noopener" class="github-docs-repo-link">
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
      $parent = $page->parent();
      $repoUrl = $parent->github_repo_url()->value();
      $branch = $parent->github_branch()->or('main')->value();
      $docsPath = $parent->github_docs_path()->or('docs')->value();
      $token = $parent->github_api_token()->value();
      $currentSlug = $page->slug();
      
      if (!empty($repoUrl)):
        try {
          $client = new \GitHubDocs\GitHubClient($repoUrl, $branch, $token);
          $markdownFiles = $client->getMarkdownFiles($docsPath);
          $navigationTree = $client->buildNavigationTree($markdownFiles, $docsPath);
          
          function renderNavigation($tree, $currentPage, $currentSlug, $level = 0) {
            if (empty($tree)) return;
            
            echo '<ul class="github-docs-nav-list" data-level="' . $level . '">';
            
            foreach ($tree as $key => $item) {
              if ($item['type'] === 'directory') {
                echo '<li class="github-docs-nav-item github-docs-nav-directory">';
                echo '<span class="github-docs-nav-directory-title">' . htmlspecialchars($item['title']) . '</span>';
                renderNavigation($item['children'], $currentPage, $currentSlug, $level + 1);
                echo '</li>';
              } else {
                $docUrl = $currentPage->parent()->url() . '/github-docs/' . \Kirby\Toolkit\Str::slug($item['slug']);
                $isActive = \Kirby\Toolkit\Str::slug($item['slug']) === $currentSlug;
                
                echo '<li class="github-docs-nav-item github-docs-nav-file' . ($isActive ? ' is-active' : '') . '">';
                echo '<a href="' . $docUrl . '" class="github-docs-nav-link">';
                echo htmlspecialchars($item['title']);
                echo '</a>';
                echo '</li>';
              }
            }
            
            echo '</ul>';
          }
          
          renderNavigation($navigationTree, $page, $currentSlug);
          
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
      <!-- Breadcrumb -->
      <nav class="github-docs-breadcrumb-nav">
        <a href="<?= $page->parent()->url() ?>" class="github-docs-breadcrumb-link">Documentation</a>
        <span class="github-docs-breadcrumb-separator">→</span>
        <span class="github-docs-breadcrumb-current"><?= $page->title()->html() ?></span>
      </nav>

      <!-- Page Header -->
      <header class="github-docs-page-header">
        <h1><?= $page->title()->html() ?></h1>
        
        <div class="github-docs-page-meta">
          <span class="github-docs-file-path">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
              <path d="M1.5 1a.5.5 0 0 0 0 1h2.25a.75.75 0 0 1 .75.75v9.5a.75.75 0 0 1-.75.75H1.5a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1h-2.25a.75.75 0 0 1-.75-.75v-9.5a.75.75 0 0 1 .75-.75H14.5a.5.5 0 0 0 0-1H1.5Z"/>
            </svg>
            <?= $page->github_file_path() ?>
          </span>
          <a href="<?= $page->github_raw_url() ?>" target="_blank" rel="noopener" class="github-docs-external-link">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
              <path d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
            </svg>
            View on GitHub
          </a>
        </div>
      </header>

      <!-- Page Content -->
      <article class="github-docs-article">
        <?php 
        $content = $page->markdown_content()->value();
        
        // Include Mermaid snippet if enabled
        if ($page->parent()->mermaid_support()->toBool()) {
          snippet('mermaid-renderer');
          $content = processMermaidInMarkdown($content);
        }
        
        // Process images to use GitHub raw URLs
        $repoInfo = json_decode($page->repo_info()->value(), true);
        if ($repoInfo) {
          $content = processGithubImages($content, $repoInfo, $page->parent()->github_branch()->or('main'));
        }
        
        echo kirbytext($content);
        ?>
      </article>

      <!-- Page Navigation -->
      <nav class="github-docs-page-nav">
        <?php 
        // Get previous and next pages
        try {
          $client = new \GitHubDocs\GitHubClient($repoUrl, $branch, $token);
          $markdownFiles = $client->getMarkdownFiles($docsPath);
          
          // Find current page index
          $currentIndex = -1;
          foreach ($markdownFiles as $index => $file) {
            $slug = \Kirby\Toolkit\Str::slug(str_replace('.md', '', basename($file['path'])));
            if ($slug === $currentSlug) {
              $currentIndex = $index;
              break;
            }
          }
          
          if ($currentIndex >= 0):
            $prevFile = $currentIndex > 0 ? $markdownFiles[$currentIndex - 1] : null;
            $nextFile = $currentIndex < count($markdownFiles) - 1 ? $markdownFiles[$currentIndex + 1] : null;
        ?>
          <div class="github-docs-page-nav-links">
            <?php if ($prevFile): 
              $prevSlug = \Kirby\Toolkit\Str::slug(str_replace('.md', '', basename($prevFile['path'])));
              $prevUrl = $page->parent()->url() . '/github-docs/' . $prevSlug;
              $prevTitle = ucfirst(str_replace(['-', '_'], ' ', $prevSlug));
            ?>
              <a href="<?= $prevUrl ?>" class="github-docs-page-nav-prev">
                <span class="github-docs-page-nav-direction">← Previous</span>
                <span class="github-docs-page-nav-title"><?= htmlspecialchars($prevTitle) ?></span>
              </a>
            <?php endif ?>
            
            <?php if ($nextFile): 
              $nextSlug = \Kirby\Toolkit\Str::slug(str_replace('.md', '', basename($nextFile['path'])));
              $nextUrl = $page->parent()->url() . '/github-docs/' . $nextSlug;
              $nextTitle = ucfirst(str_replace(['-', '_'], ' ', $nextSlug));
            ?>
              <a href="<?= $nextUrl ?>" class="github-docs-page-nav-next">
                <span class="github-docs-page-nav-direction">Next →</span>
                <span class="github-docs-page-nav-title"><?= htmlspecialchars($nextTitle) ?></span>
              </a>
            <?php endif ?>
          </div>
        <?php endif ?>
        <?php } catch (Exception $e) { /* Silent fail */ } ?>
      </nav>    </div>
  </div>
</main>

<!-- GitHub Documentation JavaScript -->
<script src="<?= url('site/plugins/github-docs/assets/js/github-docs.js') ?>"></script>

<?php snippet('footer') ?>

<style>
.github-doc-page {
  max-width: 900px;
  margin: 0 auto;
  padding: 2rem;
}

.github-doc-nav {
  margin-bottom: 2rem;
}

.github-doc-back {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: #0366d6;
  text-decoration: none;
  font-weight: 500;
}

.github-doc-back:hover {
  text-decoration: underline;
}

.github-doc-header {
  margin-bottom: 3rem;
  border-bottom: 1px solid #e1e4e8;
  padding-bottom: 2rem;
}

.github-doc-header h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  color: #24292e;
  line-height: 1.25;
}

.github-doc-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  font-size: 0.9rem;
  color: #586069;
}

.github-doc-meta a {
  color: #0366d6;
  text-decoration: none;
}

.github-doc-meta a:hover {
  text-decoration: underline;
}

.github-doc-content {
  line-height: 1.6;
  color: #24292e;
}

.github-doc-content h1,
.github-doc-content h2,
.github-doc-content h3,
.github-doc-content h4,
.github-doc-content h5,
.github-doc-content h6 {
  margin-top: 2rem;
  margin-bottom: 1rem;
  font-weight: 600;
  line-height: 1.25;
}

.github-doc-content h1 {
  font-size: 2rem;
  border-bottom: 1px solid #e1e4e8;
  padding-bottom: 0.3rem;
}

.github-doc-content h2 {
  font-size: 1.5rem;
  border-bottom: 1px solid #e1e4e8;
  padding-bottom: 0.3rem;
}

.github-doc-content h3 {
  font-size: 1.25rem;
}

.github-doc-content p {
  margin-bottom: 1rem;
}

.github-doc-content ul,
.github-doc-content ol {
  margin-bottom: 1rem;
  padding-left: 2rem;
}

.github-doc-content li {
  margin-bottom: 0.25rem;
}

.github-doc-content pre {
  background: #f6f8fa;
  border-radius: 6px;
  padding: 1rem;
  overflow-x: auto;
  font-size: 0.875rem;
  line-height: 1.45;
  margin-bottom: 1rem;
}

.github-doc-content code {
  background: #f6f8fa;
  padding: 0.2em 0.4em;
  border-radius: 3px;
  font-size: 0.875rem;
}

.github-doc-content pre code {
  background: none;
  padding: 0;
}

.github-doc-content blockquote {
  border-left: 4px solid #dfe2e5;
  padding-left: 1rem;
  margin: 1rem 0;
  color: #6a737d;
}

.github-doc-content table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1rem;
}

.github-doc-content th,
.github-doc-content td {
  border: 1px solid #dfe2e5;
  padding: 6px 13px;
  text-align: left;
}

.github-doc-content th {
  background: #f6f8fa;
  font-weight: 600;
}

.github-doc-content img {
  max-width: 100%;
  height: auto;
  border-radius: 6px;
  margin: 1rem 0;
}

/* Mermaid diagram styles */
.mermaid-diagram {
  text-align: center;
  margin: 2rem 0;
  padding: 1rem;
  background: #f6f8fa;
  border-radius: 6px;
  border: 1px solid #e1e4e8;
}

@media (max-width: 768px) {
  .github-doc-page {
    padding: 1rem;
  }
  
  .github-doc-header h1 {
    font-size: 2rem;
  }
  
  .github-doc-meta {
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .github-doc-content pre {
    font-size: 0.8rem;
  }
}
</style>

<!-- Mermaid JS for diagram rendering -->
<?php if ($page->parent()->mermaid_support()->toBool()): ?>
<script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
<script>
  mermaid.initialize({
    startOnLoad: true,
    theme: 'default',
    themeVariables: {
      fontFamily: 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
    }
  });
</script>
<?php endif ?>

<?php snippet('footer') ?>

<?php
/**
 * Process Mermaid diagrams in markdown content
 */
function processMermaidDiagrams($content) {
  // Replace ```mermaid code blocks with Mermaid divs
  $content = preg_replace_callback(
    '/```mermaid\s*\n(.*?)\n```/s',
    function($matches) {
      $diagramCode = trim($matches[1]);
      return '<div class="mermaid-diagram">' . htmlspecialchars($diagramCode) . '</div>';
    },
    $content
  );
  
  return $content;
}

/**
 * Process GitHub images to use raw URLs
 */
function processGithubImages($content, $repoInfo, $branch) {
  // Replace relative image paths with GitHub raw URLs
  $content = preg_replace_callback(
    '/!\[([^\]]*)\]\(([^)]+)\)/',
    function($matches) use ($repoInfo, $branch) {
      $alt = $matches[1];
      $src = $matches[2];
      
      // If it's already a full URL, leave it alone
      if (strpos($src, 'http') === 0) {
        return $matches[0];
      }
      
      // Convert to GitHub raw URL
      $rawUrl = "https://raw.githubusercontent.com/{$repoInfo['owner']}/{$repoInfo['repo']}/{$branch}/" . ltrim($src, '/');
      
      return '![' . $alt . '](' . $rawUrl . ')';
    },
    $content
  );
  
  return $content;
}
?>
