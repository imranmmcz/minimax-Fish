<?php
$pageTitle = 'পুকুর পরিচালনা';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/auth.php';

// চাষী রোল চেক করুন
requireRole('farmer');

$db = getDB();
$userId = getUserId();

// পুকুরের তথ্য লোড করুন
$stmt = $db->prepare("SELECT * FROM ponds WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$ponds = $stmt->fetchAll();

include_once __DIR__ . '/../../../includes/header.php';
?>

<div class="dashboard-layout">
    <!-- Sidebar -->
    <aside class="dashboard-sidebar">
        <div class="sidebar-content">
            <nav class="sidebar-nav">
                <a href="index.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2L2 8V18H7V13H13V18H18V8L10 2Z"/>
                    </svg>
                    <span>ড্যাশবোর্ড হোম</span>
                </a>
                <a href="ponds.php" class="nav-item active">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 15C7.24 15 5 12.76 5 10C5 7.24 7.24 5 10 5C12.76 5 15 7.24 15 10C15 12.76 12.76 15 10 15Z"/>
                    </svg>
                    <span>পুকুর ব্যবস্থাপনা</span>
                </a>
                <a href="add-income.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H11V14H9V11H6V9H9V6H11V9H14V11Z"/>
                    </svg>
                    <span>আয় যোগ করুন</span>
                </a>
                <a href="add-expense.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H6V9H14V11Z"/>
                    </svg>
                    <span>ব্যয় যোগ করুন</span>
                </a>
                <a href="transactions.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 4H18V6H2V4ZM2 9H18V11H2V9ZM2 14H18V16H2V14Z"/>
                    </svg>
                    <span>লেনদেন তালিকা</span>
                </a>
                <a href="/fishcare/pages/profile.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 4C11.66 4 13 5.34 13 7C13 8.66 11.66 10 10 10C8.34 10 7 8.66 7 7C7 5.34 8.34 4 10 4ZM10 17C7.33 17 5.01 15.45 4 13.25C4.03 11 8 9.79 10 9.79C11.99 9.79 15.97 11 16 13.25C14.99 15.45 12.67 17 10 17Z"/>
                    </svg>
                    <span>প্রোফাইল</span>
                </a>
            </nav>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="dashboard-content">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="flex justify-between items-center">
                <div>
                    <h1>পুকুর পরিচালনা</h1>
                    <p class="text-muted">আপনার পুকুরগুলো পরিচালনা করুন</p>
                </div>
                <div class="flex gap-3">
                    <button id="toggleView" class="btn btn-glass">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path id="viewIcon" d="M3 4H5V6H3V4ZM7 4H17V6H7V4ZM3 8H17V10H3V8ZM3 12H17V14H3V12ZM3 16H17V18H3V16Z"/>
                        </svg>
                        <span id="viewText">কার্ড ভিউ</span>
                    </button>
                    <button onclick="openAddPondModal()" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM14 11H11V14H9V11H6V9H9V6H11V9H14V11Z"/>
                        </svg>
                        নতুন পুকুর যোগ করুন
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-3 mb-8">
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M24 4C12.95 4 4 12.95 4 24C4 35.05 12.95 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4ZM24 34C18.48 34 14 29.52 14 24C14 18.48 18.48 14 24 14C29.52 14 34 18.48 34 24C34 29.52 29.52 34 24 34Z"/>
                    </svg>
                </div>
                <div class="data-card-value"><?php echo count($ponds); ?></div>
                <div class="data-card-label">মোট পুকুর</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M38 8H10C7.8 8 6 9.8 6 12V36C6 38.2 7.8 40 10 40H38C40.2 40 42 38.2 42 36V12C42 9.8 40.2 8 38 8ZM24 32L12 28L14 26L16 28L20 24L22 26L16 32ZM32 30H26V26H32V30ZM32 20H26V16H32V20Z"/>
                    </svg>
                </div>
                <div class="data-card-value text-success">
                    <?php echo count(array_filter($ponds, fn($p) => $p['status'] === 'active')); ?>
                </div>
                <div class="data-card-label">সক্রিয় পুকুর</div>
            </div>
            
            <div class="glass-card data-card">
                <div class="data-card-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M38 8H10C7.8 8 6 9.8 6 12V36C6 38.2 7.8 40 10 40H38C40.2 40 42 38.2 42 36V12C42 9.8 40.2 8 38 8ZM10 16H38V12H10V16ZM10 20H38V36H10V20ZM24 32H34V34H24V32Z"/>
                    </svg>
                </div>
                <div class="data-card-value text-warning">
                    <?php echo count(array_filter($ponds, fn($p) => $p['status'] === 'maintenance')); ?>
                </div>
                <div class="data-card-label">মেইনটেন্যান্স</div>
            </div>
        </div>

        <!-- Ponds Display -->
        <div id="pondsDisplay" class="ponds-grid">
            <!-- Card View (Default) -->
            <div id="cardView" class="view-mode active">
                <?php if (count($ponds) > 0): ?>
                    <?php foreach ($ponds as $pond): ?>
                        <div class="pond-card glass-card" data-pond-id="<?php echo $pond['id']; ?>">
                            <div class="pond-card-header">
                                <div class="pond-status-badge <?php echo $pond['status']; ?>">
                                    <?php 
                                        echo match($pond['status']) {
                                            'active' => 'সক্রিয়',
                                            'inactive' => 'নিষ্ক্রিয়',
                                            'maintenance' => 'মেইনটেন্যান্স',
                                            default => 'অজানা'
                                        };
                                    ?>
                                </div>
                                <div class="pond-actions">
                                    <button onclick="editPond(<?php echo $pond['id']; ?>)" class="btn btn-glass btn-sm">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.71 3.29C18.21 2.79 18.99 2.79 19.49 3.29L20.71 4.51C21.21 5.01 21.21 5.79 20.71 6.29L13.71 13.29L6.71 14.29L7.71 13.29L14.71 6.29L15.19 6.77C15.69 7.27 17.21 7.27 17.71 6.77L18.99 5.49L19.49 4.99L18.19 3.69C17.99 3.49 17.81 3.39 17.71 3.29Z"/>
                                        </svg>
                                    </button>
                                    <button onclick="deletePond(<?php echo $pond['id']; ?>)" class="btn btn-glass btn-sm text-error">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 2V1C9 0.45 9.45 0 10 0H10.01C10.56 0 11 0.45 11 1V2H15V1C15 0.45 15.45 0 16 0C16.56 0 17 0.45 17 1V2H19C19.55 2 20 2.45 20 3C20 3.55 19.55 4 19 4H17V16C17 17.1 16.1 18 15 18H5C3.9 18 3 17.1 3 16V4H1C0.45 4 0 3.55 0 3C0 2.45 0.45 2 1 2H3V1C3 0.45 3.45 0 4 0C4.56 0 5 0.45 5 1V2H9Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="pond-content">
                                <h3 class="pond-name"><?php echo escape($pond['name']); ?></h3>
                                <div class="pond-info">
                                    <div class="info-item">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 15C7.24 15 5 12.76 5 10C5 7.24 7.24 5 10 5C12.76 5 15 7.24 15 10C15 12.76 12.76 15 10 15Z"/>
                                        </svg>
                                        <span><?php echo escape($pond['location'] ?? 'লোকেশন সেট করা নেই'); ?></span>
                                    </div>
                                    
                                    <?php if ($pond['area_size']): ?>
                                    <div class="info-item">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M4 4H16V6H4V4ZM4 8H16V10H4V8ZM4 12H16V14H4V12ZM4 16H16V18H4V16Z"/>
                                        </svg>
                                        <span>
                                            <?php echo $pond['area_size']; ?> 
                                            <?php echo match($pond['area_unit']) {
                                                'shotok' => 'শতক',
                                                'bigha' => 'বিঘা',
                                                'acre' => 'একর',
                                                default => $pond['area_unit']
                                            }; ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($pond['water_depth']): ?>
                                    <div class="info-item">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 0L3 7L3 15C3 16.1 3.9 17 5 17H7C8.1 17 9 16.1 9 15L9 7H11L11 15C11 16.1 11.9 17 13 17H15C16.1 17 17 16.1 17 15L17 7L10 0Z"/>
                                        </svg>
                                        <span><?php echo $pond['water_depth']; ?> ফুট গভীর</span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($pond['notes']): ?>
                                <div class="pond-notes">
                                    <p><?php echo escape($pond['notes']); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="pond-footer">
                                <small class="text-muted">
                                    তৈরি: <?php echo formatDate($pond['created_at']); ?>
                                </small>
                                <button onclick="showPondDetails(<?php echo $pond['id']; ?>)" class="btn btn-glass btn-sm">
                                    বিস্তারিত দেখুন
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state glass-card">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="currentColor" style="margin-bottom: 1rem; opacity: 0.5;">
                            <path d="M40 0C17.92 0 0 17.92 0 40C0 62.08 17.92 80 40 80C62.08 80 80 62.08 80 40C80 17.92 62.08 0 40 0ZM40 60C28.8 60 20 51.2 20 40C20 28.8 28.8 20 40 20C51.2 20 60 28.8 60 40C60 51.2 51.2 60 40 60Z"/>
                        </svg>
                        <h3>কোনো পুকুর নেই</h3>
                        <p>আপনার প্রথম পুকুর তৈরি করুন</p>
                        <button onclick="openAddPondModal()" class="btn btn-primary">নতুন পুকুর যোগ করুন</button>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Table View -->
            <div id="tableView" class="view-mode">
                <div class="glass-card">
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>পুকুরের নাম</th>
                                    <th>লোকেশন</th>
                                    <th>আকার</th>
                                    <th>গভীরতা</th>
                                    <th>অবস্থা</th>
                                    <th>তৈরির তারিখ</th>
                                    <th>পদক্ষেপ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($ponds) > 0): ?>
                                    <?php foreach ($ponds as $pond): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo escape($pond['name']); ?></strong>
                                                <?php if ($pond['notes']): ?>
                                                    <br><small class="text-muted"><?php echo escape(substr($pond['notes'], 50)); ?>...</small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo escape($pond['location'] ?? '-'); ?></td>
                                            <td>
                                                <?php if ($pond['area_size']): ?>
                                                    <?php echo $pond['area_size']; ?> 
                                                    <?php echo match($pond['area_unit']) {
                                                        'shotok' => 'শতক',
                                                        'bigha' => 'বিঘা',
                                                        'acre' => 'একর',
                                                        default => $pond['area_unit']
                                                    }; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $pond['water_depth'] ? $pond['water_depth'] . ' ফুট' : '-'; ?></td>
                                            <td>
                                                <span class="badge <?php echo match($pond['status']) {
                                                    'active' => 'badge-success',
                                                    'inactive' => 'badge-muted',
                                                    'maintenance' => 'badge-warning',
                                                    default => 'badge-muted'
                                                }; ?>">
                                                    <?php 
                                                        echo match($pond['status']) {
                                                            'active' => 'সক্রিয়',
                                                            'inactive' => 'নিষ্ক্রিয়',
                                                            'maintenance' => 'মেইনটেন্যান্স',
                                                            default => 'অজানা'
                                                        };
                                                    ?>
                                                </span>
                                            </td>
                                            <td><?php echo formatDate($pond['created_at']); ?></td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <button onclick="showPondDetails(<?php echo $pond['id']; ?>)" class="btn btn-glass btn-sm">
                                                        বিস্তারিত
                                                    </button>
                                                    <button onclick="editPond(<?php echo $pond['id']; ?>)" class="btn btn-glass btn-sm">
                                                        সম্পাদনা
                                                    </button>
                                                    <button onclick="deletePond(<?php echo $pond['id']; ?>)" class="btn btn-glass btn-sm text-error">
                                                        ডিলিট
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">কোনো পুকুর নেই</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add/Edit Pond Modal -->
<div id="pondModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">নতুন পুকুর যোগ করুন</h2>
            <button onclick="closePondModal()" class="btn btn-glass btn-sm">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M15.59 4.59L14 3.17L10 7.17L6 3.17L4.59 4.59L8.59 8.59L4.59 12.59L6 14L10 10L14 14L15.41 12.59L11.41 8.59L15.59 4.59Z"/>
                </svg>
            </button>
        </div>
        
        <form id="pondForm" class="modal-body">
            <input type="hidden" id="pondId" name="id">
            
            <div class="form-group">
                <label for="pondName">পুকুরের নাম *</label>
                <input type="text" id="pondName" name="name" required placeholder="যেমন: রুহান পুকুর">
                <div class="error-message" id="nameError"></div>
            </div>
            
            <div class="form-group">
                <label for="pondLocation">লোকেশন</label>
                <input type="text" id="pondLocation" name="location" placeholder="যেমন: গ্রাম: রুহানপুর, উপজেলা: কালীগঞ্জ">
                <div class="error-message" id="locationError"></div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="pondAreaSize">আকার</label>
                    <input type="number" id="pondAreaSize" name="area_size" step="0.01" placeholder="10.5">
                    <div class="error-message" id="areaSizeError"></div>
                </div>
                
                <div class="form-group">
                    <label for="pondAreaUnit">একক</label>
                    <select id="pondAreaUnit" name="area_unit">
                        <option value="shotok">শতক</option>
                        <option value="bigha">বিঘা</option>
                        <option value="acre">একর</option>
                    </select>
                    <div class="error-message" id="areaUnitError"></div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="waterDepth">জলের গভীরতা (ফুট)</label>
                <input type="number" id="waterDepth" name="water_depth" step="0.1" placeholder="5.5">
                <div class="error-message" id="waterDepthError"></div>
            </div>
            
            <div class="form-group">
                <label for="pondStatus">অবস্থা</label>
                <select id="pondStatus" name="status">
                    <option value="active">সক্রিয়</option>
                    <option value="inactive">নিষ্ক্রিয়</option>
                    <option value="maintenance">মেইনটেন্যান্স</option>
                </select>
                <div class="error-message" id="statusError"></div>
            </div>
            
            <div class="form-group">
                <label for="pondNotes">নোট/বিবরণ</label>
                <textarea id="pondNotes" name="notes" rows="3" placeholder="পুকুর সম্পর্কে অতিরিক্ত তথ্য..."></textarea>
                <div class="error-message" id="notesError"></div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closePondModal()" class="btn btn-glass">বাতিল</button>
                <button type="submit" id="submitBtn" class="btn btn-primary">
                    <span class="loading-spinner" id="loadingSpinner" style="display: none;"></span>
                    সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Pond Details Modal -->
