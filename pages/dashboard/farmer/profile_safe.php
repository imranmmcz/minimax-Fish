<?php
// Profile পেজ এরর হ্যান্ডলিং উন্নত করা
$pageTitle = 'প্রোফাইল সম্পাদনা';

// Error handling যোগ করুন
function handleDatabaseError($message) {
    if (!isset($_SESSION)) {
        session_start();
    }
    
    if (!function_exists('setError')) {
        function setError($msg) {
            $_SESSION['error'] = $msg;
        }
    }
    
    if (!function_exists('setSuccess')) {
        function setSuccess($msg) {
            $_SESSION['success'] = $msg;
        }
    }
    
    if (!function_exists('getError')) {
        function getError() {
            return $_SESSION['error'] ?? '';
        }
    }
    
    setError($message);
}

try {
    require_once __DIR__ . '/../../../config/config.php';
    require_once __DIR__ . '/../../../includes/auth.php';
    
    // চাষী রোল চেক করুন
    requireRole('farmer');
    
    $db = getDB();
    $userId = getUserId();
    
    // ইউজারের মূল তথ্য পান
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    
    // চাষ সংক্রান্ত তথ্য (সেফ হ্যান্ডলিং)
    $profile = null;
    try {
        $stmt = $db->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
        $stmt->execute([$userId]);
        $profile = $stmt->fetch();
        
        // যদি প্রোফাইল না থাকে তাহলে ডিফল্ট ভ্যালু দিয়ে তৈরি করুন
        if (!$profile) {
            try {
                $createProfile = $db->prepare("INSERT INTO user_profiles (user_id, farming_experience, pond_count, farming_type, preferred_fish_species, annual_income, bio) VALUES (?, 0, 0, 'traditional', '', 0.00, '')");
                $createProfile->execute([$userId]);
                
                // পুনরায় লোড করুন
                $stmt = $db->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
                $stmt->execute([$userId]);
                $profile = $stmt->fetch();
            } catch (Exception $e) {
                // টেবিল না থাকলে ডিফল্ট ভ্যালু সেট করুন
                $profile = [
                    'id' => 0,
                    'user_id' => $userId,
                    'farming_experience' => 0,
                    'pond_count' => 0,
                    'farming_type' => 'traditional',
                    'preferred_fish_species' => '',
                    'annual_income' => 0.00,
                    'bio' => ''
                ];
                handleDatabaseError('Profile টেবিল তৈরি করা প্রয়োজন। অনুগ্রহ করে profile_diagnostic.php দেখুন।');
            }
        }
    } catch (Exception $e) {
        // টেবিল না থাকলে ডিফল্ট ভ্যালু সেট করুন
        $profile = [
            'id' => 0,
            'user_id' => $userId,
            'farming_experience' => 0,
            'pond_count' => 0,
            'farming_type' => 'traditional',
            'preferred_fish_species' => '',
            'annual_income' => 0.00,
            'bio' => ''
        ];
        handleDatabaseError('Profile টেবিল তৈরি করা প্রয়োজন। অনুগ্রহ করে profile_diagnostic.php দেখুন।');
    }
    
    // ফর্ম সাবমিট হ্যান্ডলিং (অবশিষ্ট অংশ রয়েছে - এই ফাইলে আগের অংশের সাথে যোগ করুন)
    // ... বাকি কোড এখানে থাকবে ...

} catch (Exception $e) {
    handleDatabaseError('পেজ লোড করতে সমস্যা: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Profile'; ?> - Fish Care</title>
    <style>
        /* Essential CSS for error display */
        .error-alert {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            margin: 20px;
            position: relative;
        }
        .error-alert .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #721c24;
        }
        .fix-button {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .fix-button:hover {
            background: #c82333;
            color: white;
        }
    </style>
</head>
<body>
    <?php if (getError()): ?>
        <div class="error-alert">
            <button class="close-btn" onclick="this.parentElement.style.display='none'">&times;</button>
            <strong>⚠️ সমস্যা:</strong> <?php echo htmlspecialchars(getError()); ?>
            <br>
            <a href="../profile_diagnostic.php" class="fix-button">🔧 সমাধান করুন</a>
            <a href="index.php" class="fix-button" style="background: #28a745;">🏠 ড্যাশবোর্ডে ফিরুন</a>
        </div>
    <?php endif; ?>

    <?php if (!getError()): ?>
        <div style="padding: 20px; text-align: center;">
            <h2>Profile পেজ লোড হচ্ছে...</h2>
            <p>অনুগ্রহ করে অপেক্ষা করুন।</p>
            
            <!-- পেজ লোড হওয়ার পর এখানে মূল কন্টেন্ট দেখানো হবে -->
            <div id="profile-content" style="margin-top: 30px;">
                <!-- এখানে মূল profile.php কোড বসানো হবে -->
                <p style="color: #666;">Profile কন্টেন্ট লোড হচ্ছে...</p>
            </div>
        </div>
        
        <script>
            // Profile কন্টেন্ট লোড করুন
            fetch('profile_content.php')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('profile-content').innerHTML = html;
                })
                .catch(error => {
                    document.getElementById('profile-content').innerHTML = 
                        '<div class="error-alert"><strong>❌ ত্রুটি:</strong> Profile কন্টেন্ট লোড করা যায়নি।<br><a href="profile_diagnostic.php" class="fix-button">🔧 সমাধান করুন</a></div>';
                });
        </script>
    <?php endif; ?>
</body>
</html>
