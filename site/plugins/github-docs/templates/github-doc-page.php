<?php 
// Helper functions for this template
function processMermaidInMarkdown($content) {
  // Pattern to match mermaid code blocks
  $pattern = '/```mermaid\s*\n(.*?)\n```/s';
  
  $content = preg_replace_callback($pattern, function($matches) {
    $mermaidCode = trim($matches[1]);
    // Create a unique ID for each diagram
    $id = 'mermaid-' . uniqid();
    return '<div class="mermaid" id="' . $id . '">' . "\n" . $mermaidCode . "\n" . '</div>';
  }, $content);
  
  return $content;
}

function processGithubImages($content, $repoInfo, $branch = 'main') {
  if (!$repoInfo || !isset($repoInfo['owner']) || !isset($repoInfo['repo'])) {
    return $content;
  }
  
  $owner = $repoInfo['owner'];
  $repo = $repoInfo['repo'];
  
  // Pattern to match markdown images with relative paths
  $pattern = '/!\[([^\]]*)\]\((?!https?:\/\/)([^)]+)\)/';
  
  $content = preg_replace_callback($pattern, function($matches) use ($owner, $repo, $branch) {
    $altText = $matches[1];
    $imagePath = ltrim($matches[2], '/');
    
    // Convert to GitHub raw URL
    $rawUrl = "https://raw.githubusercontent.com/{$owner}/{$repo}/{$branch}/{$imagePath}";
    
    return "![{$altText}]({$rawUrl})";
  }, $content);
  
  return $content;
}

snippet('header') ?>

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
          // Check if GitHubClient class exists
          if (!class_exists('\GitHubDocs\GitHubClient')) {
            throw new Exception('GitHubClient class not found');
          }
          
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
      </header>      <!-- Page Content -->
      <article class="github-docs-article">
        <?php 
        try {
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
        } catch (Exception $e) {
          echo '<div class="error">Error loading content: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>
      </article>      <!-- Page Navigation -->
      <nav class="github-docs-page-nav">
        <?php 
        // Get previous and next pages
        if (!empty($repoUrl)):
          try {
            if (!class_exists('\GitHubDocs\GitHubClient')) {
              throw new Exception('GitHubClient class not found');
            }
            
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
          <?php } catch (Exception $e) { 
            echo '<div class="github-docs-nav-error">Error loading page navigation: ' . htmlspecialchars($e->getMessage()) . '</div>';
          } ?>
        <?php endif ?>
      </nav></nav>
    </div>
  </div>
</main>

<!-- GitHub Documentation JavaScript -->
<script src="<?= url('site/plugins/github-docs/assets/js/github-docs.js') ?>"></script>

<?php snippet('footer') ?>