<div id="detailsModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2>পুকুরের বিস্তারিত তথ্য</h2>
            <button onclick="closeDetailsModal()" class="btn btn-glass btn-sm">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M15.59 4.59L14 3.17L10 7.17L6 3.17L4.59 4.59L8.59 8.59L4.59 12.59L6 14L10 10L14 14L15.41 12.59L11.41 8.59L15.59 4.59Z"/>
                </svg>
            </button>
        </div>
        
        <div class="modal-body" id="pondDetailsContent">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

<style>
/* Custom styles for pond management */
.dashboard-layout {
    display: flex;
    min-height: calc(100vh - 72px - 200px);
}

.dashboard-sidebar {
    width: 260px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-right: 1px solid rgba(255, 255, 255, 0.2);
    padding: var(--space-6);
    position: sticky;
    top: 72px;
    height: calc(100vh - 72px);
    overflow-y: auto;
}

.sidebar-nav {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.nav-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-4);
    color: var(--color-neutral-900);
    border-radius: var(--radius-md);
    transition: all var(--duration-fast) var(--easing-default);
    text-decoration: none;
}

.nav-item:hover {
    background: rgba(0, 188, 212, 0.1);
}

.nav-item.active {
    background: var(--color-primary-500);
    color: white;
}

.dashboard-content {
    flex: 1;
    padding: var(--space-8);
}

