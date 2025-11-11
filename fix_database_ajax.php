<?php
// Profile ডেটাবেস AJAX ফিক্স টুল
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? '';

$host = 'localhost';
$dbname = 'fishcare';
$username = 'root';
$password = ''; // আপনার পাসওয়ার্ড

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $output = '';
    
    if ($action === 'fix') {
        // সমস্যা ঠিক করুন
        $output = fixDatabase($pdo);
    } elseif ($action === 'create_tables') {
        // নতুন টেবিল তৈরি করুন
        $output = createTables($pdo);
    } else {
        throw new Exception('Unknown action');
    }
    
    echo $output;
    
} catch (Exception $e) {
    echo '<div class="status-card error">';
    echo '<span class="status-icon"></span>';
    echo '<strong>❌ ত্রুটি:</strong> ' . htmlspecialchars($e->getMessage());
    echo '</div>';
}

function fixDatabase($pdo) {
    $output = '<div class="status-card success">';
    $output .= '<span class="status-icon"></span>';
    $output .= '<strong>🔧 ডেটাবেস ফিক্স করা হচ্ছে...</strong><br>';
    $output .= '</div>';
    
    // ১. user_profiles টেবিল তৈরি
    $sql = "CREATE TABLE IF NOT EXISTS user_profiles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL UNIQUE,
        profile_image VARCHAR(500),
        farming_experience INT DEFAULT 0,
        pond_count INT DEFAULT 0,
        farming_type ENUM('traditional', 'modern', 'semi_modern') DEFAULT 'traditional',
        preferred_fish_species TEXT DEFAULT '',
        annual_income DECIMAL(12,2) DEFAULT 0.00,
        bio TEXT DEFAULT '',
        notification_preferences JSON,
        privacy_settings JSON,
        last_login TIMESTAMP,
        profile_completion_percentage INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_user (user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    $output .= '<div class="status-card success">✅ user_profiles টেবিল তৈরি হয়েছে</div>';
    
    // ২. ইউজারদের জন্য ডিফল্ট প্রোফাইল তৈরি
    $sql = "INSERT INTO user_profiles (user_id, farming_experience, pond_count, farming_type, preferred_fish_species, annual_income, bio)
            SELECT 
                u.id,
                3,
                2,
                'traditional',
                'রুই,তেলাপিয়া',
                200000.00,
                'নতুন ব্যবহারকারী'
            FROM users u
            LEFT JOIN user_profiles up ON u.id = up.user_id
            WHERE up.user_id IS NULL
            ON DUPLICATE KEY UPDATE
                farming_experience = VALUES(farming_experience),
                pond_count = VALUES(pond_count),
                farming_type = VALUES(farming_type),
                preferred_fish_species = VALUES(preferred_fish_species),
                annual_income = VALUES(annual_income),
                bio = VALUES(bio)";
    
    $affected = $pdo->exec($sql);
    $output .= '<div class="status-card success">✅ ' . $affected . ' ইউজারের জন্য প্রোফাইল তৈরি/আপডেট হয়েছে</div>';
    
    // ৩. যাচাই
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM user_profiles");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $output .= '<div class="status-card success">✅ মোট ' . $result['total'] . ' টি প্রোফাইল রয়েছে</div>';
    
    return $output;
}

function createTables($pdo) {
    $output = '<div class="status-card success">';
    $output .= '<span class="status-icon"></span>';
    $output .= '<strong>🏗️ নতুন টেবিল তৈরি করা হচ্ছে...</strong><br>';
    $output .= '</div>';
    
    // প্রয়োজনীয় সব টেবিল তৈরি করুন
    $tables = [
        'user_profiles' => "CREATE TABLE IF NOT EXISTS user_profiles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL UNIQUE,
            profile_image VARCHAR(500),
            farming_experience INT DEFAULT 0,
            pond_count INT DEFAULT 0,
            farming_type ENUM('traditional', 'modern', 'semi_modern') DEFAULT 'traditional',
            preferred_fish_species TEXT DEFAULT '',
            annual_income DECIMAL(12,2) DEFAULT 0.00,
            bio TEXT DEFAULT '',
            notification_preferences JSON,
            privacy_settings JSON,
            last_login TIMESTAMP,
            profile_completion_percentage INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_user (user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    ];
    
    foreach ($tables as $name => $sql) {
        try {
            $pdo->exec($sql);
            $output .= '<div class="status-card success">✅ ' . $name . ' টেবিল তৈরি হয়েছে</div>';
        } catch (Exception $e) {
            $output .= '<div class="status-card error">❌ ' . $name . ' টেবিল তৈরি ব্যর্থ: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
    
    return $output;
}
?>
