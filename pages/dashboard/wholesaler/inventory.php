<?php
$pageTitle = 'ইনভেন্টরি ম্যানেজমেন্ট';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('wholesaler');

$db = getDB();
$userId = getUserId();

// Get products
$stmt = $db->query("
    SELECT *, 
    CASE 
        WHEN stock_quantity <= 10 THEN 'low'
        WHEN stock_quantity <= 50 THEN 'medium'
        ELSE 'high'
    END as stock_level
    FROM products 
    ORDER BY stock_quantity ASC
");
$products = $stmt->fetchAll();

// Statistics
$stmt = $db->query("
    SELECT 
        COUNT(*) as total_products,
        SUM(CASE WHEN stock_quantity <= 10 THEN 1 ELSE 0 END) as low_stock,
        SUM(CASE WHEN stock_quantity = 0 THEN 1 ELSE 0 END) as out_of_stock,
        SUM(stock_quantity * price) as total_value
    FROM products
");
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
                <a href="invoices.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4 2H16C17.1 2 18 2.9 18 4V16C18 17.1 17.1 18 16 18H4C2.9 18 2 17.1 2 16V4C2 2.9 2.9 2 4 2ZM4 6H16V4H4V6ZM4 10H16V8H4V10ZM4 14H12V12H4V14Z"/></svg>
                    <span>ইনভয়েস ম্যানেজমেন্ট</span>
                </a>
                <a href="shipments.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M18 8H15V6L13 4H7L5 6V8H2C0.9 8 0 8.9 0 10V16C0 17.1 0.9 18 2 18H3C3 19.1 3.9 20 5 20C6.1 20 7 19.1 7 18H13C13 19.1 13.9 20 15 20C16.1 20 17 19.1 17 18H18C19.1 18 20 17.1 20 16V10C20 8.9 19.1 8 18 8Z"/></svg>
                    <span>শিপমেন্ট</span>
                </a>
                <a href="inventory.php" class="nav-item active">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4 2H16L20 6V18C20 19.1 19.1 20 18 20H2C0.9 20 0 19.1 0 18V6L4 2ZM10 12L6 8H9V4H11V8H14L10 12Z"/></svg>
                    <span>ইনভেন্টরি</span>
                </a>
                <a href="customers.php" class="nav-item">
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
            <h1>ইনভেন্টরি ম্যানেজমেন্ট</h1>
            <button class="btn btn-primary" onclick="showAddProductModal()">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H11V14H9V11H6V9H9V6H11V9H14V11Z"/></svg>
                পণ্য যোগ করুন
            </button>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-value text-primary"><?php echo $stats['total_products']; ?></div>
                <div class="data-card-label">মোট পণ্য</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-success">৳<?php echo formatMoney($stats['total_value']); ?></div>
                <div class="data-card-label">মোট মূল্য</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-warning"><?php echo $stats['low_stock']; ?></div>
                <div class="data-card-label">কম স্টক</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-danger"><?php echo $stats['out_of_stock']; ?></div>
                <div class="data-card-label">স্টক শেষ</div>
            </div>
        </div>
        
        <!-- Low Stock Alert -->
        <?php if ($stats['low_stock'] > 0): ?>
        <div class="alert alert-warning mb-6">
            <strong>সতর্কতা:</strong> <?php echo $stats['low_stock']; ?>টি পণ্যের স্টক কম আছে। অনুগ্রহ করে স্টক পুনর্ভরণ করুন।
        </div>
        <?php endif; ?>
        
        <!-- Inventory Table -->
        <div class="glass-card">
            <h3 class="card-title">পণ্য তালিকা</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>পণ্যের নাম</th>
                            <th>ক্যাটাগরি</th>
                            <th>ইউনিট</th>
                            <th>মূল্য</th>
                            <th>স্টক পরিমাণ</th>
                            <th>স্টক স্ট্যাটাস</th>
                            <th>কর্ম</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $product): ?>
                        <tr>
                            <td><strong><?php echo escape($product['name']); ?></strong></td>
                            <td><?php echo escape($product['category']); ?></td>
                            <td><?php echo escape($product['unit']); ?></td>
                            <td>৳<?php echo formatMoney($product['price']); ?></td>
                            <td><?php echo $product['stock_quantity']; ?></td>
                            <td>
                                <?php
                                if ($product['stock_level'] === 'low') {
                                    echo '<span class="badge badge-danger">কম স্টক</span>';
                                } elseif ($product['stock_level'] === 'medium') {
                                    echo '<span class="badge badge-warning">মাঝারি</span>';
                                } else {
                                    echo '<span class="badge badge-success">পর্যাপ্ত</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="updateStock(<?php echo $product['id']; ?>)">স্টক আপডেট</button>
                                <button class="btn btn-sm btn-secondary" onclick="editProduct(<?php echo $product['id']; ?>)">সম্পাদনা</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Stock Movement Chart -->
        <div class="glass-card mt-6">
            <h3 class="card-title">স্টক মুভমেন্ট (শেষ ৭ দিন)</h3>
            <canvas id="stockChart" style="height: 300px;"></canvas>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Stock Movement Chart
const stockCtx = document.getElementById('stockChart').getContext('2d');
new Chart(stockCtx, {
    type: 'line',
    data: {
        labels: ['রবি', 'সোম', 'মঙ্গল', 'বুধ', 'বৃহস্পতি', 'শুক্র', 'শনি'],
        datasets: [{
            label: 'স্টক ইন',
            data: [120, 90, 150, 80, 110, 140, 95],
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 175, 80, 0.1)',
            tension: 0.4
        }, {
            label: 'স্টক আউট',
            data: [80, 70, 100, 60, 85, 95, 75],
            borderColor: '#F44336',
            backgroundColor: 'rgba(244, 67, 54, 0.1)',
            tension: 0.4
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

function showAddProductModal() {
    alert('পণ্য যোগ করার ফর্ম এখানে খুলবে');
}

function updateStock(id) {
    const quantity = prompt('নতুন স্টক পরিমাণ লিখুন:');
    if (quantity) {
        alert('পণ্য #' + id + ' এর স্টক আপডেট করা হয়েছে');
    }
}

function editProduct(id) {
    alert('পণ্য #' + id + ' সম্পাদনা করুন');
}
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
