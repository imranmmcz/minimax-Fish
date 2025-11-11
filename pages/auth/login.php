<?php
$pageTitle = 'লগইন';
include_once __DIR__ . '/../../includes/header.php';

// ইতিমধ্যে লগইন থাকলে ড্যাশবোর্ডে রিডাইরেক্ট করুন
if (isLoggedIn()) {
    redirect(getRoleDashboard(getUserRole()));
}

// ফর্ম সাবমিট হ্যান্ডলিং
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        setError('নিরাপত্তা ত্রুটি। আবার চেষ্টা করুন।');
    } else {
        $username = clean($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        $result = loginUser($username, $password);
        
        if ($result['success']) {
            setSuccess('সফলভাবে লগইন হয়েছে!');
            redirect(getRoleDashboard($result['user']['role']));
        } else {
            setError($result['error']);
        }
    }
}

$csrfToken = generateCsrfToken();
?>

<div class="auth-page">
    <div class="container">
        <div class="auth-container">
            <!-- Auth Card -->
            <div class="glass-card auth-card">
                <!-- Logo and Title -->
                <div class="auth-header">
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" class="auth-logo">
                        <path d="M32 8C16 8 8 24 8 32C8 40 12.8 56 32 56C51.2 56 56 40 56 32C56 24 48 8 32 8Z" fill="#00BCD4"/>
                        <ellipse cx="40" cy="28.8" rx="3.2" ry="3.2" fill="white"/>
                    </svg>
                    <h1>স্বাগতম!</h1>
                    <p class="auth-subtitle">ফিশ কেয়ার সিস্টেমে লগইন করুন</p>
                </div>
                
                <!-- Login Form -->
                <form method="POST" action="" class="auth-form">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                    
                    <!-- Username -->
                    <div class="form-group">
                        <label for="username" class="form-label required">ইউজারনেম বা ইমেইল</label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="form-input" 
                            placeholder="আপনার ইউজারনেম বা ইমেইল দিন"
                            required
                            autocomplete="username"
                        >
                    </div>
                    
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label required">পাসওয়ার্ড</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="আপনার পাসওয়ার্ড দিন"
                            required
                            autocomplete="current-password"
                        >
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="form-checkbox">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">আমাকে মনে রাখুন</label>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        লগইন করুন
                    </button>
                </form>
                
                <!-- Auth Footer -->
                <div class="auth-footer">
                    <p>অ্যাকাউন্ট নেই? <a href="register.php" class="text-primary">রেজিস্টার করুন</a></p>
                </div>
            </div>
            
            <!-- Info Card -->
            <div class="glass-card info-card">
                <h3>কেন ফিশ কেয়ার সিস্টেম?</h3>
                <ul class="info-list">
                    <li>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#4CAF50">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                        <span>সম্পূর্ণ ডিজিটাল ব্যবস্থাপনা</span>
                    </li>
                    <li>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#4CAF50">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                        <span>রিয়েল-টাইম বাজার মূল্য</span>
                    </li>
                    <li>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#4CAF50">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                        <span>স্বয়ংক্রিয় হিসাব-নিকাশ</span>
                    </li>
                    <li>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#4CAF50">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                        <span>বিশেষজ্ঞের পরামর্শ</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.auth-page {
    min-height: calc(100vh - 72px);
    display: flex;
    align-items: center;
    padding: var(--space-8) 0;
}

.auth-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-8);
    max-width: 1000px;
    margin: 0 auto;
}

.auth-card {
    padding: var(--space-12);
}

.auth-header {
    text-align: center;
    margin-bottom: var(--space-8);
}

.auth-logo {
    margin: 0 auto var(--space-4);
    filter: drop-shadow(0 4px 12px rgba(0, 188, 212, 0.3));
}

.auth-subtitle {
    color: var(--color-neutral-600);
    margin-top: var(--space-2);
}

.auth-form {
    margin-bottom: var(--space-6);
}

.auth-footer {
    text-align: center;
    padding-top: var(--space-6);
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.info-card {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.info-list {
    list-style: none;
    margin-top: var(--space-6);
}

.info-list li {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) 0;
    font-size: var(--text-base);
}

@media screen and (max-width: 768px) {
    .auth-container {
        grid-template-columns: 1fr;
    }
    
    .info-card {
        display: none;
    }
    
    .auth-card {
        padding: var(--space-6);
    }
}
</style>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
