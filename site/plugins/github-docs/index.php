<?php

require_once __DIR__ . '/classes/GitHubClient.php';

use GitHubDocs\GitHubClient;
use Kirby\Toolkit\Str;

Kirby::plugin('unibe/github-docs', [
    'blueprints' => [
        'pages/github-docs' => __DIR__ . '/blueprints/github-docs.yml',
        'pages/github-doc-page' => __DIR__ . '/blueprints/github-doc-page.yml'
    ],    'templates' => [
        'github-docs' => __DIR__ . '/templates/github-docs.php',
        'github-doc-page' => __DIR__ . '/templates/github-doc-page-synced.php',
        'github-api-test' => __DIR__ . '/templates/github-api-test.php',
        'plugin-test' => __DIR__ . '/templates/plugin-test.php'
    ],    'snippets' => [
        'mermaid-renderer' => __DIR__ . '/snippets/mermaid-renderer.php'
    ],
    'assets' => [
        'js/github-docs-panel.js' => __DIR__ . '/assets/js/github-docs-panel.js'
    ],'routes' => [
        [
            'pattern' => 'plugin-test',
            'action' => function () {
                $testPage = new \Kirby\Cms\Page([
                    'slug' => 'plugin-test',
                    'template' => 'plugin-test',
                    'content' => [
                        'title' => 'Plugin Test'
                    ]
                ]);
                
                return site()->visit($testPage);
            }
        ],
        [            'pattern' => 'simple-test',
            'action' => function () {
                return new \Kirby\Http\Response('<h1>Simple Route Test</h1><p>If you see this, the routing is working!</p>', 'text/html');
            }
        ],
        [
            'pattern' => 'test-sync',
            'action' => function () {
                // Create a mock parent page for testing sync
                $mockParent = new \Kirby\Cms\Page([
                    'slug' => 'test-sync',
                    'template' => 'github-docs',
                    'content' => [
                        'title' => 'Test Sync',
                        'github_repo_url' => 'https://github.com/microsoft/vscode',
                        'github_branch' => 'main',
                        'github_docs_path' => 'docs'
                    ]
                ]);
                
                try {
                    $result = syncGithubDocs($mockParent);
                    
                    $html = '<h1>Sync Test Results</h1>';
                    $html .= '<pre>' . json_encode($result, JSON_PRETTY_PRINT) . '</pre>';
                    
                    return new \Kirby\Http\Response($html, 'text/html');
                    
                } catch (Exception $e) {
                    return new \Kirby\Http\Response('<h1>Sync Test Error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>', 'text/html');
                }
            }
        ]
    ],
    'api' => [
        'routes' => [
            [
                'pattern' => 'github-docs/sync',
                'method' => 'POST',
                'action' => function () {
                    $parentSlug = get('parent');
                    if (!$parentSlug) {
                        return ['error' => 'Parent slug required'];
                    }
                    
                    $parent = site()->find($parentSlug);
                    if (!$parent || $parent->intendedTemplate() !== 'github-docs') {
                        return ['error' => 'Parent page not found or invalid template'];
                    }
                    
                    try {
                        $result = syncGithubDocs($parent);
                        return $result;
                    } catch (Exception $e) {
                        return ['error' => $e->getMessage()];
                    }
                }
            ]
        ]
    ],
    'hooks' => [
        'route:after' => function () {
            // Check if we need to run scheduled sync
            checkScheduledSync();
        }
    ],
    'pagesMethods' => [
        'githubDocs' => function () {
            return $this->filterBy('intendedTemplate', 'github-docs');
        }
    ]
]);

/**
 * Sync GitHub documentation to Kirby content folder
 */
function syncGithubDocs($parent) {
    $repoUrl = $parent->github_repo_url()->value();
    $branch = $parent->github_branch()->or('main')->value();
    $docsPath = $parent->github_docs_path()->or('docs')->value();
    $token = $parent->github_api_token()->value();
    
    if (empty($repoUrl)) {
        throw new Exception('No repository URL configured');
    }
    
    $client = new GitHubClient($repoUrl, $branch, $token);
    $markdownFiles = $client->getMarkdownFiles($docsPath);
    
    $syncResult = [
        'success' => true,
        'created' => 0,
        'updated' => 0,
        'deleted' => 0,
        'errors' => []
    ];
    
    // Get existing synced pages
    $existingPages = $parent->children()->filterBy('github_synced', true);
    $processedSlugs = [];
    
    foreach ($markdownFiles as $fileInfo) {
        try {
            $fileContent = $client->getFileContent($fileInfo['path']);
            if (!$fileContent) {
                continue;
            }
            
            // Extract title and create slug
            $title = $client->extractTitle($fileContent['content'], basename($fileInfo['path'], '.md'));
            $slug = Str::slug(basename($fileInfo['path'], '.md'));
            $processedSlugs[] = $slug;
            
            // Check if page already exists
            $existingPage = $parent->find($slug);
            
            $pageData = [
                'title' => $title,
                'text' => $client->parseMarkdown($fileContent['content'], dirname($fileInfo['path'])),
                'github_path' => $fileInfo['path'],
                'github_synced' => 'true',
                'github_last_sync' => date('Y-m-d H:i:s'),
                'github_sha' => $fileInfo['sha'] ?? '',
                'template' => 'github-doc-page'
            ];
            
            if ($existingPage) {
                // Update existing page
                $existingPage->update($pageData);
                $syncResult['updated']++;
            } else {
                // Create new page
                $parent->createChild([
                    'slug' => $slug,
                    'template' => 'github-doc-page',
                    'content' => $pageData
                ]);
                $syncResult['created']++;
            }
            
        } catch (Exception $e) {
            $syncResult['errors'][] = "Error processing {$fileInfo['path']}: " . $e->getMessage();
        }
    }
    
    // Remove pages that no longer exist in GitHub
    foreach ($existingPages as $page) {
        $pageSlug = $page->slug();
        if (!in_array($pageSlug, $processedSlugs)) {
            try {
                $page->delete();
                $syncResult['deleted']++;
            } catch (Exception $e) {
                $syncResult['errors'][] = "Error deleting page {$pageSlug}: " . $e->getMessage();
            }
        }
    }
    
    // Update parent's last sync time
    $parent->update([
        'github_last_sync' => date('Y-m-d H:i:s')
    ]);
    
    return $syncResult;
}

/**
 * Check if scheduled sync should run
 */
function checkScheduledSync() {
    $githubDocsPages = site()->pages()->filterBy('intendedTemplate', 'github-docs');
    
    foreach ($githubDocsPages as $page) {
        $syncInterval = $page->github_sync_interval()->or(24)->toInt(); // hours
        $lastSync = $page->github_last_sync()->value();
        
        if (empty($lastSync)) {
            continue; // Never synced, skip automatic sync
        }
        
        $lastSyncTime = strtotime($lastSync);
        $nextSyncTime = $lastSyncTime + ($syncInterval * 3600);
        
        if (time() >= $nextSyncTime) {
            try {
                syncGithubDocs($page);
            } catch (Exception $e) {
                // Log error but don't interrupt normal page loading
                error_log("GitHub Docs automatic sync failed for {$page->slug()}: " . $e->getMessage());
            }
        }
    }
}

/**
 * Get all GitHub documentation pages for a parent
 */
function githubDocsPages($parent) {
    return $parent->children()->filterBy('github_synced', true);
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
