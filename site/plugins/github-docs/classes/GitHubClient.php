<?php

namespace GitHubDocs;

use Kirby\Http\Remote;
use Kirby\Toolkit\Str;
use Kirby\Data\Yaml;
use Kirby\Cms\Page;
use Exception;

/**
 * GitHub API Client for documentation fetching
 */
class GitHubClient {
    
    protected $owner;
    protected $repo;
    protected $branch;
    protected $token;
    protected $cache = [];
    
    public function __construct($repoUrl, $branch = 'main', $token = null) {
        $this->parseRepoUrl($repoUrl);
        $this->branch = $branch;
        $this->token = $token;
    }
    
    /**
     * Parse GitHub repository URL
     */
    protected function parseRepoUrl($url) {
        $pattern = '/github\.com\/([^\/]+)\/([^\/]+)/';
        if (preg_match($pattern, $url, $matches)) {
            $this->owner = $matches[1];
            $this->repo = rtrim($matches[2], '.git');
        } else {
            throw new Exception('Invalid GitHub repository URL');
        }
    }
    
    /**
     * Get repository information
     */
    public function getRepoInfo() {
        return [
            'owner' => $this->owner,
            'repo' => $this->repo,
            'branch' => $this->branch
        ];
    }
      /**
     * Make API request to GitHub
     */
    protected function apiRequest($endpoint) {
        $url = "https://api.github.com/repos/{$this->owner}/{$this->repo}/" . ltrim($endpoint, '/');
        
        // Check cache first
        $cacheKey = md5($url);
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }
        
        $options = [
            'headers' => [
                'User-Agent' => 'Kirby-GitHub-Docs-Plugin',
                'Accept' => 'application/vnd.github.v3+json'
            ]
        ];
        
        if ($this->token) {
            $options['headers']['Authorization'] = 'Bearer ' . $this->token;
        }
        
