#!/usr/bin/env php
<?php

/**
 * Command-line interface for AsciiDoc Converter
 * 
 * Usage:
 *   php convert-asciidoc.php [options]
 * 
 * Options:
 *   --help, -h      Show this help message
 *   --scan, -s      Scan for AsciiDoc files without converting
 *   --path=PATH     Target path within content directory
 *   --no-backup     Don't create backup files
 *   --no-recursive  Don't process subdirectories
 *   --test          Run test conversion on example files
 */

// Bootstrap Kirby
$kirbyPath = dirname(__DIR__, 3);
require_once $kirbyPath . '/index.php';

// Load converter classes
require_once __DIR__ . '/classes/Converter.php';
require_once __DIR__ . '/classes/SyntaxPatterns.php';

use AsciiDocConverter\Converter;

class CliInterface
{
    private $converter;
    private $options;
    
    public function __construct()
    {
        $this->converter = new Converter(kirby());
        $this->options = $this->parseArguments();
    }
    
    public function run(): int
    {
        try {
            if ($this->options['help']) {
                $this->showHelp();
                return 0;
            }
            
            if ($this->options['test']) {
                return $this->runTests();
            }
            
            if ($this->options['scan']) {
                return $this->scanFiles();
            }
            
            return $this->convertFiles();
            
        } catch (Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
    
    private function parseArguments(): array
    {
        $options = [
            'help' => false,
            'scan' => false,
            'test' => false,
            'path' => '',
            'backup' => true,
            'recursive' => true
        ];
        
        $args = array_slice($GLOBALS['argv'], 1);
        
        foreach ($args as $arg) {
            if ($arg === '--help' || $arg === '-h') {
                $options['help'] = true;
            } elseif ($arg === '--scan' || $arg === '-s') {
                $options['scan'] = true;
            } elseif ($arg === '--test') {
                $options['test'] = true;
            } elseif ($arg === '--no-backup') {
                $options['backup'] = false;
            } elseif ($arg === '--no-recursive') {
                $options['recursive'] = false;
            } elseif (strpos($arg, '--path=') === 0) {
                $options['path'] = substr($arg, 7);
            }
        }
        
        return $options;
    }
    
    private function showHelp(): void
    {
        echo "AsciiDoc to Markdown Converter for Kirby CMS\n";
        echo "============================================\n\n";
        echo "Usage: php convert-asciidoc.php [options]\n\n";
        echo "Options:\n";
        echo "  --help, -h      Show this help message\n";
        echo "  --scan, -s      Scan for AsciiDoc files without converting\n";
        echo "  --path=PATH     Target path within content directory\n";
        echo "  --no-backup     Don't create backup files\n";
        echo "  --no-recursive  Don't process subdirectories\n";
        echo "  --test          Run test conversion on example files\n\n";
        echo "Examples:\n";
        echo "  php convert-asciidoc.php --scan\n";
        echo "  php convert-asciidoc.php --path=docs\n";
        echo "  php convert-asciidoc.php --no-backup --path=blog\n";
        echo "  php convert-asciidoc.php --test\n\n";
    }
    
    private function scanFiles(): int
    {
        $this->info("Scanning for AsciiDoc files...");
        
        $scan = $this->converter->scanForAsciiDocFiles($this->options['path']);
        
        if (isset($scan['error'])) {
            $this->error($scan['error']);
            return 1;
        }
        
        if (empty($scan['files'])) {
            $this->info("No AsciiDoc files found.");
            return 0;
        }
        
        $this->success("Found {$scan['count']} AsciiDoc files:");
        
        foreach ($scan['files'] as $file) {
            $size = number_format($file['size']);
            echo "  • {$file['path']} ({$size} bytes, modified: {$file['modified']})\n";
        }
        
        return 0;
    }
    
    private function convertFiles(): int
    {
        $this->info("Starting AsciiDoc conversion...");
        
        // First scan to show what will be converted
        $scan = $this->converter->scanForAsciiDocFiles($this->options['path']);
        
        if (empty($scan['files'])) {
            $this->info("No AsciiDoc files found to convert.");
            return 0;
        }
        
        $this->info("Found {$scan['count']} files to convert.");
        
        // Ask for confirmation
        echo "Do you want to proceed? [y/N]: ";
        $handle = fopen("php://stdin", "r");
        $confirmation = trim(fgets($handle));
        fclose($handle);
        
        if (strtolower($confirmation) !== 'y' && strtolower($confirmation) !== 'yes') {
            $this->info("Conversion cancelled.");
            return 0;
        }
        
        // Perform conversion
        $result = $this->converter->convertPath(
            $this->options['path'],
            $this->options['recursive'],
            $this->options['backup']
        );
        
        // Report results
        $this->success("Conversion completed!");
        echo "  • Converted: {$result['stats']['converted']} files\n";
        echo "  • Errors: " . count($result['stats']['errors']) . "\n";
        
        if (!empty($result['stats']['errors'])) {
            $this->error("\nErrors encountered:");
            foreach ($result['stats']['errors'] as $error) {
                echo "  • {$error['file']}: {$error['error']}\n";
            }
        }
        
        return count($result['stats']['errors']) > 0 ? 1 : 0;
    }
    
    private function runTests(): int
    {
        $this->info("Running AsciiDoc converter tests...");
        
        // Test basic syntax conversions
        $testCases = [
            '= Main Heading' => '# Main Heading',
            '== Sub Heading' => '## Sub Heading',
            '*bold text*' => '**bold text**',
            '_italic text_' => '*italic text*',
            'link:https://example.com[Example]' => '[Example](https://example.com)',
            'image::test.jpg[Test Image]' => '![Test Image](test.jpg)',
            'NOTE: This is a note' => '(info: This is a note)',
        ];
        
        $passed = 0;
        $failed = 0;
        
        // Use reflection to access protected method
        $reflection = new ReflectionClass($this->converter);
        $convertSyntax = $reflection->getMethod('convertSyntax');
        $convertSyntax->setAccessible(true);
        
        foreach ($testCases as $input => $expected) {
            $result = trim($convertSyntax->invoke($this->converter, $input));
            if ($result === $expected) {
                echo "  ✓ '$input' → '$result'\n";
                $passed++;
            } else {
                echo "  ✗ '$input' → '$result'\n";
                echo "    Expected: '$expected'\n";
                $failed++;
            }
        }
        
        echo "\nTest Results: {$passed} passed, {$failed} failed\n";
        
        return $failed > 0 ? 1 : 0;
    }
    
    private function info(string $message): void
    {
        echo "\033[36m[INFO]\033[0m {$message}\n";
    }
    
    private function success(string $message): void
    {
        echo "\033[32m[SUCCESS]\033[0m {$message}\n";
    }
    
    private function error(string $message): void
    {
        echo "\033[31m[ERROR]\033[0m {$message}\n";
    }
}

// Run the CLI interface
$cli = new CliInterface();
exit($cli->run());
