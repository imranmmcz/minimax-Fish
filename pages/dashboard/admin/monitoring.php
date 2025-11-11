<?php
$pageTitle = 'সিস্টেম মনিটরিং';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('admin');

$db = getDB();

// System metrics
$stmt = $db->query("SELECT TABLE_NAME, ROUND(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024), 2) AS 'Size_MB' FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'fishcare'");
$dbTables = $stmt->fetchAll();

// Recent activities (last 24 hours)
$stmt = $db->query("
    SELECT 
        'ব্যবহারকারী নিবন্ধন' as activity_type,
        u.name as user_name,
        u.created_at as activity_time
    FROM users u
    WHERE u.created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
    
    UNION ALL
    
    SELECT 
        'নতুন ইনভয়েস' as activity_type,
        CONCAT('Invoice #', i.id) as user_name,
        i.created_at as activity_time
    FROM invoices i
    WHERE i.created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
    
    ORDER BY activity_time DESC
    LIMIT 20
");
$recentActivities = $stmt->fetchAll();

// Server info
$serverLoad = sys_getloadavg()[0] ?? 'N/A';
$diskTotal = disk_total_space('/');
$diskFree = disk_free_space('/');
$diskUsed = $diskTotal - $diskFree;
$diskUsagePercent = round(($diskUsed / $diskTotal) * 100, 2);

$memoryLimit = ini_get('memory_limit');
$maxExecutionTime = ini_get('max_execution_time');
$uploadMaxFilesize = ini_get('upload_max_filesize');

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
                <a href="reports.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4H8V8H4V4ZM10 4H14V8H10V4ZM16 4H20V8H16V4ZM4 10H8V14H4V10ZM10 10H14V14H10V10ZM16 10H20V14H16V10ZM4 16H8V20H4V16ZM10 16H14V20H10V16ZM16 16H20V20H16V16Z"/></svg>
                    <span>রিপোর্ট</span>
                </a>
                <a href="settings.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M17.43 10.98C17.47 10.66 17.5 10.34 17.5 10C17.5 9.66 17.47 9.34 17.43 9.02L19.54 7.37C19.73 7.22 19.78 6.95 19.66 6.73L17.66 3.27C17.54 3.05 17.27 2.97 17.05 3.05L14.56 4.05C14.04 3.66 13.48 3.32 12.87 3.07L12.49 0.42C12.46 0.18 12.25 0 12 0H8C7.75 0 7.54 0.18 7.51 0.42L7.13 3.07C6.52 3.32 5.96 3.66 5.44 4.05L2.95 3.05C2.73 2.96 2.46 3.05 2.34 3.27L0.34 6.73C0.21 6.95 0.27 7.22 0.46 7.37L2.57 9.02C2.53 9.34 2.5 9.66 2.5 10C2.5 10.34 2.53 10.66 2.57 10.98L0.46 12.63C0.27 12.78 0.22 13.05 0.34 13.27L2.34 16.73C2.46 16.95 2.73 17.03 2.95 16.95L5.44 15.95C5.96 16.34 6.52 16.68 7.13 16.93L7.51 19.58C7.54 19.82 7.75 20 8 20H12C12.25 20 12.46 19.82 12.49 19.58L12.87 16.93C13.48 16.68 14.04 16.34 14.56 15.95L17.05 16.95C17.27 17.04 17.54 16.95 17.66 16.73L19.66 13.27C19.78 13.05 19.73 12.78 19.54 12.63L17.43 10.98ZM10 13.5C8.07 13.5 6.5 11.93 6.5 10C6.5 8.07 8.07 6.5 10 6.5C11.93 6.5 13.5 8.07 13.5 10C13.5 11.93 11.93 13.5 10 13.5Z"/></svg>
                    <span>সেটিংস</span>
                </a>
                <a href="monitoring.php" class="nav-item active">
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
            <h1>সিস্টেম মনিটরিং</h1>
            <button class="btn btn-secondary" onclick="location.reload()">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M17.65 6.35C16.2 4.9 14.21 4 12 4C7.58 4 4.01 7.58 4.01 12C4.01 16.42 7.58 20 12 20C15.73 20 18.84 17.45 19.73 14H17.65C16.83 16.33 14.61 18 12 18C8.69 18 6 15.31 6 12C6 8.69 8.69 6 12 6C13.66 6 15.14 6.69 16.22 7.78L13 11H20V4L17.65 6.35Z"/></svg>
                রিফ্রেশ
            </button>
        </div>
        
        <!-- Server Metrics -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-value text-success"><?php echo number_format($serverLoad, 2); ?></div>
                <div class="data-card-label">সার্ভার লোড</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-value text-warning"><?php echo $diskUsagePercent; ?>%</div>
                <div class="data-card-label">ডিস্ক ব্যবহার</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-value text-info"><?php echo $memoryLimit; ?></div>
                <div class="data-card-label">মেমরি লিমিট</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-value text-primary"><?php echo count($dbTables); ?></div>
                <div class="data-card-label">ডেটাবেস টেবিল</div>
            </div>
        </div>
        
        <!-- System Details -->
        <div class="grid grid-2 mb-8">
            <div class="glass-card">
                <h3 class="card-title">সার্ভার তথ্য</h3>
                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">PHP ভার্সন:</span>
                        <span class="info-value"><?php echo phpversion(); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">MySQL ভার্সন:</span>
                        <span class="info-value"><?php echo $db->getAttribute(PDO::ATTR_SERVER_VERSION); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">সার্ভার সফটওয়্যার:</span>
                        <span class="info-value"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ম্যাক্স এক্সিকিউশন টাইম:</span>
                        <span class="info-value"><?php echo $maxExecutionTime; ?> সেকেন্ড</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ম্যাক্স আপলোড সাইজ:</span>
                        <span class="info-value"><?php echo $uploadMaxFilesize; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">সার্ভার আপটাইম:</span>
                        <span class="info-value"><?php echo shell_exec('uptime -p') ?: 'N/A'; ?></span>
                    </div>
                </div>
            </div>
            
            <div class="glass-card">
                <h3 class="card-title">ডিস্ক তথ্য</h3>
                <div class="disk-usage-chart">
                    <canvas id="diskChart" style="height: 250px;"></canvas>
                </div>
                <div class="info-list mt-4">
                    <div class="info-row">
                        <span class="info-label">মোট স্পেস:</span>
                        <span class="info-value"><?php echo formatBytes($diskTotal); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ব্যবহৃত স্পেস:</span>
                        <span class="info-value"><?php echo formatBytes($diskUsed); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ফ্রি স্পেস:</span>
                        <span class="info-value"><?php echo formatBytes($diskFree); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Database Tables -->
        <div class="glass-card mb-6">
            <h3 class="card-title">ডেটাবেস টেবিল তথ্য</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>টেবিল নাম</th>
                            <th>সাইজ (MB)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dbTables as $table): ?>
                        <tr>
                            <td><?php echo escape($table['TABLE_NAME']); ?></td>
                            <td><?php echo $table['Size_MB']; ?> MB</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="glass-card">
            <h3 class="card-title">সাম্প্রতিক কার্যক্রম (শেষ ২৪ ঘণ্টা)</h3>
            <div class="activity-timeline">
                <?php foreach($recentActivities as $activity): ?>
                <div class="activity-item">
                    <div class="activity-icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 18C5.59 18 2 14.41 2 10C2 5.59 5.59 2 10 2C14.41 2 18 5.59 18 10C18 14.41 14.41 18 10 18Z"/></svg>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title"><?php echo escape($activity['activity_type']); ?></div>
                        <div class="activity-desc"><?php echo escape($activity['user_name']); ?></div>
                        <div class="activity-time"><?php echo timeAgo($activity['activity_time']); ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Disk Usage Chart
