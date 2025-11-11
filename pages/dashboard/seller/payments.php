<?php
$pageTitle = 'পেমেন্ট ইতিহাস';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('seller');

$db = getDB();
$userId = getUserId();

// Get payment history (from invoices)
$stmt = $db->prepare("
    SELECT * FROM invoices 
    WHERE user_id = ? 
    ORDER BY invoice_date DESC, created_at DESC
");
$stmt->execute([$userId]);
$payments = $stmt->fetchAll();

// Calculate totals
$totalReceived = array_sum(array_map(function($p) {
    return $p['grand_total'] - $p['due_amount'];
}, $payments));

$totalPending = array_sum(array_column($payments, 'due_amount'));

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
                <a href="payments.php" class="nav-item active">
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
                <a href="profile.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C11.66 4 13 5.34 13 7C13 8.66 11.66 10 10 10C8.34 10 7 8.66 7 7C7 5.34 8.34 4 10 4ZM10 17C7.33 17 5.01 15.45 4 13.15C4.03 10.81 8.67 9.55 10 9.55C11.32 9.55 15.97 10.81 16 13.15C14.99 15.45 12.67 17 10 17Z"/></svg>
                    <span>প্রোফাইল</span>
                </a>
            </nav>
        </div>
    </aside>
    
    <main class="dashboard-content">
        <div class="dashboard-header">
            <h1>পেমেন্ট ইতিহাস</h1>
        </div>
        
        <!-- Payment Summary -->
        <div class="grid grid-3 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-value text-success">৳<?php echo formatMoney($totalReceived); ?></div>
                <div class="data-card-label">মোট প্রাপ্ত</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-warning">৳<?php echo formatMoney($totalPending); ?></div>
                <div class="data-card-label">বকেয়া প্রাপ্য</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-primary">৳<?php echo formatMoney($totalReceived + $totalPending); ?></div>
                <div class="data-card-label">মোট লেনদেন</div>
            </div>
        </div>
        
        <!-- Payments Table -->
        <div class="glass-card">
            <h3 class="card-title">পেমেন্ট রেকর্ড</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>তারিখ</th>
                            <th>ইনভয়েস নং</th>
                            <th>ক্রেতা</th>
                            <th>মোট টাকা</th>
                            <th>প্রাপ্ত</th>
                            <th>বকেয়া</th>
                            <th>স্ট্যাটাস</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($payments as $payment): ?>
                        <tr>
                            <td><?php echo date('d M Y', strtotime($payment['invoice_date'])); ?></td>
                            <td><strong><?php echo escape($payment['invoice_number']); ?></strong></td>
                            <td><?php echo escape($payment['buyer_name']); ?></td>
                            <td>৳<?php echo formatMoney($payment['grand_total']); ?></td>
                            <td class="text-success">৳<?php echo formatMoney($payment['grand_total'] - $payment['due_amount']); ?></td>
                            <td class="text-warning">৳<?php echo formatMoney($payment['due_amount']); ?></td>
                            <td>
                                <?php
                                $badgeClass = $payment['status'] === 'paid' ? 'badge-success' : ($payment['status'] === 'pending' ? 'badge-warning' : 'badge-info');
                                $statusText = $payment['status'] === 'paid' ? 'সম্পূর্ণ পরিশোধিত' : ($payment['status'] === 'pending' ? 'অপেক্ষমাণ' : 'আংশিক পরিশোধ');
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($payments)): ?>
                        <tr>
                            <td colspan="7" class="text-center">কোনো পেমেন্ট রেকর্ড পাওয়া যায়নি</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