.dashboard-header {
    margin-bottom: var(--space-8);
}

.dashboard-header h1 {
    margin-bottom: var(--space-2);
}

/* View Mode Toggles */
.view-mode {
    display: none;
}

.view-mode.active {
    display: block;
}

/* Ponds Grid (Card View) */
.ponds-grid {
    display: grid;
    gap: var(--space-6);
}

#cardView.active {
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
}

.pond-card {
    transition: all var(--duration-normal) var(--easing-default);
    position: relative;
}

.pond-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-glass-lg);
}

.pond-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--space-4);
}

.pond-status-badge {
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-full);
    font-size: var(--text-small);
    font-weight: var(--weight-semibold);
}

.pond-status-badge.active {
    background: var(--color-success);
    color: white;
}

.pond-status-badge.inactive {
    background: var(--color-neutral-300);
    color: var(--color-neutral-700);
}

.pond-status-badge.maintenance {
    background: #FF9800;
    color: white;
}

.pond-actions {
    display: flex;
    gap: var(--space-2);
}

.pond-name {
    font-size: var(--text-xl);
    font-weight: var(--weight-bold);
    margin-bottom: var(--space-3);
    color: var(--color-neutral-900);
}

.pond-info {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
    margin-bottom: var(--space-4);
}

.info-item {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--text-small);
    color: var(--color-neutral-700);
}

