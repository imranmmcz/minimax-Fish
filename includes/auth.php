<?php
/**
 * Authentication এবং সেশন ম্যানেজমেন্ট
 * ফিশ কেয়ার সিস্টেম
 */

require_once __DIR__ . '/../config/config.php';

/**
 * ইউজার রেজিস্ট্রেশন
 */
function registerUser($data) {
    try {
        $db = getDB();
        
        // ইনপুট ভ্যালিডেশন
        $required = ['username', 'email', 'password', 'full_name', 'role'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return ['success' => false, 'error' => 'সব ফিল্ড পূরণ করুন'];
            }
        }
        
        // ইমেইল ফরম্যাট চেক
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'সঠিক ইমেইল দিন'];
        }
        
        // পাসওয়ার্ড দৈর্ঘ্য চেক
        if (strlen($data['password']) < 6) {
            return ['success' => false, 'error' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে'];
        }
        
        // ইউজারনেম এবং ইমেইল ইউনিক চেক
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$data['username'], $data['email']]);
        if ($stmt->fetch()) {
            return ['success' => false, 'error' => 'ইউজারনেম বা ইমেইল ইতিমধ্যে ব্যবহৃত'];
        }
        
        // পাসওয়ার্ড হ্যাশ করুন
        $hashedPassword = password_hash($data['password'], HASH_ALGO);
        
        // ইউজার ইনসার্ট করুন
        $stmt = $db->prepare("
            INSERT INTO users (username, email, password, role, full_name, phone, 
                             division_id, district_id, upazila_id, address)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            $data['username'],
            $data['email'],
            $hashedPassword,
            $data['role'],
            $data['full_name'],
            $data['phone'] ?? null,
            $data['division_id'] ?? null,
            $data['district_id'] ?? null,
            $data['upazila_id'] ?? null,
            $data['address'] ?? null
        ]);
        
        if ($result) {
            $userId = $db->lastInsertId();
            logActivity('user_registered', "নতুন {$data['role']} রেজিস্টার হয়েছে", $userId);
            return ['success' => true, 'user_id' => $userId];
        }
        
        return ['success' => false, 'error' => 'রেজিস্ট্রেশন ব্যর্থ'];
        
    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        return ['success' => false, 'error' => 'সিস্টেম ত্রুটি'];
    }
}

/**
 * ইউজার লগইন
 */
function loginUser($username, $password) {
    try {
        $db = getDB();
        
        // ইনপুট ভ্যালিডেশন
        if (empty($username) || empty($password)) {
            return ['success' => false, 'error' => 'ইউজারনেম এবং পাসওয়ার্ড দিন'];
        }
        
        // ইউজার খুঁজুন
        $stmt = $db->prepare("
            SELECT id, username, email, password, role, full_name, status 
            FROM users 
            WHERE (username = ? OR email = ?) AND status = 'active'
        ");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        
        if (!$user) {
            return ['success' => false, 'error' => 'ইউজার পাওয়া যায়নি'];
        }
        
        // পাসওয়ার্ড যাচাই করুন
        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'error' => 'ভুল পাসওয়ার্ড'];
        }
        
        // সেশন তৈরি করুন
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['logged_in_time'] = time();
        
        // সেশন হাইজ্যাকিং প্রতিরোধ
        session_regenerate_id(true);
        
        // লগ রেকর্ড করুন
        logActivity('user_login', "ইউজার লগইন করেছে", $user['id']);
        
        return [
            'success' => true,
            'user' => [
                'id' => $user['id'],
                'name' => $user['full_name'],
                'role' => $user['role']
            ]
        ];
        
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return ['success' => false, 'error' => 'সিস্টেম ত্রুটি'];
    }
}

/**
 * ইউজার লগআউট
 */
function logoutUser() {
    if (isLoggedIn()) {
        $userId = getUserId();
        logActivity('user_logout', "ইউজার লগআউট করেছে", $userId);
    }
    
    // সেশন ধ্বংস করুন
    $_SESSION = array();
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    session_destroy();
    return true;
}

/**
 * বর্তমান ইউজারের সম্পূর্ণ তথ্য পান
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    try {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT u.*, 
                   d.name as division_name,
                   dis.name as district_name,
                   upz.name as upazila_name
            FROM users u
            LEFT JOIN divisions d ON u.division_id = d.id
            LEFT JOIN districts dis ON u.district_id = dis.id
            LEFT JOIN upazilas upz ON u.upazila_id = upz.id
            WHERE u.id = ?
        ");
        $stmt->execute([getUserId()]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Get user error: " . $e->getMessage());
        return null;
    }
}

/**
 * ইউজার প্রোফাইল আপডেট করুন
 */
function updateUserProfile($userId, $data) {
    try {
        $db = getDB();
        
        // বর্তমান ডেটা পান (লগের জন্য)
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $oldData = $stmt->fetch();
        
        // আপডেট করুন
        $stmt = $db->prepare("
            UPDATE users 
            SET full_name = ?, phone = ?, division_id = ?, district_id = ?, 
                upazila_id = ?, address = ?, updated_at = NOW()
            WHERE id = ?
        ");
        
        $result = $stmt->execute([
            $data['full_name'],
            $data['phone'] ?? null,
            $data['division_id'] ?? null,
            $data['district_id'] ?? null,
            $data['upazila_id'] ?? null,
            $data['address'] ?? null,
            $userId
        ]);
        
        if ($result) {
            // প্রোফাইল আপডেট লগ রেকর্ড করুন
            foreach ($data as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $stmt = $db->prepare("
                        INSERT INTO profile_updates (user_id, field_name, old_value, new_value)
                        VALUES (?, ?, ?, ?)
                    ");
                    $stmt->execute([$userId, $key, $oldData[$key], $value]);
                }
            }
            
            // সেশন আপডেট করুন
            if (getUserId() == $userId) {
                $_SESSION['user_name'] = $data['full_name'];
            }
            
            logActivity('profile_updated', "প্রোফাইল আপডেট করা হয়েছে", $userId);
            return ['success' => true];
        }
        
        return ['success' => false, 'error' => 'আপডেট ব্যর্থ'];
        
    } catch (PDOException $e) {
        error_log("Update profile error: " . $e->getMessage());
        return ['success' => false, 'error' => 'সিস্টেম ত্রুটি'];
    }
}

/**
 * পাসওয়ার্ড পরিবর্তন করুন
 */
function changePassword($userId, $oldPassword, $newPassword) {
    try {
        $db = getDB();
        
        // পাসওয়ার্ড দৈর্ঘ্য চেক
        if (strlen($newPassword) < 6) {
            return ['success' => false, 'error' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে'];
        }
        
        // বর্তমান পাসওয়ার্ড যাচাই করুন
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if (!$user || !password_verify($oldPassword, $user['password'])) {
            return ['success' => false, 'error' => 'পুরাতন পাসওয়ার্ড ভুল'];
        }
        
        // নতুন পাসওয়ার্ড হ্যাশ করুন এবং আপডেট করুন
        $hashedPassword = password_hash($newPassword, HASH_ALGO);
        $stmt = $db->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
        $result = $stmt->execute([$hashedPassword, $userId]);
        
        if ($result) {
            logActivity('password_changed', "পাসওয়ার্ড পরিবর্তন করা হয়েছে", $userId);
            return ['success' => true];
        }
        
        return ['success' => false, 'error' => 'পাসওয়ার্ড পরিবর্তন ব্যর্থ'];
        
    } catch (PDOException $e) {
        error_log("Change password error: " . $e->getMessage());
        return ['success' => false, 'error' => 'সিস্টেম ত্রুটি'];
    }
}
