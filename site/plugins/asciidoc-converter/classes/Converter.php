<?php

namespace AsciiDocConverter;

use Kirby\Cms\App;
use Kirby\Filesystem\Dir;
use Kirby\Filesystem\F;
use Kirby\Toolkit\Str;
use Exception;

/**
 * AsciiDoc to Markdown with KirbyText Converter
 * 
 * This class provides functionality to convert AsciiDoc files to Markdown
 * format with KirbyText extensions, specifically designed for Kirby CMS.
 */
class Converter
{
    protected App $kirby;
    protected string $contentRoot;
    protected array $stats;
    
    public function __construct(App $kirby)
    {
        $this->kirby = $kirby;
        $this->contentRoot = $kirby->root('content');
        $this->stats = [
            'converted' => 0,
            'skipped' => 0,
            'errors' => []
        ];
    }
    
    /**
     * Convert AsciiDoc files in a given path
     */
    public function convertPath(string $path = '', bool $recursive = true, bool $backup = true): array
    {
        $this->resetStats();
        $targetPath = $this->contentRoot . ($path ? '/' . trim($path, '/') : '');
        
        if (!is_dir($targetPath)) {
            throw new Exception("Directory does not exist: {$targetPath}");
        }
        
        $this->processDirectory($targetPath, $recursive, $backup);
        
        return [
            'success' => true,
            'stats' => $this->stats,
            'path' => $path
        ];
    }
    
    /**
     * Scan for AsciiDoc files in content directory
     */
    public function scanForAsciiDocFiles(string $path = ''): array
    {
        $targetPath = $this->contentRoot . ($path ? '/' . trim($path, '/') : '');
        $files = [];
        
        if (!is_dir($targetPath)) {
            return ['files' => [], 'error' => "Directory does not exist: {$targetPath}"];
        }
        
        $this->scanDirectory($targetPath, $files);
        
        return [
            'files' => $files,
            'count' => count($files)
        ];
    }
    
