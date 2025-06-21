# AsciiDoc Converter Plugin Validation Script
# This script validates the plugin structure and files

Write-Host "AsciiDoc Converter Plugin Validation" -ForegroundColor Cyan
Write-Host "====================================" -ForegroundColor Cyan
Write-Host ""

$pluginPath = "c:\repo\vscode\ch-unibe-learning\site\plugins\asciidoc-converter"

# Check if plugin directory exists
if (-not (Test-Path $pluginPath)) {
    Write-Host "✗ Plugin directory not found: $pluginPath" -ForegroundColor Red
    exit 1
}

Write-Host "✓ Plugin directory exists" -ForegroundColor Green

# Check required files
$requiredFiles = @(
    "index.php",
    "README.md",
    "classes\Converter.php",
    "classes\SyntaxPatterns.php",
    "convert-asciidoc.php",
    "convert-asciidoc.ps1",
    "examples\sample.adoc",
    "examples\course-materials.adoc",
    "test\test-converter.php"
)

$missingFiles = @()
$foundFiles = @()

foreach ($file in $requiredFiles) {
    $fullPath = Join-Path $pluginPath $file
    if (Test-Path $fullPath) {
        Write-Host "✓ $file" -ForegroundColor Green
        $foundFiles += $file
    } else {
        Write-Host "✗ $file (missing)" -ForegroundColor Red
        $missingFiles += $file
    }
}

Write-Host ""
Write-Host "Validation Summary:" -ForegroundColor Yellow
Write-Host "  Found: $($foundFiles.Count) files" -ForegroundColor Green
Write-Host "  Missing: $($missingFiles.Count) files" -ForegroundColor Red

if ($missingFiles.Count -eq 0) {
    Write-Host ""
    Write-Host "✓ All required files are present!" -ForegroundColor Green
    Write-Host ""
    
    # Show file sizes
    Write-Host "File Information:" -ForegroundColor Cyan
    foreach ($file in $requiredFiles) {
        $fullPath = Join-Path $pluginPath $file
        $fileInfo = Get-Item $fullPath
        $size = if ($fileInfo.Length -gt 1024) { 
            "{0:N1} KB" -f ($fileInfo.Length / 1024)
        } else { 
            "$($fileInfo.Length) bytes" 
        }
        Write-Host "  $file - $size"
    }
    
    Write-Host ""
    Write-Host "Plugin Installation Instructions:" -ForegroundColor Yellow
    Write-Host "1. The plugin is already in the correct location"
    Write-Host "2. If PHP is available, you can test with:"
    Write-Host "   php site\plugins\asciidoc-converter\convert-asciidoc.php --test"
    Write-Host "3. Or use the PowerShell wrapper:"
    Write-Host "   .\site\plugins\asciidoc-converter\convert-asciidoc.ps1 -Test"
    Write-Host ""
    Write-Host "Usage Examples:" -ForegroundColor Green
    Write-Host "• Scan for AsciiDoc files:"
    Write-Host "  .\site\plugins\asciidoc-converter\convert-asciidoc.ps1 -Scan"
    Write-Host "• Convert files in specific folder:"
    Write-Host "  .\site\plugins\asciidoc-converter\convert-asciidoc.ps1 -Path 'docs'"
    Write-Host "• Convert without backups:"
    Write-Host "  .\site\plugins\asciidoc-converter\convert-asciidoc.ps1 -NoBackup"
    
} else {
    Write-Host ""
    Write-Host "✗ Plugin validation failed. Missing files need to be created." -ForegroundColor Red
}

Write-Host ""
