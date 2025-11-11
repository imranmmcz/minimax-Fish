<?php
$pageTitle = 'অ্যাডমিন প্রোফাইল';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('admin');

$db = getDB();
$userId = getUserId();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'update_profile') {
            $stmt = $db->prepare("UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?");
            $stmt->execute([$_POST['name'], $_POST['phone'], $_POST['address'], $userId]);
            $_SESSION['success'] = 'প্রোফাইল সফলভাবে আপডেট করা হয়েছে';
        } elseif ($_POST['action'] === 'change_password') {
            $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $currentHash = $stmt->fetchColumn();
            
            if (password_verify($_POST['current_password'], $currentHash)) {
                if ($_POST['new_password'] === $_POST['confirm_password']) {
                    $newHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt->execute([$newHash, $userId]);
                    $_SESSION['success'] = 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে';
                } else {
                    $_SESSION['error'] = 'নতুন পাসওয়ার্ড মিলছে না';
                }
            } else {
                $_SESSION['error'] = 'বর্তমান পাসওয়ার্ড ভুল';
            }
        }
        header('Location: profile.php');
        exit;
    }
}

// Get user data
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

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
                <a href="settings.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M17.43 10.98C17.47 10.66 17.5 10.34 17.5 10C17.5 9.66 17.47 9.34 17.43 9.02L19.54 7.37C19.73 7.22 19.78 6.95 19.66 6.73L17.66 3.27C17.54 3.05 17.27 2.97 17.05 3.05L14.56 4.05C14.04 3.66 13.48 3.32 12.87 3.07L12.49 0.42C12.46 0.18 12.25 0 12 0H8C7.75 0 7.54 0.18 7.51 0.42L7.13 3.07C6.52 3.32 5.96 3.66 5.44 4.05L2.95 3.05C2.73 2.96 2.46 3.05 2.34 3.27L0.34 6.73C0.21 6.95 0.27 7.22 0.46 7.37L2.57 9.02C2.53 9.34 2.5 9.66 2.5 10C2.5 10.34 2.53 10.66 2.57 10.98L0.46 12.63C0.27 12.78 0.22 13.05 0.34 13.27L2.34 16.73C2.46 16.95 2.73 17.03 2.95 16.95L5.44 15.95C5.96 16.34 6.52 16.68 7.13 16.93L7.51 19.58C7.54 19.82 7.75 20 8 20H12C12.25 20 12.46 19.82 12.49 19.58L12.87 16.93C13.48 16.68 14.04 16.34 14.56 15.95L17.05 16.95C17.27 17.04 17.54 16.95 17.66 16.73L19.66 13.27C19.78 13.05 19.73 12.78 19.54 12.63L17.43 10.98ZM10 13.5C8.07 13.5 6.5 11.93 6.5 10C6.5 8.07 8.07 6.5 10 6.5C11.93 6.5 13.5 8.07 13.5 10C13.5 11.93 11.93 13.5 10 13.5Z"/></svg>
                    <span>সেটিংস</span>
                </a>
                <a href="monitoring.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C10.55 4 11 4.45 11 5C11 5.55 10.55 6 10 6C9.45 6 9 5.55 9 5C9 4.45 9.45 4 10 4ZM13 15H7V13H9V9H8V7H11V13H13V15Z"/></svg>
                    <span>মনিটরিং</span>
                </a>
                <a href="profile.php" class="nav-item active">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C11.66 4 13 5.34 13 7C13 8.66 11.66 10 10 10C8.34 10 7 8.66 7 7C7 5.34 8.34 4 10 4ZM10 17C7.33 17 5.01 15.45 4 13.15C4.03 10.81 8.67 9.55 10 9.55C11.32 9.55 15.97 10.81 16 13.15C14.99 15.45 12.67 17 10 17Z"/></svg>
                    <span>প্রোফাইল</span>
                </a>
            </nav>
        </div>
    </aside>
    
    <main class="dashboard-content">
        <div class="dashboard-header">
            <h1>আমার প্রোফাইল</h1>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <div class="grid grid-2">
            <!-- Profile Information -->
            <div class="glass-card">
                <h3 class="card-title">প্রোফাইল তথ্য</h3>
                <div class="profile-avatar">
                    <div class="avatar-circle">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="currentColor"><path d="M40 0C17.9 0 0 17.9 0 40C0 62.1 17.9 80 40 80C62.1 80 80 62.1 80 40C80 17.9 62.1 0 40 0ZM40 12C46.6 12 52 17.4 52 24C52 30.6 46.6 36 40 36C33.4 36 28 30.6 28 24C28 17.4 33.4 12 40 12ZM40 68C30 68 21.2 62.6 16 54.6C16.1 46.5 32 41.9 40 41.9C47.9 41.9 63.9 46.5 64 54.6C58.8 62.6 50 68 40 68Z"/></svg>
                    </div>
                </div>
                
                <form method="POST" class="mt-6">
                    <input type="hidden" name="action" value="update_profile">
                    
                    <div class="form-group">
                        <label>নাম</label>
                        <input type="text" name="name" value="<?php echo escape($user['name']); ?>" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>ইমেইল</label>
                        <input type="email" value="<?php echo escape($user['email']); ?>" disabled class="form-control">
                        <small class="text-muted">ইমেইল পরিবর্তন করা যাবে না</small>
                    </div>
                    
                    <div class="form-group">
                        <label>ফোন</label>
                        <input type="text" name="phone" value="<?php echo escape($user['phone'] ?? ''); ?>" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>ঠিকানা</label>
                        <textarea name="address" class="form-control" rows="3"><?php echo escape($user['address'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>রোল</label>
                        <input type="text" value="<?php echo escape($user['role']); ?>" disabled class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>নিবন্ধন তারিখ</label>
                        <input type="text" value="<?php echo date('d M Y', strtotime($user['created_at'])); ?>" disabled class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">প্রোফাইল আপডেট করুন</button>
                </form>
            </div>
            
            <!-- Security Settings -->
            <div class="glass-card">
                <h3 class="card-title">নিরাপত্তা সেটিংস</h3>
                
                <form method="POST">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div class="form-group">
                        <label>বর্তমান পাসওয়ার্ড</label>
                        <input type="password" name="current_password" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>নতুন পাসওয়ার্ড</label>
                        <input type="password" name="new_password" required class="form-control" minlength="6">
                    </div>
                    
                    <div class="form-group">
                        <label>পাসওয়ার্ড নিশ্চিত করুন</label>
                        <input type="password" name="confirm_password" required class="form-control" minlength="6">
                    </div>
                    
                    <button type="submit" class="btn btn-warning">পাসওয়ার্ড পরিবর্তন করুন</button>
                </form>
                
                <div class="security-info mt-8">
                    <h4 class="mb-4">অ্যাকাউন্ট নিরাপত্তা টিপস</h4>
                    <ul class="security-tips">
                        <li>শক্তিশালী পাসওয়ার্ড ব্যবহার করুন (কমপক্ষে ৮ অক্ষর)</li>
                        <li>নিয়মিত পাসওয়ার্ড পরিবর্তন করুন</li>
                        <li>একই পাসওয়ার্ড বিভিন্ন জায়গায় ব্যবহার করবেন না</li>
                        <li>সন্দেহজনক কার্যকলাপ দেখলে অবিলম্বে পাসওয়ার্ড পরিবর্তন করুন</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Activity Log -->
        <div class="glass-card mt-6">
            <h3 class="card-title">সাম্প্রতিক লগইন কার্যকলাপ</h3>
            <div class="activity-log">
                <div class="log-item">
                    <div class="log-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z"/></svg>
                    </div>
                    <div class="log-content">
                        <div class="log-title">সফল লগইন</div>
                        <div class="log-desc">IP: 103.123.45.67 | Browser: Chrome</div>
                        <div class="log-time"><?php echo date('d M Y, h:i A'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
.profile-avatar {
    display: flex;
    justify-content: center;
    margin: 2rem 0;
}
.avatar-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(0, 188, 212, 0.2), rgba(0, 188, 212, 0.05));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #00BCD4;
}
.security-info h4 {
    color: #00BCD4;
    font-size: 1.1rem;
    margin-bottom: 1rem;
}
.security-tips {
    list-style: none;
    padding: 0;
}
.security-tips li {
    padding: 0.75rem;
    background: rgba(255,255,255,0.05);
    border-radius: 6px;
    margin-bottom: 0.5rem;
    padding-left: 2rem;
    position: relative;
}
.security-tips li:before {
    content: "✓";
    position: absolute;
    left: 0.75rem;
    color: #4CAF50;
    font-weight: bold;
}
.activity-log {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.log-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
}
.log-icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 188, 212, 0.2);
    border-radius: 50%;
    color: #00BCD4;
}
.log-content {
    flex: 1;
}
.log-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
}
.log-desc {
    color: rgba(255,255,255,0.7);
    font-size: 0.9rem;
}
.log-time {
    color: rgba(255,255,255,0.5);
    font-size: 0.85rem;
    margin-top: 0.25rem;
}
</style>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
