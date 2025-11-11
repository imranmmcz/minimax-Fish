<?php
$pageTitle = 'চাষী ড্যাশবোর্ড';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

// চাষী রোল চেক করুন
requireRole('farmer');

$db = getDB();
$userId = getUserId();

// মেট্রিক্স ডেটা লোড করুন
$stmt = $db->prepare("
    SELECT 
        COALESCE(SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END), 0) as total_income,
        COALESCE(SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END), 0) as total_expense
    FROM income_expenses 
    WHERE user_id = ?
");
$stmt->execute([$userId]);
$financial = $stmt->fetch();

$totalIncome = $financial['total_income'];
$totalExpense = $financial['total_expense'];
$totalProfit = $totalIncome - $totalExpense;

// পুকুরের সংখ্যা
$stmt = $db->prepare("SELECT COUNT(*) as pond_count FROM ponds WHERE user_id = ? AND status = 'active'");
$stmt->execute([$userId]);
$pondCount = $stmt->fetch()['pond_count'];

// সাম্প্রতিক লেনদেন
$stmt = $db->prepare("
    SELECT * FROM income_expenses 
    WHERE user_id = ? 
    ORDER BY transaction_date DESC, created_at DESC 
    LIMIT 10
");
$stmt->execute([$userId]);
$recentTransactions = $stmt->fetchAll();

include_once __DIR__ . '/../../../includes/header.php';
?>

<div class="dashboard-layout">
    <!-- Sidebar -->
    <aside class="dashboard-sidebar">
        <div class="sidebar-content">
            <nav class="sidebar-nav">
                <a href="index.php" class="nav-item active">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2L2 8V18H7V13H13V18H18V8L10 2Z"/>
                    </svg>
                    <span>ড্যাশবোর্ড হোম</span>
                </a>
                <a href="ponds.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 15C7.24 15 5 12.76 5 10C5 7.24 7.24 5 10 5C12.76 5 15 7.24 15 10C15 12.76 12.76 15 10 15Z"/>
                    </svg>
                    <span>পুকুর ব্যবস্থাপনা</span>
                </a>
                <a href="add-income.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H11V14H9V11H6V9H9V6H11V9H14V11Z"/>
                    </svg>
                    <span>আয় যোগ করুন</span>
                </a>
                <a href="add-expense.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H6V9H14V11Z"/>
                    </svg>
                    <span>ব্যয় যোগ করুন</span>
                </a>
                <a href="transactions.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 4H18V6H2V4ZM2 9H18V11H2V9ZM2 14H18V16H2V14Z"/>
                    </svg>
                    <span>লেনদেন তালিকা</span>
                </a>
                <a href="/fishcare/pages/profile.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C11.66 4 13 5.34 13 7C13 8.66 11.66 10 10 10C8.34 10 7 8.66 7 7C7 5.34 8.34 4 10 4ZM10 17C7.33 17 5.01 15.45 4 13.25C4.03 11 8 9.79 10 9.79C11.99 9.79 15.97 11 16 13.25C14.99 15.45 12.67 17 10 17Z"/>
                    </svg>
                    <span>প্রোফাইল</span>
                </a>
            </nav>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="dashboard-content">
        <div class="dashboard-header">
            <h1>স্বাগতম, <?php echo escape(getUserName()); ?>!</h1>
            <p class="text-muted">আজকের তারিখ: <?php echo formatDate(date('Y-m-d'), 'd F, Y'); ?></p>
        </div>
        
        <!-- Metrics Cards -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M38 8H10C7.8 8 6 9.8 6 12V36C6 38.2 7.8 40 10 40H38C40.2 40 42 38.2 42 36V12C42 9.8 40.2 8 38 8ZM38 36H10V16H38V36Z"/>
                    </svg>
                </div>
                <div class="data-card-value text-success">৳<?php echo formatMoney($totalIncome); ?></div>
                <div class="data-card-label">মোট আয়</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M38 8H10C7.8 8 6 9.8 6 12V36C6 38.2 7.8 40 10 40H38C40.2 40 42 38.2 42 36V12C42 9.8 40.2 8 38 8ZM16 32L12 28L14 26L16 28L20 24L22 26L16 32ZM16 22L12 18L14 16L16 18L20 14L22 16L16 22ZM32 30H26V26H32V30ZM32 20H26V16H32V20Z"/>
                    </svg>
                </div>
                <div class="data-card-value text-error">৳<?php echo formatMoney($totalExpense); ?></div>
                <div class="data-card-label">মোট ব্যয়</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M22 6V20L6 32L10 38L24 28L38 38L42 32L26 20V6H22ZM24 2C25.1 2 26 2.9 26 4C26 5.1 25.1 6 24 6C22.9 6 22 5.1 22 4C22 2.9 22.9 2 24 2Z"/>
                    </svg>
                </div>
                <div class="data-card-value <?php echo $totalProfit >= 0 ? 'text-success' : 'text-error'; ?>">
                    ৳<?php echo formatMoney(abs($totalProfit)); ?>
                </div>
                <div class="data-card-label">মোট <?php echo $totalProfit >= 0 ? 'লাভ' : 'লোকসান'; ?></div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M24 4C12.95 4 4 12.95 4 24C4 35.05 12.95 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4ZM24 34C18.48 34 14 29.52 14 24C14 18.48 18.48 14 24 14C29.52 14 34 18.48 34 24C34 29.52 29.52 34 24 34Z"/>
                    </svg>
                </div>
                <div class="data-card-value"><?php echo $pondCount; ?></div>
                <div class="data-card-label">সক্রিয় পুকুর</div>
            </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="glass-card">
            <div class="card-header">
                <h3>সাম্প্রতিক লেনদেন</h3>
                <a href="transactions.php" class="btn btn-glass btn-sm">সব দেখুন</a>
            </div>
            
            <?php if (count($recentTransactions) > 0): ?>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>তারিখ</th>
                                <th>ধরন</th>
                                <th>বিবরণ</th>
                                <th>পরিমাণ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentTransactions as $trans): ?>
                                <tr>
                                    <td><?php echo formatDate($trans['transaction_date']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $trans['type'] === 'income' ? 'badge-success' : 'badge-error'; ?>">
                                            <?php echo $trans['type'] === 'income' ? 'আয়' : 'ব্যয়'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo escape($trans['description'] ?? $trans['category']); ?></td>
                                    <td class="<?php echo $trans['type'] === 'income' ? 'text-success' : 'text-error'; ?>">
                                        ৳<?php echo formatMoney($trans['amount']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>কোনো লেনদেন নেই</p>
                    <a href="add-income.php" class="btn btn-primary">আয় যোগ করুন</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<style>
.dashboard-layout {
    display: flex;
    min-height: calc(100vh - 72px - 200px);
}

.dashboard-sidebar {
    width: 260px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-right: 1px solid rgba(255, 255, 255, 0.2);
    padding: var(--space-6);
    position: sticky;
    top: 72px;
    height: calc(100vh - 72px);
    overflow-y: auto;
}

.sidebar-nav {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.nav-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-4);
    color: var(--color-neutral-900);
    border-radius: var(--radius-md);
    transition: all var(--duration-fast) var(--easing-default);
}

.nav-item:hover {
    background: rgba(0, 188, 212, 0.1);
}

.nav-item.active {
    background: var(--color-primary-500);
    color: white;
}

.dashboard-content {
    flex: 1;
    padding: var(--space-8);
}

.dashboard-header {
    margin-bottom: var(--space-8);
}

.dashboard-header h1 {
    margin-bottom: var(--space-2);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
}

.empty-state {
    text-align: center;
    padding: var(--space-12) 0;
}

@media screen and (max-width: 768px) {
    .dashboard-layout {
        flex-direction: column;
    }
    
    .dashboard-sidebar {
        width: 100%;
        height: auto;
        position: static;
    }
    
    .sidebar-nav {
        flex-direction: row;
        overflow-x: auto;
    }
}
</style>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
