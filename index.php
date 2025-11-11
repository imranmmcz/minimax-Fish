<?php
$pageTitle = 'হোম';
$bodyClass = 'home-page';
include_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="glass-card hero-card">
                <h1 class="hero-title">ফিশ কেয়ার সিস্টেম</h1>
                <p class="hero-subtitle">বাংলাদেশের মৎস্য চাষ ব্যবসায়ের সম্পূর্ণ ডিজিটাল ব্যবস্থাপনা সিস্টেম</p>
                <div class="hero-actions">
                    <?php if (isLoggedIn()): ?>
                        <a href="<?php echo getRoleDashboard(getUserRole()); ?>" class="btn btn-primary btn-lg">
                            ড্যাশবোর্ডে যান
                        </a>
                    <?php else: ?>
                        <a href="/fishcare/pages/auth/register.php" class="btn btn-primary btn-lg">শুরু করুন</a>
                        <a href="/fishcare/pages/auth/login.php" class="btn btn-glass btn-lg">লগইন করুন</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Role Selection Section -->
<section class="roles-section">
    <div class="container">
        <h2 class="section-title text-center">আপনার রোল নির্বাচন করুন</h2>
        <p class="section-subtitle text-center">প্রতিটি রোলের জন্য বিশেষায়িত ড্যাশবোর্ড এবং ফিচার</p>
        
        <div class="grid grid-3">
            <!-- Admin -->
            <div class="glass-card role-card">
                <div class="role-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M24 4C12.95 4 4 12.95 4 24C4 35.05 12.95 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4ZM24 12C27.31 12 30 14.69 30 18C30 21.31 27.31 24 24 24C20.69 24 18 21.31 18 18C18 14.69 20.69 12 24 12ZM24 38C18 38 12.5 35.25 10 30.5C10.06 25.62 20 23 24 23C27.98 23 37.94 25.62 38 30.5C35.5 35.25 30 38 24 38Z"/>
                    </svg>
                </div>
                <h3 class="role-title">অ্যাডমিন</h3>
                <p class="role-description">সম্পূর্ণ সিস্টেম পরিচালনা এবং নিয়ন্ত্রণ</p>
            </div>
            
            <!-- Farmer -->
            <div class="glass-card role-card">
                <div class="role-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M24 4L6 14V24C6 34 14 42 24 44C34 42 42 34 42 24V14L24 4ZM24 24C21.79 24 20 22.21 20 20C20 17.79 21.79 16 24 16C26.21 16 28 17.79 28 20C28 22.21 26.21 24 24 24Z"/>
                    </svg>
                </div>
                <h3 class="role-title">চাষী</h3>
                <p class="role-description">পুকুর ব্যবস্থাপনা এবং আয়-ব্যয় ট্র্যাকিং</p>
            </div>
            
            <!-- Wholesaler -->
            <div class="glass-card role-card">
                <div class="role-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M38 8H10C7.8 8 6 9.8 6 12V36C6 38.2 7.8 40 10 40H38C40.2 40 42 38.2 42 36V12C42 9.8 40.2 8 38 8ZM38 36H10V16H38V36Z"/>
                    </svg>
                </div>
                <h3 class="role-title">হোলসেলার</h3>
                <p class="role-description">ইনভয়েস এবং শিপমেন্ট ম্যানেজমেন্ট</p>
            </div>
            
            <!-- Seller -->
            <div class="glass-card role-card">
                <div class="role-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M14 4L8 12V38C8 40.2 9.8 42 12 42H36C38.2 42 40 40.2 40 38V12L34 4H14ZM24 32C19.58 32 16 28.42 16 24C16 19.58 19.58 16 24 16C28.42 16 32 19.58 32 24C32 28.42 28.42 32 24 32Z"/>
                    </svg>
                </div>
                <h3 class="role-title">বিক্রেতা</h3>
                <p class="role-description">দৈনন্দিন বিক্রয় এবং স্টক পরিচালনা</p>
            </div>
            
            <!-- Customer -->
            <div class="glass-card role-card">
                <div class="role-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M16 4L4 12V22C4 32.5 11 42 20 44V42C12.27 40.11 6 31.59 6 22V14L16 8L26 14V22C26 24.21 25.55 26.31 24.74 28.22C28.37 26.85 31.22 24.04 32.74 20.48C33.57 22.18 34 24.06 34 26C34 34 28 40.93 20 42.93V44.93C29 42.89 36 35.03 36 26C36 23.27 35.31 20.69 34.15 18.43C37.67 16.77 40 13.24 40 9.25C40 3.87 35.63 -0.5 30.25 -0.5C24.87 -0.5 20.5 3.87 20.5 9.25C20.5 11.71 21.43 13.93 22.93 15.64L16 4Z"/>
                    </svg>
                </div>
                <h3 class="role-title">ক্রেতা</h3>
                <p class="role-description">অর্ডার এবং লেনদেন ট্র্যাকিং</p>
            </div>
            
            <!-- Visitor -->
            <div class="glass-card role-card">
                <div class="role-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M24 4C12.95 4 4 12.95 4 24C4 35.05 12.95 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4ZM26 34H22V22H26V34ZM26 18H22V14H26V18Z"/>
                    </svg>
                </div>
                <h3 class="role-title">ভিজিটর</h3>
                <p class="role-description">তথ্য এবং পরামর্শ পাবলিক অ্যাক্সেস</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <h2 class="section-title text-center">মূল ফিচার সমূহ</h2>
        
        <div class="grid grid-4">
            <div class="glass-card feature-card">
                <div class="feature-icon">📊</div>
                <h4>ড্যাশবোর্ড</h4>
                <p>রিয়েল-টাইম ডেটা ভিজুয়ালাইজেশন</p>
            </div>
            
            <div class="glass-card feature-card">
                <div class="feature-icon">💰</div>
                <h4>আর্থিক ট্র্যাকিং</h4>
                <p>আয়-ব্যয় হিসাব রক্ষণ</p>
            </div>
            
            <div class="glass-card feature-card">
                <div class="feature-icon">📈</div>
                <h4>বাজার মূল্য</h4>
                <p>বর্তমান বাজার দর তথ্য</p>
            </div>
            
            <div class="glass-card feature-card">
                <div class="feature-icon">🧮</div>
                <h4>ক্যালকুলেটর</h4>
                <p>মৎস্য চাষ হিসাব টুল</p>
            </div>
        </div>
    </div>