.info-item svg {
    opacity: 0.7;
}

.pond-notes {
    background: rgba(255, 255, 255, 0.3);
    border-radius: var(--radius-md);
    padding: var(--space-3);
    margin-bottom: var(--space-4);
}

.pond-notes p {
    margin: 0;
    font-size: var(--text-small);
    line-height: 1.5;
}

.pond-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: var(--space-3);
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

/* Table View */
.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: var(--space-3) var(--space-4);
    text-align: left;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.data-table th {
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-800);
    background: rgba(255, 255, 255, 0.1);
}

/* Badges */
.badge {
    display: inline-block;
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-full);
    font-size: var(--text-small);
    font-weight: var(--weight-semibold);
}

.badge-success {
    background: var(--color-success);
    color: white;
}

.badge-warning {
    background: #FF9800;
    color: white;
}

.badge-muted {
    background: var(--color-neutral-300);
    color: var(--color-neutral-700);
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all var(--duration-normal) var(--easing-default);
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: var(--color-glass-white);
    backdrop-filter: blur(20px) saturate(150%);
    -webkit-backdrop-filter: blur(20px) saturate(150%);
    border: 1px solid var(--color-glass-border);
    border-radius: var(--radius-xl);
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    transform: translateY(20px);
    transition: transform var(--duration-normal) var(--easing-default);
}

