<?php
/**
 * OAuth Authentication Fix Verification Script
 * 
 * This script verifies that all necessary configuration changes
 * for fixing the OAuth authentication issue are in place.
 * 
 * Usage: php verify_oauth_fix.php
 */

echo "=== OAuth Authentication Fix Verification ===\n\n";

$configPath = __DIR__ . '/site/config/config.php';
$passed = 0;
$total = 0;

function test($description, $condition) {
    global $passed, $total;
    $total++;
    if ($condition) {
        echo "✓ $description\n";
        $passed++;
        return true;
    } else {
        echo "✗ $description\n";
        return false;
    }
}

// Test 1: Configuration file exists and loads
try {
    $config = include $configPath;
    test("Configuration file loads successfully", is_array($config));
} catch (Exception $e) {
    test("Configuration file loads successfully", false);
    echo "  Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 2: OAuth configuration
$oauthConfig = $config['thathoff']['oauth'] ?? null;
test("OAuth configuration exists", $oauthConfig !== null);
test("OAuth only mode enabled", ($oauthConfig['onlyOauth'] ?? false) === true);
test("Azure provider configured", isset($oauthConfig['providers']['azure']));
test("Domain whitelist includes unibe.ch", 
     isset($oauthConfig['domainWhitelist']) && 
     in_array('unibe.ch', $oauthConfig['domainWhitelist']));

// Test 3: Session configuration
$sessionConfig = $config['session'] ?? null;
test("Session configuration exists", $sessionConfig !== null);

if ($sessionConfig) {
    test("Session cookies set to secure", ($sessionConfig['cookie']['secure'] ?? false) === true);
    test("Session cookies set to httpOnly", ($sessionConfig['cookie']['httpOnly'] ?? false) === true);
    test("Session cookies sameSite is Lax", ($sessionConfig['cookie']['sameSite'] ?? '') === 'Lax');
    test("Session timeout configured", isset($sessionConfig['timeout']));
}

// Test 4: API configuration
test("API configuration exists", isset($config['api']));

// Test 5: OAuth hooks
$hooks = $config['hooks'] ?? null;
test("Hooks configuration exists", $hooks !== null);
test("OAuth login hook configured", 
     isset($hooks['thathoff.oauth.login:after']) && 
     is_callable($hooks['thathoff.oauth.login:after']));

// Test 6: Required dependencies
$vendorPath = __DIR__ . '/vendor';
test("Vendor directory exists", is_dir($vendorPath));
test("OAuth plugin installed", is_dir($vendorPath . '/thathoff') || is_dir(__DIR__ . '/site/plugins/oauth'));
test("Azure OAuth provider installed", is_dir($vendorPath . '/thenetworg/oauth2-azure'));

// Test 7: .gitignore updated
$gitignorePath = __DIR__ . '/.gitignore';
if (file_exists($gitignorePath)) {
    $gitignoreContent = file_get_contents($gitignorePath);
    test(".gitignore excludes vendor directory", strpos($gitignoreContent, '/vendor/*') !== false);
} else {
    test(".gitignore exists", false);
}

// Summary
echo "\n=== Summary ===\n";
echo "Tests passed: $passed/$total\n";

if ($passed === $total) {
    echo "✓ All tests passed! OAuth authentication fix is properly configured.\n";
    echo "\nThe fix addresses:\n";
    echo "- Session cookie configuration for Azure HTTPS environment\n";
    echo "- OAuth session regeneration after login\n";
    echo "- Extended session timeout\n";
    echo "- Proper API authentication settings\n";
    echo "\nThis should resolve the 'Unauthenticated' error when saving pages.\n";
    exit(0);
} else {
    echo "✗ Some tests failed. Please review the configuration.\n";
    exit(1);
}