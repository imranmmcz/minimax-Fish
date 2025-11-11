/**
 * Installation Verification Script
 * ইনস্টলেশন যাচাই করার জন্য এই ফাইল চালান
 */

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ফিশ কেয়ার সিস্টেম - ইনস্টলেশন চেক</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Hind Siliguri', Arial, sans-serif;
            background: linear-gradient(135deg, #E0F7FA 0%, #F0F4FA 50%, #FAFBFF 100%);
            padding: 40px 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        }
        h1 {
            color: #00BCD4;
            margin-bottom: 30px;
            text-align: center;
        }
        .check-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            border-left: 4px solid #ccc;
        }
        .check-item.success {
            border-left-color: #4CAF50;
        }
        .check-item.error {
            border-left-color: #F44336;
        }
        .check-item svg {
            margin-right: 15px;
            flex-shrink: 0;
        }
        .check-item .label {
            flex: 1;
            font-weight: 500;
        }
        .check-item .status {
            font-weight: bold;
        }
        .success-text { color: #4CAF50; }
        .error-text { color: #F44336; }
        .summary {
            margin-top: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #00BCD4;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            margin-top: 20px;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #00ACC1;
            transform: scale(1.02);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ফিশ কেয়ার সিস্টেম - ইনস্টলেশন চেক</h1>
        
        <?php
        $checks = [];
        $allPassed = true;
        
        // PHP Version Check
        $phpVersion = phpversion();
        $phpOk = version_compare($phpVersion, '7.4.0', '>=');
        $checks[] = [
            'label' => 'PHP Version',
            'value' => $phpVersion,
            'status' => $phpOk,
            'message' => $phpOk ? 'সঠিক' : 'PHP 7.4+ প্রয়োজন'
        ];
        $allPassed = $allPassed && $phpOk;
        
        // Database Connection Check
        $dbFile = __DIR__ . '/config/database.php';
        $dbExists = file_exists($dbFile);
        $checks[] = [
            'label' => 'Database Config File',
            'value' => $dbExists ? 'পাওয়া গেছে' : 'পাওয়া যায়নি',
            'status' => $dbExists,
            'message' => $dbExists ? 'সঠিক' : 'config/database.php ফাইল পাওয়া যায়নি'
        ];
        $allPassed = $allPassed && $dbExists;
        
        if ($dbExists) {
            require_once $dbFile;
            try {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
                $pdo = new PDO($dsn, DB_USER, DB_PASS);
                $dbConnected = true;
                $checks[] = [
                    'label' => 'Database Connection',
                    'value' => 'সংযুক্ত',
                    'status' => true,
                    'message' => 'ডেটাবেস সংযোগ সফল'
                ];
                
                // Check tables
                $stmt = $pdo->query("SHOW TABLES");
                $tableCount = $stmt->rowCount();
                $checks[] = [
                    'label' => 'Database Tables',
                    'value' => "$tableCount টেবিল",
                    'status' => $tableCount >= 15,
                    'message' => $tableCount >= 15 ? 'সব টেবিল আছে' : 'টেবিল কম আছে (SQL import করুন)'
                ];
                $allPassed = $allPassed && ($tableCount >= 15);
            } catch (PDOException $e) {
                $dbConnected = false;
                $checks[] = [
                    'label' => 'Database Connection',
                    'value' => 'ব্যর্থ',
                    'status' => false,
                    'message' => 'ডেটাবেস সংযোগ ব্যর্থ: ' . $e->getMessage()
                ];
                $allPassed = false;
            }
        }
        
        // Check required directories
        $uploadDir = __DIR__ . '/assets/uploads';
        $uploadExists = is_dir($uploadDir);
        $uploadWritable = is_writable($uploadDir);
        $checks[] = [
            'label' => 'Upload Directory',
            'value' => $uploadExists && $uploadWritable ? 'লিখার যোগ্য' : 'সমস্যা আছে',
            'status' => $uploadExists && $uploadWritable,
            'message' => $uploadExists ? ($uploadWritable ? 'সঠিক' : 'পারমিশন সমস্যা') : 'ডিরেক্টরি নেই'
        ];
        $allPassed = $allPassed && $uploadExists && $uploadWritable;
        
        // Check required PHP extensions
        $requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'json'];
        foreach ($requiredExtensions as $ext) {
            $loaded = extension_loaded($ext);
            $checks[] = [
                'label' => "PHP Extension: $ext",
                'value' => $loaded ? 'লোড হয়েছে' : 'লোড হয়নি',
                'status' => $loaded,
                'message' => $loaded ? 'সঠিক' : 'Extension ইনস্টল করুন'
            ];
            $allPassed = $allPassed && $loaded;
        }
        
        // Display checks
        foreach ($checks as $check) {
            $class = $check['status'] ? 'success' : 'error';
            $icon = $check['status'] ? 
                '<svg width="24" height="24" fill="#4CAF50"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>' :
                '<svg width="24" height="24" fill="#F44336"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';
            $textClass = $check['status'] ? 'success-text' : 'error-text';
            
            echo "<div class='check-item $class'>";
            echo $icon;
            echo "<div class='label'>{$check['label']}</div>";
            echo "<div class='status $textClass'>{$check['value']}</div>";
            echo "</div>";
        }
        ?>
        
        <div class="summary">
            <?php if ($allPassed): ?>
                <svg width="64" height="64" fill="#4CAF50"><path d="M32 0C14.3 0 0 14.3 0 32s14.3 32 32 32 32-14.3 32-32S49.7 0 32 0zm-6.7 45.3L9.3 29.3l4.5-4.5 11.5 11.5L51.2 10.7l4.5 4.5-29.4 30.1z"/></svg>
                <h2 class="success-text">সব চেক সফল! ✅</h2>
                <p>আপনার ইনস্টলেশন সম্পন্ন এবং সিস্টেম চালানোর জন্য প্রস্তুত।</p>
                <a href="/fishcare/index.php" class="btn">ওয়েবসাইটে যান</a>
                <a href="/fishcare/pages/auth/login.php" class="btn">লগইন করুন</a>
            <?php else: ?>
                <svg width="64" height="64" fill="#F44336"><path d="M32 0C14.3 0 0 14.3 0 32s14.3 32 32 32 32-14.3 32-32S49.7 0 32 0zm3.6 45.3h-7.2V38.1h7.2v7.2zm0-14.5h-7.2V16.7h7.2v14.1z"/></svg>
                <h2 class="error-text">কিছু সমস্যা আছে ⚠️</h2>
                <p>উপরের ত্রুটি গুলো ঠিক করুন এবং এই পেজ রিফ্রেশ করুন।</p>
                <a href="QUICK_START.md" class="btn">ইনস্টলেশন গাইড দেখুন</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
