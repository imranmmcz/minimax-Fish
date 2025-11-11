<?php
$pageTitle = 'বিক্রেতা ড্যাশবোর্ড';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('seller');

$db = getDB();
$userId = getUserId();

// Sales metrics
$stmt = $db->prepare("
    SELECT 
        COUNT(*) as total_orders,
        COALESCE(SUM(grand_total), 0) as total_sales,
        COALESCE(SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END), 0) as pending_orders,
        COALESCE(SUM(CASE WHEN status = 'paid' THEN grand_total ELSE 0 END), 0) as received_payment
    FROM invoices 
    WHERE user_id = ?
");
$stmt->execute([$userId]);
$metrics = $stmt->fetch();

// Recent orders
$stmt = $db->prepare("
    SELECT * FROM invoices 
    WHERE user_id = ? 
    ORDER BY invoice_date DESC, created_at DESC 
    LIMIT 10
");
$stmt->execute([$userId]);
$recentOrders = $stmt->fetchAll();

// Sales trend (last 7 days)
$stmt = $db->prepare("
    SELECT 
        DATE(invoice_date) as date,
        SUM(grand_total) as daily_sales
    FROM invoices
    WHERE user_id = ? AND invoice_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    GROUP BY DATE(invoice_date)
    ORDER BY date ASC
");
$stmt->execute([$userId]);
$salesTrend = $stmt->fetchAll();

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
                <a href="profile.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C11.66 4 13 5.34 13 7C13 8.66 11.66 10 10 10C8.34 10 7 8.66 7 7C7 5.34 8.34 4 10 4ZM10 17C7.33 17 5.01 15.45 4 13.15C4.03 10.81 8.67 9.55 10 9.55C11.32 9.55 15.97 10.81 16 13.15C14.99 15.45 12.67 17 10 17Z"/></svg>
                    <span>প্রোফাইল</span>
                </a>
            </nav>
        </div>
    </aside>
    
    <main class="dashboard-content">
        <div class="dashboard-header">
            <h1>স্বাগতম, <?php echo escape(getUserName()); ?>!</h1>
            <p class="text-muted">বিক্রেতা ড্যাশবোর্ড</p>
        </div>
        
        <!-- Metrics Cards -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M38 8H10C7.8 8 6 9.8 6 12V36C6 38.2 7.8 40 10 40H38C40.2 40 42 38.2 42 36V12C42 9.8 40.2 8 38 8Z"/></svg>
                </div>
                <div class="data-card-value text-primary">৳<?php echo formatMoney($metrics['total_sales']); ?></div>
                <div class="data-card-label">মোট বিক্রয়</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M20 8V2H28V8H20ZM8 14H40V18H8V14ZM10 20H38V42H10V20ZM16 26H32V30H16V26Z"/></svg>
                </div>
                <div class="data-card-value text-info"><?php echo $metrics['total_orders']; ?></div>
                <div class="data-card-label">মোট অর্ডার</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M24 4C12.95 4 4 12.95 4 24C4 35.05 12.95 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4Z"/></svg>
                </div>
                <div class="data-card-value text-success">৳<?php echo formatMoney($metrics['received_payment']); ?></div>
                <div class="data-card-label">প্রাপ্ত পেমেন্ট</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M42 18H32V8H16V18H6V42H42V18ZM20 12H28V18H20V12ZM38 38H10V22H38V38Z"/></svg>
                </div>
                <div class="data-card-value text-warning"><?php echo $metrics['pending_orders']; ?></div>
                <div class="data-card-label">পেন্ডিং অর্ডার</div>
            </div>
        </div>
        
        <!-- Sales Chart -->
        <div class="glass-card mb-6">
            <h3 class="card-title">বিক্রয় প্রবণতা (শেষ ৭ দিন)</h3>
            <canvas id="salesChart" style="height: 300px;"></canvas>
        </div>
        
        <!-- Recent Orders -->
        <div class="glass-card">
            <div class="card-header">
                <h3 class="card-title">সাম্প্রতিক অর্ডার</h3>
                <a href="orders.php" class="btn btn-sm btn-secondary">সব দেখুন</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ইনভয়েস নং</th>
                            <th>তারিখ</th>
                            <th>ক্রেতা</th>
                            <th>মোট টাকা</th>
                            <th>স্ট্যাটাস</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recentOrders as $order): ?>
                        <tr>
                            <td><strong><?php echo escape($order['invoice_number']); ?></strong></td>
                            <td><?php echo date('d M Y', strtotime($order['invoice_date'])); ?></td>
                            <td><?php echo escape($order['buyer_name']); ?></td>
                            <td>৳<?php echo formatMoney($order['grand_total']); ?></td>
                            <td>
                                <?php
                                $badgeClass = $order['status'] === 'paid' ? 'badge-success' : ($order['status'] === 'pending' ? 'badge-warning' : 'badge-info');
                                $statusText = $order['status'] === 'paid' ? 'পরিশোধিত' : ($order['status'] === 'pending' ? 'অপেক্ষমাণ' : 'আংশিক');
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($recentOrders)): ?>
                        <tr>
                            <td colspan="5" class="text-center">কোনো অর্ডার পাওয়া যায়নি</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesData = <?php echo json_encode($salesTrend); ?>;
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: salesData.map(d => d.date),
        datasets: [{
            label: 'দৈনিক বিক্রয় (৳)',
            data: salesData.map(d => parseFloat(d.daily_sales)),
            borderColor: '#00BCD4',
            backgroundColor: 'rgba(0, 188, 212, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
