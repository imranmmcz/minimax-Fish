<?php
// Profile ডেটাবেস ফিক্স স্ক্রিপ্ট
// এই ফাইলটি একবার চালান, তারপর ডিলিট করে ফেলুন

// Error reporting অন করুন (ডেভেলপমেন্টে)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
try {
    $host = 'localhost';
    $dbname = 'fishcare';
    $username = 'root';
    $password = ''; // আপনার পাসওয়ার্ড
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🔧 Profile ডেটাবেস ফিক্স</h2>";
    echo "<div style='font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 20px; background: #f5f5f5; border-radius: 10px;'>";
    
    // ১. টেবিল তৈরি
    echo "<h3>১. টেবিল তৈরি...</h3>";
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
        INDEX idx_user (user_id),
        INDEX idx_farming_experience (farming_experience),
        INDEX idx_pond_count (pond_count)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "✅ user_profiles টেবিল তৈরি হয়েছে<br>";
    
    // ২. ইউজারদের জন্য ডিফল্ট প্রোফাইল তৈরি
    echo "<h3>২. ইউজার প্রোফাইল তৈরি...</h3>";
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
    echo "✅ $affected ইউজারের জন্য প্রোফাইল তৈরি/আপডেট হয়েছে<br>";
    
    // ৩. যাচাই
    echo "<h3>৩. যাচাই করা হচ্ছে...</h3>";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM user_profiles");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ মোট " . $result['total'] . " টি প্রোফাইল তৈরি হয়েছে<br>";
    
    // ৪. টেস্ট কুয়েরি
    echo "<h3>৪. টেস্ট কুয়েরি...</h3>";
    $stmt = $pdo->prepare("SELECT u.username, u.full_name, up.farming_experience, up.pond_count 
                          FROM users u 
                          LEFT JOIN user_profiles up ON u.id = up.user_id 
                          WHERE u.role = 'farmer' 
                          LIMIT 3");
    $stmt->execute();
    $testResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
    echo "<tr><th>Username</th><th>Name</th><th>Experience</th><th>Ponds</th></tr>";
    foreach ($testResults as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
        echo "<td>" . ($row['farming_experience'] ?? 'N/A') . " বছর</td>";
        echo "<td>" . ($row['pond_count'] ?? 'N/A') . " টি</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h3>🎉 সমাপ্ত!</h3>";
    echo "<p style='color: green; font-weight: bold;'>Profile পেজ এখন কাজ করবে।</p>";
    echo "<p><a href='profile.php' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Profile পেজ দেখুন</a></p>";
    echo "<p style='color: red; font-weight: bold;'>⚠️ এই ফাইলটি ব্যবহারের পর ডিলিট করে ফেলুন!</p>";
    
} catch (PDOException $e) {
    echo "<h3>❌ ত্রুটি!</h3>";
    echo "<p style='color: red;'>ত্রুটি: " . $e->getMessage() . "</p>";
    echo "<p>অনুগ্রহ করে নিশ্চিত করুন যে:</p>";
    echo "<ul>";
    echo "<li>MySQL সার্ভার চালু আছে</li>";
    echo "<li>Database credentials সঠিক আছে</li>";
    echo "<li>fishcare ডেটাবেস তৈরি আছে</li>";
    echo "</ul>";
}

echo "</div>";
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile ডেটাবেস ফিক্স</title>
    <style>
        body { 
            font-family: 'Hind Siliguri', Arial, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        h2, h3 { color: #333; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background: #f2f2f2;
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
    </style>
</head>
<body>
