<?php
/**
 * সাধারণ কনফিগারেশন সেটিংস
 * ফিশ কেয়ার সিস্টেম
 */

// সেশন শুরু করুন (যদি ইতিমধ্যে শুরু না হয়)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// টাইমজোন সেট করুন
date_default_timezone_set('Asia/Dhaka');

// সাইট সেটিংস
define('SITE_NAME', 'ফিশ কেয়ার সিস্টেম');
define('SITE_URL', 'http://localhost/fishcare');
define('SITE_EMAIL', 'info@fishcare.com');

// ফাইল আপলোড সেটিংস
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'pdf']);

// পেজিনেশন
define('ITEMS_PER_PAGE', 20);

// সিকিউরিটি
define('HASH_ALGO', PASSWORD_DEFAULT);
define('SESSION_LIFETIME', 7200); // 2 ঘন্টা

// ত্রুটি রিপোর্টিং (প্রোডাকশনে বন্ধ করুন)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ডেটাবেস ইনক্লুড করুন
require_once __DIR__ . '/database.php';

// হেল্পার ফাংশন ইনক্লুড করুন
require_once __DIR__ . '/../includes/functions.php';

// রোল-ভিত্তিক রিডাইরেক্ট URL
$ROLE_DASHBOARD = [
    'admin' => '/pages/dashboard/admin/index.php',
    'farmer' => '/pages/dashboard/farmer/index.php',
    'wholesaler' => '/pages/dashboard/wholesaler/index.php',
    'seller' => '/pages/dashboard/seller/index.php',
    'customer' => '/pages/dashboard/customer/index.php',
    'visitor' => '/index.php'
];

// রোল-ভিত্তিক ড্যাশবোর্ড রিটার্ন করুন
function getRoleDashboard($role) {
    global $ROLE_DASHBOARD;
    return $ROLE_DASHBOARD[$role] ?? '/index.php';
}
