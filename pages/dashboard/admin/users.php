<?php
$pageTitle = 'ব্যবহারকারী ম্যানেজমেন্ট';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

requireRole('admin');

$db = getDB();

// Handle user actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete' && isset($_POST['user_id'])) {
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$_POST['user_id']]);
            $_SESSION['success'] = 'ব্যবহারকারী সফলভাবে মুছে ফেলা হয়েছে';
        } elseif ($_POST['action'] === 'update_role' && isset($_POST['user_id'], $_POST['role'])) {
            $stmt = $db->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$_POST['role'], $_POST['user_id']]);
            $_SESSION['success'] = 'রোল সফলভাবে আপডেট করা হয়েছে';
        } elseif ($_POST['action'] === 'add_user') {
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (name, email, password, role, phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['name'], $_POST['email'], $hashedPassword, $_POST['role'], $_POST['phone']]);
            $_SESSION['success'] = 'নতুন ব্যবহারকারী যোগ করা হয়েছে';
        }
        header('Location: users.php');
        exit;
    }
}

// Get filter parameters
$searchQuery = $_GET['search'] ?? '';
$roleFilter = $_GET['role'] ?? '';

// Build query
$query = "SELECT * FROM users WHERE 1=1";
$params = [];

if ($searchQuery) {
    $query .= " AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $searchParam = "%{$searchQuery}%";
    $params = [$searchParam, $searchParam, $searchParam];
}

if ($roleFilter) {
    $query .= " AND role = ?";
    $params[] = $roleFilter;
}

$query .= " ORDER BY created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$users = $stmt->fetchAll();

// Get role statistics
$stmt = $db->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
$roleStats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

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
                <a href="users.php" class="nav-item active">
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
            <h1>ব্যবহারকারী ম্যানেজমেন্ট</h1>
            <button class="btn btn-primary" onclick="showAddUserModal()">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H11V14H9V11H6V9H9V6H11V9H14V11Z"/></svg>
                নতুন ব্যবহারকারী যোগ করুন
            </button>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <!-- Statistics Cards -->
        <div class="grid grid-4 mb-8">
            <?php foreach(['admin' => 'অ্যাডমিন', 'wholesaler' => 'হোলসেলার', 'seller' => 'বিক্রেতা', 'customer' => 'ক্রেতা'] as $role => $label): ?>
            <div class="glass-card data-card">
                <div class="data-card-value text-primary"><?php echo $roleStats[$role] ?? 0; ?></div>
                <div class="data-card-label"><?php echo $label; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Search and Filter -->
        <div class="glass-card mb-6">
            <form method="GET" class="filter-form">
                <div class="grid grid-3">
                    <input type="text" name="search" placeholder="নাম, ইমেইল বা ফোন অনুসন্ধান করুন" value="<?php echo escape($searchQuery); ?>" class="form-control">
                    <select name="role" class="form-control">
                        <option value="">সব রোল</option>
                        <option value="admin" <?php echo $roleFilter === 'admin' ? 'selected' : ''; ?>>অ্যাডমিন</option>
                        <option value="wholesaler" <?php echo $roleFilter === 'wholesaler' ? 'selected' : ''; ?>>হোলসেলার</option>
                        <option value="seller" <?php echo $roleFilter === 'seller' ? 'selected' : ''; ?>>বিক্রেতা</option>
                        <option value="customer" <?php echo $roleFilter === 'customer' ? 'selected' : ''; ?>>ক্রেতা</option>
                        <option value="farmer" <?php echo $roleFilter === 'farmer' ? 'selected' : ''; ?>>চাষী</option>
                    </select>
                    <button type="submit" class="btn btn-primary">অনুসন্ধান করুন</button>
                </div>
            </form>
        </div>
        
        <!-- Users Table -->
        <div class="glass-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>আইডি</th>
                            <th>নাম</th>
                            <th>ইমেইল</th>
                            <th>ফোন</th>
                            <th>রোল</th>
                            <th>নিবন্ধন তারিখ</th>
                            <th>কর্ম</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo escape($user['name']); ?></td>
                            <td><?php echo escape($user['email']); ?></td>
                            <td><?php echo escape($user['phone'] ?? 'N/A'); ?></td>
                            <td><span class="badge badge-info"><?php echo escape($user['role']); ?></span></td>
                            <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <button onclick="editUser(<?php echo $user['id']; ?>, '<?php echo escape($user['role']); ?>')" class="btn btn-sm btn-info">সম্পাদনা</button>
                                <?php if ($user['id'] != getUserId()): ?>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('আপনি কি নিশ্চিত?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">মুছুন</button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Add User Modal -->
<div id="addUserModal" class="modal" style="display:none;">
    <div class="modal-content glass-card">
        <h2>নতুন ব্যবহারকারী যোগ করুন</h2>
        <form method="POST">
            <input type="hidden" name="action" value="add_user">
            <div class="form-group">
                <label>নাম</label>
                <input type="text" name="name" required class="form-control">
            </div>
            <div class="form-group">
                <label>ইমেইল</label>
                <input type="email" name="email" required class="form-control">
            </div>
            <div class="form-group">
                <label>ফোন</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <label>পাসওয়ার্ড</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <div class="form-group">
                <label>রোল</label>
                <select name="role" required class="form-control">
                    <option value="customer">ক্রেতা</option>
                    <option value="seller">বিক্রেতা</option>
                    <option value="wholesaler">হোলসেলার</option>
                    <option value="farmer">চাষী</option>
                    <option value="admin">অ্যাডমিন</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">যোগ করুন</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal()">বাতিল</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Role Modal -->
<div id="editRoleModal" class="modal" style="display:none;">
    <div class="modal-content glass-card">
        <h2>রোল পরিবর্তন করুন</h2>
        <form method="POST">
            <input type="hidden" name="action" value="update_role">
            <input type="hidden" name="user_id" id="edit_user_id">
            <div class="form-group">
                <label>নতুন রোল</label>
                <select name="role" id="edit_role" required class="form-control">
                    <option value="customer">ক্রেতা</option>
                    <option value="seller">বিক্রেতা</option>
                    <option value="wholesaler">হোলসেলার</option>
                    <option value="farmer">চাষী</option>
                    <option value="admin">অ্যাডমিন</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal()">বাতিল</button>
            </div>
        </form>
    </div>
</div>

<style>
.modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; z-index: 1000; }
.modal-content { max-width: 500px; width: 90%; padding: 2rem; }
.form-group { margin-bottom: 1.5rem; }
.form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; }
.form-actions { display: flex; gap: 1rem; margin-top: 2rem; }
</style>

<script>
function showAddUserModal() {
    document.getElementById('addUserModal').style.display = 'flex';
}

function editUser(userId, currentRole) {
    document.getElementById('edit_user_id').value = userId;
    document.getElementById('edit_role').value = currentRole;
    document.getElementById('editRoleModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('addUserModal').style.display = 'none';
    document.getElementById('editRoleModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        closeModal();
    }
}
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>
