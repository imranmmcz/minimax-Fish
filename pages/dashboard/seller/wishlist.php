<?php
$pageTitle = 'উইশলিস্ট';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('seller');

$db = getDB();
$userId = getUserId();

// Get wishlist items (mock data)
$wishlistItems = [];
$stmt = $db->query("SELECT * FROM products LIMIT 10");
$allProducts = $stmt->fetchAll();

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
                <a href="wishlist.php" class="nav-item active">
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
            <h1>আমার উইশলিস্ট</h1>
        </div>
        
        <?php if (empty($allProducts)): ?>
        <div class="glass-card text-center py-12">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="currentColor" style="opacity: 0.3; margin: 0 auto 2rem;"><path d="M40 72L34.2 66.8C13.6 48.44 0 36.44 0 22C0 9.68 9.68 0 22 0C28.96 0 35.64 3.24 40 8.36C44.36 3.24 51.04 0 58 0C70.32 0 80 9.68 80 22C80 36.44 66.4 48.44 45.8 66.8L40 72Z"/></svg>
            <h2>উইশলিস্ট খালি</h2>
            <p class="text-muted">আপনার পছন্দের পণ্য এখানে যোগ করুন</p>
            <a href="/fishcare/pages/marketplace.php" class="btn btn-primary mt-4">মার্কেটপ্লেস ব্রাউজ করুন</a>
        </div>
        <?php else: ?>
        <!-- Product Grid -->
        <div class="grid grid-3">
            <?php foreach(array_slice($allProducts, 0, 6) as $product): ?>
            <div class="glass-card product-card">
                <div class="product-image">
                    <div class="product-placeholder">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="currentColor"><path d="M7.5 52.5H52.5V22.5L37.5 7.5H7.5V52.5ZM30 37.5L15 22.5H22.5V7.5H37.5V22.5H45L30 37.5Z"/></svg>
                    </div>
                    <button class="remove-wishlist" onclick="removeFromWishlist(<?php echo $product['id']; ?>)">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM16 13H8V11H16V13Z"/></svg>
                    </button>
                </div>
                <div class="product-info">
                    <h4><?php echo escape($product['name']); ?></h4>
                    <p class="text-muted"><?php echo escape($product['category']); ?></p>
                    <div class="product-price">৳<?php echo formatMoney($product['price']); ?> / <?php echo escape($product['unit']); ?></div>
                    <div class="product-stock">
                        স্টক: <span class="text-success"><?php echo $product['stock_quantity']; ?></span>
                    </div>
                    <button class="btn btn-primary btn-sm w-full mt-3" onclick="addToCart(<?php echo $product['id']; ?>)">
                        কার্টে যোগ করুন
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </main>
</div>

<style>
.product-card {
    overflow: hidden;
}
.product-image {
    position: relative;
    height: 200px;
    background: rgba(0, 188, 212, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: -1.5rem -1.5rem 1.5rem;
}
.product-placeholder {
    color: rgba(0, 188, 212, 0.3);
}
.remove-wishlist {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(244, 67, 54, 0.9);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.3s;
}
.remove-wishlist:hover {
    background: #F44336;
    transform: scale(1.1);
}
.product-info h4 {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}
.product-price {
    font-size: 1.25rem;
    font-weight: 600;
    color: #00BCD4;
    margin: 0.75rem 0;
}
.product-stock {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.7);
}
</style>

<script>
function removeFromWishlist(productId) {
    if (confirm('উইশলিস্ট থেকে মুছে ফেলবেন?')) {
        alert('পণ্য #' + productId + ' উইশলিস্ট থেকে মুছে ফেলা হয়েছে');
        location.reload();
    }
}

function addToCart(productId) {
    alert('পণ্য #' + productId + ' কার্টে যোগ করা হয়েছে');
}
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
