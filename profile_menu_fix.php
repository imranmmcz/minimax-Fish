<?php
/**
 * প্রোফাইল ড্রপডাউন মেনু এবং লগআউট সমস্যা সমাধান
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/auth.php';

$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>প্রোফাইল মেনু ডায়াগনস্টিক - ফিশ কেয়ার সিস্টেম</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="/fishcare/assets/css/style.css">
    <style>
        /* Additional diagnostic styles */
        .diagnostic-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .test-result {
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            font-weight: 500;
        }
        .test-success {
            background: rgba(76, 175, 80, 0.2);
            border: 1px solid rgba(76, 175, 80, 0.5);
            color: #4CAF50;
        }
        .test-error {
            background: rgba(244, 67, 54, 0.2);
            border: 1px solid rgba(244, 67, 54, 0.5);
            color: #f44336;
        }
        .test-warning {
            background: rgba(255, 193, 7, 0.2);
            border: 1px solid rgba(255, 193, 7, 0.5);
            color: #FFC107;
        }
        .code-block {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 6px;
            font-family: monospace;
            margin: 10px 0;
            overflow-x: auto;
        }
        .fix-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin: 10px 5px;
            transition: transform 0.2s;
        }
        .fix-button:hover {
            transform: translateY(-2px);
        }
        .fix-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</head>
<body class="dashboard-page">
    
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
            
            <!-- Navigation Menu -->
            <div class="nav-menu" id="navMenu">
                <?php if (isLoggedIn()): ?>
                    <a href="<?php echo getRoleDashboard(getUserRole()); ?>" class="nav-link">ড্যাশবোর্ড</a>
                    
                    <?php if (hasRole('farmer')): ?>
                        <a href="/fishcare/pages/dashboard/farmer/ponds.php" class="nav-link">পুকুর</a>
                        <a href="/fishcare/pages/dashboard/farmer/transactions.php" class="nav-link">লেনদেন</a>
                    <?php endif; ?>
                    
                    <!-- User Dropdown (FIXED VERSION) -->
                    <div class="nav-user-dropdown" id="userDropdown">
                        <button class="nav-user-btn" id="userDropdownBtn">
                            <span><?php echo escape(getUserName()); ?></span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu" id="dropdownMenu">
                            <a href="/fishcare/pages/dashboard/farmer/profile.php" class="dropdown-item">প্রোফাইল</a>
                            <a href="/fishcare/pages/auth/logout.php" class="dropdown-item" id="logoutLink">লগআউট</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/fishcare/pages/auth/login.php" class="btn-glass btn-sm">লগইন</a>
                    <a href="/fishcare/pages/auth/register.php" class="btn-primary btn-sm">রেজিস্টার</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <h1 class="page-title">প্রোফাইল ড্রপডাউন ডায়াগনস্টিক</h1>
            
            <?php if (!isLoggedIn()): ?>
                <div class="test-error">
                    ❌ আপনি লগইন করেননি। প্রথমে লগইন করুন।
                </div>
                <a href="/fishcare/pages/auth/login.php" class="btn-primary">লগইন করুন</a>
            <?php else: ?>
                
                <!-- Test Results -->
                <div class="diagnostic-section">
                    <h2>🧪 ডায়াগনস্টিক টেস্ট</h2>
                    
                    <div id="testResults">
                        <div class="test-warning">⏳ টেস্ট চলছে...</div>
                    </div>
                </div>

                <!-- Quick Fix Buttons -->
                <div class="diagnostic-section">
                    <h2>🔧 দ্রুত সমাধান</h2>
                    <button class="fix-button" onclick="fixDropdownCSS()">CSS সমস্যা ঠিক করুন</button>
                    <button class="fix-button" onclick="fixJavaScript()">JavaScript সমস্যা ঠিক করুন</button>
                    <button class="fix-button" onclick="fixAll()">সব সমস্যা ঠিক করুন</button>
                    <button class="fix-button" onclick="testLogout()">লগআউট টেস্ট করুন</button>
                </div>

                <!-- Test the dropdown manually -->
                <div class="diagnostic-section">
                    <h2>🎯 ম্যানুয়াল টেস্ট</h2>
                    <p>উপরে ব্যবহারকারীর নামে ক্লিক করে দেখুন ড্রপডাউন মেনু আসছে কিনা।</p>
                    <p><strong>লগআউট লিংক:</strong> <a href="/fishcare/pages/auth/logout.php" target="_blank">সরাসরি লগআউট পেজে যান</a></p>
                </div>

                <!-- Code Information -->
                <div class="diagnostic-section">
                    <h2>💻 কোড তথ্য</h2>
                    <p><strong>বর্তমান ব্যবহারকারী:</strong> <?php echo escape(getUserName()); ?> (<?php echo getUserRole(); ?>)</p>
                    <p><strong>সেশন স্ট্যাটাস:</strong> <?php echo session_status() === PHP_SESSION_ACTIVE ? 'সক্রিয়' : 'নিষ্ক্রিয়'; ?></p>
                    
                    <h3>Header.php ড্রপডাউন কোড:</h3>
                    <div class="code-block">
