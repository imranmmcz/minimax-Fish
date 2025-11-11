<?php
$pageTitle = 'সিস্টেম রিপোর্ট';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('admin');

$db = getDB();

// Date range filter
$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate = $_GET['end_date'] ?? date('Y-m-d');

// Sales Report
$stmt = $db->prepare("
    SELECT 
        DATE(invoice_date) as date,
        COUNT(*) as total_invoices,
        SUM(grand_total) as total_sales,
        SUM(due_amount) as total_due
    FROM invoices
    WHERE invoice_date BETWEEN ? AND ?
    GROUP BY DATE(invoice_date)
    ORDER BY date DESC
");
$stmt->execute([$startDate, $endDate]);
$salesReport = $stmt->fetchAll();

// User Registration Report
$stmt = $db->prepare("
    SELECT 
        DATE(created_at) as date,
        role,
        COUNT(*) as count
    FROM users
    WHERE created_at BETWEEN ? AND ?
    GROUP BY DATE(created_at), role
    ORDER BY date DESC
");
$stmt->execute([$startDate, $endDate]);
$userReport = $stmt->fetchAll();

// Product Performance
$stmt = $db->prepare("
    SELECT 
        p.name,
        p.category,
        COUNT(ii.id) as total_sold,
        SUM(ii.quantity) as total_quantity,
        SUM(ii.sub_total) as total_revenue
    FROM products p
    LEFT JOIN invoice_items ii ON p.id = ii.product_id
    LEFT JOIN invoices i ON ii.invoice_id = i.id
    WHERE i.invoice_date BETWEEN ? AND ?
    GROUP BY p.id
    ORDER BY total_revenue DESC
    LIMIT 20
");
$stmt->execute([$startDate, $endDate]);
$productReport = $stmt->fetchAll();

// Summary Statistics
$stmt = $db->prepare("
    SELECT 
        SUM(grand_total) as total_revenue,
        SUM(due_amount) as total_due,
        COUNT(*) as total_invoices,
        AVG(grand_total) as avg_invoice_value
    FROM invoices
    WHERE invoice_date BETWEEN ? AND ?
");
$stmt->execute([$startDate, $endDate]);
$summary = $stmt->fetch();

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
                <a href="users.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M14 6C14 8.21 12.21 10 10 10C7.79 10 6 8.21 6 6C6 3.79 7.79 2 10 2C12.21 2 14 3.79 14 6ZM2 18V16C2 13.34 7.33 12 10 12C12.67 12 18 13.34 18 16V18H2Z"/></svg>
                    <span>ব্যবহারকারী ম্যানেজমেন্ট</span>
                </a>
                <a href="reports.php" class="nav-item active">
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
            <h1>সিস্টেম রিপোর্ট</h1>
            <div class="header-actions">
                <button onclick="window.print()" class="btn btn-secondary">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M16 6H14V2H6V6H4C2.9 6 2 6.9 2 8V14H6V18H14V14H18V8C18 6.9 17.1 6 16 6ZM8 4H12V6H8V4ZM12 16H8V12H12V16ZM14 11H16V9H14V11Z"/></svg>
                    প্রিন্ট করুন
                </button>
                <button onclick="exportToExcel()" class="btn btn-success">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M14 2H6C4.9 2 4 2.9 4 4V16C4 17.1 4.9 18 6 18H14C15.1 18 16 17.1 16 16V4C16 2.9 15.1 2 14 2ZM14 16H6V4H14V16Z"/></svg>
                    এক্সেল এক্সপোর্ট
                </button>
            </div>
        </div>
        
        <!-- Date Filter -->
        <div class="glass-card mb-6">
            <form method="GET" class="filter-form">
                <div class="grid grid-3">
                    <div class="form-group">
                        <label>শুরুর তারিখ</label>
                        <input type="date" name="start_date" value="<?php echo $startDate; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>শেষ তারিখ</label>
                        <input type="date" name="end_date" value="<?php echo $endDate; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-full">ফিল্টার করুন</button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Summary Cards -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-value text-primary">৳<?php echo formatMoney($summary['total_revenue']); ?></div>
                <div class="data-card-label">মোট রাজস্ব</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-warning"><?php echo $summary['total_invoices']; ?></div>
                <div class="data-card-label">মোট ইনভয়েস</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-success">৳<?php echo formatMoney($summary['avg_invoice_value']); ?></div>
                <div class="data-card-label">গড় ইনভয়েস মূল্য</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-danger">৳<?php echo formatMoney($summary['total_due']); ?></div>
                <div class="data-card-label">মোট বকেয়া</div>
            </div>
        </div>
        
        <!-- Sales Report -->
        <div class="glass-card mb-6">
            <h3 class="card-title">দৈনিক বিক্রয় রিপোর্ট</h3>
            <div class="table-responsive">
                <table class="table" id="salesReportTable">
                    <thead>
                        <tr>
                            <th>তারিখ</th>
                            <th>ইনভয়েস সংখ্যা</th>
                            <th>মোট বিক্রয়</th>
                            <th>বকেয়া</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($salesReport as $row): ?>
                        <tr>
                            <td><?php echo date('d M Y', strtotime($row['date'])); ?></td>
                            <td><?php echo $row['total_invoices']; ?></td>
                            <td>৳<?php echo formatMoney($row['total_sales']); ?></td>
                            <td>৳<?php echo formatMoney($row['total_due']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Top Products -->
        <div class="glass-card mb-6">
            <h3 class="card-title">সেরা পণ্য পারফরম্যান্স</h3>
            <div class="table-responsive">
                <table class="table" id="productReportTable">
                    <thead>
                        <tr>
                            <th>পণ্যের নাম</th>
                            <th>ক্যাটাগরি</th>
                            <th>বিক্রীত সংখ্যা</th>
                            <th>মোট পরিমাণ</th>
                            <th>মোট রাজস্ব</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($productReport as $row): ?>
                        <tr>
                            <td><?php echo escape($row['name']); ?></td>
                            <td><?php echo escape($row['category']); ?></td>
                            <td><?php echo $row['total_sold']; ?></td>
                            <td><?php echo $row['total_quantity']; ?></td>
                            <td>৳<?php echo formatMoney($row['total_revenue']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- User Registration Report -->
        <div class="glass-card">
            <h3 class="card-title">ব্যবহারকারী নিবন্ধন রিপোর্ট</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>তারিখ</th>
                            <th>রোল</th>
                            <th>সংখ্যা</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($userReport as $row): ?>
                        <tr>
                            <td><?php echo date('d M Y', strtotime($row['date'])); ?></td>
                            <td><span class="badge badge-info"><?php echo escape($row['role']); ?></span></td>
                            <td><?php echo $row['count']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
function exportToExcel() {
    // Simple CSV export
    let csv = 'তারিখ,ইনভয়েস সংখ্যা,মোট বিক্রয়,বকেয়া\n';
    const table = document.getElementById('salesReportTable');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td');
        const rowData = Array.from(cols).map(col => col.textContent.trim()).join(',');
        csv += rowData + '\n';
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'sales_report_<?php echo date("Y-m-d"); ?>.csv';
    a.click();
}
</script>

<style>
@media print {
    .dashboard-sidebar, .header-actions, .btn { display: none; }
    .dashboard-content { margin-left: 0; }
}
</style>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
