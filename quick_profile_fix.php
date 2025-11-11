<?php
// দ্রুত Profile ডেটাবেস ফিক্স - এক ক্লিক সমাধান
header('Content-Type: text/html; charset=utf-8');

// ডেটাবেস কনফিগ (আপনার অনুযায়ী পরিবর্তন করুন)
$host = 'localhost';
$dbname = 'fishcare';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo '<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile ডেটাবেস ফিক্স</title>
    <style>
        body { font-family: "Hind Siliguri", Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin: 0; padding: 20px; min-height: 100vh; }
        .container { max-width: 600px; margin: 50px auto; background: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 40px; backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-size: 2.5rem; margin-bottom: 10px; background: linear-gradient(45deg, #007cba, #00BCD4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; padding: 15px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px; padding: 15px; margin: 10px 0; }
        .btn { background: linear-gradient(45deg, #007cba, #00BCD4); color: white; border: none; padding: 15px 30px; border-radius: 8px; font-size: 16px; cursor: pointer; text-decoration: none; display: inline-block; margin: 10px; transition: transform 0.2s; }
        .btn:hover { transform: translateY(-2px); }
        .progress { border: 4px solid #f3f3f3; border-top: 4px solid #007cba; border-radius: 50%; width: 40px; height: 40px; animation: spin 2s linear infinite; margin: 20px auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔧 Profile ডেটাবেস ফিক্স</h1>
            <p>অ্যাকশন নেওয়া হচ্ছে...</p>
        </div>';
    
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
    echo '<div class="success">✅ user_profiles টেবিল তৈরি হয়েছে</div>';
    
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
    echo '<div class="success">✅ ' . $affected . ' ইউজারের জন্য প্রোফাইল তৈরি/আপডেট হয়েছে</div>';
    
    // ৩. যাচাই
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM user_profiles");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div class="success">✅ মোট ' . $result['total'] . ' টি প্রোফাইল তৈরি হয়েছে</div>';
    
    echo '<div class="success">
        <h3>🎉 সমাপ্ত!</h3>
        <p><strong>Profile ডেটাবেস সফলভাবে ফিক্স হয়েছে।</strong></p>
        <p>এখন Profile পেজ সম্পূর্ণ কার্যকরী।</p>
    </div>';
    
    echo '<div style="text-align: center; margin-top: 30px;">';
    echo '<a href="pages/dashboard/farmer/profile.php" class="btn">📱 Profile পেজ দেখুন</a>';
    echo '<a href="pages/dashboard/farmer/index.php" class="btn">🏠 চাষী ড্যাশবোর্ড</a>';
    echo '<a href="profile_diagnostic.php" class="btn">🔍 ডায়াগনস্টিক</a>';
    echo '</div>';
    
    echo '<div class="success" style="margin-top: 20px; text-align: center;">';
    echo '<p>⚠️ <strong>নিরাপত্তার জন্য:</strong> এই ফাইলটি ব্যবহারের পর ডিলিট করে ফেলুন</p>';
    echo '</div>';
    
} catch (Exception $e) {
    echo '<div class="error">
        <h3>❌ ত্রুটি!</h3>
        <p>' . htmlspecialchars($e->getMessage()) . '</p>
        <p><strong>সমাধান:</strong></p>
        <ul>
            <li>MySQL সার্ভার চালু আছে কিনা চেক করুন</li>
            <li>Database credentials সঠিক আছে কিনা দেখুন</li>
            <li>fishcare ডেটাবেস তৈরি আছে কিনা যাচাই করুন</li>
        </ul>
    </div>';
    
    echo '<div style="text-align: center; margin-top: 20px;">';
    echo '<a href="profile_diagnostic.php" class="btn">🔍 সমস্যা চিহ্নিত করুন</a>';
    echo '</div>';
}

echo '    </div>
</body>
</html>';
?>
