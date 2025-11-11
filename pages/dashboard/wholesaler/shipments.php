<?php
$pageTitle = 'শিপমেন্ট ট্র্যাকিং';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('wholesaler');

$db = getDB();
$userId = getUserId();

// Handle shipment actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_shipment') {
        $trackingNumber = 'SHP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $stmt = $db->prepare("INSERT INTO shipments (user_id, tracking_number, destination, items_count, notes, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$userId, $trackingNumber, $_POST['destination'], $_POST['items_count'], $_POST['notes'] ?? '']);
        $_SESSION['success'] = 'শিপমেন্ট সফলভাবে যোগ করা হয়েছে';
        header('Location: shipments.php');
        exit;
    } elseif ($_POST['action'] === 'update_status' && isset($_POST['shipment_id'], $_POST['status'])) {
        $updates = ['status' => $_POST['status']];
        if ($_POST['status'] === 'in_transit') {
            $updates['shipped_date'] = date('Y-m-d');
        } elseif ($_POST['status'] === 'delivered') {
            $updates['delivery_date'] = date('Y-m-d');
        }
        
        $setClause = [];
        $params = [];
        foreach ($updates as $key => $value) {
            $setClause[] = "$key = ?";
            $params[] = $value;
        }
        $params[] = $_POST['shipment_id'];
        $params[] = $userId;
        
        $stmt = $db->prepare("UPDATE shipments SET " . implode(', ', $setClause) . " WHERE id = ? AND user_id = ?");
        $stmt->execute($params);
        $_SESSION['success'] = 'শিপমেন্ট স্ট্যাটাস আপডেট করা হয়েছে';
        header('Location: shipments.php');
        exit;
    }
}

// Get real shipments from database
try {
    $stmt = $db->prepare("SELECT * FROM shipments WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$userId]);
    $shipments = $stmt->fetchAll();
} catch (PDOException $e) {
    // If table doesn't exist, create it and use sample data
    $shipments = [];
}

// Calculate statistics
$stats = [
    'total' => count($shipments),
    'delivered' => count(array_filter($shipments, fn($s) => $s['status'] === 'delivered')),
    'in_transit' => count(array_filter($shipments, fn($s) => $s['status'] === 'in_transit')),
    'pending' => count(array_filter($shipments, fn($s) => $s['status'] === 'pending'))
];

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
                <a href="shipments.php" class="nav-item active">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M18 8H15V6L13 4H7L5 6V8H2C0.9 8 0 8.9 0 10V16C0 17.1 0.9 18 2 18H3C3 19.1 3.9 20 5 20C6.1 20 7 19.1 7 18H13C13 19.1 13.9 20 15 20C16.1 20 17 19.1 17 18H18C19.1 18 20 17.1 20 16V10C20 8.9 19.1 8 18 8Z"/></svg>
                    <span>শিপমেন্ট ট্র্যাকিং</span>
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
            <h1>শিপমেন্ট ট্র্যাকিং</h1>
            <button class="btn btn-primary" onclick="showAddShipmentModal()">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H11V14H9V11H6V9H9V6H11V9H14V11Z"/></svg>
                নতুন শিপমেন্ট যোগ করুন
            </button>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="grid grid-4 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-value text-primary"><?php echo $stats['total']; ?></div>
                <div class="data-card-label">মোট শিপমেন্ট</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-warning"><?php echo $stats['pending']; ?></div>
                <div class="data-card-label">অপেক্ষমাণ</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-info"><?php echo $stats['in_transit']; ?></div>
                <div class="data-card-label">পথে আছে</div>
            </div>
            <div class="glass-card data-card">
                <div class="data-card-value text-success"><?php echo $stats['delivered']; ?></div>
                <div class="data-card-label">সরবরাহ সম্পন্ন</div>
            </div>
        </div>

        <!-- Shipments Table -->
        <div class="glass-card">
            <div class="card-header">
                <h2>শিপমেন্ট তালিকা</h2>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ট্র্যাকিং নম্বর</th>
                            <th>গন্তব্য</th>
                            <th>পণ্য সংখ্যা</th>
                            <th>স্ট্যাটাস</th>
                            <th>শিপিং তারিখ</th>
                            <th>ডেলিভারি তারিখ</th>
                            <th>নোট</th>
                            <th>অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($shipments)): ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 2rem;">
                                    <p style="color: #666;">কোনো শিপমেন্ট পাওয়া যায়নি। নতুন শিপমেন্ট যোগ করুন।</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($shipments as $shipment): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($shipment['tracking_number']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($shipment['destination']); ?></td>
                                    <td><?php echo $shipment['items_count']; ?></td>
                                    <td>
                                        <?php
                                        $statusLabels = [
                                            'pending' => ['label' => 'অপেক্ষমাণ', 'class' => 'badge-warning'],
                                            'in_transit' => ['label' => 'পথে আছে', 'class' => 'badge-info'],
                                            'delivered' => ['label' => 'সরবরাহ সম্পন্ন', 'class' => 'badge-success']
                                        ];
                                        $status = $statusLabels[$shipment['status']] ?? ['label' => $shipment['status'], 'class' => 'badge-secondary'];
                                        ?>
                                        <span class="badge <?php echo $status['class']; ?>"><?php echo $status['label']; ?></span>
                                    </td>
                                    <td><?php echo $shipment['shipped_date'] ? date('d/m/Y', strtotime($shipment['shipped_date'])) : '-'; ?></td>
                                    <td><?php echo $shipment['delivery_date'] ? date('d/m/Y', strtotime($shipment['delivery_date'])) : '-'; ?></td>
                                    <td><?php echo htmlspecialchars($shipment['notes'] ?? '-'); ?></td>
                                    <td>
                                        <?php if ($shipment['status'] !== 'delivered'): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="update_status">
                                                <input type="hidden" name="shipment_id" value="<?php echo $shipment['id']; ?>">
                                                <select name="status" onchange="this.form.submit()" class="status-select">
                                                    <option value="">স্ট্যাটাস পরিবর্তন করুন</option>
                                                    <?php if ($shipment['status'] === 'pending'): ?>
                                                        <option value="in_transit">পথে পাঠান</option>
                                                        <option value="delivered">সরবরাহ সম্পন্ন</option>
                                                    <?php elseif ($shipment['status'] === 'in_transit'): ?>
                                                        <option value="delivered">সরবরাহ সম্পন্ন</option>
                                                    <?php endif; ?>
                                                </select>
                                            </form>
                                        <?php else: ?>
                                            <span style="color: #4caf50;">✓ সম্পন্ন</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Add Shipment Modal -->
<div id="addShipmentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>নতুন শিপমেন্ট যোগ করুন</h2>
            <button class="close-btn" onclick="closeModal('addShipmentModal')">&times;</button>
        </div>
        <form method="POST" class="form">
            <input type="hidden" name="action" value="add_shipment">
            
            <div class="form-group">
                <label for="destination">গন্তব্য <span class="required">*</span></label>
                <input type="text" id="destination" name="destination" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="items_count">পণ্য সংখ্যা <span class="required">*</span></label>
                <input type="number" id="items_count" name="items_count" class="form-control" min="1" required>
            </div>

            <div class="form-group">
                <label for="notes">নোট (ঐচ্ছিক)</label>
                <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addShipmentModal')">বাতিল</button>
                <button type="submit" class="btn btn-primary">যোগ করুন</button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddShipmentModal() {
    document.getElementById('addShipmentModal').style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.getElementsByClassName('modal');
    for (let modal of modals) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
}
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