    /**
     * Process directory for AsciiDoc files
     */
    protected function processDirectory(string $dir, bool $recursive, bool $backup): void
    {
        $items = scandir($dir);
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            
            $fullPath = $dir . '/' . $item;
            
            if (is_dir($fullPath) && $recursive) {
                $this->processDirectory($fullPath, $recursive, $backup);
            } elseif (is_file($fullPath) && $this->isAsciiDocFile($fullPath)) {
                $this->convertFile($fullPath, $backup);
            }
        }
    }
    
    /**
     * Scan directory for AsciiDoc files
     */
    protected function scanDirectory(string $dir, array &$files): void
    {
        $items = scandir($dir);
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            
            $fullPath = $dir . '/' . $item;
            
            if (is_dir($fullPath)) {
                $this->scanDirectory($fullPath, $files);
            } elseif (is_file($fullPath) && $this->isAsciiDocFile($fullPath)) {
                $relativePath = str_replace($this->contentRoot . '/', '', $fullPath);
                $files[] = [
                    'path' => $relativePath,
                    'fullPath' => $fullPath,
                    'size' => filesize($fullPath),
                    'modified' => date('Y-m-d H:i:s', filemtime($fullPath))
                ];
            }
        }
    }
    
    /**
     * Check if file is an AsciiDoc file
     */
    protected function isAsciiDocFile(string $filepath): bool
    {
        $extension = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        return in_array($extension, ['adoc', 'asciidoc', 'asc', 'txt']);
    }
    
    /**
     * Convert a single AsciiDoc file to Markdown
     */
    protected function convertFile(string $filepath, bool $backup): void
    {
        try {
            $content = file_get_contents($filepath);
            if ($content === false) {
                throw new Exception("Cannot read file: {$filepath}");
            }
            
            // Create backup if requested
            if ($backup) {
                $backupPath = $filepath . '.backup';
                if (!copy($filepath, $backupPath)) {
                    throw new Exception("Cannot create backup: {$backupPath}");
                }
            }
            
            // Convert content
            $markdownContent = $this->convertAsciiDocToMarkdown($content);
            
            // Write to new .md file
            $newFilepath = $this->getMarkdownFilePath($filepath);
            if (!file_put_contents($newFilepath, $markdownContent)) {
                throw new Exception("Cannot write converted file: {$newFilepath}");
            }
            
            // Remove original file if conversion successful
            if (!$backup) {
                unlink($filepath);
            }
            
            $this->stats['converted']++;
            
        } catch (Exception $e) {
            $this->stats['errors'][] = [
                'file' => $filepath,
                'error' => $e->getMessage()
            ];
        }
    }
      /**
     * Convert AsciiDoc content to Markdown with KirbyText
     */
    protected function convertAsciiDocToMarkdown(string $content): string
    {
        // Parse AsciiDoc document attributes using enhanced patterns
        $attributePattern = SyntaxPatterns::getAttributePattern();
        $parsed = $attributePattern['extract']($content);
        
        $frontmatter = $parsed['attributes'];
        $body = $parsed['body'];
        
        // Convert AsciiDoc syntax to Markdown
        $markdown = $this->convertSyntax($body);
        
        // Add Kirby frontmatter if we extracted attributes
        if (!empty($frontmatter)) {
            $yaml = "----\n";
            foreach ($frontmatter as $key => $value) {
                $yaml .= "{$key}: {$value}\n";
            }
            $yaml .= "----\n\n";
            $markdown = $yaml . $markdown;
        }
        
        return $markdown;
    }
      /**
     * Convert AsciiDoc syntax to Markdown with KirbyText extensions
     */
    protected function convertSyntax(string $content): string
    {
        // Load syntax patterns
        $patterns = SyntaxPatterns::getPatterns();
        
        // Apply basic patterns
        foreach ($patterns as $name => $pattern) {
            if (is_callable($pattern['replacement'])) {
                $content = preg_replace_callback($pattern['pattern'], $pattern['replacement'], $content);
            } else {
                $content = preg_replace($pattern['pattern'], $pattern['replacement'], $content);
            }
        }
        
        // Apply table conversion
        $tablePattern = SyntaxPatterns::getTablePattern();
        $content = preg_replace_callback($tablePattern['pattern'], $tablePattern['replacement'], $content);
        
        // Apply KirbyText-specific patterns
        $kirbyPatterns = SyntaxPatterns::getKirbyTextPatterns();
        foreach ($kirbyPatterns as $name => $pattern) {
            $content = preg_replace($pattern['pattern'], $pattern['replacement'], $content);
        }
        
        // Apply cleanup patterns
        $cleanupPatterns = SyntaxPatterns::getCleanupPatterns();
        foreach ($cleanupPatterns as $name => $pattern) {
            $content = preg_replace($pattern['pattern'], $pattern['replacement'], $content);
        }
        
        return trim($content);
    }
    
    /**
     * Get the new Markdown file path for a given AsciiDoc file
     */
    protected function getMarkdownFilePath(string $asciiDocPath): string
    {
        $pathInfo = pathinfo($asciiDocPath);
        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.md';
    }
    
    /**
     * Reset conversion statistics
     */
    protected function resetStats(): void
    {
        $this->stats = [
            'converted' => 0,
            'skipped' => 0,
            'errors' => []
        ];
    }
    
    /**
     * Command line interface for conversion
     */
    public function convertCommand($cli): int
    {
        $path = $cli->arg('path', '');
        $recursive = $cli->arg('recursive', true);
        $backup = $cli->arg('backup', true);
        
        try {
            $cli->out("Scanning for AsciiDoc files in: " . ($path ?: 'entire content directory'));
            
            $scan = $this->scanForAsciiDocFiles($path);
            if (empty($scan['files'])) {
                $cli->out("No AsciiDoc files found.");
                return 0;
            }
            
            $cli->out("Found {$scan['count']} AsciiDoc files to convert.");
            
            if (!$cli->confirm('Do you want to proceed with the conversion?')) {
                $cli->out("Conversion cancelled.");
                return 0;
            }
            
            $result = $this->convertPath($path, $recursive, $backup);
            
            $cli->out("Conversion completed:");
            $cli->out("- Converted: {$result['stats']['converted']} files");
            $cli->out("- Errors: " . count($result['stats']['errors']));
            
            if (!empty($result['stats']['errors'])) {
                $cli->out("\nErrors:");
                foreach ($result['stats']['errors'] as $error) {
                    $cli->out("- {$error['file']}: {$error['error']}");
                }
            }
            
            return 0;
            
        } catch (Exception $e) {
            $cli->error("Error: " . $e->getMessage());
            return 1;
        }
    }
    
    /**
     * Get admin interface HTML
     */
    public function getAdminInterface(): string
    {
        $scan = $this->scanForAsciiDocFiles();
        
        return '<!DOCTYPE html>
<html>
<head>
    <title>AsciiDoc Converter - Kirby CMS</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 2rem; }
        .container { max-width: 800px; margin: 0 auto; }
        .file-list { background: #f8f9fa; padding: 1rem; border-radius: 6px; margin: 1rem 0; }
        .file-item { padding: 0.5rem 0; border-bottom: 1px solid #e9ecef; }
        .file-item:last-child { border-bottom: none; }
        .btn { background: #007bff; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .alert { padding: 1rem; margin: 1rem 0; border-radius: 4px; }
        .alert-info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; }
        .alert-warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; }
    </style>
</head>
<body>
    <div class="container">
        <h1>AsciiDoc to Markdown Converter</h1>
        
        <div class="alert alert-info">
            <strong>Info:</strong> This tool will convert AsciiDoc files (.adoc, .asciidoc, .asc, .txt) to Markdown format 
            with KirbyText extensions in your content directory.
        </div>
        
        <h2>Scan Results</h2>
        <p>Found <strong>' . $scan['count'] . '</strong> AsciiDoc files to convert:</p>
        
        <div class="file-list">
            ' . (empty($scan['files']) ? '<p>No AsciiDoc files found in content directory.</p>' : '') . '
            ' . implode('', array_map(function($file) {
                return '<div class="file-item">
                    <strong>' . htmlspecialchars($file['path']) . '</strong><br>
                    <small>Size: ' . number_format($file['size']) . ' bytes, Modified: ' . $file['modified'] . '</small>
                </div>';
            }, $scan['files'])) . '
        </div>
        
        ' . (!empty($scan['files']) ? '
        <form method="post" onsubmit="return confirm(\'Are you sure you want to convert ' . $scan['count'] . ' files? This action cannot be undone.\');">
            <input type="hidden" name="action" value="convert">
            <input type="hidden" name="path" value="">
            <input type="hidden" name="recursive" value="1">
            <input type="hidden" name="backup" value="1">
            <button type="submit" class="btn">Convert All Files</button>
        </form>
        
        <div class="alert alert-warning">
            <strong>Warning:</strong> This will create backup files (.backup extension) and generate new .md files. 
            Please review the results carefully before removing the backup files.
        </div>
        ' : '') . '
        
        <p><a href="/admin">← Back to Admin Panel</a></p>
    </div>
</body>
</html>';
    }
}
