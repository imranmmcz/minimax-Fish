<?php
/**
 * প্রোডাকশন রেডিনেস চেক স্ক্রিপ্ট
 * এই স্ক্রিপ্টটি সার্ভারে রান করে সিস্টেম প্রস্তুত কিনা যাচাই করুন
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ANSI Colors for terminal
$colors = [
    'green' => "\033[0;32m",
    'red' => "\033[0;31m",
    'yellow' => "\033[1;33m",
    'blue' => "\033[0;34m",
    'reset' => "\033[0m"
];

function printHeader($text) {
    global $colors;
    echo "\n{$colors['blue']}=== $text ==={$colors['reset']}\n";
}

function printSuccess($text) {
    global $colors;
    echo "{$colors['green']}✓{$colors['reset']} $text\n";
}

function printError($text) {
    global $colors;
    echo "{$colors['red']}✗{$colors['reset']} $text\n";
}

function printWarning($text) {
    global $colors;
    echo "{$colors['yellow']}⚠{$colors['reset']} $text\n";
}

$errors = [];
$warnings = [];

printHeader("ফিশ কেয়ার সিস্টেম - প্রোডাকশন রেডিনেস চেক");

// 1. PHP Version Check
printHeader("১. PHP কনফিগারেশন চেক");
$phpVersion = phpversion();
if (version_compare($phpVersion, '7.4.0', '>=')) {
    printSuccess("PHP Version: $phpVersion");
} else {
    printError("PHP Version: $phpVersion (Required: 7.4+)");
    $errors[] = "PHP version too old";
}

// 2. Required PHP Extensions
$requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'json', 'session'];
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        printSuccess("Extension loaded: $ext");
    } else {
        printError("Extension missing: $ext");
        $errors[] = "Missing extension: $ext";
    }
}

// 3. PHP Settings
printHeader("২. PHP সেটিংস যাচাই");
$settings = [
    'upload_max_filesize' => ['current' => ini_get('upload_max_filesize'), 'recommended' => '10M'],
    'post_max_size' => ['current' => ini_get('post_max_size'), 'recommended' => '10M'],
    'max_execution_time' => ['current' => ini_get('max_execution_time'), 'recommended' => '30'],
    'memory_limit' => ['current' => ini_get('memory_limit'), 'recommended' => '128M'],
];

foreach ($settings as $key => $value) {
    echo "$key: {$value['current']} (সুপারিশকৃত: {$value['recommended']})\n";
}

// Display errors in production
if (ini_get('display_errors') == '1') {
    printWarning("display_errors is ON (প্রোডাকশনে OFF করুন)");
    $warnings[] = "display_errors should be OFF in production";
}

// 4. File/Directory Permissions
printHeader("৩. ফাইল এবং ডিরেক্টরি পারমিশন");
$baseDir = __DIR__ . '/..';
$checkDirs = [
    'uploads' => 0775,
    'assets/invoices' => 0775,
    'config' => 0755,
    'database' => 0750,
];

foreach ($checkDirs as $dir => $expectedPerm) {
    $fullPath = "$baseDir/$dir";
    if (file_exists($fullPath)) {
        $actualPerm = fileperms($fullPath) & 0777;
        $permString = decoct($actualPerm);
        if (is_writable($fullPath)) {
            printSuccess("$dir: writable ($permString)");
        } else {
            printError("$dir: not writable ($permString)");
            $errors[] = "$dir not writable";
        }
    } else {
        printError("$dir: না পাওয়া গেছে");
        $errors[] = "$dir directory missing";
    }
}

// 5. Database Connection Test
printHeader("৪. ডেটাবেস কানেকশন টেস্ট");
try {
    require_once $baseDir . '/config/database.php';
    $db = getDB();
    printSuccess("ডেটাবেস কানেকশন সফল");
    
    // Check required tables
    $requiredTables = [
        'users', 'products', 'invoices', 'pond_records', 
        'income_expense', 'shipments', 'notifications', 'wishlists'
    ];
    
    $stmt = $db->query("SHOW TABLES");
    $existingTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    printHeader("৫. ডেটাবেস টেবিল যাচাই");
    foreach ($requiredTables as $table) {
        if (in_array($table, $existingTables)) {
            // Count records
            $stmt = $db->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            printSuccess("$table: ✓ ($count records)");
        } else {
            printError("$table: টেবিল নেই");
            $errors[] = "Table $table missing";
        }
    }
    
} catch (Exception $e) {
    printError("ডেটাবেস কানেকশন ব্যর্থ: " . $e->getMessage());
    $errors[] = "Database connection failed";
}

// 6. Configuration Files
printHeader("৬. কনফিগারেশন ফাইল চেক");
$configFiles = [
    'config/config.php',
    'config/database.php',
    'includes/auth.php',
    'includes/functions.php',
];

foreach ($configFiles as $file) {
    $fullPath = "$baseDir/$file";
    if (file_exists($fullPath)) {
        printSuccess("$file: পাওয়া গেছে");
    } else {
        printError("$file: নেই");
        $errors[] = "$file missing";
    }
}

// 7. Check for default passwords
printHeader("৭. নিরাপত্তা চেক");
try {
    if (isset($db)) {
        // Check for default admin password
        $stmt = $db->query("SELECT id FROM users WHERE email = 'admin@fishcare.com'");
        if ($stmt->rowCount() > 0) {
            printWarning("ডিফল্ট অ্যাডমিন অ্যাকাউন্ট পাওয়া গেছে - পাসওয়ার্ড পরিবর্তন করুন!");
            $warnings[] = "Default admin account exists";
        }
        
        // Check SSL requirement
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
            printWarning("HTTPS সক্রিয় নয় - SSL সার্টিফিকেট ইনস্টল করুন");
            $warnings[] = "HTTPS not enabled";
        }
    }
} catch (Exception $e) {
    // Ignore if tables don't exist
}

// 8. Web Server Check
printHeader("৮. ওয়েব সার্ভার কনফিগারেশন");
if (file_exists($baseDir . '/.htaccess')) {
    printSuccess(".htaccess ফাইল পাওয়া গেছে");
} else {
    printWarning(".htaccess ফাইল নেই (Apache এর জন্য প্রয়োজন)");
    $warnings[] = ".htaccess missing";
}

// Final Summary
printHeader("সারসংক্ষেপ");
echo "\n";

if (empty($errors)) {
    printSuccess("কোনো গুরুতর সমস্যা নেই!");
} else {
    printError("মোট " . count($errors) . " টি সমস্যা পাওয়া গেছে:");
    foreach ($errors as $error) {
        echo "  - $error\n";
    }
}

if (!empty($warnings)) {
    printWarning("মোট " . count($warnings) . " টি সতর্কতা:");
    foreach ($warnings as $warning) {
        echo "  - $warning\n";
    }
}

echo "\n";

if (empty($errors) && empty($warnings)) {
    echo "{$colors['green']}";
    echo "╔════════════════════════════════════════╗\n";
    echo "║  সিস্টেম প্রোডাকশনের জন্য প্রস্তুত!  ║\n";
    echo "╚════════════════════════════════════════╝\n";
    echo "{$colors['reset']}";
    exit(0);
} elseif (empty($errors)) {
    echo "{$colors['yellow']}";
    echo "╔════════════════════════════════════════════╗\n";
    echo "║  সিস্টেম ব্যবহারযোগ্য, কিন্তু সতর্কতা আছে ║\n";
    echo "╚════════════════════════════════════════════╝\n";
    echo "{$colors['reset']}";
    exit(0);
} else {
    echo "{$colors['red']}";
    echo "╔═══════════════════════════════════════════════╗\n";
    echo "║  সমস্যা সমাধান করুন এবং আবার টেস্ট করুন    ║\n";
    echo "╚═══════════════════════════════════════════════╝\n";
    echo "{$colors['reset']}";
    exit(1);
}
