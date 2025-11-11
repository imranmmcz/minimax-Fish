<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/auth.php';

$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pageTitle ?? 'ফিশ কেয়ার সিস্টেম'; ?> - <?php echo SITE_NAME; ?></title>
    
    <!-- Google Fonts - Hind Siliguri (বাংলা) এবং Poppins (ইংরেজি) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="/fishcare/assets/css/style.css">
    <link rel="stylesheet" href="/fishcare/assets/css/components.css">
    <link rel="stylesheet" href="/fishcare/assets/css/responsive.css">
    <link rel="stylesheet" href="/fishcare/assets/css/dropdown-fix.css">
    
    <!-- Custom Page CSS -->
    <?php if (isset($customCSS)): ?>
        <link rel="stylesheet" href="<?php echo $customCSS; ?>">
    <?php endif; ?>
</head>
<body class="<?php echo $bodyClass ?? ''; ?>">
    
    <!-- Glass Navigation Bar -->
    <nav class="glass-navbar">
        <div class="container nav-container">
            <!-- Logo -->
            <a href="/fishcare/index.php" class="nav-logo">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <path d="M20 5C10 5 5 15 5 20C5 25 8 35 20 35C32 35 35 25 35 20C35 15 30 5 20 5Z" fill="#00BCD4"/>
                    <ellipse cx="25" cy="18" rx="2" ry="2" fill="white"/>
                </svg>
                <span class="logo-text">ফিশ কেয়ার সিস্টেম</span>
            </a>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <!-- Navigation Menu -->
            <div class="nav-menu" id="navMenu">
                <?php if (isLoggedIn()): ?>
                    <!-- Logged In Menu -->
                    <a href="<?php echo getRoleDashboard(getUserRole()); ?>" class="nav-link">ড্যাশবোর্ড</a>
                    
                    <?php if (hasRole('farmer')): ?>
                        <a href="/fishcare/pages/dashboard/farmer/ponds.php" class="nav-link">পুকুর</a>
                        <a href="/fishcare/pages/dashboard/farmer/transactions.php" class="nav-link">লেনদেন</a>
                    <?php elseif (hasRole('wholesaler')): ?>
                        <a href="/fishcare/pages/dashboard/wholesaler/invoices.php" class="nav-link">ইনভয়েস</a>
                        <a href="/fishcare/pages/dashboard/wholesaler/shipments.php" class="nav-link">শিপমেন্ট</a>
                    <?php elseif (hasRole('seller')): ?>
                        <a href="/fishcare/pages/dashboard/seller/sales.php" class="nav-link">বিক্রয়</a>
                        <a href="/fishcare/pages/dashboard/seller/stocks.php" class="nav-link">স্টক</a>
                    <?php elseif (hasRole('admin')): ?>
                        <a href="/fishcare/pages/dashboard/admin/users.php" class="nav-link">ইউজার</a>
                        <a href="/fishcare/pages/dashboard/admin/reports.php" class="nav-link">রিপোর্ট</a>
                    <?php endif; ?>
                    
                    <!-- User Dropdown -->
                    <div class="nav-user-dropdown" id="navUserDropdown">
                        <button class="nav-user-btn" id="navUserBtn" type="button">
                            <span><?php echo escape(getUserName()); ?></span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu" id="navDropdownMenu">
                            <a href="/fishcare/pages/dashboard/farmer/profile.php" class="dropdown-item">প্রোফাইল</a>
                            <a href="/fishcare/pages/auth/logout.php" class="dropdown-item" id="navLogoutLink">লগআউট</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Public Menu -->
                    <a href="/fishcare/pages/public/tools-seba.php" class="nav-link">টুলসেবা</a>
                    <a href="/fishcare/pages/public/poramorsho.php" class="nav-link">পরামর্শ</a>
                    <a href="/fishcare/pages/public/rogo-byabosthapona.php" class="nav-link">রোগ ব্যবস্থাপনা</a>
                    <a href="/fishcare/pages/public/bazar-dor.php" class="nav-link">বাজার দর</a>
                    <a href="/fishcare/pages/public/calculator.php" class="nav-link">ক্যালকুলেটর</a>
                    
                    <!-- Auth Buttons -->
                    <a href="/fishcare/pages/auth/login.php" class="btn-glass btn-sm">লগইন</a>
                    <a href="/fishcare/pages/auth/register.php" class="btn-primary btn-sm">রেজিস্টার</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    <?php if ($success = getSuccess()): ?>
        <div class="flash-message flash-success">
            <div class="container">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM8 15L3 10L4.41 8.59L8 12.17L15.59 4.58L17 6L8 15Z"/>
                </svg>
                <span><?php echo escape($success); ?></span>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($error = getError()): ?>
        <div class="flash-message flash-error">
            <div class="container">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM11 15H9V13H11V15ZM11 11H9V5H11V11Z"/>
                </svg>
                <span><?php echo escape($error); ?></span>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="main-content">
