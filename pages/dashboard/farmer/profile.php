<?php
$pageTitle = 'প্রোফাইল সম্পাদনা';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

// চাষী রোল চেক করুন
requireRole('farmer');

$db = getDB();
$userId = getUserId();

// ইউজারের মূল তথ্য পান
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// চাষ সংক্রান্ত তথ্য
$stmt = $db->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
$stmt->execute([$userId]);
$profile = $stmt->fetch();

// যদি প্রোফাইল না থাকে তাহলে ডিফল্ট ভ্যালু দিয়ে তৈরি করুন
if (!$profile) {
    $createProfile = $db->prepare("INSERT INTO user_profiles (user_id, farming_experience, pond_count, farming_type, preferred_fish_species, annual_income, bio) VALUES (?, 0, 0, 'traditional', '', 0.00, '')");
    $createProfile->execute([$userId]);
    
    // পুনরায় লোড করুন
    $stmt = $db->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
    $stmt->execute([$userId]);
    $profile = $stmt->fetch();
}

// ফর্ম সাবমিট হ্যান্ডলিং
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // ব্যক্তিগত তথ্য আপডেট
        if (isset($_POST['update_personal'])) {
            $full_name = $_POST['full_name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            
            // ফর্ম ভ্যালিডেশন
            if (empty($full_name) || empty($phone)) {
                setError('নাম এবং ফোন নম্বর আবশ্যক');
            } else {
                // ইমেইল ইউনিক চেক করুন
                if (!empty($email) && $email !== $user['email']) {
                    $check = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                    $check->execute([$email, $userId]);
                    if ($check->fetch()) {
                        setError('এই ইমেইল ইতিমধ্যে ব্যবহার করা হয়েছে');
                    }
                }
                
                if (empty(getError())) {
                    $stmt = $db->prepare("
                        UPDATE users 
                        SET full_name = ?, email = ?, phone = ?, address = ?
                        WHERE id = ?
                    ");
                    $stmt->execute([$full_name, $email, $phone, $address, $userId]);
                    
                    if ($stmt) {
                        setSuccess('ব্যক্তিগত তথ্য সফলভাবে আপডেট হয়েছে');
                        
                        // পুনরায় লোড করুন
                        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
                        $stmt->execute([$userId]);
                        $user = $stmt->fetch();
                    }
                }
            }
        }
        
        // চাষ সংক্রান্ত তথ্য আপডেট
        if (isset($_POST['update_farming'])) {
            $farming_experience = (int)$_POST['farming_experience'];
            $pond_count = (int)$_POST['pond_count'];
            $preferred_fish_species = $_POST['preferred_fish_species'];
            $farming_type = $_POST['farming_type'];
            $annual_income = (float)$_POST['annual_income'];
            $bio = $_POST['bio'];
            
            if ($farming_experience < 0 || $pond_count < 0 || $annual_income < 0) {
                setError('অভিজ্ঞতা, পুকুরের সংখ্যা এবং আয় সঠিক হতে হবে');
            } else {
                // প্রোফাইল আপডেট করুন
                $stmt = $db->prepare("
                    INSERT INTO user_profiles (user_id, farming_experience, pond_count, preferred_fish_species, farming_type, annual_income, bio) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE 
                    farming_experience = VALUES(farming_experience),
                    pond_count = VALUES(pond_count),
                    preferred_fish_species = VALUES(preferred_fish_species),
                    farming_type = VALUES(farming_type),
                    annual_income = VALUES(annual_income),
                    bio = VALUES(bio)
                ");
                $stmt->execute([$userId, $farming_experience, $pond_count, $preferred_fish_species, $farming_type, $annual_income, $bio]);
                
                if ($stmt) {
                    setSuccess('চাষ সংক্রান্ত তথ্য সফলভাবে আপডেট হয়েছে');
                    
                    // পুনরায় লোড করুন
                    $stmt = $db->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
                    $stmt->execute([$userId]);
                    $profile = $stmt->fetch();
                }
            }
        }
        
        // পাসওয়ার্ড পরিবর্তন
        if (isset($_POST['update_password'])) {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                setError('সকল পাসওয়ার্ড ফিল্ড পূরণ করুন');
            } elseif (!password_verify($current_password, $user['password'])) {
                setError('বর্তমান পাসওয়ার্ড ভুল');
            } elseif ($new_password !== $confirm_password) {
                setError('নতুন পাসওয়ার্ড এবং নিশ্চিতকরণ পাসওয়ার্ড মিলছে না');
            } elseif (strlen($new_password) < 6) {
                setError('পাসওয়ার্ড অন্তত ৬ অক্ষরের হতে হবে');
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->execute([$hashed_password, $userId]);
                
                if ($stmt) {
                    setSuccess('পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে');
                }
            }
        }
        
        // ছবি আপলোড
        if (isset($_POST['update_photo'])) {
            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../../../assets/images/profiles/';
                
                // ডিরেক্টরি তৈরি করুন
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file = $_FILES['profile_photo'];
                $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
                $max_size = 2 * 1024 * 1024; // 2MB
                
                if (!in_array($file['type'], $allowed_types)) {
                    setError('শুধুমাত্র JPG, PNG এবং WebP ফরম্যাটের ছবি আপলোড করা যাবে');
                } elseif ($file['size'] > $max_size) {
                    setError('ছবির সাইজ ২MB এর কম হতে হবে');
                } else {
                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filename = 'profile_' . $userId . '_' . time() . '.' . $extension;
                    $filepath = $upload_dir . $filename;
                    
                    if (move_uploaded_file($file['tmp_name'], $filepath)) {
                        // পুরাতন ছবি ডিলিট করুন
                        if (!empty($user['profile_image']) && file_exists($upload_dir . $user['profile_image'])) {
                            unlink($upload_dir . $user['profile_image']);
                        }
                        
                        // ডেটাবেস আপডেট করুন
                        $stmt = $db->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
                        $stmt->execute([$filename, $userId]);
                        
                        if ($stmt) {
                            setSuccess('প্রোফাইল ছবি সফলভাবে আপলোড হয়েছে');
                            
                            // পুনরায় লোড করুন
                            $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
                            $stmt->execute([$userId]);
                            $user = $stmt->fetch();
                        }
                    } else {
                        setError('ছবি আপলোড করতে সমস্যা হয়েছে');
                    }
                }
            }
        }
        
    } catch (Exception $e) {
        setError('সমস্যা হয়েছে: ' . $e->getMessage());
    }
}