.modal-overlay.active .modal-content {
    transform: translateY(0);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-6) var(--space-6) var(--space-4);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-header h2 {
    margin: 0;
    font-size: var(--text-xl);
}

.modal-body {
    padding: var(--space-6);
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: var(--space-3);
    margin-top: var(--space-6);
    padding-top: var(--space-4);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

/* Form Styles */
.form-group {
    margin-bottom: var(--space-4);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-4);
}

.form-group label {
    display: block;
    margin-bottom: var(--space-2);
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-800);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: var(--space-3);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: var(--radius-md);
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    color: var(--color-neutral-900);
    font-family: var(--font-primary);
    transition: all var(--duration-fast) var(--easing-default);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--color-primary-500);
    box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.1);
}

.error-message {
    color: var(--color-error);
    font-size: var(--text-small);
    margin-top: var(--space-1);
    display: none;
}

.error-message.show {
    display: block;
}

.loading-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: var(--space-12) var(--space-6);
}

.empty-state h3 {
    margin: var(--space-4) 0 var(--space-2);
    color: var(--color-neutral-700);
}

.empty-state p {
    margin-bottom: var(--space-6);
    color: var(--color-neutral-600);
}

/* Responsive */
@media screen and (max-width: 768px) {
    .dashboard-layout {
        flex-direction: column;
    }
    
    .dashboard-sidebar {
        width: 100%;
        height: auto;
        position: static;
    }
    
    .sidebar-nav {
        flex-direction: row;
        overflow-x: auto;
    }
    
    .dashboard-content {
        padding: var(--space-4);
    }
    
    .flex {
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .justify-between {
        align-items: stretch;
    }
    
    .grid {
        grid-template-columns: 1fr !important;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .modal-content {
        width: 95%;
        margin: var(--space-4);
    }
    
    .modal-footer {
        flex-direction: column;
    }
    
    .btn-block {
        width: 100%;
    }
}

@media screen and (max-width: 480px) {
    .pond-actions {
        flex-direction: column;
    }
    
    .pond-footer {
        flex-direction: column;
        align-items: stretch;
        gap: var(--space-2);
    }
    
    .data-table {
        font-size: var(--text-small);
    }
    
    .data-table th,
    .data-table td {
        padding: var(--space-2);
    }
}
</style>

<script>
// Global variables
let currentView = 'card';
let ponds = <?php echo json_encode($ponds); ?>;
let isEditMode = false;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Set up event listeners
    document.getElementById('toggleView').addEventListener('click', toggleView);
    document.getElementById('pondForm').addEventListener('submit', handlePondSubmit);
    
    // Close modals on background click
    document.getElementById('pondModal').addEventListener('click', function(e) {
        if (e.target === this) closePondModal();
    });
    
    document.getElementById('detailsModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetailsModal();
    });
});

