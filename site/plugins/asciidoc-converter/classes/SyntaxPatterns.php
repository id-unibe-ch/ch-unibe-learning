<?php

namespace AsciiDocConverter;

/**
 * Enhanced AsciiDoc syntax patterns and conversions
 * 
 * This class contains advanced pattern matching and conversion
 * rules for more complex AsciiDoc syntax elements.
 */
class SyntaxPatterns
{
    /**
     * Get all conversion patterns
     */
    public static function getPatterns(): array
    {
        return [
            'headings' => [
                'pattern' => '/^(=+)\s+(.+)$/m',
                'replacement' => function($matches) {
                    $level = strlen($matches[1]);
                    return str_repeat('#', $level) . ' ' . $matches[2];
                }
            ],
            
            'bold' => [
                'pattern' => '/\*([^*\n]+)\*/',
                'replacement' => '**$1**'
            ],
            
            'italic' => [
                'pattern' => '/\b_([^_\n]+)_\b/',
                'replacement' => '*$1*'
            ],
            
            'code_blocks_with_lang' => [
                'pattern' => '/^\[source,([^\]]+)\]\s*\n----\s*\n(.*?)\n----\s*$/ms',
                'replacement' => "```$1\n$2\n```"
            ],
            
            'code_blocks_generic' => [
                'pattern' => '/^----\s*\n(.*?)\n----\s*$/ms',
                'replacement' => "```\n$1\n```"
            ],
            
            'literal_blocks' => [
                'pattern' => '/^\.\.\.\.\s*\n(.*?)\n\.\.\.\.\s*$/ms',
                'replacement' => "```\n$1\n```"
            ],
            
            'ordered_lists' => [
                'pattern' => '/^\.\s+(.+)$/m',
                'replacement' => '1. $1'
            ],
            
            'links_with_text' => [
                'pattern' => '/link:([^\[]+)\[([^\]]*)\]/',
                'replacement' => '[$2]($1)'
            ],
            
            'http_links_with_text' => [
                'pattern' => '/(https?:\/\/[^\s\[]+)\[([^\]]+)\]/',
                'replacement' => '[$2]($1)'
            ],
            
            'images' => [
                'pattern' => '/image::([^\[]+)\[([^\]]*)\]/',
                'replacement' => '![$2]($1)'
            ],
            
            'admonitions' => [
                'pattern' => '/^(NOTE|TIP|IMPORTANT|CAUTION|WARNING):\s+(.+)$/m',
                'replacement' => function($matches) {
                    $type = strtolower($matches[1]);
                    $text = $matches[2];
                    return "(info: {$text})";
                }
            ],
            
            'cross_references' => [
                'pattern' => '/<<([^,>]+)(?:,([^>]+))?>>/​',
                'replacement' => '[$2]($1)'
            ],
            
            'footnotes' => [
                'pattern' => '/footnote:\[([^\]]+)\]/',
                'replacement' => '[^fn]'
            ]
        ];
    }
    
    /**
     * Get table conversion pattern
     */
    public static function getTablePattern(): array
    {
        return [
            'pattern' => '/^\|===\s*\n(.*?)\n\|===\s*$/ms',
            'replacement' => function($matches) {
                $tableContent = trim($matches[1]);
                $lines = explode("\n", $tableContent);
                $markdownTable = '';
                $headerProcessed = false;
                
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line)) continue;
                    
                    // Convert AsciiDoc table row to Markdown
                    $cells = explode('|', $line);
                    array_shift($cells); // Remove first empty element
                    
                    $markdownLine = '| ' . implode(' | ', array_map('trim', $cells)) . ' |';
                    $markdownTable .= $markdownLine . "\n";
                    
                    // Add header separator after first row
                    if (!$headerProcessed) {
                        $headerSeparator = '|' . str_repeat(' --- |', count($cells));
                        $markdownTable .= $headerSeparator . "\n";
                        $headerProcessed = true;
                    }
                }
                
                return $markdownTable;
            }
        ];
    }
    
    /**
     * Get document attribute patterns
     */
    public static function getAttributePattern(): array
    {
        return [
            'pattern' => '/^:([^:]+):\s*(.+)$/m',
            'extract' => function($content) {
                $attributes = [];
                $body = $content;
                
                if (preg_match('/^:([^:]+):\s*(.+)$/m', $content)) {
                    preg_match_all('/^:([^:]+):\s*(.+)$/m', $content, $matches, PREG_SET_ORDER);
                    foreach ($matches as $match) {
                        $attributes[trim($match[1])] = trim($match[2]);
                        $body = str_replace($match[0], '', $body);
                    }
                }
                
                return [
                    'attributes' => $attributes,
                    'body' => trim($body)
                ];
            }
        ];
    }
    
    /**
     * Get KirbyText-specific conversions
     */
    public static function getKirbyTextPatterns(): array
    {
        return [
            'email_links' => [
                'pattern' => '/mailto:([^\[]+)\[([^\]]*)\]/',
                'replacement' => '[email: $1 text: $2]'
            ],
            
            'tel_links' => [
                'pattern' => '/tel:([^\[]+)\[([^\]]*)\]/',
                'replacement' => '[tel: $1 text: $2]'
            ],
            
            'youtube_videos' => [
                'pattern' => '/video::([^:]+):youtube\[([^\]]*)\]/',
                'replacement' => '[youtube: $1]'
            ],
            
            'vimeo_videos' => [
                'pattern' => '/video::([^:]+):vimeo\[([^\]]*)\]/',
                'replacement' => '[vimeo: $1]'
            ]
        ];
    }
    
    /**
     * Get cleanup patterns to run after conversion
     */
    public static function getCleanupPatterns(): array
    {
        return [
            'extra_whitespace' => [
                'pattern' => '/\n{3,}/',
                'replacement' => "\n\n"
            ],
            
            'trailing_spaces' => [
                'pattern' => '/[ \t]+$/m',
                'replacement' => ''
            ],
            
            'leading_trailing_newlines' => [
                'pattern' => '/^\n+|\n+$/',
                'replacement' => ''
            ]
        ];
    }
}
