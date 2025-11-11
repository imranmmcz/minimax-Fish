-- ডেটাবেস আপডেট স্ক্রিপ্ট
-- বিদ্যমান fishcare ডেটাবেসে user_profiles টেবিল যোগ করা হচ্ছে

-- ডেটাবেস ব্যবহার
USE fishcare;

-- টেবিল আছে কিনা চেক করে তৈরি করুন
CREATE TABLE IF NOT EXISTS user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    profile_image VARCHAR(500),
    farming_experience INT COMMENT 'চাষের অভিজ্ঞতা (বছর)',
    pond_count INT DEFAULT 0 COMMENT 'মোট পুকুর সংখ্যা',
    farming_type ENUM('traditional', 'modern', 'semi_modern') DEFAULT 'traditional',
    preferred_fish_species TEXT COMMENT 'পছন্দের মাছের প্রজাতি (কমা দিয়ে আলাদা)',
    annual_income DECIMAL(12,2) DEFAULT 0 COMMENT 'বার্ষিক আয়',
    bio TEXT COMMENT 'ব্যক্তিগত পরিচয়',
    notification_preferences JSON COMMENT 'নোটিফিকেশন পছন্দ',
    privacy_settings JSON COMMENT 'গোপনীয়তা সেটিং',
    last_login TIMESTAMP,
    profile_completion_percentage INT DEFAULT 0 COMMENT 'প্রোফাইল সম্পূর্ণতার শতাংশ',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_farming_experience (farming_experience),
    INDEX idx_pond_count (pond_count)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ইন্ডেক্স যোগ করুন (যদি টেবিল তৈরি হয়ে থাকে)
ALTER TABLE user_profiles ADD INDEX IF NOT EXISTS idx_user (user_id);
ALTER TABLE user_profiles ADD INDEX IF NOT EXISTS idx_farming_experience (farming_experience);
ALTER TABLE user_profiles ADD INDEX IF NOT EXISTS idx_pond_count (pond_count);

-- ইউজারদের জন্য ডিফল্ট প্রোফাইল তৈরি করুন (যাদের নেই)
INSERT INTO user_profiles (user_id, farming_experience, pond_count, farming_type, preferred_fish_species, annual_income, bio)
SELECT 
    u.id,
    3 as farming_experience, -- ডিফল্ট ৩ বছর অভিজ্ঞতা
    2 as pond_count, -- ডিফল্ট ২টি পুকুর
    'traditional' as farming_type,
    'রুই,তেলাপিয়া' as preferred_fish_species,
    200000.00 as annual_income,
    'নতুন ব্যবহারকারী' as bio
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
SELECT 'user_profiles টেবিল সফলভাবে তৈরি/আপডেট হয়েছে!' as message;