<?php
$pageTitle = 'হোলসেলার ড্যাশবোর্ড';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('wholesaler');

$db = getDB();
$userId = getUserId();

// মেট্রিক্স
$stmt = $db->prepare("
    SELECT 
        COUNT(*) as total_invoices,
        COALESCE(SUM(grand_total), 0) as total_sales,
        COALESCE(SUM(due_amount), 0) as total_due,
        COALESCE(SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END), 0) as pending_invoices
    FROM invoices 
    WHERE user_id = ?
");
$stmt->execute([$userId]);
$metrics = $stmt->fetch();

$totalSales = $metrics['total_sales'];
$totalDue = $metrics['total_due'];
$grossProfit = $totalSales * 0.15; // 15% অনুমানিক লাভ
$pendingInvoices = $metrics['pending_invoices'];

// সাম্প্রতিক ইনভয়েস
$stmt = $db->prepare("
    SELECT * FROM invoices 
    WHERE user_id = ? 
    ORDER BY invoice_date DESC, created_at DESC 
    LIMIT 10
");
$stmt->execute([$userId]);
$recentInvoices = $stmt->fetchAll();

include_once __DIR__ . '/../../../includes/header.php';
?>

<div class="dashboard-layout">
    <aside class="dashboard-sidebar">
        <div class="sidebar-content">
            <nav class="sidebar-nav">
                <a href="index.php" class="nav-item active">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2L2 8V18H7V13H13V18H18V8L10 2Z"/></svg>
                    <span>ড্যাশবোর্ড হোম</span>
                </a>
                <a href="invoices.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4 2H16C17.1 2 18 2.9 18 4V16C18 17.1 17.1 18 16 18H4C2.9 18 2 17.1 2 16V4C2 2.9 2.9 2 4 2ZM4 6H16V4H4V6ZM4 10H16V8H4V10ZM4 14H12V12H4V14Z"/></svg>
                    <span>ইনভয়েস ম্যানেজমেন্ট</span>
                </a>
                <a href="create-invoice.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H11V14H9V11H6V9H9V6H11V9H14V11Z"/></svg>
                    <span>ইনভয়েস তৈরি</span>
                </a>
                <a href="shipments.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M18 8H15V6L13 4H7L5 6V8H2C0.9 8 0 8.9 0 10V16C0 17.1 0.9 18 2 18H3C3 19.1 3.9 20 5 20C6.1 20 7 19.1 7 18H13C13 19.1 13.9 20 15 20C16.1 20 17 19.1 17 18H18C19.1 18 20 17.1 20 16V10C20 8.9 19.1 8 18 8Z"/></svg>
                    <span>শিপমেন্ট</span>
                </a>
                <a href="/fishcare/pages/profile.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C11.66 4 13 5.34 13 7C13 8.66 11.66 10 10 10C8.34 10 7 8.66 7 7C7 5.34 8.34 4 10 4Z"/></svg>
                    <span>প্রোফাইল</span>
                </a>
            </nav>
        </div>
    </aside>
    
    <main class="dashboard-content">
        <div class="dashboard-header">
            <h1>স্বাগতম, <?php echo escape(getUserName()); ?>!</h1>
            <p class="text-muted">হোলসেলার ড্যাশবোর্ড</p>
        </div>
        
        <!-- Metrics Cards -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M38 8H10C7.8 8 6 9.8 6 12V36C6 38.2 7.8 40 10 40H38C40.2 40 42 38.2 42 36V12C42 9.8 40.2 8 38 8Z"/></svg>
                </div>
                <div class="data-card-value text-primary">৳<?php echo formatMoney($totalSales); ?></div>
                <div class="data-card-label">মোট বিক্রয়</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M24 4C12.95 4 4 12.95 4 24C4 35.05 12.95 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4Z"/></svg>
                </div>
                <div class="data-card-value text-warning">৳<?php echo formatMoney($totalDue); ?></div>
                <div class="data-card-label">বকেয়া পাওনা</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M22 6V20L6 32L10 38L24 28L38 38L42 32L26 20V6H22Z"/></svg>
                </div>
                <div class="data-card-value text-success">৳<?php echo formatMoney($grossProfit); ?></div>
                <div class="data-card-label">গ্রস প্রফিট</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M38 8H10V16H38V8ZM10 20V40H18V20H10ZM22 20V40H30V20H22ZM34 20V40H42V20H34Z"/></svg>
                </div>
                <div class="data-card-value"><?php echo $pendingInvoices; ?></div>
                <div class="data-card-label">পেন্ডিং ইনভয়েস</div>
            </div>
        </div>
        
        <!-- Recent Invoices -->
        <div class="glass-card">
            <div class="card-header">
                <h3>সাম্প্রতিক ইনভয়েস</h3>
                <a href="invoices.php" class="btn btn-glass btn-sm">সব দেখুন</a>
            </div>
            
            <?php if (count($recentInvoices) > 0): ?>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ইনভয়েস নং</th>
                                <th>গ্রাহক</th>
                                <th>তারিখ</th>
                                <th>মোট</th>
                                <th>স্ট্যাটাস</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentInvoices as $inv): ?>
                                <tr>
                                    <td><strong><?php echo escape($inv['invoice_no']); ?></strong></td>
                                    <td><?php echo escape($inv['customer_name']); ?></td>
                                    <td><?php echo formatDate($inv['invoice_date']); ?></td>
                                    <td>৳<?php echo formatMoney($inv['grand_total']); ?></td>
                                    <td>
                                        <?php
                                        $statusBadge = [
                                            'paid' => 'badge-success',
                                            'pending' => 'badge-warning',
                                            'partial' => 'badge-info',
                                            'cancelled' => 'badge-error'
                                        ];
                                        $statusText = [
                                            'paid' => 'পেইড',
                                            'pending' => 'পেন্ডিং',
                                            'partial' => 'আংশিক',
                                            'cancelled' => 'বাতিল'
                                        ];
                                        ?>
                                        <span class="badge <?php echo $statusBadge[$inv['status']] ?? 'badge-secondary'; ?>">
                                            <?php echo $statusText[$inv['status']] ?? $inv['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="view-invoice.php?id=<?php echo $inv['id']; ?>" class="btn btn-glass btn-sm">দেখুন</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>কোনো ইনভয়েস নেই</p>
                    <a href="create-invoice.php" class="btn btn-primary">ইনভয়েস তৈরি করুন</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