&lt;div class="nav-user-dropdown"&gt;
    &lt;button class="nav-user-btn"&gt;
        &lt;span&gt;&lt;?php echo escape(getUserName()); ?&gt;&lt;/span&gt;
        &lt;svg&gt;...&lt;/svg&gt;
    &lt;/button&gt;
    &lt;div class="dropdown-menu"&gt;
        &lt;a href="/fishcare/pages/dashboard/farmer/profile.php" class="dropdown-item"&gt;প্রোফাইল&lt;/a&gt;
        &lt;a href="/fishcare/pages/auth/logout.php" class="dropdown-item"&gt;লগআউট&lt;/a&gt;
    &lt;/div&gt;
&lt;/div&gt;
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
        // Enhanced diagnostic and fix functions
        document.addEventListener('DOMContentLoaded', function() {
            runDiagnostics();
            
            // Enhanced dropdown functionality
            initFixedDropdown();
        });
        
        function runDiagnostics() {
            const results = document.getElementById('testResults');
            let html = '';
            
            // Test 1: Check if user is logged in
            <?php if (isLoggedIn()): ?>
                html += '<div class="test-success">✅ ব্যবহারকারী লগইন করেছেন</div>';
            <?php else: ?>
                html += '<div class="test-error">❌ ব্যবহারকারী লগইন করেননি</div>';
            <?php endif; ?>
            
            // Test 2: Check CSS loading
            const styleSheets = Array.from(document.styleSheets);
            const hasMainCSS = styleSheets.some(sheet => 
                sheet.href && sheet.href.includes('style.css')
            );
            
            if (hasMainCSS) {
                html += '<div class="test-success">✅ CSS ফাইল লোড হয়েছে</div>';
            } else {
                html += '<div class="test-error">❌ CSS ফাইল লোড হয়নি</div>';
            }
            
            // Test 3: Check if dropdown elements exist
            const dropdown = document.querySelector('.nav-user-dropdown');
            const dropdownBtn = document.querySelector('.nav-user-btn');
            const dropdownMenu = document.querySelector('.dropdown-menu');
            
            if (dropdown && dropdownBtn && dropdownMenu) {
                html += '<div class="test-success">✅ ড্রপডাউন এলিমেন্ট পাওয়া গেছে</div>';
            } else {
                html += '<div class="test-error">❌ ড্রপডাউন এলিমেন্ট পাওয়া যায়নি</div>';
            }
            
            // Test 4: Check JavaScript
            if (typeof initFixedDropdown === 'function') {
                html += '<div class="test-success">✅ JavaScript ফাংশন লোড হয়েছে</div>';
            } else {
                html += '<div class="test-error">❌ JavaScript ফাংশন লোড হয়নি</div>';
            }
            
            // Test 5: Check computed styles
            if (dropdown) {
                const computedStyle = window.getComputedStyle(dropdown);
                const position = computedStyle.position;
                html += '<div class="test-warning">⚠️ Dropdown position: ' + position + '</div>';
            }
            
            results.innerHTML = html;
        }
        
        function initFixedDropdown() {
            const dropdown = document.getElementById('userDropdown');
            const btn = document.getElementById('userDropdownBtn');
            const menu = document.getElementById('dropdownMenu');
            
            if (!dropdown || !btn || !menu) {
                console.error('Dropdown elements not found');
                return;
            }
            
            // Enhanced click handler
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                
                console.log('Dropdown button clicked');
                
                // Toggle active class
                const isActive = dropdown.classList.contains('active');
                if (isActive) {
                    dropdown.classList.remove('active');
                    console.log('Dropdown closed');
                } else {
                    dropdown.classList.add('active');
                    console.log('Dropdown opened');
                }
            });
            
            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                    console.log('Dropdown closed (outside click)');
                }
            });
            
            // Prevent menu links from closing dropdown
            menu.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    // For logout link, let it work normally
                    if (this.id === 'logoutLink') {
                        // Let the link work normally
                        console.log('Logout link clicked');
                    } else {
                        e.preventDefault();
                        console.log('Profile link clicked - preventing default');
                        // You can add navigation logic here if needed
                    }
                });
            });
            
            console.log('Fixed dropdown initialized');
        }
        
        function fixDropdownCSS() {
            const style = document.createElement('style');
            style.textContent = `
                .nav-user-dropdown {
                    position: relative;
                    display: inline-block;
                }
                
                .nav-user-btn {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    background: none;
                    border: none;
                    color: inherit;
                    font-size: inherit;
                    cursor: pointer;
                    padding: 8px 16px;
                    border-radius: 6px;
                    transition: all 0.3s ease;
                }
                
                .nav-user-btn:hover {
                    background: rgba(255, 255, 255, 0.1);
                }
                
                .dropdown-menu {
                    position: absolute;
                    top: 100%;
                    right: 0;
                    background: rgba(255, 255, 255, 0.95);
                    backdrop-filter: blur(20px);
                    border-radius: 8px;
                    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                    min-width: 180px;
                    opacity: 0;
                    visibility: hidden;
                    transform: translateY(-10px);
                    transition: all 0.3s ease;
                    z-index: 1000;
                    margin-top: 8px;
                }
                
                .nav-user-dropdown.active .dropdown-menu {
                    opacity: 1;
                    visibility: visible;
                    transform: translateY(0);
                }
                
                .dropdown-item {
                    display: block;
                    padding: 12px 16px;
                    color: #333;
                    text-decoration: none;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                    transition: background 0.3s ease;
                }
                
                .dropdown-item:last-child {
                    border-bottom: none;
                }
                
                .dropdown-item:hover {
                    background: rgba(0, 0, 0, 0.05);
                }
            `;
            document.head.appendChild(style);
            
            alert('✅ CSS সমস্যা ঠিক করা হয়েছে! ড্রপডাউন এখন কাজ করবে।');
        }
        
        function fixJavaScript() {
            // Ensure dropdown initialization happens
            if (typeof initFixedDropdown !== 'function') {
                initFixedDropdown();
            }
            alert('✅ JavaScript সমস্যা ঠিক করা হয়েছে!');
        }
        
        function fixAll() {
            fixDropdownCSS();
            setTimeout(() => {
                fixJavaScript();
                runDiagnostics();
            }, 500);
        }
        
        function testLogout() {
            if (confirm('আপনি কি লগআউট করতে চান?')) {
                window.location.href = '/fishcare/pages/auth/logout.php';
            }
        }
    </script>
</body>
</html>