<?php
$pageTitle = 'ইনভয়েস ম্যানেজমেন্ট';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('wholesaler');

$db = getDB();
$userId = getUserId();

// Get filters
$statusFilter = $_GET['status'] ?? '';
$searchQuery = $_GET['search'] ?? '';

// Build query
$query = "SELECT * FROM invoices WHERE user_id = ?";
$params = [$userId];

if ($statusFilter) {
    $query .= " AND status = ?";
    $params[] = $statusFilter;
}

if ($searchQuery) {
    $query .= " AND (invoice_number LIKE ? OR buyer_name LIKE ?)";
    $searchParam = "%{$searchQuery}%";
    $params[] = $searchParam;
    $params[] = $searchParam;
}

$query .= " ORDER BY invoice_date DESC, created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$invoices = $stmt->fetchAll();

// Statistics
$stmt = $db->prepare("
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid,
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
                <a href="invoices.php" class="nav-item active">
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
            <h1>ইনভয়েস ম্যানেজমেন্ট</h1>
            <a href="/fishcare/pages/create-invoice.php" class="btn btn-primary">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H11V14H9V11H6V9H9V6H11V9H14V11Z"/></svg>
                নতুন ইনভয়েস তৈরি
            </a>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-value text-primary"><?php echo $stats['total']; ?></div>
                <div class="data-card-label">মোট ইনভয়েস</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-success"><?php echo $stats['paid']; ?></div>
                <div class="data-card-label">পরিশোধিত</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-warning"><?php echo $stats['pending']; ?></div>
                <div class="data-card-label">অপেক্ষমাণ</div>
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
                    <input type="text" name="search" placeholder="ইনভয়েস নম্বর বা ক্রেতার নাম অনুসন্ধান করুন" value="<?php echo escape($searchQuery); ?>" class="form-control">
                    <select name="status" class="form-control">
                        <option value="">সব স্ট্যাটাস</option>
                        <option value="paid" <?php echo $statusFilter === 'paid' ? 'selected' : ''; ?>>পরিশোধিত</option>
                        <option value="pending" <?php echo $statusFilter === 'pending' ? 'selected' : ''; ?>>অপেক্ষমাণ</option>
                        <option value="partial" <?php echo $statusFilter === 'partial' ? 'selected' : ''; ?>>আংশিক</option>
                    </select>
                    <button type="submit" class="btn btn-primary">অনুসন্ধান করুন</button>
                </div>
            </form>
        </div>
        
        <!-- Invoices Table -->
        <div class="glass-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ইনভয়েস নম্বর</th>
                            <th>তারিখ</th>
                            <th>ক্রেতার নাম</th>
                            <th>মোট টাকা</th>
                            <th>পরিশোধিত</th>
                            <th>বকেয়া</th>
                            <th>স্ট্যাটাস</th>
                            <th>কর্ম</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($invoices as $invoice): ?>
                        <tr>
                            <td><strong><?php echo escape($invoice['invoice_number']); ?></strong></td>
                            <td><?php echo date('d M Y', strtotime($invoice['invoice_date'])); ?></td>
                            <td><?php echo escape($invoice['buyer_name']); ?></td>
                            <td>৳<?php echo formatMoney($invoice['grand_total']); ?></td>
                            <td>৳<?php echo formatMoney($invoice['grand_total'] - $invoice['due_amount']); ?></td>
                            <td>৳<?php echo formatMoney($invoice['due_amount']); ?></td>
                            <td>
                                <?php
                                $badgeClass = $invoice['status'] === 'paid' ? 'badge-success' : ($invoice['status'] === 'pending' ? 'badge-warning' : 'badge-info');
                                $statusText = $invoice['status'] === 'paid' ? 'পরিশোধিত' : ($invoice['status'] === 'pending' ? 'অপেক্ষমাণ' : 'আংশিক');
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span>
                            </td>
                            <td>
                                <a href="/fishcare/pages/view-invoice.php?id=<?php echo $invoice['id']; ?>" class="btn btn-sm btn-info">দেখুন</a>
                                <a href="/fishcare/pages/print-invoice.php?id=<?php echo $invoice['id']; ?>" class="btn btn-sm btn-secondary" target="_blank">প্রিন্ট</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($invoices)): ?>
                        <tr>
                            <td colspan="8" class="text-center">কোনো ইনভয়েস পাওয়া যায়নি</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
