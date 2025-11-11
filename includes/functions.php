<?php
/**
 * সাধারণ হেল্পার ফাংশন
 * ফিশ কেয়ার সিস্টেম
 */

/**
 * XSS প্রতিরোধ - আউটপুট এস্কেপ করুন
 */
function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * ইনপুট ভ্যালিডেশন এবং স্যানিটাইজ
 */
function clean($data) {
    if (is_array($data)) {
        return array_map('clean', $data);
    }
    return trim(strip_tags($data));
}

/**
 * সফলতা মেসেজ সেট করুন
 */
function setSuccess($message) {
    $_SESSION['success'] = $message;
}

/**
 * ত্রুটি মেসেজ সেট করুন
 */
function setError($message) {
    $_SESSION['error'] = $message;
}

/**
 * সফলতা মেসেজ দেখান এবং মুছুন
 */
function getSuccess() {
    if (isset($_SESSION['success'])) {
        $msg = $_SESSION['success'];
        unset($_SESSION['success']);
        return $msg;
    }
    return null;
}

/**
 * ত্রুটি মেসেজ দেখান এবং মুছুন
 */
function getError() {
    if (isset($_SESSION['error'])) {
        $msg = $_SESSION['error'];
        unset($_SESSION['error']);
        return $msg;
    }
    return null;
}

/**
 * রিডাইরেক্ট করুন
 */
function redirect($url) {
    header("Location: " . $url);
    exit;
}

/**
 * ইউজার লগইন আছে কিনা চেক করুন
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * বর্তমান ইউজারের রোল পান
 */
function getUserRole() {
    return $_SESSION['user_role'] ?? 'visitor';
}

/**
 * বর্তমান ইউজার ID পান
 */
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * বর্তমান ইউজারের নাম পান
 */
function getUserName() {
    return $_SESSION['user_name'] ?? 'অতিথি';
}

/**
 * নির্দিষ্ট রোল চেক করুন
 */
function hasRole($role) {
    return getUserRole() === $role;
}

/**
 * একাধিক রোল চেক করুন
 */
function hasAnyRole($roles) {
    return in_array(getUserRole(), $roles);
}

/**
 * লগইন প্রয়োজন - না হলে রিডাইরেক্ট
 */
function requireLogin($redirect = '/pages/auth/login.php') {
    if (!isLoggedIn()) {
        setError('অনুগ্রহ করে প্রথমে লগইন করুন');
        redirect($redirect);
    }
}

/**
 * নির্দিষ্ট রোল প্রয়োজন
 */
function requireRole($role, $redirect = '/index.php') {
    requireLogin();
    if (!hasRole($role)) {
        setError('এই পেজে প্রবেশের অনুমতি নেই');
        redirect($redirect);
    }
}

/**
 * CSRF টোকেন তৈরি করুন
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * CSRF টোকেন যাচাই করুন
 */
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * তারিখ ফরম্যাট করুন (বাংলা)
 */
function formatDate($date, $format = 'd/m/Y') {
    if (empty($date)) return '';
    return date($format, strtotime($date));
}

/**
 * টাকা ফরম্যাট করুন
 */
function formatMoney($amount, $decimals = 2) {
    return number_format($amount, $decimals, '.', ',');
}

/**
 * ফাইল আপলোড করুন
 */
function uploadFile($file, $targetDir = 'uploads/') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'ফাইল আপলোড ব্যর্থ'];
    }
    
    // ফাইল সাইজ চেক
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'error' => 'ফাইল খুব বড়'];
    }
    
    // এক্সটেনশন চেক
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_EXTENSIONS)) {
        return ['success' => false, 'error' => 'অনুমোদিত ফাইল টাইপ নয়'];
    }
    
    // ইউনিক ফাইল নাম তৈরি করুন
    $newFileName = uniqid() . '_' . time() . '.' . $ext;
    $targetPath = UPLOAD_DIR . $targetDir . $newFileName;
    
    // ডিরেক্টরি তৈরি করুন (যদি না থাকে)
    if (!is_dir(UPLOAD_DIR . $targetDir)) {
        mkdir(UPLOAD_DIR . $targetDir, 0755, true);
    }
    
    // ফাইল মুভ করুন
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'filename' => $newFileName, 'path' => $targetPath];
    }
    
    return ['success' => false, 'error' => 'ফাইল সংরক্ষণ ব্যর্থ'];
}

/**
 * পেজিনেশন লিংক তৈরি করুন
 */
function pagination($currentPage, $totalPages, $baseUrl) {
    $html = '<div class="pagination">';
    
    // পূর্ববর্তী বাটন
    if ($currentPage > 1) {
        $html .= '<a href="' . $baseUrl . '?page=' . ($currentPage - 1) . '" class="btn-glass">পূর্ববর্তী</a>';
    }
    
    // পেজ নাম্বার
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = ($i === $currentPage) ? 'active' : '';
        $html .= '<a href="' . $baseUrl . '?page=' . $i . '" class="page-num ' . $active . '">' . $i . '</a>';
    }
    
    // পরবর্তী বাটন
    if ($currentPage < $totalPages) {
        $html .= '<a href="' . $baseUrl . '?page=' . ($currentPage + 1) . '" class="btn-glass">পরবর্তী</a>';
    }
    
    $html .= '</div>';
    return $html;
}

/**
 * JSON রেসপন্স পাঠান
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * সিস্টেম লগ রেকর্ড করুন
 */
function logActivity($action, $description = '', $userId = null) {
    try {
        $db = getDB();
        $userId = $userId ?? getUserId();
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $stmt = $db->prepare("
            INSERT INTO system_logs (user_id, action, description, ip_address, user_agent)
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([$userId, $action, $description, $ipAddress, $userAgent]);
    } catch (Exception $e) {
        // লগ ব্যর্থতা silent হওয়া উচিত
        error_log("Log failed: " . $e->getMessage());
    }
}