// Toggle between card and table view
function toggleView() {
    const cardView = document.getElementById('cardView');
    const tableView = document.getElementById('tableView');
    const viewIcon = document.getElementById('viewIcon');
    const viewText = document.getElementById('viewText');
    
    if (currentView === 'card') {
        // Switch to table view
        cardView.classList.remove('active');
        tableView.classList.add('active');
        viewText.textContent = 'টেবিল ভিউ';
        
        // Update icon to table format
        viewIcon.setAttribute('d', 'M3 3H21V5H3V3ZM3 7H21V9H3V7ZM3 11H21V13H3V11ZM3 15H21V17H3V15ZM3 19H21V21H3V19Z');
        
        currentView = 'table';
    } else {
        // Switch to card view
        tableView.classList.remove('active');
        cardView.classList.add('active');
        viewText.textContent = 'কার্ড ভিউ';
        
        // Update icon to grid format
        viewIcon.setAttribute('d', 'M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM10 15C7.24 15 5 12.76 5 10C5 7.24 7.24 5 10 5C12.76 5 15 7.24 15 10C15 12.76 12.76 15 10 15Z');
        
        currentView = 'card';
    }
}

// Open add pond modal
function openAddPondModal() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'নতুন পুকুর যোগ করুন';
    document.getElementById('pondForm').reset();
    document.getElementById('pondId').value = '';
    
    // Reset errors
    document.querySelectorAll('.error-message').forEach(el => {
        el.classList.remove('show');
    });
    
    document.getElementById('pondModal').classList.add('active');
}

