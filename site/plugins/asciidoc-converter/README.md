# AsciiDoc to Markdown Converter Plugin for Kirby CMS

This plugin provides functionality to convert AsciiDoc files to Markdown format with KirbyText extensions, specifically designed for Kirby CMS content management.

## Features

- **Content Folder Scanning**: Automatically discovers AsciiDoc files in content folders and subfolders
- **Batch Conversion**: Convert multiple files at once with options for recursive directory processing
- **Backup Support**: Creates backup copies of original files before conversion
- **KirbyText Integration**: Converts AsciiDoc syntax to Markdown with KirbyText-compatible extensions
- **Command Line Interface**: Use via Kirby's command system for automated workflows
- **Admin Interface**: Web-based interface accessible from Kirby admin panel
- **API Integration**: RESTful API endpoints for programmatic access

## Installation

1. Copy the `asciidoc-converter` folder to your `site/plugins/` directory
2. The plugin will be automatically loaded by Kirby

## Supported AsciiDoc Elements

The converter handles the following AsciiDoc syntax elements:

### Basic Formatting
- **Headings**: `= Title` → `# Title`
- **Bold text**: `*bold*` → `**bold**`
- **Italic text**: `_italic_` → `*italic*`
- **Monospace**: `` `code` `` (unchanged)

### Content Blocks
- **Code blocks**: `[source,lang] ---- code ----` → ` ```lang code ``` `
- **Literal blocks**: `.... content ....` → ` ```content``` `
- **Lists**: Ordered and unordered lists (mostly compatible)

### Links and Media
- **Links**: `link:url[text]` → `[text](url)`
- **Images**: `image::path[alt]` → `![alt](path)`

### Special Elements
- **Admonitions**: `NOTE: text` → `(info: text)` (KirbyText format)
- **Tables**: Basic table conversion from AsciiDoc to Markdown format
- **Cross-references**: `<<ref,text>>` → `[text](ref)`

### Document Attributes
- AsciiDoc document attributes (`:attr: value`) are converted to Kirby frontmatter

## Usage

### Command Line Interface

Use Kirby's command system to convert files:

```bash
# Convert all AsciiDoc files in content directory
php index.php asciidoc:convert

# Convert files in specific folder
php index.php asciidoc:convert --path="folder-name"

# Convert without creating backups
php index.php asciidoc:convert --backup=false

# Convert only in current folder (not recursive)
php index.php asciidoc:convert --recursive=false
```

### Admin Interface

1. Navigate to `/admin/asciidoc-converter` in your browser
2. Review the list of detected AsciiDoc files
3. Click "Convert All Files" to process all files
4. Backup files will be created with `.backup` extension

### API Usage

**Scan for AsciiDoc files:**
```
GET /api/asciidoc-converter/scan
```

**Convert files:**
```
POST /api/asciidoc-converter/convert
{
  "path": "optional/folder/path",
  "recursive": true,
  "backup": true
}
```

## File Detection

The plugin automatically detects files with the following extensions:
- `.adoc`
- `.asciidoc`
- `.asc`
- `.txt` (only if containing AsciiDoc syntax)

## Conversion Process

1. **Scan**: Discovers AsciiDoc files in specified content folders
2. **Parse**: Extracts document attributes and content body
3. **Convert**: Transforms AsciiDoc syntax to Markdown with KirbyText
4. **Backup**: Creates backup of original file (if enabled)
5. **Write**: Saves converted content as `.md` file
6. **Cleanup**: Optionally removes original file

## Configuration

The plugin works with Kirby's standard configuration. Key settings:

```php
// site/config/config.php
return [
    'content' => [
        'extension' => 'md'  // Ensure Markdown extension is set
    ],
    'markdown' => [
        'extra' => true,     // Enable Markdown Extra features
        'breaks' => true     // Enable line breaks
    ]
];
```

## KirbyText Integration

The converter produces Markdown that's compatible with Kirby's KirbyText processor:

- **Info blocks**: AsciiDoc admonitions become `(info: text)`
- **Links**: Standard Markdown links work with Kirby's link processing
- **Images**: Image links are compatible with Kirby's image processing
- **Frontmatter**: Document attributes become Kirby field data

## Error Handling

The plugin provides comprehensive error handling:

- **File access errors**: Reports files that cannot be read/written
- **Conversion errors**: Logs specific syntax issues
- **Backup failures**: Warns if backup creation fails
- **Directory issues**: Validates target directories exist

## Requirements

- Kirby CMS 3.x or later
- PHP 8.0 or later
- Write permissions in content directory

## Limitations

- Complex AsciiDoc features may require manual review after conversion
- Custom AsciiDoc macros are not converted
- Some table formatting may need adjustment
- Include directives are not processed

## Best Practices

1. **Always create backups** before running conversions
2. **Test on a small subset** of files first
3. **Review converted content** for accuracy
4. **Update internal links** if file names change
5. **Validate KirbyText syntax** after conversion

## Contributing

To contribute to this plugin:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This plugin is open source and available under the MIT License.
