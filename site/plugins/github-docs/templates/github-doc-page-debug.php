<?php 
snippet('header');

// Debug: Show what we have
echo "<h1>Debug Individual Page</h1>";
echo "<p>Page slug: " . htmlspecialchars($page->slug()) . "</p>";
echo "<p>Page title: " . htmlspecialchars($page->title()) . "</p>";
echo "<p>Page template: " . htmlspecialchars($page->intendedTemplate()) . "</p>";
echo "<p>Parent: " . htmlspecialchars($page->parent()->title()) . "</p>";

// Test content
if ($page->markdown_content()->isNotEmpty()) {
    echo "<h2>Content exists</h2>";
    echo "<pre>" . htmlspecialchars(substr($page->markdown_content()->value(), 0, 200)) . "...</pre>";
} else {
    echo "<h2>No content found</h2>";
}

// Test repository info
$parent = $page->parent();
echo "<h2>Repository Configuration</h2>";
echo "<p>Repo URL: " . htmlspecialchars($parent->github_repo_url()->value()) . "</p>";
echo "<p>Branch: " . htmlspecialchars($parent->github_branch()->or('main')->value()) . "</p>";
echo "<p>Docs Path: " . htmlspecialchars($parent->github_docs_path()->or('docs')->value()) . "</p>";

// Test GitHubClient with detailed error reporting
try {
    $repoUrl = $parent->github_repo_url()->value();
    $branch = $parent->github_branch()->or('main')->value();
    $docsPath = $parent->github_docs_path()->or('docs')->value();
    $token = $parent->github_api_token()->value();
    
    echo "<h2>Testing GitHub API Connection</h2>";
    
    if (empty($repoUrl)) {
        echo "<p style='color: red;'>❌ No repository URL configured</p>";
    } else {
        echo "<p>✓ Repository URL: " . htmlspecialchars($repoUrl) . "</p>";
        
        $client = new \GitHubDocs\GitHubClient($repoUrl, $branch, $token);
        echo "<p>✓ GitHubClient created successfully</p>";
        
        $repoInfo = $client->getRepoInfo();
        echo "<p>✓ Owner: " . htmlspecialchars($repoInfo['owner']) . "</p>";
        echo "<p>✓ Repo: " . htmlspecialchars($repoInfo['repo']) . "</p>";
        echo "<p>✓ Branch: " . htmlspecialchars($repoInfo['branch']) . "</p>";
        
        // Test fetching directory contents
        echo "<h3>Testing Directory Contents</h3>";
        $contents = $client->getDirectoryContents($docsPath);
        
        if ($contents === null) {
            echo "<p style='color: red;'>❌ Failed to fetch directory contents</p>";
        } elseif (empty($contents)) {
            echo "<p style='color: orange;'>⚠️ Directory exists but is empty</p>";
        } else {
            echo "<p style='color: green;'>✓ Found " . count($contents) . " items in directory</p>";
            echo "<ul>";
            foreach (array_slice($contents, 0, 10) as $item) {
                echo "<li>" . htmlspecialchars($item['name']) . " (" . $item['type'] . ")</li>";
            }
            if (count($contents) > 10) {
                echo "<li>... and " . (count($contents) - 10) . " more items</li>";
            }
            echo "</ul>";
        }
        
        // Test fetching markdown files
        echo "<h3>Testing Markdown Files</h3>";
        $markdownFiles = $client->getMarkdownFiles($docsPath);
        
        if (empty($markdownFiles)) {
            echo "<p style='color: red;'>❌ No markdown files found</p>";
        } else {
            echo "<p style='color: green;'>✓ Found " . count($markdownFiles) . " markdown files</p>";
            echo "<ul>";
            foreach (array_slice($markdownFiles, 0, 10) as $file) {
                echo "<li>" . htmlspecialchars($file['path']) . "</li>";
            }
            if (count($markdownFiles) > 10) {
                echo "<li>... and " . (count($markdownFiles) - 10) . " more files</li>";
            }
            echo "</ul>";
        }
        
        // Test fetching specific file content
        $currentSlug = $page->slug();
        $targetFile = $docsPath . '/' . $currentSlug . '.md';
        
        echo "<h3>Testing File Content</h3>";
        echo "<p>Looking for file: " . htmlspecialchars($targetFile) . "</p>";
        
        $fileContent = $client->getFileContent($targetFile);
        if ($fileContent === null) {
            echo "<p style='color: red;'>❌ Failed to fetch file content</p>";
            
            // Try to find the file in our markdown files list
            foreach ($markdownFiles as $file) {
                $fileSlug = \Kirby\Toolkit\Str::slug(str_replace('.md', '', basename($file['path'])));
                if ($fileSlug === $currentSlug) {
                    echo "<p>Found matching file: " . htmlspecialchars($file['path']) . "</p>";
                    $fileContent = $client->getFileContent($file['path']);
                    break;
                }
            }
        }
        
        if ($fileContent) {
            echo "<p style='color: green;'>✓ File content fetched successfully</p>";
            echo "<p>File size: " . $fileContent['size'] . " bytes</p>";
            echo "<h4>Content preview:</h4>";
            echo "<pre style='background: #f5f5f5; padding: 1rem; max-height: 200px; overflow: auto;'>";
            echo htmlspecialchars(substr($fileContent['content'], 0, 500));
            echo "...</pre>";
        } else {
            echo "<p style='color: red;'>❌ Still failed to fetch file content</p>";
        }
    }
} catch (Exception $e) {
    echo "<h2 style='color: red;'>GitHub API Error</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
?>

<h1>Individual Documentation Page</h1>
<p>This is a simplified debug version. If you see this, the page is loading.</p>

<h2>Page Information</h2>
<ul>
    <li><strong>Slug:</strong> <?= $page->slug() ?></li>
    <li><strong>Title:</strong> <?= $page->title() ?></li>
    <li><strong>Template:</strong> <?= $page->intendedTemplate() ?></li>
    <li><strong>Parent:</strong> <?= $page->parent()->title() ?></li>
</ul>

<?php if ($page->markdown_content()->isNotEmpty()): ?>
<h2>Content Preview</h2>
<div style="background: #f5f5f5; padding: 1rem; border-radius: 4px; max-height: 300px; overflow: auto;">
    <?= kirbytext($page->markdown_content()) ?>
</div>
<?php else: ?>
<p><em>No markdown content available</em></p>
<?php endif ?>

<?php snippet('footer') ?>
