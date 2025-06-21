<?php

/**
 * Test script for AsciiDoc Converter Plugin
 * 
 * This script demonstrates how to use the converter and tests its functionality
 */

require_once __DIR__ . '/../classes/Converter.php';

use AsciiDocConverter\Converter;

// Mock Kirby app for testing
class MockKirby {
    public function root($type) {
        switch ($type) {
            case 'content':
                return __DIR__ . '/../examples';
            default:
                return __DIR__ . '/..';
        }
    }
}

// Test the converter
try {
    echo "AsciiDoc Converter Test Script\n";
    echo "==============================\n\n";
    
    $kirby = new MockKirby();
    $converter = new Converter($kirby);
    
    // Test scanning for files
    echo "1. Scanning for AsciiDoc files...\n";
    $scan = $converter->scanForAsciiDocFiles();
    
    if (empty($scan['files'])) {
        echo "   No AsciiDoc files found.\n";
        echo "   Please ensure sample files exist in the examples directory.\n";
    } else {
        echo "   Found {$scan['count']} AsciiDoc files:\n";
        foreach ($scan['files'] as $file) {
            echo "   - {$file['path']} ({$file['size']} bytes)\n";
        }
    }
    
    echo "\n2. Testing syntax conversion...\n";
    
    // Test various AsciiDoc syntax conversions
    $testCases = [
        '= Main Heading' => '# Main Heading',
        '== Sub Heading' => '## Sub Heading',
        '*bold text*' => '**bold text**',
        '_italic text_' => '*italic text*',
        'link:https://example.com[Example]' => '[Example](https://example.com)',
        'image::test.jpg[Test Image]' => '![Test Image](test.jpg)',
        'NOTE: This is a note' => '(info: This is a note)',
    ];
    
    $converter_reflection = new ReflectionClass($converter);
    $convertSyntax = $converter_reflection->getMethod('convertSyntax');
    $convertSyntax->setAccessible(true);
    
    foreach ($testCases as $input => $expected) {
        $result = $convertSyntax->invoke($converter, $input);
        $status = trim($result) === $expected ? "✓" : "✗";
        echo "   $status '$input' → '$result'\n";
        if (trim($result) !== $expected) {
            echo "     Expected: '$expected'\n";
        }
    }
    
    echo "\n3. Testing full document conversion...\n";
    
    $sampleAsciiDoc = ":title: Test Document\n:author: Test Author\n\n= Test Document\n\nThis is a *test* document with _italic_ text.\n\n== Section\n\nNOTE: This is important.\n\n[source,php]\n----\n<?php echo 'Hello World'; ?>\n----";
    
    $convertAsciiDocToMarkdown = $converter_reflection->getMethod('convertAsciiDocToMarkdown');
    $convertAsciiDocToMarkdown->setAccessible(true);
    
    $result = $convertAsciiDocToMarkdown->invoke($converter, $sampleAsciiDoc);
    echo "   Sample conversion result:\n";
    echo "   " . str_replace("\n", "\n   ", $result) . "\n";
    
    echo "\nTest completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error during testing: " . $e->getMessage() . "\n";
    exit(1);
}
