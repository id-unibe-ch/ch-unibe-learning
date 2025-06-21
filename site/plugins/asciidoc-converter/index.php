<?php

require_once __DIR__ . '/classes/Converter.php';
require_once __DIR__ . '/classes/SyntaxPatterns.php';

use Kirby\Toolkit\Dir;
use Kirby\Toolkit\F;
use Kirby\Toolkit\Str;

Kirby::plugin('unibe/asciidoc-converter', [
    'hooks' => [
        'system.loadPlugins:after' => function () {
            // Initialize converter after all plugins are loaded
            return true;
        }
    ],
    'commands' => [
        'asciidoc:convert' => [
            'description' => 'Convert AsciiDoc files to Markdown with KirbyText',
            'args' => [
                'path' => [
                    'description' => 'Content folder path to convert (relative to content root)',
                    'required' => false,
                    'default' => ''
                ],
                'recursive' => [
                    'description' => 'Convert files in subfolders recursively',
                    'required' => false,
                    'default' => true
                ],
                'backup' => [
                    'description' => 'Create backup of original files',
                    'required' => false,
                    'default' => true
                ]
            ],
            'command' => function ($cli) {
                $converter = new \AsciiDocConverter\Converter(kirby());
                return $converter->convertCommand($cli);
            }
        ]
    ],
    'routes' => [
        [
            'pattern' => 'admin/asciidoc-converter',
            'action' => function () {
                if (!kirby()->user() || !kirby()->user()->isAdmin()) {
                    throw new Exception('Access denied');
                }
                
                $converter = new \AsciiDocConverter\Converter(kirby());
                
                if (get('action') === 'convert') {
                    $path = get('path', '');
                    $recursive = get('recursive', true);
                    $backup = get('backup', true);
                    
                    $result = $converter->convertPath($path, $recursive, $backup);
                    
                    return new Kirby\Http\Response(json_encode($result), 'application/json');
                }
                
                // Return admin interface
                return new Kirby\Http\Response($converter->getAdminInterface(), 'text/html');
            }
        ]
    ],
    'api' => [
        'routes' => [
            [
                'pattern' => 'asciidoc-converter/scan',
                'method' => 'GET',
                'action' => function () {
                    $converter = new \AsciiDocConverter\Converter(kirby());
                    return $converter->scanForAsciiDocFiles();
                }
            ],
            [
                'pattern' => 'asciidoc-converter/convert',
                'method' => 'POST',
                'action' => function () {
                    $converter = new \AsciiDocConverter\Converter(kirby());
                    $data = $this->requestBody();
                    
                    return $converter->convertPath(
                        $data['path'] ?? '',
                        $data['recursive'] ?? true,
                        $data['backup'] ?? true
                    );
                }
            ]
        ]
    ]
]);
