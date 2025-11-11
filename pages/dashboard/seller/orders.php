<?php
$pageTitle = 'অর্ডার তালিকা';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('seller');

$db = getDB();
$userId = getUserId();

// Get filters
$statusFilter = $_GET['status'] ?? '';
$dateFilter = $_GET['date'] ?? '';

// Build query
$query = "SELECT * FROM invoices WHERE user_id = ?";
$params = [$userId];

if ($statusFilter) {
    $query .= " AND status = ?";
    $params[] = $statusFilter;
}

if ($dateFilter) {
    $query .= " AND DATE(invoice_date) = ?";
    $params[] = $dateFilter;
}

$query .= " ORDER BY invoice_date DESC, created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$orders = $stmt->fetchAll();

// Statistics
$stmt = $db->prepare("
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as completed,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'partial' THEN 1 ELSE 0 END) as partial
    FROM invoices 
    WHERE user_id = ?
");
$stmt->execute([$userId]);
$stats = $stmt->fetch();

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
                <a href="orders.php" class="nav-item active">
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
                <a href="profile.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C11.66 4 13 5.34 13 7C13 8.66 11.66 10 10 10C8.34 10 7 8.66 7 7C7 5.34 8.34 4 10 4ZM10 17C7.33 17 5.01 15.45 4 13.15C4.03 10.81 8.67 9.55 10 9.55C11.32 9.55 15.97 10.81 16 13.15C14.99 15.45 12.67 17 10 17Z"/></svg>
                    <span>প্রোফাইল</span>
                </a>
            </nav>
        </div>
    </aside>
    
    <main class="dashboard-content">
        <div class="dashboard-header">
            <h1>অর্ডার তালিকা</h1>
            <a href="/fishcare/pages/create-invoice.php" class="btn btn-primary">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H11V14H9V11H6V9H9V6H11V9H14V11Z"/></svg>
                নতুন অর্ডার তৈরি
            </a>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-value text-primary"><?php echo $stats['total']; ?></div>
                <div class="data-card-label">মোট অর্ডার</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-success"><?php echo $stats['completed']; ?></div>
                <div class="data-card-label">সম্পন্ন</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-warning"><?php echo $stats['pending']; ?></div>
                <div class="data-card-label">পেন্ডিং</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-info"><?php echo $stats['partial']; ?></div>
                <div class="data-card-label">আংশিক পরিশোধ</div>
            </div>
        </div>
        
        <!-- Search and Filter -->
        <div class="glass-card mb-6">
            <form method="GET" class="filter-form">
                <div class="grid grid-3">
                    <select name="status" class="form-control">
                        <option value="">সব স্ট্যাটাস</option>
                        <option value="paid" <?php echo $statusFilter === 'paid' ? 'selected' : ''; ?>>পরিশোধিত</option>
                        <option value="pending" <?php echo $statusFilter === 'pending' ? 'selected' : ''; ?>>অপেক্ষমাণ</option>
                        <option value="partial" <?php echo $statusFilter === 'partial' ? 'selected' : ''; ?>>আংশিক</option>
                    </select>
                    <input type="date" name="date" value="<?php echo $dateFilter; ?>" class="form-control">
                    <button type="submit" class="btn btn-primary">ফিল্টার করুন</button>
                </div>
            </form>
        </div>
        
        <!-- Orders Table -->
        <div class="glass-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ইনভয়েস নং</th>
                            <th>তারিখ</th>
                            <th>ক্রেতা</th>
                            <th>মোট টাকা</th>
                            <th>পরিশোধিত</th>
                            <th>বকেয়া</th>
                            <th>স্ট্যাটাস</th>
                            <th>কর্ম</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $order): ?>
                        <tr>
                            <td><strong><?php echo escape($order['invoice_number']); ?></strong></td>
                            <td><?php echo date('d M Y', strtotime($order['invoice_date'])); ?></td>
                            <td><?php echo escape($order['buyer_name']); ?></td>
                            <td>৳<?php echo formatMoney($order['grand_total']); ?></td>
                            <td>৳<?php echo formatMoney($order['grand_total'] - $order['due_amount']); ?></td>
                            <td>৳<?php echo formatMoney($order['due_amount']); ?></td>
                            <td>
                                <?php
                                $badgeClass = $order['status'] === 'paid' ? 'badge-success' : ($order['status'] === 'pending' ? 'badge-warning' : 'badge-info');
                                $statusText = $order['status'] === 'paid' ? 'পরিশোধিত' : ($order['status'] === 'pending' ? 'অপেক্ষমাণ' : 'আংশিক');
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span>
                            </td>
                            <td>
                                <a href="/fishcare/pages/view-invoice.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-info">দেখুন</a>
                                <a href="/fishcare/pages/print-invoice.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-secondary" target="_blank">প্রিন্ট</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="8" class="text-center">কোনো অর্ডার পাওয়া যায়নি</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