// Close pond modal
function closePondModal() {
    document.getElementById('pondModal').classList.remove('active');
}

// Edit pond
async function editPond(pondId) {
    try {
        const response = await fetch(`/fishcare/api/pond.php?id=${pondId}`);
        const result = await response.json();
        
        if (result.success) {
            isEditMode = true;
            const pond = result.data;
            
            document.getElementById('modalTitle').textContent = 'পুকুর সম্পাদনা';
            document.getElementById('pondForm').reset();
            
            document.getElementById('pondId').value = pond.id;
            document.getElementById('pondName').value = pond.name;
            document.getElementById('pondLocation').value = pond.location || '';
            document.getElementById('pondAreaSize').value = pond.area_size || '';
            document.getElementById('pondAreaUnit').value = pond.area_unit;
            document.getElementById('waterDepth').value = pond.water_depth || '';
            document.getElementById('pondStatus').value = pond.status;
            document.getElementById('pondNotes').value = pond.notes || '';
            
            // Reset errors
            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.remove('show');
            });
            
            document.getElementById('pondModal').classList.add('active');
        } else {
            showNotification('পুকুরের তথ্য পাওয়া যায়নি', 'error');
        }
    } catch (error) {
        console.error('Error fetching pond details:', error);
        showNotification('ত্রুটি হয়েছে', 'error');
    }
}

// Delete pond
async function deletePond(pondId) {
    if (!confirm('আপনি কি নিশ্চিত যে এই পুকুরটি ডিলিট করতে চান?')) {
        return;
    }
    
    try {
        const response = await fetch('/fishcare/api/pond.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: pondId })
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('পুকুর ডিলিট হয়েছে', 'success');
            // Reload page after short delay
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(result.error || 'ডিলিট ব্যর্থ', 'error');
        }
    } catch (error) {
        console.error('Error deleting pond:', error);
        showNotification('ত্রুটি হয়েছে', 'error');
    }
}

// Handle pond form submission
async function handlePondSubmit(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    // Show loading state
    submitBtn.disabled = true;
    loadingSpinner.style.display = 'inline-block';
    
    // Clear previous errors
    document.querySelectorAll('.error-message').forEach(el => {
        el.classList.remove('show');
    });
    
    try {
        const formData = new FormData(e.target);
        const pondData = {
            name: formData.get('name'),
            location: formData.get('location'),
            area_size: formData.get('area_size'),
            area_unit: formData.get('area_unit'),
            water_depth: formData.get('water_depth'),
            status: formData.get('status'),
            notes: formData.get('notes')
        };
        
        // If editing, include ID
        if (isEditMode) {
            pondData.id = document.getElementById('pondId').value;
        }
        
        const method = isEditMode ? 'PUT' : 'POST';
        const url = '/fishcare/api/pond.php';
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(pondData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification(isEditMode ? 'পুকুর আপডেট হয়েছে' : 'পুকুর যোগ হয়েছে', 'success');
            closePondModal();
            
            // Reload page after short delay
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            // Show validation errors
            if (result.error) {
                showNotification(result.error, 'error');
            }
            
            // Handle field-specific errors
            if (result.errors) {
                Object.keys(result.errors).forEach(field => {
                    const errorEl = document.getElementById(field + 'Error');
                    if (errorEl) {
                        errorEl.textContent = result.errors[field];
                        errorEl.classList.add('show');
                    }
                });
            }
        }
    } catch (error) {
        console.error('Error saving pond:', error);
        showNotification('ত্রুটি হয়েছে', 'error');
    } finally {
        // Reset loading state
        submitBtn.disabled = false;
        loadingSpinner.style.display = 'none';
    }
}

