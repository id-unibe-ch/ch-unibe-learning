<?php
// Simple test to verify GitHub API connectivity
snippet('header');

echo "<h1>GitHub API Test</h1>";

// Test with hardcoded values first
$testRepoUrl = 'https://github.com/octocat/Hello-World';
$testBranch = 'master';
$testDocsPath = '';

try {
    echo "<h2>Testing with sample repository</h2>";
    $client = new \GitHubDocs\GitHubClient($testRepoUrl, $testBranch, null);
    
    echo "<p>✓ Client created successfully</p>";
    
    $repoInfo = $client->getRepoInfo();
    echo "<p>Repository: " . htmlspecialchars($repoInfo['owner']) . "/" . htmlspecialchars($repoInfo['repo']) . "</p>";
    
    // Test getting directory contents
    $contents = $client->getDirectoryContents($testDocsPath);
    
    if ($contents) {
        echo "<p>✓ API connection successful</p>";
        echo "<p>Found " . count($contents) . " items in repository root</p>";
        echo "<ul>";
        foreach (array_slice($contents, 0, 5) as $item) {
            echo "<li>" . htmlspecialchars($item['name']) . " (" . $item['type'] . ")</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>❌ Failed to fetch contents</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Now test with actual page configuration
if (isset($page) && $page->parent()) {
    $parent = $page->parent();
    $repoUrl = $parent->github_repo_url()->value();
    $branch = $parent->github_branch()->or('main')->value();
    $docsPath = $parent->github_docs_path()->or('docs')->value();
    $token = $parent->github_api_token()->value();
    
    echo "<h2>Testing with page configuration</h2>";
    echo "<p>Repo URL: " . htmlspecialchars($repoUrl) . "</p>";
    echo "<p>Branch: " . htmlspecialchars($branch) . "</p>";
    echo "<p>Docs Path: " . htmlspecialchars($docsPath) . "</p>";
    echo "<p>Token: " . (empty($token) ? 'Not set' : 'Set (hidden)') . "</p>";
    
    if (!empty($repoUrl)) {
        try {
            $client = new \GitHubDocs\GitHubClient($repoUrl, $branch, $token);
            $contents = $client->getDirectoryContents($docsPath);
            
            if ($contents) {
                echo "<p>✓ Successfully connected to configured repository</p>";
                echo "<p>Found " . count($contents) . " items in docs directory</p>";
            } else {
                echo "<p>❌ Failed to fetch from configured repository</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>Error with configured repository: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}

snippet('footer');
?>