// অ্যাকাউন্ট সেটিংস
if (isset($_POST['update_settings'])) {
    $email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
    $sms_notifications = isset($_POST['sms_notifications']) ? 1 : 0;
    
    $stmt = $db->prepare("
        UPDATE users 
        SET email_notifications = ?, sms_notifications = ?
        WHERE id = ?
    ");
    $stmt->execute([$email_notifications, $sms_notifications, $userId]);
    
    if ($stmt) {
        setSuccess('অ্যাকাউন্ট সেটিংস আপডেট হয়েছে');
        
        // পুনরায় লোড করুন
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
    }
}

include_once __DIR__ . '/../../../includes/header.php';
?>

<div class="profile-page-layout">
    <!-- Profile Header -->
    <div class="profile-header glass-card">
        <div class="profile-image-section">
            <div class="profile-image-container">
                <?php if (!empty($user['profile_image'])): ?>
                    <img src="/fishcare/assets/images/profiles/<?php echo escape($user['profile_image']); ?>" 
                         alt="প্রোফাইল ছবি" class="profile-image">
                <?php else: ?>
                    <div class="profile-image-placeholder">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                            <path d="M24 4C12.95 4 4 12.95 4 24C4 35.05 12.95 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4ZM24 34C18.48 34 14 29.52 14 24C14 18.48 18.48 14 24 14C29.52 14 34 18.48 34 24C34 29.52 29.52 34 24 34Z"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>
            <div class="profile-info">
                <h2><?php echo escape($user['full_name'] ?? 'নাম পাওয়া যায়নি'); ?></h2>
                <p class="user-role">চাষী</p>
                <p class="member-since">সদস্য হিসেবে যোগদান: <?php echo !empty($user['created_at']) ? formatDate($user['created_at']) : 'অজানা'; ?></p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="profile-content">
        <!-- Sidebar -->
        <div class="profile-sidebar">
            <div class="profile-nav glass-card">
                <h3>সেকশন</h3>
                <nav class="profile-nav-links">
                    <a href="#personal-info" class="nav-link active" onclick="switchSection('personal-info')">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C11.66 4 13 5.34 13 7C13 8.66 11.66 10 10 10C8.34 10 7 8.66 7 7C7 5.34 8.34 4 10 4ZM10 17C7.33 17 5.01 15.45 4 13.25C4.03 11 8 9.79 10 9.79C11.99 9.79 15.97 11 16 13.25C14.99 15.45 12.67 17 10 17Z"/>
                        </svg>
                        ব্যক্তিগত তথ্য
                    </a>
                    <a href="#farming-info" class="nav-link" onclick="switchSection('farming-info')">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 15C7.24 15 5 12.76 5 10C5 7.24 7.24 5 10 5C12.76 5 15 7.24 15 10C15 12.76 12.76 15 10 15Z"/>
                        </svg>
                        চাষ সংক্রান্ত তথ্য
                    </a>
                    <a href="#photo-upload" class="nav-link" onclick="switchSection('photo-upload')">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.5 1H11.5L14 3.5V18.5H6V1H8.5ZM14 16.5H6V3H14V16.5Z"/>
                        </svg>
                        প্রোফাইল ছবি
                    </a>
                    <a href="#password-change" class="nav-link" onclick="switchSection('password-change')">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17,8V6C17,2.93 15.36,0.69 12,0.07V2H18V6H12V8H17ZM6,2H2V6H6V8H0V6C0,2.93 1.64,0.69 5,0.07V2H6Z"/>
                        </svg>
                        পাসওয়ার্ড পরিবর্তন
                    </a>
                    <a href="#account-settings" class="nav-link" onclick="switchSection('account-settings')">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M10,2A8,8 0 0,0 2,10C2,11.74 2.45,13.4 3.18,14.84L2.06,17.94C1.91,18.32 2.16,18.77 2.58,18.83C2.69,18.85 2.8,18.81 2.89,18.75L5.6,16.96C6.34,17.59 7.16,18.12 8.05,18.5L9.42,21.58C9.49,21.73 9.62,21.84 9.78,21.9C9.94,21.97 10.12,21.97 10.28,21.9C10.44,21.84 10.57,21.73 10.64,21.58L12.01,18.5C12.9,18.12 13.72,17.59 14.46,16.96L17.17,18.75C17.26,18.81 17.37,18.85 17.48,18.83C17.9,18.77 18.15,18.32 18,17.94L16.88,14.84C17.61,13.4 18.06,11.74 18.06,10A8,8 0 0,0 10,2Z"/>
                        </svg>
                        অ্যাকাউন্ট সেটিংস
                    </a>
                </nav>
            </div>
        </div>

        <!-- Form Sections -->
        <div class="profile-forms">
            <!-- ব্যক্তিগত তথ্য -->
            <div id="personal-info" class="form-section active">
                <div class="glass-card">
                    <div class="section-header">
                        <h3>ব্যক্তিগত তথ্য সম্পাদনা</h3>
                        <p>আপনার ব্যক্তিগত তথ্য পরিবর্তন করুন</p>
                    </div>
                    
                    <form method="POST" class="profile-form" id="personalForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="full_name">সম্পূর্ণ নাম *</label>
                                <input type="text" id="full_name" name="full_name" 
                                       value="<?php echo escape($user['full_name'] ?? ''); ?>" 
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="phone">ফোন নম্বর *</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="<?php echo escape($user['phone'] ?? ''); ?>" 
                                       required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">ইমেইল ঠিকানা</label>
                                <input type="email" id="email" name="email" 
                                       value="<?php echo escape($user['email'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="address">ঠিকানা</label>
                                <textarea id="address" name="address" rows="3"><?php echo escape($user['address'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="update_personal" class="btn-primary">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 13L4 9L5.41 7.59L8 10.17L14.59 3.58L16 5L8 13Z"/>
                                </svg>
                                তথ্য আপডেট করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- চাষ সংক্রান্ত তথ্য -->
            <div id="farming-info" class="form-section">
                <div class="glass-card">
                    <div class="section-header">
                        <h3>চাষ সংক্রান্ত তথ্য</h3>
                        <p>আপনার চাষের অভিজ্ঞতা ও তথ্য যোগ করুন</p>
                    </div>
                    
                    <form method="POST" class="profile-form" id="farmingForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="experience_years">অভিজ্ঞতা (বছর)</label>
                                <input type="number" id="farming_experience" name="farming_experience" 
                                       value="<?php echo escape($profile['farming_experience'] ?? '0'); ?>" 
                                       min="0" max="50">
                            </div>
                            <div class="form-group">
                                <label for="pond_count">পুকুরের সংখ্যা</label>
                                <input type="number" id="pond_count" name="pond_count" 
                                       value="<?php echo escape($profile['pond_count'] ?? '0'); ?>" 
                                       min="0">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="farming_type">চাষের ধরন</label>
                                <select id="farming_type" name="farming_type">
                                    <option value="">ধরন নির্বাচন করুন</option>
                                    <option value="traditional" <?php echo ($profile['farming_type'] ?? '') === 'traditional' ? 'selected' : ''; ?>>পারম্পরিক</option>
                                    <option value="modern" <?php echo ($profile['farming_type'] ?? '') === 'modern' ? 'selected' : ''; ?>>আধুনিক</option>
                                    <option value="semi_modern" <?php echo ($profile['farming_type'] ?? '') === 'semi_modern' ? 'selected' : ''; ?>>অর্ধ-আধুনিক</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="annual_income">বার্ষিক আয় (টাকা)</label>
                                <input type="number" id="annual_income" name="annual_income" 
                                       value="<?php echo escape($profile['annual_income'] ?? '0'); ?>" 
                                       min="0" step="0.01">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="preferred_fish_species">মূল মাছের প্রজাতি</label>
                            <input type="text" id="preferred_fish_species" name="preferred_fish_species" 
                                   value="<?php echo escape($profile['preferred_fish_species'] ?? ''); ?>"
                                   placeholder="যেমন: রুই, কাতলা, পাঙ্গাশ, তেলাপিয়া">
                        </div>
                        
                        <div class="form-group">
                            <label for="bio">ব্যক্তিগত পরিচয়</label>
                            <textarea id="bio" name="bio" rows="3" 
                                      placeholder="আপনার চাষ সংক্রান্ত অভিজ্ঞতা এবং বিশেষত্ব সম্পর্কে লিখুন"><?php echo escape($profile['bio'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="update_farming" class="btn-primary">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 13L4 9L5.41 7.59L8 10.17L14.59 3.58L16 5L8 13Z"/>
                                </svg>
                                তথ্য সংরক্ষণ করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- প্রোফাইল ছবি -->
            <div id="photo-upload" class="form-section">
                <div class="glass-card">
                    <div class="section-header">
                        <h3>প্রোফাইল ছবি পরিবর্তন</h3>
                        <p>আপনার প্রোফাইল ছবি আপলোড বা পরিবর্তন করুন</p>
                    </div>
                    
                    <form method="POST" enctype="multipart/form-data" class="profile-form" id="photoForm">
                        <div class="upload-section">
                            <div class="current-photo">
                                <?php if (!empty($user['profile_image'])): ?>
                                    <img src="/fishcare/assets/images/profiles/<?php echo escape($user['profile_image']); ?>" 
                                         alt="বর্তমান প্রোফাইল ছবি" class="preview-image">
                                <?php else: ?>
                                    <div class="preview-placeholder">
                                        <svg width="64" height="64" viewBox="0 0 64 64" fill="currentColor">
                                            <path d="M32 8C18.75 8 8 18.75 8 32C8 45.25 18.75 56 32 56C45.25 56 56 45.25 56 32C56 18.75 45.25 8 32 8ZM32 44C23.16 44 16 36.84 16 28C16 19.16 23.16 12 32 12C40.84 12 48 19.16 48 28C48 36.84 40.84 44 32 44Z"/>
                                        </svg>
                                        <p>কোনো ছবি নেই</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="upload-controls">
                                <div class="form-group">
                                    <label for="profile_photo">নতুন ছবি নির্বাচন করুন</label>
                                    <input type="file" id="profile_photo" name="profile_photo" 
                                           accept="image/jpeg,image/png,image/webp"
                                           onchange="previewImage(this)">
                                    <small class="form-help">
                                        সাপোর্টেড ফরম্যাট: JPG, PNG, WebP (সর্বোচ্চ 2MB)
                                    </small>
                                </div>
                                
                                <div class="image-preview" id="imagePreview" style="display: none;">
                                    <img id="previewImg" alt="প্রাকদর্শন">
                                    <button type="button" onclick="clearPreview()" class="remove-preview">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M15 5L5 15M5 5L15 15"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="update_photo" class="btn-primary">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 13L4 9L5.41 7.59L8 10.17L14.59 3.58L16 5L8 13Z"/>
                                </svg>
                                ছবি আপলোড করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- পাসওয়ার্ড পরিবর্তন -->
            <div id="password-change" class="form-section">
                <div class="glass-card">
                    <div class="section-header">
                        <h3>পাসওয়ার্ড পরিবর্তন</h3>
                        <p>আপনার পাসওয়ার্ড আপডেট করুন</p>
                    </div>
                    
                    <form method="POST" class="profile-form" id="passwordForm">
                        <div class="form-group">
                            <label for="current_password">বর্তমান পাসওয়ার্ড *</label>
                            <div class="password-input">
                                <input type="password" id="current_password" name="current_password" required>
                                <button type="button" onclick="togglePassword('current_password')" class="password-toggle">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 3C5.03 3 1 7.03 1 12C1 17.03 5.03 21 10 21C15.03 21 19 17.03 19 12C19 7.03 15.03 3 10 3ZM10 19C6.13 19 3 15.87 3 12C3 8.13 6.13 5 10 5C13.87 5 17 8.13 17 12C17 15.87 13.87 19 10 19ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7Z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="new_password">নতুন পাসওয়ার্ড *</label>
                                <div class="password-input">
                                    <input type="password" id="new_password" name="new_password" required>
                                    <button type="button" onclick="togglePassword('new_password')" class="password-toggle">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 3C5.03 3 1 7.03 1 12C1 17.03 5.03 21 10 21C15.03 21 19 17.03 19 12C19 7.03 15.03 3 10 3ZM10 19C6.13 19 3 15.87 3 12C3 8.13 6.13 5 10 5C13.87 5 17 8.13 17 12C17 15.87 13.87 19 10 19ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7Z"/>
                                        </svg>
                                    </button>
                                </div>
                                <small class="form-help">পাসওয়ার্ড অন্তত ৬ অক্ষরের হতে হবে</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="confirm_password">পাসওয়ার্ড নিশ্চিত করুন *</label>
                                <div class="password-input">
                                    <input type="password" id="confirm_password" name="confirm_password" required>
                                    <button type="button" onclick="togglePassword('confirm_password')" class="password-toggle">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 3C5.03 3 1 7.03 1 12C1 17.03 5.03 21 10 21C15.03 21 19 17.03 19 12C19 7.03 15.03 3 10 3ZM10 19C6.13 19 3 15.87 3 12C3 8.13 6.13 5 10 5C13.87 5 17 8.13 17 12C17 15.87 13.87 19 10 19ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="update_password" class="btn-primary">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 13L4 9L5.41 7.59L8 10.17L14.59 3.58L16 5L8 13Z"/>
                                </svg>
                                পাসওয়ার্ড আপডেট করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- অ্যাকাউন্ট সেটিংস -->
            <div id="account-settings" class="form-section">
                <div class="glass-card">
                    <div class="section-header">
                        <h3>অ্যাকাউন্ট সেটিংস</h3>
                        <p>নোটিফিকেশন ও প্রাইভেসি সেটিংস</p>
                    </div>
                    
                    <form method="POST" class="profile-form" id="settingsForm">
                        <div class="settings-group">
                            <h4>নোটিফিকেশন সেটিংস</h4>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="email_notifications" value="1" 
                                           <?php echo ($user['email_notifications'] ?? 1) ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                    ইমেইল নোটিফিকেশন পান
                                </label>
                                <small class="form-help">
                                    আপনার ইমেইলে গুরুত্বপূর্ণ আপডেট ও নোটিফিকেশন পাবেন
                                </small>
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="sms_notifications" value="1" 
                                           <?php echo ($user['sms_notifications'] ?? 1) ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                    SMS নোটিফিকেশন পান
                                </label>
                                <small class="form-help">
                                    মোবাইল নম্বরে গুরুত্বপূর্ণ বার্তা পাবেন
                                </small>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="update_settings" class="btn-primary">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 13L4 9L5.41 7.59L8 10.17L14.59 3.58L16 5L8 13Z"/>
                                </svg>
                                সেটিংস সংরক্ষণ করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-page-layout {
    max-width: 1400px;
    margin: 0 auto;
    padding: var(--space-8);
}

/* Profile Header */
.profile-header {
    margin-bottom: var(--space-8);
    padding: var(--space-8);
}

.profile-image-section {
    display: flex;
    align-items: center;
    gap: var(--space-6);
}

.profile-image-container {
    position: relative;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--color-primary-100);
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-image-placeholder {
    color: var(--color-primary-500);
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-info h2 {
    margin-bottom: var(--space-2);
    color: var(--color-neutral-900);
}

.user-role {
    background: var(--color-primary-500);
    color: white;
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-md);
    display: inline-block;
    font-size: 0.875rem;
    margin-bottom: var(--space-2);
}

.member-since {
    color: var(--color-neutral-600);
    font-size: 0.875rem;
}

/* Main Content Layout */
.profile-content {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: var(--space-8);
}

/* Profile Sidebar */
.profile-sidebar {
    height: fit-content;
}

.profile-nav {
    padding: var(--space-6);
}

.profile-nav h3 {
    margin-bottom: var(--space-4);
    font-size: 1.125rem;
    color: var(--color-neutral-900);
}

.profile-nav-links {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.profile-nav-links .nav-link {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-4);
    color: var(--color-neutral-700);
    border-radius: var(--radius-md);
    transition: all var(--duration-fast) var(--easing-default);
    text-decoration: none;
}

.profile-nav-links .nav-link:hover {
    background: rgba(0, 188, 212, 0.1);
    color: var(--color-primary-600);
}

.profile-nav-links .nav-link.active {
    background: var(--color-primary-500);
    color: white;
}

/* Profile Forms */
.profile-forms {
    min-height: 600px;
}

.form-section {
    display: none;
}

.form-section.active {
    display: block;
}

.glass-card {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: var(--radius-xl);
    padding: var(--space-8);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.section-header {
    margin-bottom: var(--space-8);
    text-align: center;
}

.section-header h3 {
    margin-bottom: var(--space-2);
    color: var(--color-neutral-900);
}

.section-header p {
    color: var(--color-neutral-600);
}

/* Forms */
.profile-form {
    max-width: none;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-6);
    margin-bottom: var(--space-6);
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.form-group label {
    font-weight: 500;
    color: var(--color-neutral-800);
    font-size: 0.875rem;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: var(--space-3) var(--space-4);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: var(--radius-md);
    background: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
    transition: all var(--duration-fast) var(--easing-default);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--color-primary-500);
    box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.1);
}

.form-help {
    color: var(--color-neutral-500);
    font-size: 0.75rem;
    margin-top: var(--space-1);
}

/* Password Input */
.password-input {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: var(--space-3);
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--color-neutral-500);
    cursor: pointer;
    padding: var(--space-1);
    border-radius: var(--radius-sm);
    transition: color var(--duration-fast) var(--easing-default);
}

.password-toggle:hover {
    color: var(--color-neutral-700);
}

/* Upload Section */
.upload-section {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: var(--space-8);
    align-items: start;
    margin-bottom: var(--space-8);
}

.current-photo {
    text-align: center;
}

.preview-image,
.preview-placeholder {
    width: 150px;
    height: 150px;
    border-radius: var(--radius-lg);
    object-fit: cover;
    background: var(--color-neutral-100);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--color-neutral-500);
    margin: 0 auto;
}

.preview-image {
    border: 3px solid var(--color-primary-500);
}

.preview-placeholder svg {
    margin-bottom: var(--space-2);
}

.upload-controls {
    padding-top: var(--space-2);
}

/* Image Preview */
.image-preview {
    position: relative;
    margin-top: var(--space-4);
    max-width: 200px;
}

.image-preview img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: var(--radius-lg);
    border: 2px solid var(--color-primary-300);
}

.remove-preview {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 32px;
    height: 32px;
    background: var(--color-error-500);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

/* Checkbox */
.checkbox-label {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    cursor: pointer;
    font-size: 1rem;
    color: var(--color-neutral-800);
}

.checkbox-label input[type="checkbox"] {
    display: none;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid var(--color-neutral-300);
    border-radius: var(--radius-sm);
    position: relative;
    transition: all var(--duration-fast) var(--easing-default);
}

.checkbox-label input[type="checkbox"]:checked + .checkmark {
    background: var(--color-primary-500);
    border-color: var(--color-primary-500);
}

.checkbox-label input[type="checkbox"]:checked + .checkmark::after {
    content: '';
    position: absolute;
    left: 6px;
    top: 2px;
    width: 6px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

/* Settings Group */
.settings-group {
    margin-bottom: var(--space-8);
}

.settings-group h4 {
    margin-bottom: var(--space-4);
    color: var(--color-neutral-900);
    font-size: 1.125rem;
}

/* Buttons */
.form-actions {
    display: flex;
    justify-content: center;
    gap: var(--space-4);
    margin-top: var(--space-8);
}

.btn-primary {
    background: var(--color-primary-500);
    color: white;
    border: none;
    padding: var(--space-3) var(--space-6);
    border-radius: var(--radius-md);
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all var(--duration-fast) var(--easing-default);
    display: flex;
    align-items: center;
    gap: var(--space-2);
    text-decoration: none;
}

.btn-primary:hover {
    background: var(--color-primary-600);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 188, 212, 0.3);
}

.btn-primary:active {
    transform: translateY(0);
}

/* Responsive Design */
@media screen and (max-width: 1024px) {
    .profile-content {
        grid-template-columns: 240px 1fr;
        gap: var(--space-6);
    }
    
    .form-row {
        gap: var(--space-4);
    }
}

@media screen and (max-width: 768px) {
    .profile-page-layout {
        padding: var(--space-4);
    }
    
    .profile-content {
        grid-template-columns: 1fr;
        gap: var(--space-6);
    }
    
    .profile-sidebar {
        order: 2;
    }
    
    .profile-forms {
        order: 1;
    }
    
    .profile-nav {
        padding: var(--space-4);
    }
    
    .profile-nav-links {
        flex-direction: row;
        overflow-x: auto;
        gap: var(--space-1);
    }
    
    .profile-nav-links .nav-link {
        white-space: nowrap;
        min-width: fit-content;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .upload-section {
        grid-template-columns: 1fr;
        gap: var(--space-6);
        text-align: center;
    }
    
    .form-actions {
        flex-direction: column;
        gap: var(--space-3);
    }
    
    .btn-primary {
        width: 100%;
        justify-content: center;
    }
}

@media screen and (max-width: 480px) {
    .profile-header {
        padding: var(--space-6);
    }
    
    .glass-card {
        padding: var(--space-6);
    }
    
    .profile-image-section {
        flex-direction: column;
        text-align: center;
        gap: var(--space-4);
    }
    
    .profile-image-container {
        width: 100px;
        height: 100px;
    }
}
</style>

<script>
// Navigation Functions
function switchSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.form-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Remove active class from all nav links
    document.querySelectorAll('.profile-nav-links .nav-link').forEach(link => {
        link.classList.remove('active');
    });
    
    // Show selected section
    document.getElementById(sectionId).classList.add('active');
    
    // Add active class to clicked nav link
    event.target.closest('.nav-link').classList.add('active');
    
    // Smooth scroll to form
    document.getElementById(sectionId).scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// Password Toggle Function
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const button = field.nextElementSibling;
    
    if (field.type === 'password') {
        field.type = 'text';
        button.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 3C5.03 3 1 7.03 1 12C1 17.03 5.03 21 10 21C15.03 21 19 17.03 19 12C19 7.03 15.03 3 10 3ZM10 19C6.13 19 3 15.87 3 12C3 8.13 6.13 5 10 5C13.87 5 17 8.13 17 12C17 15.87 13.87 19 10 19ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7Z"/>
            </svg>
        `;
    } else {
        field.type = 'password';
        button.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                <path d="M3.53 2.47A17.77 17.77 0 0 1 10 3C15.03 3 19 7.03 19 12C19 17.03 15.03 21 10 21C4.97 21 1 17.03 1 12C1 7.03 4.97 3 10 3A17.77 17.77 0 0 1 16.47 4.53L13.42 7.58C13.1 7.9 12.61 8.1 12.11 8.1C11.52 8.1 11 7.58 11 6.99C11 6.49 11.21 6 11.53 5.68L3.53 2.47ZM15 12C15 8.13 12.69 5 9.2 4.98C5.71 4.96 3.47 7.2 3.45 10.69C3.43 14.18 5.67 16.42 9.16 16.44C12.65 16.46 14.89 14.22 14.91 10.73C14.93 8.67 14.33 6.78 13.23 5.43L10.29 8.36C10.7 8.77 11 9.35 11 10C11 10.63 10.63 11 10 11C9.35 11 8.78 10.71 8.36 10.29L5.45 13.2C4.2 12.1 3.33 10.21 3.33 8.22C3.33 3.72 6.96 0.09 11.46 0.09C15.96 0.09 19.59 3.72 19.59 8.22V8.33L16.04 11.88C15.7 12.22 15.21 12.44 14.71 12.44C14.22 12.44 13.73 12.22 13.39 11.88L12.36 10.85C11.91 10.4 11.66 9.76 11.66 9.11C11.66 8.46 11.91 7.82 12.36 7.37L15.27 4.46L15 12Z"/>
            </svg>
        `;
    }
}

// Image Preview Function
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const img = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Clear Preview Function
function clearPreview() {
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('profile_photo').value = '';
}

// Form Validation
document.addEventListener('DOMContentLoaded', function() {
    // Password form validation
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('নতুন পাসওয়ার্ড এবং নিশ্চিতকরণ পাসওয়ার্ড মিলছে না');
                return false;
            }
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('পাসওয়ার্ড অন্তত ৬ অক্ষরের হতে হবে');
                return false;
            }
        });
    }
    
    // Auto-hide flash messages
    setTimeout(function() {
        const flashMessages = document.querySelectorAll('.flash-message');
        flashMessages.forEach(function(message) {
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 300);
        });
    }, 5000);
    
    // Smooth animations for form sections
    document.querySelectorAll('.form-section').forEach(function(section) {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
    });
    
    // Add animation when switching sections
    const originalSwitchSection = window.switchSection;
    window.switchSection = function(sectionId) {
        originalSwitchSection(sectionId);
        
        setTimeout(() => {
            const activeSection = document.querySelector('.form-section.active');
            if (activeSection) {
                activeSection.style.opacity = '1';
                activeSection.style.transform = 'translateY(0)';
            }
        }, 100);
    };
});
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>