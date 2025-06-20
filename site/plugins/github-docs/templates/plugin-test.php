<?php
// Simple test page to check if our plugin is working
snippet('header');
?>

<h1>Plugin Test</h1>

<p>This page tests if our GitHub Docs plugin is loaded and working.</p>

<h2>Plugin Registration Test</h2>
<?php
// Test if our plugin is registered
$plugins = kirby()->plugins();
if (isset($plugins['unibe/github-docs'])) {
    echo "<p style='color: green;'>✓ Plugin is registered</p>";
} else {
    echo "<p style='color: red;'>❌ Plugin is NOT registered</p>";
}

// Test if GitHubClient class is available
if (class_exists('\GitHubDocs\GitHubClient')) {
    echo "<p style='color: green;'>✓ GitHubClient class is available</p>";
} else {
    echo "<p style='color: red;'>❌ GitHubClient class is NOT available</p>";
}

// Test if routes are registered
$routes = kirby()->routes();
echo "<p>Total routes registered: " . count($routes) . "</p>";

// Check if we can find a github-docs page
$githubDocsPages = site()->pages()->filterBy('intendedTemplate', 'github-docs');
echo "<p>GitHub docs pages found: " . $githubDocsPages->count() . "</p>";

if ($githubDocsPages->count() > 0) {
    foreach ($githubDocsPages as $docPage) {
        echo "<p>Found: <a href='" . $docPage->url() . "'>" . $docPage->title() . "</a> (slug: " . $docPage->slug() . ")</p>";
    }
}
?>

<h2>Test Routes</h2>
<ul>
    <li><a href="/doc-test/github-docs/budget">Individual Page Test</a></li>
    <li><a href="/doc-test/github-api-test">API Test</a></li>
</ul>

<h2>Environment Information</h2>
<ul>
    <li><strong>Kirby Version:</strong> <?= kirby()->version() ?></li>
    <li><strong>PHP Version:</strong> <?= phpversion() ?></li>
    <li><strong>Current URL:</strong> <?= kirby()->request()->url() ?></li>
</ul>

<?php snippet('footer'); ?>