        try {
            $response = Remote::get($url, $options);
            
            // Debug logging
            error_log("GitHub API Request: " . $url);
            error_log("Response code: " . $response->code());
            
            if ($response->code() === 200) {
                $data = $response->json();
                $this->cache[$cacheKey] = $data;
                return $data;
            } elseif ($response->code() === 404) {
                error_log("GitHub API 404: " . $url);
                return null;
            } else {
                error_log("GitHub API Error " . $response->code() . ": " . $response->content());
                return null;
            }
        } catch (Exception $e) {
            error_log("GitHub API Exception: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get directory contents
     */
    public function getDirectoryContents($path = '') {
        $endpoint = "contents/" . ltrim($path, '/');
        if ($this->branch !== 'main') {
            $endpoint .= "?ref=" . $this->branch;
        }
        
        return $this->apiRequest($endpoint);
    }
    
    /**
     * Get file content
     */
    public function getFileContent($path) {
        $endpoint = "contents/" . ltrim($path, '/');
        if ($this->branch !== 'main') {
            $endpoint .= "?ref=" . $this->branch;
        }
        
        $data = $this->apiRequest($endpoint);
        
        if ($data && isset($data['content']) && $data['type'] === 'file') {
            return [
                'content' => base64_decode($data['content']),
                'sha' => $data['sha'],
                'size' => $data['size'],
                'download_url' => $data['download_url'],
                'path' => $data['path']
            ];
        }
        
        return null;
    }
      /**
     * Get all markdown files in a directory with hierarchical structure
     */
    public function getMarkdownFiles($path = '', $recursive = true) {
        $contents = $this->getDirectoryContents($path);
        $markdownFiles = [];
        
        if (is_array($contents)) {
            foreach ($contents as $item) {
                if ($item['type'] === 'file' && Str::endsWith($item['name'], '.md')) {
                    $item['level'] = substr_count($item['path'], '/');
                    $item['parent_path'] = dirname($item['path']) === '.' ? '' : dirname($item['path']);
                    $markdownFiles[] = $item;
                } elseif ($item['type'] === 'dir' && $recursive) {
                    // Recursively get markdown files from subdirectories
                    $subPath = $path ? $path . '/' . $item['name'] : $item['name'];
                    $subFiles = $this->getMarkdownFiles($subPath, true);
                    $markdownFiles = array_merge($markdownFiles, $subFiles);
                }
            }
        }
        
        // Sort by path for consistent ordering
        usort($markdownFiles, function($a, $b) {
            return strcmp($a['path'], $b['path']);
        });
        
        return $markdownFiles;
    }
    
    /**
     * Build navigation tree from markdown files
     */
    public function buildNavigationTree($files, $basePath = '') {
        $tree = [];
        
        foreach ($files as $file) {
            $relativePath = str_replace($basePath . '/', '', $file['path']);
            $pathParts = explode('/', $relativePath);
            $current = &$tree;
            
            // Build nested structure
            for ($i = 0; $i < count($pathParts) - 1; $i++) {
                $dir = $pathParts[$i];
                if (!isset($current[$dir])) {
                    $current[$dir] = [
                        'type' => 'directory',
                        'name' => $dir,
                        'title' => ucfirst(str_replace(['-', '_'], ' ', $dir)),
                        'children' => []
                    ];
                }
                $current = &$current[$dir]['children'];
            }
            
            // Add the file
            $fileName = end($pathParts);
            $slug = str_replace('.md', '', $fileName);
            $current[$slug] = [
                'type' => 'file',
                'name' => $fileName,
                'slug' => $slug,
                'title' => $this->extractTitle($this->getFileContent($file['path'])['content'] ?? '', ucfirst(str_replace(['-', '_'], ' ', $slug))),
                'path' => $file['path'],
                'size' => $file['size'],
                'url' => $file['html_url'] ?? null
            ];
        }
        
        return $tree;
    }
    
    /**
     * Parse markdown frontmatter
     */
    public function parseFrontmatter($content) {
        $frontmatter = [];
        $body = $content;
        
        if (Str::startsWith($content, '---')) {
            $parts = explode('---', $content, 3);
            if (count($parts) >= 3) {
                try {
                    $frontmatter = Yaml::decode($parts[1]) ?? [];
                    $body = trim($parts[2]);
                } catch (Exception $e) {
                    // If YAML parsing fails, just use the original content
                }
            }
        }
        
        return [
            'frontmatter' => $frontmatter,
            'body' => $body
        ];
    }
    
    /**
     * Extract title from markdown content
     */
    public function extractTitle($content, $fallback = null) {
        $parsed = $this->parseFrontmatter($content);
        
        // Check frontmatter first
        if (isset($parsed['frontmatter']['title'])) {
            return $parsed['frontmatter']['title'];
        }
        
        // Look for first H1 heading
        $lines = explode("\n", $parsed['body']);
        foreach ($lines as $line) {
            $line = trim($line);
            if (Str::startsWith($line, '# ')) {
                return trim(substr($line, 2));
            }
        }
        
        return $fallback;
    }
    
    /**
     * Process images in markdown content
     */
    public function processImages($content, $basePath = '') {
        return preg_replace_callback(
            '/!\[([^\]]*)\]\(([^)]+)\)/',
            function($matches) use ($basePath) {
                $alt = $matches[1];
                $src = $matches[2];
                
                // Skip if already a full URL
                if (strpos($src, 'http') === 0) {
                    return $matches[0];
                }
                
                // Convert to GitHub raw URL
                $imagePath = $basePath ? $basePath . '/' . ltrim($src, '/') : ltrim($src, '/');
                $rawUrl = "https://raw.githubusercontent.com/{$this->owner}/{$this->repo}/{$this->branch}/" . $imagePath;
                
                return '![' . $alt . '](' . $rawUrl . ')';
            },
            $content
        );
    }
}

/**
 * Virtual page factory for GitHub documentation
 */
class GitHubDocPageFactory {
    
    /**
     * Create a virtual page from GitHub content
     */
    public static function create($parent, $docPath, $client) {
        try {
            $fileData = $client->getFileContent($docPath);
            
            if (!$fileData) {
                return null;
            }
            
            $content = $fileData['content'];
            $parsed = $client->parseFrontmatter($content);
            
            // Extract title
            $title = $client->extractTitle($content, basename($docPath, '.md'));
            
            // Process images
            $processedContent = $client->processImages($parsed['body'], dirname($docPath));
            
            // Create slug from file path
            $slug = Str::slug(basename($docPath, '.md'));
            
            // Create virtual page
            $virtualPage = new Page([
                'slug' => $slug,
                'template' => 'github-doc-page',
                'model' => 'github-doc-page',
                'parent' => $parent,
                'content' => array_merge([
                    'title' => $title,
                    'markdown_content' => $processedContent,
                    'github_file_path' => $docPath,
                    'github_raw_url' => $fileData['download_url'],
                    'last_modified' => $fileData['sha'],
                    'repo_info' => json_encode($client->getRepoInfo()),
                    'file_size' => $fileData['size']
                ], $parsed['frontmatter'])
            ]);
            
            return $virtualPage;
            
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Create multiple virtual pages from a directory
     */
    public static function createFromDirectory($parent, $directory, $client) {
        $pages = [];
        $markdownFiles = $client->getMarkdownFiles($directory);
        
        foreach ($markdownFiles as $file) {
            $virtualPage = self::create($parent, $file['path'], $client);
            if ($virtualPage) {
                $pages[] = $virtualPage;
            }
        }
        
        return $pages;
    }
}
