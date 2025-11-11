# 🔧 Profile পেজ সমস্যা সমাধান

## ❌ সমস্যা
`profile.php` পেজে এই এরর হচ্ছে:
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'fishcare.user_profiles' doesn't exist
```

## ✅ সমাধান

### ধাপ ১: ডেটাবেস আপডেট করুন

আপনার MySQL কমান্ড প্রম্পটে বা phpMyAdmin এ এই SQL রান করুন:

```sql
-- ডেটাবেস ব্যবহার
USE fishcare;

-- টেবিল তৈরি করুন
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
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ইউজারদের জন্য ডিফল্ট প্রোফাইল তৈরি করুন
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
    pond_count = VALUES(pond_count);
```

### ধাপ ২: চেক করুন

ডেটাবেসে এই কমান্ড চালান:
```sql
SELECT COUNT(*) as profile_count FROM user_profiles;
```

### ধাপ ৩: টেস্ট করুন

1. আপনার ব্রাউজারে যান: `http://localhost/fishcare/pages/dashboard/farmer/profile.php`
2. লগইন করুন (farmer1 / farmer123)
3. Profile পেজটি খুলুন এবং কাজ করছে কিনা দেখুন

## 📋 যা আপডেট হয়েছে:

✅ `user_profiles` টেবিল তৈরি  
✅ ফর্ম ফিল্ড নাম পরিবর্তন:
   - `experience_years` → `farming_experience`
   - `fish_species` → `preferred_fish_species`
   - `annual_production` → `annual_income`
   - `specialization` → `bio`

✅ চাষের ধরনের অপশন:
   - পারম্পরিক, আধুনিক, অর্ধ-আধুনিক

## 🆘 সমস্যা থাকলে:

যদি এখনও সমস্যা থাকে, তাহলে:
1. ব্রাউজার cache clear করুন
2. PHP server restart করুন
3. ডেটাবেস connection চেক করুন

---
**নোট:** এই সমাধানটি আপনার existing ডেটাবেস কোনো ক্ষতি করবে না।
