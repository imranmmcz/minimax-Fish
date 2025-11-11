<?php
$pageTitle = 'আর্থিক হিসাব';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('wholesaler');

$db = getDB();
$userId = getUserId();

// Date filter
$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate = $_GET['end_date'] ?? date('Y-m-d');

// Income data (from invoices)
$stmt = $db->prepare("
    SELECT 
        SUM(grand_total - due_amount) as total_income,
        COUNT(*) as total_transactions
    FROM invoices
    WHERE user_id = ? AND invoice_date BETWEEN ? AND ?
");
$stmt->execute([$userId, $startDate, $endDate]);
$incomeData = $stmt->fetch();

// Expense data
$stmt = $db->prepare("
    SELECT 
        SUM(amount) as total_expense,
        COUNT(*) as total_transactions
    FROM income_expense
    WHERE user_id = ? AND type = 'expense' AND transaction_date BETWEEN ? AND ?
");
$stmt->execute([$userId, $startDate, $endDate]);
$expenseData = $stmt->fetch();

// Monthly trend
$stmt = $db->prepare("
    SELECT 
        DATE_FORMAT(invoice_date, '%Y-%m') as month,
        SUM(grand_total - due_amount) as income
    FROM invoices
    WHERE user_id = ? AND invoice_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY month
    ORDER BY month ASC
");
$stmt->execute([$userId]);
$monthlyIncome = $stmt->fetchAll();

$stmt = $db->prepare("
    SELECT 
        DATE_FORMAT(transaction_date, '%Y-%m') as month,
        SUM(amount) as expense
    FROM income_expense
    WHERE user_id = ? AND type = 'expense' AND transaction_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY month
    ORDER BY month ASC
");
$stmt->execute([$userId]);
$monthlyExpense = $stmt->fetchAll();

// Recent transactions
$stmt = $db->prepare("
    SELECT * FROM income_expense
    WHERE user_id = ?
    ORDER BY transaction_date DESC
    LIMIT 20
");
$stmt->execute([$userId]);
$recentTransactions = $stmt->fetchAll();

$totalIncome = $incomeData['total_income'] ?? 0;
$totalExpense = $expenseData['total_expense'] ?? 0;
$netProfit = $totalIncome - $totalExpense;

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
                <a href="customers.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M14 6C14 8.21 12.21 10 10 10C7.79 10 6 8.21 6 6C6 3.79 7.79 2 10 2C12.21 2 14 3.79 14 6ZM2 18V16C2 13.34 7.33 12 10 12C12.67 12 18 13.34 18 16V18H2Z"/></svg>
                    <span>কাস্টমার</span>
                </a>
                <a href="finance.php" class="nav-item active">
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
            <h1>আর্থিক হিসাব</h1>
            <button class="btn btn-primary" onclick="showAddTransactionModal()">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H11V14H9V11H6V9H9V6H11V9H14V11Z"/></svg>
                খরচ যোগ করুন
            </button>
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
        
        <!-- Financial Summary -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-value text-success">৳<?php echo formatMoney($totalIncome); ?></div>
                <div class="data-card-label">মোট আয়</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-danger">৳<?php echo formatMoney($totalExpense); ?></div>
                <div class="data-card-label">মোট খরচ</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value <?php echo $netProfit >= 0 ? 'text-primary' : 'text-warning'; ?>">৳<?php echo formatMoney($netProfit); ?></div>
                <div class="data-card-label">নিট লাভ/ক্ষতি</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-info"><?php echo number_format($totalIncome > 0 ? ($netProfit / $totalIncome * 100) : 0, 1); ?>%</div>
                <div class="data-card-label">লাভের হার</div>
            </div>
        </div>
        
        <!-- Charts -->
        <div class="grid grid-2 mb-8">
            <!-- Income vs Expense Trend -->
            <div class="glass-card">
                <h3 class="card-title">আয়-ব্যয় প্রবণতা (শেষ ৬ মাস)</h3>
                <canvas id="trendChart" style="height: 300px;"></canvas>
            </div>
            
            <!-- Expense Breakdown -->
            <div class="glass-card">
                <h3 class="card-title">আয় বনাম ব্যয়</h3>
                <canvas id="pieChart" style="height: 300px;"></canvas>
            </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="glass-card">
            <h3 class="card-title">সাম্প্রতিক লেনদেন</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>তারিখ</th>
                            <th>বিবরণ</th>
                            <th>ক্যাটাগরি</th>
                            <th>ধরন</th>
                            <th>পরিমাণ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recentTransactions as $transaction): ?>
                        <tr>
                            <td><?php echo date('d M Y', strtotime($transaction['transaction_date'])); ?></td>
                            <td><?php echo escape($transaction['description']); ?></td>
                            <td><?php echo escape($transaction['category']); ?></td>
                            <td>
                                <?php if ($transaction['type'] === 'income'): ?>
                                <span class="badge badge-success">আয়</span>
                                <?php else: ?>
                                <span class="badge badge-danger">ব্যয়</span>
                                <?php endif; ?>
                            </td>
                            <td class="<?php echo $transaction['type'] === 'income' ? 'text-success' : 'text-danger'; ?>">
                                <?php echo $transaction['type'] === 'income' ? '+' : '-'; ?>৳<?php echo formatMoney($transaction['amount']); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($recentTransactions)): ?>
                        <tr>
                            <td colspan="5" class="text-center">কোনো লেনদেন পাওয়া যায়নি</td>
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
// Income vs Expense Trend Chart
const trendCtx = document.getElementById('trendChart').getContext('2d');
const monthlyIncomeData = <?php echo json_encode($monthlyIncome); ?>;
const monthlyExpenseData = <?php echo json_encode($monthlyExpense); ?>;

new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: monthlyIncomeData.map(d => d.month),
        datasets: [{
            label: 'আয়',
            data: monthlyIncomeData.map(d => parseFloat(d.income)),
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 175, 80, 0.1)',
            tension: 0.4
        }, {
            label: 'ব্যয়',
            data: monthlyExpenseData.map(d => parseFloat(d.expense)),
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

// Income vs Expense Pie Chart
const pieCtx = document.getElementById('pieChart').getContext('2d');
new Chart(pieCtx, {
    type: 'doughnut',
    data: {
        labels: ['আয়', 'ব্যয়'],
        datasets: [{
            data: [<?php echo $totalIncome; ?>, <?php echo $totalExpense; ?>],
            backgroundColor: ['#4CAF50', '#F44336']
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

function showAddTransactionModal() {
    alert('খরচ যোগ করার ফর্ম এখানে খুলবে');
}
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
