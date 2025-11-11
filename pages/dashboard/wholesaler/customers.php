<?php
$pageTitle = 'কাস্টমার ম্যানেজমেন্ট';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('wholesaler');

$db = getDB();
$userId = getUserId();

// Get customers (from invoices)
$stmt = $db->prepare("
    SELECT 
        buyer_name,
        buyer_phone,
        buyer_address,
        COUNT(*) as total_orders,
        SUM(grand_total) as total_purchase,
        MAX(invoice_date) as last_order_date
    FROM invoices
    WHERE user_id = ?
    GROUP BY buyer_name, buyer_phone, buyer_address
    ORDER BY total_purchase DESC
");
$stmt->execute([$userId]);
$customers = $stmt->fetchAll();

// Statistics
$totalCustomers = count($customers);
$activeCustomers = count(array_filter($customers, function($c) {
    return strtotime($c['last_order_date']) >= strtotime('-30 days');
}));

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
                <a href="invoices.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4 2H16C17.1 2 18 2.9 18 4V16C18 17.1 17.1 18 16 18H4C2.9 18 2 17.1 2 16V4C2 2.9 2.9 2 4 2ZM4 6H16V4H4V6ZM4 10H16V8H4V10ZM4 14H12V12H4V14Z"/></svg>
                    <span>ইনভয়েস ম্যানেজমেন্ট</span>
                </a>
                <a href="shipments.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M18 8H15V6L13 4H7L5 6V8H2C0.9 8 0 8.9 0 10V16C0 17.1 0.9 18 2 18H3C3 19.1 3.9 20 5 20C6.1 20 7 19.1 7 18H13C13 19.1 13.9 20 15 20C16.1 20 17 19.1 17 18H18C19.1 18 20 17.1 20 16V10C20 8.9 19.1 8 18 8Z"/></svg>
                    <span>শিপমেন্ট</span>
                </a>
                <a href="inventory.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4 2H16L20 6V18C20 19.1 19.1 20 18 20H2C0.9 20 0 19.1 0 18V6L4 2ZM10 12L6 8H9V4H11V8H14L10 12Z"/></svg>
                    <span>ইনভেন্টরি</span>
                </a>
                <a href="customers.php" class="nav-item active">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M14 6C14 8.21 12.21 10 10 10C7.79 10 6 8.21 6 6C6 3.79 7.79 2 10 2C12.21 2 14 3.79 14 6ZM2 18V16C2 13.34 7.33 12 10 12C12.67 12 18 13.34 18 16V18H2Z"/></svg>
                    <span>কাস্টমার</span>
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
            <h1>কাস্টমার ম্যানেজমেন্ট</h1>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-3 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-value text-primary"><?php echo $totalCustomers; ?></div>
                <div class="data-card-label">মোট কাস্টমার</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-success"><?php echo $activeCustomers; ?></div>
                <div class="data-card-label">সক্রিয় কাস্টমার (৩০ দিন)</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-info"><?php echo $totalCustomers - $activeCustomers; ?></div>
                <div class="data-card-label">নিষ্ক্রিয় কাস্টমার</div>
            </div>
        </div>
        
        <!-- Customers Table -->
        <div class="glass-card">
            <h3 class="card-title">কাস্টমার তালিকা</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>নাম</th>
                            <th>ফোন</th>
                            <th>ঠিকানা</th>
                            <th>মোট অর্ডার</th>
                            <th>মোট ক্রয়</th>
                            <th>শেষ অর্ডার</th>
                            <th>কর্ম</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($customers as $customer): ?>
                        <tr>
                            <td><strong><?php echo escape($customer['buyer_name']); ?></strong></td>
                            <td><?php echo escape($customer['buyer_phone']); ?></td>
                            <td><?php echo escape($customer['buyer_address']); ?></td>
                            <td><?php echo $customer['total_orders']; ?></td>
                            <td>৳<?php echo formatMoney($customer['total_purchase']); ?></td>
                            <td><?php echo date('d M Y', strtotime($customer['last_order_date'])); ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewCustomerDetails('<?php echo escape($customer['buyer_name']); ?>')">বিস্তারিত</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($customers)): ?>
                        <tr>
                            <td colspan="7" class="text-center">কোনো কাস্টমার পাওয়া যায়নি</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Top Customers Chart -->
        <div class="glass-card mt-6">
            <h3 class="card-title">শীর্ষ কাস্টমার (ক্রয় পরিমাণ অনুযায়ী)</h3>
            <canvas id="customerChart" style="height: 300px;"></canvas>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Top Customers Chart
const customerCtx = document.getElementById('customerChart').getContext('2d');
const topCustomers = <?php echo json_encode(array_slice($customers, 0, 10)); ?>;
new Chart(customerCtx, {
    type: 'bar',
    data: {
        labels: topCustomers.map(c => c.buyer_name),
        datasets: [{
            label: 'মোট ক্রয় (৳)',
            data: topCustomers.map(c => parseFloat(c.total_purchase)),
            backgroundColor: '#00BCD4',
            borderColor: '#00BCD4',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { beginAtZero: true }
        }
    }
});

function viewCustomerDetails(name) {
    alert('কাস্টমার "' + name + '" এর বিস্তারিত');
}
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
