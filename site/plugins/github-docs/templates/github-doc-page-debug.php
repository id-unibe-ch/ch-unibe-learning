<?php 
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

// Test GitHubClient
try {
    $repoUrl = $parent->github_repo_url()->value();
    $branch = $parent->github_branch()->or('main')->value();
    $token = $parent->github_api_token()->value();
    
    if (!empty($repoUrl)) {
        $client = new \GitHubDocs\GitHubClient($repoUrl, $branch, $token);
        echo "<h2>GitHubClient working</h2>";
        echo "<p>Owner: " . $client->getRepoInfo()['owner'] . "</p>";
        echo "<p>Repo: " . $client->getRepoInfo()['repo'] . "</p>";
    } else {
        echo "<h2>No repository URL configured</h2>";
    }
} catch (Exception $e) {
    echo "<h2>GitHubClient Error</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}

snippet('header') ?>

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
