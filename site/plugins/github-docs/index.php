<?php

require_once __DIR__ . '/classes/GitHubClient.php';

use GitHubDocs\GitHubClient;
use GitHubDocs\GitHubDocPageFactory;
use Kirby\Toolkit\Str;

Kirby::plugin('unibe/github-docs', [
    'blueprints' => [
        'pages/github-docs' => __DIR__ . '/blueprints/github-docs.yml',
        'pages/github-doc-page' => __DIR__ . '/blueprints/github-doc-page.yml'
    ],    'templates' => [
        'github-docs' => __DIR__ . '/templates/github-docs.php',
        'github-doc-page' => __DIR__ . '/templates/github-doc-page-debug.php',
        'github-api-test' => __DIR__ . '/templates/github-api-test.php',
        'plugin-test' => __DIR__ . '/templates/plugin-test.php'
    ],
    'snippets' => [
        'mermaid-renderer' => __DIR__ . '/snippets/mermaid-renderer.php'
    ],    'routes' => [
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
        [
            'pattern' => 'simple-test',
            'action' => function () {
                return new \Kirby\Http\Response('<h1>Simple Route Test</h1><p>If you see this, the routing is working!</p>', 'text/html');
            }
        ],
        [
            'pattern' => '([^/]+)/github-docs/([^/]+)',
            'action' => function ($parentSlug, $docPath) {
                error_log("GitHub Docs Route: Parent=$parentSlug, Doc=$docPath");
                
                $parent = site()->find($parentSlug);
                
                if (!$parent) {
                    error_log("GitHub Docs Route: Parent page not found");
                    return new \Kirby\Http\Response('<h1>Error</h1><p>Parent page not found: ' . htmlspecialchars($parentSlug) . '</p>', 'text/html');
                }
                
                if ($parent->intendedTemplate() !== 'github-docs') {
                    error_log("GitHub Docs Route: Parent is not github-docs template");
                    return new \Kirby\Http\Response('<h1>Error</h1><p>Parent page is not github-docs template. Found: ' . htmlspecialchars($parent->intendedTemplate()) . '</p>', 'text/html');
                }
                
                $virtualPage = createGithubDocPage($parent, $docPath);
                
                if (!$virtualPage) {
                    error_log("GitHub Docs Route: Failed to create virtual page");
                    return new \Kirby\Http\Response('<h1>Error</h1><p>Failed to create virtual page for: ' . htmlspecialchars($docPath) . '</p>', 'text/html');
                }
                
                error_log("GitHub Docs Route: Success, visiting virtual page");
                return site()->visit($virtualPage);
            }
        ],
        [
            'pattern' => '([^/]+)/github-api-test',
            'action' => function ($parentSlug) {
                $parent = site()->find($parentSlug);
                
                if (!$parent || $parent->intendedTemplate() !== 'github-docs') {
                    return new \Kirby\Http\Response('<h1>Error</h1><p>Parent page not found or not github-docs template</p>', 'text/html');
                }
                
                // Create a simple test page
                $testPage = new \Kirby\Cms\Page([
                    'slug' => 'github-api-test',
                    'template' => 'github-api-test',
                    'parent' => $parent,
                    'content' => [
                        'title' => 'GitHub API Test'
                    ]
                ]);
                
                return site()->visit($testPage);
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
        error_log("GitHub Docs: No repository URL configured");
        return null;
    }
    
    try {
        $client = new GitHubClient($repoUrl, $branch, $token);
        
        // Build full file path
        $filePath = $docsPath . '/' . $docPath;
        if (!Str::endsWith($filePath, '.md')) {
            $filePath .= '.md';
        }
        
        error_log("GitHub Docs: Attempting to create page for " . $filePath);
        
        // Try to get file content directly first
        $fileData = $client->getFileContent($filePath);
        
        if (!$fileData) {
            error_log("GitHub Docs: File not found at " . $filePath);
            
            // Try to find the file in markdown files list
            $markdownFiles = $client->getMarkdownFiles($docsPath);
            foreach ($markdownFiles as $file) {
                $fileSlug = Str::slug(str_replace('.md', '', basename($file['path'])));
                if ($fileSlug === $docPath) {
                    error_log("GitHub Docs: Found file via search: " . $file['path']);
                    $fileData = $client->getFileContent($file['path']);
                    $filePath = $file['path'];
                    break;
                }
            }
        }
        
        if (!$fileData) {
            error_log("GitHub Docs: Still no file data found");
            return null;
        }
        
        // Create simple virtual page
        $title = $client->extractTitle($fileData['content'], basename($filePath, '.md'));
        $slug = Str::slug(basename($filePath, '.md'));
        
        $virtualPage = new \Kirby\Cms\Page([
            'slug' => $slug,
            'template' => 'github-doc-page',
            'parent' => $parent,
            'content' => [
                'title' => $title,
                'markdown_content' => $fileData['content'],
                'github_file_path' => $filePath,
                'github_raw_url' => $fileData['download_url'],
                'repo_info' => json_encode($client->getRepoInfo())
            ]
        ]);
        
        error_log("GitHub Docs: Virtual page created successfully");
        return $virtualPage;
        
    } catch (Exception $e) {
        error_log("GitHub Docs: Exception creating page: " . $e->getMessage());
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
