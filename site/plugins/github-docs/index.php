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
        ],        [
            'pattern' => '([^/]+)/github-docs/(.+)',
            'action' => function ($parentSlug, $docPath) {
                $debugInfo = [];
                $debugInfo[] = "GitHub Docs Route: Parent=$parentSlug, Doc=$docPath";
                
                $parent = site()->find($parentSlug);
                
                if (!$parent) {
                    $debugInfo[] = "GitHub Docs Route: Parent page not found";
                    return new \Kirby\Http\Response('<h1>Error</h1><p>Parent page not found: ' . htmlspecialchars($parentSlug) . '</p>' . 
                        '<pre>' . implode("\n", $debugInfo) . '</pre>', 'text/html');
                }
                
                // Check if this page has the github-docs template
                $parentTemplate = trim($parent->intendedTemplate());
                $debugInfo[] = "GitHub Docs Route: Parent template = '" . $parentTemplate . "'";
                
                if ($parentTemplate !== 'github-docs') {
                    $debugInfo[] = "GitHub Docs Route: Template mismatch - expected 'github-docs', got '" . $parentTemplate . "'";
                    return new \Kirby\Http\Response('<h1>Debug Info</h1>
                        <p>Parent slug: ' . htmlspecialchars($parentSlug) . '</p>
                        <p>Parent title: ' . htmlspecialchars($parent->title()) . '</p>
                        <p>Parent intended template: "' . htmlspecialchars($parentTemplate) . '"</p>
                        <p>Expected: "github-docs"</p>
                        <p>Template length: ' . strlen($parentTemplate) . '</p>
                        <p>Expected length: ' . strlen('github-docs') . '</p>
                        <pre>' . implode("\n", $debugInfo) . '</pre>', 'text/html');
                }
                
                $debugInfo[] = "GitHub Docs Route: Template check passed, creating virtual page";
                
                try {
                    $virtualPage = createGithubDocPage($parent, $docPath);
                    
                    if (!$virtualPage) {
                        $debugInfo[] = "GitHub Docs Route: Failed to create virtual page";
                        return new \Kirby\Http\Response('<h1>Error</h1><p>Failed to create virtual page for: ' . htmlspecialchars($docPath) . '</p><p>Check the GitHub repository configuration.</p>' . 
                            '<pre>' . implode("\n", $debugInfo) . '</pre>', 'text/html');
                    }
                    
                    $debugInfo[] = "GitHub Docs Route: Success, visiting virtual page";
                    return site()->visit($virtualPage);
                    
                } catch (Exception $e) {
                    $debugInfo[] = "GitHub Docs Route: Exception: " . $e->getMessage();
                    return new \Kirby\Http\Response('<h1>Error</h1><p>Exception creating page: ' . htmlspecialchars($e->getMessage()) . '</p>' . 
                        '<pre>' . implode("\n", $debugInfo) . '</pre>', 'text/html');
                }
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
        ],
        [
            'pattern' => 'github-docs-test/([^/]+)',
            'action' => function ($docPath) {
                // Create a mock parent page with GitHub configuration for testing
                $mockParent = new \Kirby\Cms\Page([
                    'slug' => 'github-docs-test',
                    'template' => 'github-docs',
                    'content' => [
                        'title' => 'Test GitHub Docs',                        'github_repo_url' => 'https://github.com/microsoft/vscode',
                        'github_branch' => 'main',
                        'github_docs_path' => 'docs'
                    ]
                ]);
                
                try {
                    $virtualPage = createGithubDocPage($mockParent, $docPath);
                    
                    if (!$virtualPage) {
                        return new \Kirby\Http\Response('<h1>Error</h1><p>Failed to create virtual page for: ' . htmlspecialchars($docPath) . '</p><p>Check the error details above.</p>', 'text/html');
                    }
                    
                    return site()->visit($virtualPage);
                    
                } catch (Exception $e) {
                    return new \Kirby\Http\Response('<h1>Test Error</h1><p>Exception: ' . htmlspecialchars($e->getMessage()) . '</p>', 'text/html');
                }
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
    $debugInfo = [];
    $debugInfo[] = "Creating GitHub doc page for: $docPath";
    
    $repoUrl = $parent->github_repo_url()->value();
    $branch = $parent->github_branch()->or('main')->value();
    $docsPath = $parent->github_docs_path()->or('docs')->value();
    $token = $parent->github_api_token()->value();
    
    $debugInfo[] = "Repository config: URL=$repoUrl, Branch=$branch, DocsPath=$docsPath";
    
    if (empty($repoUrl)) {
        $debugInfo[] = "GitHub Docs: No repository URL configured";
        throw new Exception("No repository URL configured. Debug: " . implode("; ", $debugInfo));
    }
    
    try {
        $client = new GitHubClient($repoUrl, $branch, $token);
        $debugInfo[] = "GitHub client created successfully";
          // Build full file path - first try direct path
        $filePath = $docsPath . '/' . $docPath;
        if (!Str::endsWith($filePath, '.md')) {
            $filePath .= '.md';
        }
        
        $debugInfo[] = "GitHub Docs: Attempting to fetch file: " . $filePath;
        
        // Try to get file content directly first
        $fileData = $client->getFileContent($filePath);
        
        if (!$fileData) {
            $debugInfo[] = "GitHub Docs: File not found at " . $filePath . ", searching recursively";
            
            // Extract just the filename from docPath for searching
            $searchFilename = basename($docPath);
            if (!Str::endsWith($searchFilename, '.md')) {
                $searchFilename .= '.md';
            }
            
            $debugInfo[] = "GitHub Docs: Searching for filename: " . $searchFilename;
            
            // Get all markdown files recursively
            $markdownFiles = $client->getMarkdownFiles($docsPath);
            $debugInfo[] = "GitHub Docs: Found " . count($markdownFiles) . " markdown files";
            
            foreach ($markdownFiles as $file) {
                $filename = basename($file['path']);
                $debugInfo[] = "GitHub Docs: Checking file: " . $file['path'] . " (filename: $filename)";
                
                if ($filename === $searchFilename) {
                    $debugInfo[] = "GitHub Docs: Found matching file: " . $file['path'];
                    $fileData = $client->getFileContent($file['path']);
                    $filePath = $file['path'];
                    break;
                }
            }
        }
        
        if (!$fileData) {
            $debugInfo[] = "GitHub Docs: Still no file data found";
            throw new Exception("File data not found. Debug: " . implode("; ", $debugInfo));
        }
        
        $debugInfo[] = "GitHub Docs: File data retrieved successfully, size: " . strlen($fileData['content']);
        
        // Create simple virtual page
        $title = $client->extractTitle($fileData['content'], basename($filePath, '.md'));
        $slug = Str::slug(basename($filePath, '.md'));
        
        $debugInfo[] = "GitHub Docs: Creating virtual page with title: $title, slug: $slug";
          $virtualPage = new \Kirby\Cms\Page([
            'slug' => $slug,
            'template' => 'github-doc-page-debug',
            'parent' => $parent,
            'content' => [
                'title' => $title,
                'markdown_content' => $fileData['content'],
                'github_file_path' => $filePath,
                'github_raw_url' => $fileData['download_url'],
                'repo_info' => json_encode($client->getRepoInfo()),
                'debug_info' => implode("\n", $debugInfo)
            ]
        ]);
        
        $debugInfo[] = "GitHub Docs: Virtual page created successfully";
        return $virtualPage;
        
    } catch (Exception $e) {
        $debugInfo[] = "GitHub Docs: Exception creating page: " . $e->getMessage();
        $debugInfo[] = "GitHub Docs: Stack trace: " . $e->getTraceAsString();
        throw new Exception("Failed to create page: " . $e->getMessage() . ". Debug: " . implode("; ", $debugInfo));
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
        $markdownFiles = $client->getMarkdownFiles($docsPath);
        
        $pages = [];
        foreach ($markdownFiles as $file) {
            $filename = basename($file['path'], '.md');
            $slug = Str::slug($filename);
            
            $pages[] = [
                'slug' => $slug,
                'title' => ucwords(str_replace(['-', '_'], ' ', $filename)),
                'path' => $file['path'],
                'url' => $parent->url() . '/github-docs/' . $slug
            ];
        }
        
        return $pages;
        
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
