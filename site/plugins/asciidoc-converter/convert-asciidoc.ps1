# AsciiDoc Converter PowerShell Wrapper
# Usage: .\convert-asciidoc.ps1 [options]

param(
    [switch]$Help,
    [switch]$Scan,
    [switch]$Test,
    [string]$Path = "",
    [switch]$NoBackup,
    [switch]$NoRecursive
)

# Get the directory where this script is located
$ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Definition

# Build PHP command arguments
$phpArgs = @()

if ($Help) {
    $phpArgs += "--help"
}
elseif ($Scan) {
    $phpArgs += "--scan"
}
elseif ($Test) {
    $phpArgs += "--test"
}

if ($Path) {
    $phpArgs += "--path=$Path"
}

if ($NoBackup) {
    $phpArgs += "--no-backup"
}

if ($NoRecursive) {
    $phpArgs += "--no-recursive"
}

# Check if PHP is available
try {
    $phpVersion = php --version 2>$null
    if (-not $phpVersion) {
        throw "PHP not found"
    }
}
catch {
    Write-Host "Error: PHP is not installed or not in PATH" -ForegroundColor Red
    Write-Host "Please install PHP and add it to your system PATH" -ForegroundColor Yellow
    exit 1
}

# Show help if no arguments provided
if (-not $Help -and -not $Scan -and -not $Test -and -not $Path -and $phpArgs.Count -eq 0) {
    Write-Host "AsciiDoc to Markdown Converter for Kirby CMS" -ForegroundColor Cyan
    Write-Host "============================================" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Usage: .\convert-asciidoc.ps1 [options]" -ForegroundColor White
    Write-Host ""
    Write-Host "Options:" -ForegroundColor Yellow
    Write-Host "  -Help           Show this help message"
    Write-Host "  -Scan           Scan for AsciiDoc files without converting"
    Write-Host "  -Test           Run test conversion on example files"
    Write-Host "  -Path <path>    Target path within content directory"
    Write-Host "  -NoBackup       Don't create backup files"
    Write-Host "  -NoRecursive    Don't process subdirectories"
    Write-Host ""
    Write-Host "Examples:" -ForegroundColor Green
    Write-Host "  .\convert-asciidoc.ps1 -Scan"
    Write-Host "  .\convert-asciidoc.ps1 -Path docs"
    Write-Host "  .\convert-asciidoc.ps1 -NoBackup -Path blog"
    Write-Host "  .\convert-asciidoc.ps1 -Test"
    Write-Host ""
    exit 0
}

# Execute PHP script
$phpScript = Join-Path $ScriptDir "convert-asciidoc.php"

try {
    Write-Host "Running AsciiDoc converter..." -ForegroundColor Cyan
    
    if ($phpArgs.Count -gt 0) {
        $processArgs = @($phpScript) + $phpArgs
        & php @processArgs
    } else {
        & php $phpScript
    }
    
    $exitCode = $LASTEXITCODE
    
    if ($exitCode -eq 0) {
        Write-Host "Operation completed successfully." -ForegroundColor Green
    } else {
        Write-Host "Operation completed with errors (exit code: $exitCode)." -ForegroundColor Yellow
    }
    
    exit $exitCode
}
catch {
    Write-Host "Error executing PHP script: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}