</section>

<style>
.hero-section {
    background: var(--bg-hero);
    min-height: 500px;
    display: flex;
    align-items: center;
    padding: var(--space-16) 0;
    position: relative;
    overflow: hidden;
}

.hero-card {
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
    padding: var(--space-12);
}

.hero-title {
    font-size: var(--text-xl);
    color: white;
    margin-bottom: var(--space-4);
}

.hero-subtitle {
    font-size: var(--text-base);
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: var(--space-8);
    line-height: 1.6;
}

.hero-actions {
    display: flex;
    gap: var(--space-4);
    justify-content: center;
    flex-wrap: wrap;
}

.roles-section,
.features-section {
    padding: var(--space-16) 0;
}

.section-title {
    font-size: var(--text-md);
    margin-bottom: var(--space-4);
}

.section-subtitle {
    font-size: var(--text-base);
    color: var(--color-neutral-600);
    margin-bottom: var(--space-12);
}

.role-card,
.feature-card {
    text-align: center;
    cursor: pointer;
    transition: all var(--duration-normal) var(--easing-default);
}

.role-icon,
.feature-icon {
    color: var(--color-primary-500);
    margin-bottom: var(--space-4);
}

.feature-icon {
    font-size: 48px;
}

.role-title {
    font-size: var(--text-sm);
    margin-bottom: var(--space-2);
}

.role-description {
    color: var(--color-neutral-600);
    font-size: var(--text-small);
}

@media screen and (max-width: 768px) {
    .hero-title {
        font-size: var(--text-lg);
    }
    
    .hero-actions {
        flex-direction: column;
    }
}
</style>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