const diskCtx = document.getElementById('diskChart').getContext('2d');
new Chart(diskCtx, {
    type: 'doughnut',
    data: {
        labels: ['ব্যবহৃত', 'ফ্রি'],
        datasets: [{
            data: [<?php echo $diskUsagePercent; ?>, <?php echo 100 - $diskUsagePercent; ?>],
            backgroundColor: ['#F44336', '#4CAF50']
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

<style>
.info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem;
    background: rgba(255,255,255,0.05);
    border-radius: 6px;
}
.info-label {
    font-weight: 500;
    color: rgba(255,255,255,0.7);
}
.info-value {
    color: #00BCD4;
    font-weight: 600;
}
.activity-timeline {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.activity-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
}
.activity-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 188, 212, 0.2);
    border-radius: 50%;
    color: #00BCD4;
}
.activity-content {
    flex: 1;
}
.activity-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
}
.activity-desc {
    color: rgba(255,255,255,0.7);
    font-size: 0.9rem;
}
.activity-time {
    color: rgba(255,255,255,0.5);
    font-size: 0.85rem;
    margin-top: 0.25rem;
}
</style>

<?php
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, $precision) . ' ' . $units[$pow];
}

function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) return $diff . ' সেকেন্ড আগে';
    if ($diff < 3600) return floor($diff / 60) . ' মিনিট আগে';
    if ($diff < 86400) return floor($diff / 3600) . ' ঘণ্টা আগে';
    return floor($diff / 86400) . ' দিন আগে';
}
?>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
