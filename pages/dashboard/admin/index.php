<?php
$pageTitle = 'অ্যাডমিন ড্যাশবোর্ড';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('admin');

$db = getDB();

// সিস্টেম মেট্রিক্স
$stmt = $db->query("SELECT COUNT(*) as total_users FROM users");
$totalUsers = $stmt->fetch()['total_users'];

$stmt = $db->query("SELECT COUNT(*) as total_products FROM products");
$totalProducts = $stmt->fetch()['total_products'];

$stmt = $db->query("SELECT COALESCE(SUM(grand_total), 0) as total_revenue FROM invoices");
$totalRevenue = $stmt->fetch()['total_revenue'];

$stmt = $db->query("SELECT COUNT(*) as active_orders FROM invoices WHERE status = 'pending'");
$activeOrders = $stmt->fetch()['active_orders'];

// রোল ভিত্তিক ব্যবহারকারী
$stmt = $db->query("
    SELECT role, COUNT(*) as count 
    FROM users 
    GROUP BY role
");
$usersByRole = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// সাম্প্রতিক কার্যক্রম
$stmt = $db->query("
    SELECT u.name, u.role, u.created_at, u.email 
    FROM users u 
    ORDER BY u.created_at DESC 
    LIMIT 10
");
$recentActivities = $stmt->fetchAll();

// মাসিক বিক্রয় ডেটা (চার্টের জন্য)
$stmt = $db->query("
    SELECT 
        DATE_FORMAT(invoice_date, '%Y-%m') as month,
        SUM(grand_total) as total
    FROM invoices
    WHERE invoice_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY month
    ORDER BY month ASC
");
$salesData = $stmt->fetchAll();

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
            <p class="text-muted">সিস্টেম অ্যাডমিনিস্ট্রেটর ড্যাশবোর্ড</p>
        </div>
        
        <!-- Metrics Cards -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M28 6C28 9.31 25.31 12 22 12C18.69 12 16 9.31 16 6C16 2.69 18.69 0 22 0C25.31 0 28 2.69 28 6ZM4 36V32C4 26.68 14.67 24 22 24C29.33 24 40 26.68 40 32V36H4Z"/></svg>
                </div>
                <div class="data-card-value text-primary"><?php echo $totalUsers; ?></div>
                <div class="data-card-label">মোট ব্যবহারকারী</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M38 8H10C7.8 8 6 9.8 6 12V36C6 38.2 7.8 40 10 40H38C40.2 40 42 38.2 42 36V12C42 9.8 40.2 8 38 8Z"/></svg>
                </div>
                <div class="data-card-value text-success">৳<?php echo formatMoney($totalRevenue); ?></div>
                <div class="data-card-label">মোট রাজস্ব</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M42 18H32V8H16V18H6V42H42V18ZM20 12H28V18H20V12ZM38 38H10V22H38V38Z"/></svg>
                </div>
                <div class="data-card-value text-info"><?php echo $totalProducts; ?></div>
                <div class="data-card-label">মোট পণ্য</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor"><path d="M20 8V2H28V8H20ZM8 14H40V18H8V14ZM10 20H38V42H10V20ZM16 26H32V30H16V26Z"/></svg>
                </div>
                <div class="data-card-value text-warning"><?php echo $activeOrders; ?></div>
                <div class="data-card-label">সক্রিয় অর্ডার</div>
            </div>
        </div>
        
        <!-- Charts and Tables Row -->
        <div class="grid grid-2 mb-8">
            <!-- Sales Chart -->
            <div class="glass-card">
                <h3 class="card-title">মাসিক বিক্রয় প্রবণতা</h3>
                <canvas id="salesChart" style="height: 300px;"></canvas>
            </div>
            
            <!-- Users by Role -->
            <div class="glass-card">
                <h3 class="card-title">রোল ভিত্তিক ব্যবহারকারী</h3>
                <canvas id="roleChart" style="height: 300px;"></canvas>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="glass-card">
            <div class="card-header">
                <h3 class="card-title">সাম্প্রতিক ব্যবহারকারী নিবন্ধন</h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>নাম</th>
                            <th>ইমেইল</th>
                            <th>রোল</th>
                            <th>নিবন্ধন তারিখ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recentActivities as $activity): ?>
                        <tr>
                            <td><?php echo escape($activity['name']); ?></td>
                            <td><?php echo escape($activity['email']); ?></td>
                            <td><span class="badge badge-info"><?php echo escape($activity['role']); ?></span></td>
                            <td><?php echo date('d M Y', strtotime($activity['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
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
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($salesData, 'month')); ?>,
        datasets: [{
            label: 'বিক্রয় (৳)',
            data: <?php echo json_encode(array_column($salesData, 'total')); ?>,
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

// Role Chart
const roleCtx = document.getElementById('roleChart').getContext('2d');
new Chart(roleCtx, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode(array_keys($usersByRole)); ?>,
        datasets: [{
            data: <?php echo json_encode(array_values($usersByRole)); ?>,
            backgroundColor: [
                '#00BCD4',
                '#4CAF50',
                '#FFC107',
                '#F44336',
                '#9C27B0',
                '#FF9800'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
