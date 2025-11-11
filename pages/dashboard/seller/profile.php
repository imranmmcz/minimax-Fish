<?php
$pageTitle = 'প্রোফাইল সেটিংস';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('seller');

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
                <a href="orders.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4 2H16C17.1 2 18 2.9 18 4V16C18 17.1 17.1 18 16 18H4C2.9 18 2 17.1 2 16V4C2 2.9 2.9 2 4 2ZM4 6H16V4H4V6ZM4 10H16V8H4V10ZM4 14H12V12H4V14Z"/></svg>
                    <span>অর্ডার তালিকা</span>
                </a>
                <a href="payments.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M18 4H2C0.9 4 0 4.9 0 6V14C0 15.1 0.9 16 2 16H18C19.1 16 20 15.1 20 14V6C20 4.9 19.1 4 18 4ZM18 14H2V10H18V14ZM18 8H2V6H18V8Z"/></svg>
                    <span>পেমেন্ট</span>
                </a>
                <a href="wishlist.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 18L8.55 16.7C3.4 12.11 0 9.11 0 5.5C0 2.42 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.42 20 5.5C20 9.11 16.6 12.11 11.45 16.7L10 18Z"/></svg>
                    <span>উইশলিস্ট</span>
                </a>
                <a href="stocks.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4 2H16L20 6V18C20 19.1 19.1 20 18 20H2C0.9 20 0 19.1 0 18V6L4 2ZM10 12L6 8H9V4H11V8H14L10 12Z"/></svg>
                    <span>স্টক ব্যবস্থাপনা</span>
                </a>
                <a href="finance.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2C5.58 2 2 5.58 2 10C2 14.42 5.58 18 10 18C14.42 18 18 14.42 18 10C18 5.58 14.42 2 10 2ZM10 16C6.69 16 4 13.31 4 10C4 6.69 6.69 4 10 4C13.31 4 16 6.69 16 10C16 13.31 13.31 16 10 16ZM10.5 6H9V11L13.2 13.6L14 12.3L10.5 10.2V6Z"/></svg>
                    <span>আর্থিক হিসাব</span>
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
            <h1>প্রোফাইল সেটিংস</h1>
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
                        <input type="text" value="বিক্রেতা" disabled class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">প্রোফাইল আপডেট করুন</button>
                </form>
            </div>
            
            <!-- Security Settings -->
            <div class="glass-card">
                <h3 class="card-title">পাসওয়ার্ড পরিবর্তন</h3>
                
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
                
                <!-- Business Statistics -->
                <div class="business-info mt-8">
                    <h3 class="card-title mb-4">বিক্রয় পরিসংখ্যান</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">মোট অর্ডার</div>
                            <div class="info-value">
                                <?php
                                $stmt = $db->prepare("SELECT COUNT(*) FROM invoices WHERE user_id = ?");
                                $stmt->execute([$userId]);
                                echo $stmt->fetchColumn();
                                ?>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">মোট বিক্রয়</div>
                            <div class="info-value">
                                <?php
                                $stmt = $db->prepare("SELECT COALESCE(SUM(grand_total), 0) FROM invoices WHERE user_id = ?");
                                $stmt->execute([$userId]);
                                echo '৳' . formatMoney($stmt->fetchColumn());
                                ?>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">সদস্য থেকে</div>
                            <div class="info-value"><?php echo date('d M Y', strtotime($user['created_at'])); ?></div>
                        </div>
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
.business-info {
    padding-top: 2rem;
    border-top: 1px solid rgba(255,255,255,0.1);
}
.info-grid {
    display: grid;
    gap: 1rem;
}
.info-item {
    padding: 1rem;
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
}
.info-label {
    color: rgba(255,255,255,0.7);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}
.info-value {
    color: #00BCD4;
    font-size: 1.25rem;
    font-weight: 600;
}
</style>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
