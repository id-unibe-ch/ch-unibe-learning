<?php

require_once __DIR__ . '/classes/GitHubClient.php';

use GitHubDocs\GitHubClient;
use GitHubDocs\GitHubDocPageFactory;
use Kirby\Toolkit\Str;

Kirby::plugin('unibe/github-docs', [
    'blueprints' => [
        'pages/github-docs' => __DIR__ . '/blueprints/github-docs.yml',
        'pages/github-doc-page' => __DIR__ . '/blueprints/github-doc-page.yml'
    ],
    'templates' => [
        'github-docs' => __DIR__ . '/templates/github-docs.php',
        'github-doc-page' => __DIR__ . '/templates/github-doc-page.php'
    ],
    'snippets' => [
        'mermaid-renderer' => __DIR__ . '/snippets/mermaid-renderer.php'
    ],    'routes' => [
        [
            'pattern' => '([^/]+)/github-docs/([^/]+)',
            'action' => function ($parentSlug, $docPath) {
                $parent = site()->find($parentSlug);
                
                if (!$parent || $parent->intendedTemplate() !== 'github-docs') {
                    return false;
                }
                
                $virtualPage = createGithubDocPage($parent, $docPath);
                
                if (!$virtualPage) {
                    return false;
                }
                
                return site()->visit($virtualPage);
            }
        ]
    ],
    'pagesMethods' => [
        'githubDocs' => function () {
            return $this->filterBy('intendedTemplate', 'github-docs');
        }
    ]
]);

/**
 * Create a virtual GitHub documentation page
 */
function createGithubDocPage($parent, $docPath) {
    $repoUrl = $parent->github_repo_url()->value();
    $branch = $parent->github_branch()->or('main')->value();
    $docsPath = $parent->github_docs_path()->or('docs')->value();
    $token = $parent->github_api_token()->value();
    
    if (empty($repoUrl)) {
        return null;
    }
    
    try {
        $client = new GitHubClient($repoUrl, $branch, $token);
        
        // Build full file path
        $filePath = $docsPath . '/' . $docPath;
        if (!Str::endsWith($filePath, '.md')) {
            $filePath .= '.md';
        }
        
        // Create virtual page using the factory
        return GitHubDocPageFactory::create($parent, $filePath, $client);
        
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Get all GitHub documentation pages for a parent
 */
function githubDocsPages($parent) {
    $repoUrl = $parent->github_repo_url()->value();
    $branch = $parent->github_branch()->or('main')->value();
    $docsPath = $parent->github_docs_path()->or('docs')->value();
    $token = $parent->github_api_token()->value();
    
    if (empty($repoUrl)) {
        return [];
    }
    
    try {
        $client = new GitHubClient($repoUrl, $branch, $token);
        return GitHubDocPageFactory::createFromDirectory($parent, $docsPath, $client);
        
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Parse GitHub URL to extract owner and repo
 */
function parseGithubUrl($url) {
    $pattern = '/github\.com\/([^\/]+)\/([^\/]+)/';
    if (preg_match($pattern, $url, $matches)) {
        return [
            'owner' => $matches[1],
            'repo' => rtrim($matches[2], '.git')
        ];
    }
    return null;
}

/**
 * Extract title from markdown content
 */
function extractTitleFromMarkdown($content) {
    $lines = explode("\n", $content);
    foreach ($lines as $line) {
        $line = trim($line);
        if (Str::startsWith($line, '# ')) {
            return trim(substr($line, 2));
        }
    }
    return null;
}
