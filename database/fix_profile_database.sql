-- Profile পেজ ঠিক করার জন্য দ্রুত ডেটাবেস আপডেট স্ক্রিপ্ট

-- ডেটাবেস ব্যবহার
USE fishcare;

-- টেবিল তৈরি করুন (যদি না থাকে)
CREATE TABLE IF NOT EXISTS user_profiles (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- সব ইউজারের জন্য ডিফল্ট প্রোফাইল তৈরি করুন
INSERT INTO user_profiles (user_id, farming_experience, pond_count, farming_type, preferred_fish_species, annual_income, bio)
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
    bio = VALUES(bio);

-- সফলতার বার্তা
SELECT 'Profile টেবিল ঠিক করা হয়েছে!' as message, 
       COUNT(*) as total_profiles 
FROM user_profiles;