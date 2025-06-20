<?php snippet('header') ?>

<main class="main" role="main">
  <article class="github-doc-page">
    <nav class="github-doc-nav">
      <a href="<?= $page->parent()->url() ?>" class="github-doc-back">
        ← Back to <?= $page->parent()->title() ?>
      </a>
    </nav>

    <header class="github-doc-header">
      <h1><?= $page->title()->html() ?></h1>
      
      <div class="github-doc-meta">
        <span class="github-file-path">
          <strong>File:</strong> <?= $page->github_file_path() ?>
        </span>
        <span class="github-repo-link">
          <a href="<?= $page->github_raw_url() ?>" target="_blank" rel="noopener">
            View on GitHub
          </a>
        </span>
      </div>
    </header>

    <div class="github-doc-content">
      <?php 
      $content = $page->markdown_content()->value();
      
      // Process Mermaid diagrams if enabled
      if ($page->parent()->mermaid_support()->toBool()) {
        $content = processMermaidDiagrams($content);
      }
      
      // Process images to use GitHub raw URLs
      $repoInfo = json_decode($page->repo_info()->value(), true);
      if ($repoInfo) {
        $content = processGithubImages($content, $repoInfo, $page->parent()->github_branch()->or('main'));
      }
      
      echo kirbytext($content);
      ?>
    </div>
  </article>
</main>

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
