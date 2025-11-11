<?php
$pageTitle = 'স্টক ব্যবস্থাপনা';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('seller');

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
                <a href="stocks.php" class="nav-item active">
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
            <h1>স্টক ব্যবস্থাপনা</h1>
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
            <strong>সতর্কতা:</strong> <?php echo $stats['low_stock']; ?>টি পণ্যের স্টক কম আছে।
        </div>
        <?php endif; ?>
        
        <!-- Stock Table -->
        <div class="glass-card">
            <h3 class="card-title">পণ্য স্টক তালিকা</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>পণ্যের নাম</th>
                            <th>ক্যাটাগরি</th>
                            <th>ইউনিট</th>
                            <th>মূল্য</th>
                            <th>স্টক পরিমাণ</th>
                            <th>স্ট্যাটাস</th>
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
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Stock Alerts -->
        <div class="glass-card mt-6">
            <h3 class="card-title">স্টক সতর্কতা</h3>
            <div class="alert-list">
                <?php
                $lowStockProducts = array_filter($products, function($p) {
                    return $p['stock_level'] === 'low';
                });
                ?>
                
                <?php if (empty($lowStockProducts)): ?>
                <p class="text-center text-muted">কোনো সতর্কতা নেই</p>
                <?php else: ?>
                <?php foreach($lowStockProducts as $product): ?>
                <div class="alert-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="color: #FFC107;"><path d="M1 21H23L12 2L1 21ZM13 18H11V16H13V18ZM13 14H11V10H13V14Z"/></svg>
                    <div>
                        <strong><?php echo escape($product['name']); ?></strong>
                        <p class="text-muted">বর্তমান স্টক: <?php echo $product['stock_quantity']; ?> <?php echo escape($product['unit']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<style>
.alert-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.alert-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 193, 7, 0.1);
    border-left: 3px solid #FFC107;
    border-radius: 6px;
}
.alert-item p {
    margin: 0.25rem 0 0;
    font-size: 0.9rem;
}
</style>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
