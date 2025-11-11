<?php
$pageTitle = 'রেজিস্টার';
include_once __DIR__ . '/../../includes/header.php';

// ইতিমধ্যে লগইন থাকলে ড্যাশবোর্ডে রিডাইরেক্ট করুন
if (isLoggedIn()) {
    redirect(getRoleDashboard(getUserRole()));
}

// ডিভিশন লোড করুন
$db = getDB();
$divisions = $db->query("SELECT * FROM divisions ORDER BY name")->fetchAll();

// ফর্ম সাবমিট হ্যান্ডলিং
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        setError('নিরাপত্তা ত্রুটি। আবার চেষ্টা করুন।');
    } else {
        $data = [
            'username' => clean($_POST['username'] ?? ''),
            'email' => clean($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'full_name' => clean($_POST['full_name'] ?? ''),
            'phone' => clean($_POST['phone'] ?? ''),
            'role' => clean($_POST['role'] ?? 'visitor'),
            'division_id' => clean($_POST['division_id'] ?? null),
            'district_id' => clean($_POST['district_id'] ?? null),
            'address' => clean($_POST['address'] ?? '')
        ];
        
        // পাসওয়ার্ড কনফার্ম চেক
        if ($data['password'] !== ($_POST['confirm_password'] ?? '')) {
            setError('পাসওয়ার্ড এবং কনফার্ম পাসওয়ার্ড মিলছে না');
        } else {
            $result = registerUser($data);
            
            if ($result['success']) {
                setSuccess('সফলভাবে রেজিস্টার হয়েছে! এখন লগইন করুন।');
                redirect('login.php');
            } else {
                setError($result['error']);
            }
        }
    }
}

$csrfToken = generateCsrfToken();
?>

<div class="auth-page">
    <div class="container">
        <div class="register-container">
            <div class="glass-card auth-card">
                <div class="auth-header">
                    <h1>নতুন অ্যাকাউন্ট তৈরি করুন</h1>
                    <p class="auth-subtitle">ফিশ কেয়ার সিস্টেমে যোগ দিন</p>
                </div>
                
                <form method="POST" action="" class="auth-form">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                    
                    <div class="grid grid-2">
                        <!-- Full Name -->
                        <div class="form-group">
                            <label for="full_name" class="form-label required">পূর্ণ নাম</label>
                            <input type="text" id="full_name" name="full_name" class="form-input" required>
                        </div>
                        
                        <!-- Username -->
                        <div class="form-group">
                            <label for="username" class="form-label required">ইউজারনেম</label>
                            <input type="text" id="username" name="username" class="form-input" required>
                        </div>
                        
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label required">ইমেইল</label>
                            <input type="email" id="email" name="email" class="form-input" required>
                        </div>
                        
                        <!-- Phone -->
                        <div class="form-group">
                            <label for="phone" class="form-label">মোবাইল</label>
                            <input type="tel" id="phone" name="phone" class="form-input" placeholder="01XXXXXXXXX">
                        </div>
                        
                        <!-- Role -->
                        <div class="form-group">
                            <label for="role" class="form-label required">আপনি কোন ধরনের ইউজার?</label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="farmer">চাষী</option>
                                <option value="wholesaler">হোলসেলার</option>
                                <option value="seller">বিক্রেতা</option>
                                <option value="customer">ক্রেতা</option>
                                <option value="visitor">ভিজিটর</option>
                            </select>
                        </div>
                        
                        <!-- Division -->
                        <div class="form-group">
                            <label for="division_id" class="form-label">বিভাগ</label>
                            <select id="division_id" name="division_id" class="form-select">
                                <option value="">বিভাগ নির্বাচন করুন</option>
                                <?php foreach ($divisions as $div): ?>
                                    <option value="<?php echo $div['id']; ?>"><?php echo escape($div['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label required">পাসওয়ার্ড</label>
                            <input type="password" id="password" name="password" class="form-input" required minlength="6">
                            <span class="form-help">কমপক্ষে ৬ অক্ষরের হতে হবে</span>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="confirm_password" class="form-label required">পাসওয়ার্ড নিশ্চিত করুন</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-input" required>
                        </div>
                    </div>
                    
                    <!-- Address -->
                    <div class="form-group">
                        <label for="address" class="form-label">ঠিকানা</label>
                        <textarea id="address" name="address" class="form-textarea" rows="3"></textarea>
                    </div>
                    
                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-block btn-lg">রেজিস্টার করুন</button>
                </form>
                
                <div class="auth-footer">
                    <p>ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="login.php" class="text-primary">লগইন করুন</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.register-container {
    max-width: 800px;
    margin: 0 auto;
}
</style>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
