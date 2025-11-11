-- ইউজার প্রোফাইল এক্সটেনশন টেবিল
-- Profile.php পেজের জন্য প্রয়োজনীয় টেবিল যোগ করা হচ্ছে

-- ২০. ইউজার প্রোফাইল এক্সটেনশন টেবিল
CREATE TABLE user_profiles (
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
    INDEX idx_pond_count (pond_count),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ডিফল্ট প্রোফাইল ডেটা (প্রথম ১০টি ইউজারের জন্য)
INSERT INTO user_profiles (user_id, farming_experience, pond_count, farming_type, preferred_fish_species, annual_income, bio) VALUES
(1, 10, 5, 'modern', 'রুই,কাতলা,মৃগেল', 500000.00, 'অভিজ্ঞ মৎস্য চাষী এবং সিস্টেম অ্যাডমিন'),
(2, 5, 3, 'traditional', 'পাঙ্গাস,তেলাপিয়া', 300000.00, 'নতুন প্রজন্মের চাষী, আধুনিক পদ্ধতি অনুসন্ধানে'),
(3, 8, 4, 'semi_modern', 'রুই,সিলভার কার্প', 400000.00, 'ঐতিহ্যবাহী চাষের সাথে নতুন প্রযুক্তি ব্যবহার করি');
