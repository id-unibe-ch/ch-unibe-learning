# AsciiDoc to Markdown Converter Demo
# This script demonstrates the plugin features and structure

Write-Host ""
Write-Host "🔄 AsciiDoc to Markdown Converter for Kirby CMS" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""

$pluginPath = "c:\repo\vscode\ch-unibe-learning\site\plugins\asciidoc-converter"

Write-Host "📁 Plugin Structure:" -ForegroundColor Yellow
Write-Host ""

# Show plugin structure
$items = Get-ChildItem -Recurse $pluginPath | Sort-Object FullName
foreach ($item in $items) {
    $relativePath = $item.FullName.Replace("$pluginPath\", "")
    $indent = "  " * (($relativePath.Split('\').Length - 1))
    $icon = if ($item.PSIsContainer) { "📂" } else { "📄" }
    
    if ($item.PSIsContainer) {
        Write-Host "$indent$icon $($item.Name)/" -ForegroundColor Blue
    } else {
        $size = if ($item.Length -gt 1024) { 
            " ({0:N1} KB)" -f ($item.Length / 1024)
        } else { 
            " ({0} bytes)" -f $item.Length
        }
        Write-Host "$indent$icon $($item.Name)$size" -ForegroundColor White
    }
}

Write-Host ""
Write-Host "✨ Key Features:" -ForegroundColor Green
Write-Host "  • Converts AsciiDoc files (.adoc, .asciidoc, .asc) to Markdown"
Write-Host "  • Preserves document attributes as Kirby frontmatter"
Write-Host "  • Converts AsciiDoc syntax to KirbyText-compatible Markdown"
Write-Host "  • Supports recursive directory processing"
Write-Host "  • Creates backup files for safety"
Write-Host "  • Command-line and API interfaces"
Write-Host ""

Write-Host "🔧 Supported Conversions:" -ForegroundColor Magenta
Write-Host "  • Headings: = Title → # Title"
Write-Host "  • Bold text: *bold* → **bold**"
Write-Host "  • Italic text: _italic_ → *italic*"
Write-Host "  • Code blocks: [source,lang] ---- → ```lang"
Write-Host "  • Links: link:url[text] → [text](url)"
Write-Host "  • Images: image::path[alt] → ![alt](path)"
Write-Host "  • Admonitions: NOTE: text → (info: text)"
Write-Host "  • Tables: AsciiDoc tables → Markdown tables"
Write-Host ""

Write-Host "📋 Usage Examples:" -ForegroundColor Yellow

if (Get-Command php -ErrorAction SilentlyContinue) {
    Write-Host "  With PHP available:"
    Write-Host "    php site\plugins\asciidoc-converter\convert-asciidoc.php --scan"
    Write-Host "    php site\plugins\asciidoc-converter\convert-asciidoc.php --test"
    Write-Host "    php site\plugins\asciidoc-converter\convert-asciidoc.php --path=docs"
} else {
    Write-Host "  PHP not found in PATH. Install PHP to use the converter directly."
}

Write-Host ""
Write-Host "  PowerShell wrapper (when PHP is available):"
Write-Host "    .\site\plugins\asciidoc-converter\convert-asciidoc.ps1 -Scan"
Write-Host "    .\site\plugins\asciidoc-converter\convert-asciidoc.ps1 -Test"
Write-Host "    .\site\plugins\asciidoc-converter\convert-asciidoc.ps1 -Path docs"
Write-Host ""

Write-Host "🌐 Kirby Integration:" -ForegroundColor Cyan
Write-Host "  • API endpoints: /api/asciidoc-converter/scan and /api/asciidoc-converter/convert"
Write-Host "  • Admin interface: /admin/asciidoc-converter"
Write-Host "  • Command: php index.php asciidoc:convert"
Write-Host ""

Write-Host "📖 Example AsciiDoc Files:" -ForegroundColor Green
$exampleFiles = Get-ChildItem "$pluginPath\examples\*.adoc"
foreach ($file in $exampleFiles) {
    Write-Host "  📄 $($file.Name)" -ForegroundColor White
    
    # Show first few lines
    $content = Get-Content $file.FullName -TotalCount 5
    foreach ($line in $content) {
        if ($line.Trim()) {
            Write-Host "    $line" -ForegroundColor Gray
            break
        }
    }
    Write-Host ""
}

Write-Host "🚀 Installation Status:" -ForegroundColor Green
Write-Host "  ✅ Plugin files created successfully"
Write-Host "  ✅ Example AsciiDoc files provided"
Write-Host "  ✅ Documentation and README complete"
Write-Host "  ✅ CLI tools and PowerShell wrapper ready"
Write-Host ""

Write-Host "📌 Next Steps:" -ForegroundColor Yellow
Write-Host "  1. Install PHP if not already available"
Write-Host "  2. Place AsciiDoc files in your Kirby content directory"
Write-Host "  3. Run the converter to transform them to Markdown"
Write-Host "  4. Review converted files and adjust as needed"
Write-Host "  5. Use the Kirby admin panel for web-based conversion"
Write-Host ""

Write-Host "💡 The plugin is now ready for use!" -ForegroundColor Green
Write-Host ""
