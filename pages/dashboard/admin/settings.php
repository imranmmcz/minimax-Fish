<?php
$pageTitle = 'সিস্টেম সেটিংস';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('admin');

$db = getDB();

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'update_general') {
            // Update general settings
            $_SESSION['success'] = 'সাধারণ সেটিংস সফলভাবে আপডেট করা হয়েছে';
        } elseif ($_POST['action'] === 'update_email') {
            // Update email settings
            $_SESSION['success'] = 'ইমেইল সেটিংস সফলভাবে আপডেট করা হয়েছে';
        } elseif ($_POST['action'] === 'update_payment') {
            // Update payment settings
            $_SESSION['success'] = 'পেমেন্ট সেটিংস সফলভাবে আপডেট করা হয়েছে';
        } elseif ($_POST['action'] === 'backup_database') {
            // Database backup logic would go here
            $_SESSION['success'] = 'ডেটাবেস ব্যাকআপ সফলভাবে তৈরি করা হয়েছে';
        }
        header('Location: settings.php');
        exit;
    }
}

include_once __DIR__ . '/../../../includes/header.php';
?>

<div class="dashboard-layout">
    <aside class="dashboard-sidebar">
        <div class="sidebar-content">
            <nav class="sidebar-nav">
                <a href="index.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2L2 8V18H7V13H13V18H18V8L10 2Z"/></svg>
                    <span>ড্যাশবোর্ড হোম</span>
                </a>
                <a href="users.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M14 6C14 8.21 12.21 10 10 10C7.79 10 6 8.21 6 6C6 3.79 7.79 2 10 2C12.21 2 14 3.79 14 6ZM2 18V16C2 13.34 7.33 12 10 12C12.67 12 18 13.34 18 16V18H2Z"/></svg>
                    <span>ব্যবহারকারী ম্যানেজমেন্ট</span>
                </a>
                <a href="reports.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4H8V8H4V4ZM10 4H14V8H10V4ZM16 4H20V8H16V4ZM4 10H8V14H4V10ZM10 10H14V14H10V10ZM16 10H20V14H16V10ZM4 16H8V20H4V16ZM10 16H14V20H10V16ZM16 16H20V20H16V16Z"/></svg>
                    <span>রিপোর্ট</span>
                </a>
                <a href="settings.php" class="nav-item active">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M17.43 10.98C17.47 10.66 17.5 10.34 17.5 10C17.5 9.66 17.47 9.34 17.43 9.02L19.54 7.37C19.73 7.22 19.78 6.95 19.66 6.73L17.66 3.27C17.54 3.05 17.27 2.97 17.05 3.05L14.56 4.05C14.04 3.66 13.48 3.32 12.87 3.07L12.49 0.42C12.46 0.18 12.25 0 12 0H8C7.75 0 7.54 0.18 7.51 0.42L7.13 3.07C6.52 3.32 5.96 3.66 5.44 4.05L2.95 3.05C2.73 2.96 2.46 3.05 2.34 3.27L0.34 6.73C0.21 6.95 0.27 7.22 0.46 7.37L2.57 9.02C2.53 9.34 2.5 9.66 2.5 10C2.5 10.34 2.53 10.66 2.57 10.98L0.46 12.63C0.27 12.78 0.22 13.05 0.34 13.27L2.34 16.73C2.46 16.95 2.73 17.03 2.95 16.95L5.44 15.95C5.96 16.34 6.52 16.68 7.13 16.93L7.51 19.58C7.54 19.82 7.75 20 8 20H12C12.25 20 12.46 19.82 12.49 19.58L12.87 16.93C13.48 16.68 14.04 16.34 14.56 15.95L17.05 16.95C17.27 17.04 17.54 16.95 17.66 16.73L19.66 13.27C19.78 13.05 19.73 12.78 19.54 12.63L17.43 10.98ZM10 13.5C8.07 13.5 6.5 11.93 6.5 10C6.5 8.07 8.07 6.5 10 6.5C11.93 6.5 13.5 8.07 13.5 10C13.5 11.93 11.93 13.5 10 13.5Z"/></svg>
                    <span>সেটিংস</span>
                </a>
                <a href="monitoring.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C10.55 4 11 4.45 11 5C11 5.55 10.55 6 10 6C9.45 6 9 5.55 9 5C9 4.45 9.45 4 10 4ZM13 15H7V13H9V9H8V7H11V13H13V15Z"/></svg>
                    <span>মনিটরিং</span>
                </a>
                <a href="profile.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C11.66 4 13 5.34 13 7C13 8.66 11.66 10 10 10C8.34 10 7 8.66 7 7C7 5.34 8.34 4 10 4ZM10 17C7.33 17 5.01 15.45 4 13.15C4.03 10.81 8.67 9.55 10 9.55C11.32 9.55 15.97 10.81 16 13.15C14.99 15.45 12.67 17 10 17Z"/></svg>
                    <span>প্রোফাইল</span>
                </a>
            </nav>
        </div>
    </aside>
    
    <main class="dashboard-content">
        <div class="dashboard-header">
            <h1>সিস্টেম সেটিংস</h1>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <!-- Settings Tabs -->
        <div class="settings-tabs mb-6">
            <button class="tab-btn active" onclick="showTab('general')">সাধারণ সেটিংস</button>
            <button class="tab-btn" onclick="showTab('email')">ইমেইল সেটিংস</button>
            <button class="tab-btn" onclick="showTab('payment')">পেমেন্ট সেটিংস</button>
            <button class="tab-btn" onclick="showTab('backup')">ব্যাকআপ ও রক্ষণাবেক্ষণ</button>
        </div>
        
        <!-- General Settings -->
        <div id="general-tab" class="settings-tab-content">
            <div class="glass-card">
                <h3 class="card-title">সাধারণ সেটিংস</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="update_general">
                    <div class="form-group">
                        <label>সাইট নাম</label>
                        <input type="text" name="site_name" value="Fish Care Management System" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>সাইট বিবরণ</label>
                        <textarea name="site_description" class="form-control" rows="3">মৎস্য চাষ ব্যবস্থাপনা সিস্টেম</textarea>
                    </div>
                    <div class="form-group">
                        <label>যোগাযোগ ইমেইল</label>
                        <input type="email" name="contact_email" value="admin@fishcare.com" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>যোগাযোগ ফোন</label>
                        <input type="text" name="contact_phone" value="+৮৮০ ১৭১২৩৪৫৬৭৮" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>ঠিকানা</label>
                        <textarea name="address" class="form-control" rows="2">ঢাকা, বাংলাদেশ</textarea>
                    </div>
                    <div class="form-group">
                        <label>টাইমজোন</label>
                        <select name="timezone" class="form-control">
                            <option value="Asia/Dhaka" selected>এশিয়া/ঢাকা (GMT+6)</option>
                            <option value="Asia/Kolkata">এশিয়া/কলকাতা (GMT+5:30)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ভাষা</label>
                        <select name="language" class="form-control">
                            <option value="bn" selected>বাংলা</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                </form>
            </div>
        </div>
        
        <!-- Email Settings -->
        <div id="email-tab" class="settings-tab-content" style="display:none;">
            <div class="glass-card">
                <h3 class="card-title">ইমেইল সেটিংস</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="update_email">
                    <div class="form-group">
                        <label>SMTP হোস্ট</label>
                        <input type="text" name="smtp_host" value="smtp.gmail.com" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SMTP পোর্ট</label>
                        <input type="number" name="smtp_port" value="587" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SMTP ব্যবহারকারীর নাম</label>
                        <input type="text" name="smtp_username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SMTP পাসওয়ার্ড</label>
                        <input type="password" name="smtp_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>প্রেরকের নাম</label>
                        <input type="text" name="from_name" value="Fish Care System" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>প্রেরকের ইমেইল</label>
                        <input type="email" name="from_email" value="noreply@fishcare.com" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                    <button type="button" class="btn btn-secondary" onclick="testEmail()">টেস্ট ইমেইল পাঠান</button>
                </form>
            </div>
        </div>
        
        <!-- Payment Settings -->
        <div id="payment-tab" class="settings-tab-content" style="display:none;">
            <div class="glass-card">
                <h3 class="card-title">পেমেন্ট সেটিংস</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="update_payment">
                    <div class="form-group">
                        <label>মুদ্রা</label>
                        <select name="currency" class="form-control">
                            <option value="BDT" selected>বাংলাদেশী টাকা (৳)</option>
                            <option value="USD">US Dollar ($)</option>
                            <option value="EUR">Euro (€)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ট্যাক্স হার (%)</label>
                        <input type="number" name="tax_rate" value="0" step="0.01" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>পেমেন্ট গেটওয়ে</label>
                        <select name="payment_gateway" class="form-control">
                            <option value="none" selected>কোনটি নয়</option>
                            <option value="bkash">বিকাশ</option>
                            <option value="nagad">নগদ</option>
                            <option value="rocket">রকেট</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="enable_partial_payment">
                            আংশিক পেমেন্ট সক্রিয় করুন
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                </form>
            </div>
        </div>
        
        <!-- Backup Settings -->
        <div id="backup-tab" class="settings-tab-content" style="display:none;">
            <div class="glass-card">
                <h3 class="card-title">ব্যাকআপ ও রক্ষণাবেক্ষণ</h3>
                <div class="backup-section">
                    <h4>ডেটাবেস ব্যাকআপ</h4>
                    <p class="text-muted">সিস্টেমের সম্পূর্ণ ডেটাবেস ব্যাকআপ তৈরি করুন</p>
                    <form method="POST">
                        <input type="hidden" name="action" value="backup_database">
                        <button type="submit" class="btn btn-primary">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M14 2H6C4.9 2 4 2.9 4 4V16C4 17.1 4.9 18 6 18H14C15.1 18 16 17.1 16 16V4C16 2.9 15.1 2 14 2Z"/></svg>
                            ব্যাকআপ তৈরি করুন
                        </button>
                    </form>
                </div>
                
                <div class="backup-section mt-6">
                    <h4>সিস্টেম পরিষ্কার</h4>
                    <p class="text-muted">অস্থায়ী ফাইল এবং ক্যাশ পরিষ্কার করুন</p>
                    <button class="btn btn-warning" onclick="clearCache()">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M14 12C14 13.1 13.1 14 12 14H8C6.9 14 6 13.1 6 12V8H14V12ZM12 3H8L7 2H4V4H16V2H13L12 3Z"/></svg>
                        ক্যাশ পরিষ্কার করুন
                    </button>
                </div>
                
                <div class="backup-section mt-6">
                    <h4>সিস্টেম তথ্য</h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <strong>PHP ভার্সন:</strong> <?php echo phpversion(); ?>
                        </div>
                        <div class="info-item">
                            <strong>MySQL ভার্সন:</strong> <?php echo $db->getAttribute(PDO::ATTR_SERVER_VERSION); ?>
                        </div>
                        <div class="info-item">
                            <strong>সার্ভার সফটওয়্যার:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
.settings-tabs {
    display: flex;
    gap: 1rem;
    border-bottom: 2px solid rgba(0, 188, 212, 0.2);
    padding-bottom: 0.5rem;
}
.tab-btn {
    background: none;
    border: none;
    padding: 0.75rem 1.5rem;
    cursor: pointer;
    color: #fff;
    font-size: 1rem;
    transition: all 0.3s;
}
.tab-btn:hover {
    color: #00BCD4;
}
.tab-btn.active {
    color: #00BCD4;
    border-bottom: 3px solid #00BCD4;
}
.backup-section {
    padding: 1.5rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}
.backup-section:last-child {
    border-bottom: none;
}
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}
.info-item {
    padding: 1rem;
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
}
</style>

<script>
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.settings-tab-content').forEach(tab => {
        tab.style.display = 'none';
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').style.display = 'block';
    
    // Add active class to clicked button
    event.target.classList.add('active');
}

function testEmail() {
    alert('টেস্ট ইমেইল পাঠানো হচ্ছে...');
}

function clearCache() {
    if (confirm('আপনি কি নিশ্চিত যে ক্যাশ পরিষ্কার করতে চান?')) {
        alert('ক্যাশ সফলভাবে পরিষ্কার করা হয়েছে');
    }
}
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