// Show pond details
async function showPondDetails(pondId) {
    try {
        const response = await fetch(`/fishcare/api/pond.php?id=${pondId}`);
        const result = await response.json();
        
        if (result.success) {
            const pond = result.data;
            
            const detailsHtml = `
                <div class="pond-details">
                    <div class="detail-header">
                        <h3>${escapeHtml(pond.name)}</h3>
                        <span class="badge ${matchStatusBadge(pond.status)}">${getStatusText(pond.status)}</span>
                    </div>
                    
                    <div class="detail-grid">
                        ${pond.location ? `
                            <div class="detail-item">
                                <label>লোকেশন</label>
                                <p>${escapeHtml(pond.location)}</p>
                            </div>
                        ` : ''}
                        
                        ${pond.area_size ? `
                            <div class="detail-item">
                                <label>আকার</label>
                                <p>${pond.area_size} ${getAreaUnitText(pond.area_unit)}</p>
                            </div>
                        ` : ''}
                        
                        ${pond.water_depth ? `
                            <div class="detail-item">
                                <label>গভীরতা</label>
                                <p>${pond.water_depth} ফুট</p>
                            </div>
                        ` : ''}
                        
                        <div class="detail-item">
                            <label>অবস্থা</label>
                            <p>${getStatusText(pond.status)}</p>
                        </div>
                        
                        <div class="detail-item">
                            <label>তৈরির তারিখ</label>
                            <p>${formatDate(pond.created_at)}</p>
                        </div>
                        
                        ${pond.updated_at ? `
                            <div class="detail-item">
                                <label>শেষ আপডেট</label>
                                <p>${formatDate(pond.updated_at)}</p>
                            </div>
                        ` : ''}
                    </div>
                    
                    ${pond.notes ? `
                        <div class="detail-item">
                            <label>বিবরণ</label>
                            <p>${escapeHtml(pond.notes)}</p>
                        </div>
                    ` : ''}
                </div>
                
                <div class="modal-footer">
                    <button onclick="editPond(${pond.id})" class="btn btn-primary">
                        সম্পাদনা করুন
                    </button>
                    <button onclick="closeDetailsModal()" class="btn btn-glass">বন্ধ করুন</button>
                </div>
            `;
            
            document.getElementById('pondDetailsContent').innerHTML = detailsHtml;
            document.getElementById('detailsModal').classList.add('active');
        } else {
            showNotification('পুকুরের তথ্য পাওয়া যায়নি', 'error');
        }
    } catch (error) {
        console.error('Error fetching pond details:', error);
        showNotification('ত্রুটি হয়েছে', 'error');
    }
}

// Close details modal
function closeDetailsModal() {
    document.getElementById('detailsModal').classList.remove('active');
}

// Helper functions
function matchStatusBadge(status) {
    switch(status) {
        case 'active': return 'badge-success';
        case 'maintenance': return 'badge-warning';
        case 'inactive': return 'badge-muted';
        default: return 'badge-muted';
    }
}

function getStatusText(status) {
    switch(status) {
        case 'active': return 'সক্রিয়';
        case 'maintenance': return 'মেইনটেন্যান্স';
        case 'inactive': return 'নিষ্ক্রিয়';
        default: return 'অজানা';
    }
}

function getAreaUnitText(unit) {
    switch(unit) {
        case 'shotok': return 'শতক';
        case 'bigha': return 'বিঘা';
        case 'acre': return 'একর';
        default: unit;
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('bn-BD', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="notification-close">×</button>
        </div>
    `;
    
    // Add styles if not already added
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                padding: 1rem;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                animation: slideIn 0.3s ease-out;
            }
            
            .notification-success {
                background: var(--color-success);
                color: white;
            }
            
            .notification-error {
                background: var(--color-error);
                color: white;
            }
            
            .notification-info {
                background: var(--color-primary-500);
                color: white;
            }
            
            .notification-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
            }
            
            .notification-close {
                background: none;
                border: none;
                color: inherit;
                font-size: 18px;
                cursor: pointer;
                padding: 0;
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Add to body
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>

<?php include_once __DIR__ . '/../../../includes/footer.php'; ?>