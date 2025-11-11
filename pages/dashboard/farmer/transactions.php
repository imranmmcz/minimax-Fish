<?php
$pageTitle = "লেনদেন ট্র্যাকিং";
$bodyClass = "dashboard-page";
require_once __DIR__ . '/../../includes/header.php';

// শুধু চাষী রোল চেক করুন
if (!isLoggedIn() || !hasRole('farmer')) {
    redirect(getRoleDashboard(getUserRole()));
}

$db = getDB();
$userId = getUserId();

// পুকুরের তালিকা
$stmt = $db->prepare("SELECT id, name FROM ponds WHERE user_id = ? ORDER BY name");
$stmt->execute([$userId]);
$ponds = $stmt->fetchAll();
?>

<!-- Glass Card Container -->
<div class="glass-container">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="currentColor">
                        <path d="M8 2C6.9 2 6 2.9 6 4V6H8V4H24V6H26V4C26 2.9 25.1 2 24 2H8ZM6 8H26V26C26 27.1 25.1 28 24 28H8C6.9 28 6 27.1 6 26V8ZM10 10H14V12H10V10ZM10 14H22V16H10V14ZM10 18H18V20H10V18Z"/>
                    </svg>
                    আয়-ব্যয় ট্র্যাকিং
                </h1>
                <p class="page-description">আপনার পুকুর চাষের আয়-ব্যয় পরিচালনা করুন</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card glass-card income-card">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="card-content">
                    <h3>মোট আয়</h3>
                    <p class="amount income" id="totalIncome">৳0</p>
                </div>
            </div>
            
            <div class="summary-card glass-card expense-card">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13H5v-2h14v2z"/>
                    </svg>
                </div>
                <div class="card-content">
                    <h3>মোট ব্যয়</h3>
                    <p class="amount expense" id="totalExpense">৳0</p>
                </div>
            </div>
            
            <div class="summary-card glass-card balance-card">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                    </svg>
                </div>
                <div class="card-content">
                    <h3>বর্তমান ভারসাম্য</h3>
                    <p class="amount balance" id="totalBalance">৳0</p>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Left Column: Transaction List -->
            <div class="left-column">
                <!-- Filters and Export -->
                <div class="glass-card filter-section">
                    <h3>লেনদেন ফিল্টার</h3>
                    <div class="filter-controls">
                        <div class="filter-group">
                            <label for="dateRange">তারিখ</label>
                            <select id="dateRange" class="form-control">
                                <option value="">সকল সময়</option>
                                <option value="today">আজ</option>
                                <option value="week">এই সপ্তাহ</option>
                                <option value="month" selected>এই মাস</option>
                                <option value="year">এই বছর</option>
                                <option value="custom">কাস্টম রেঞ্জ</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="transactionType">টাইপ</label>
                            <select id="transactionType" class="form-control">
                                <option value="">সকল টাইপ</option>
                                <option value="income">আয়</option>
                                <option value="expense">ব্যয়</option>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="categoryFilter">ক্যাটাগরি</label>
                            <select id="categoryFilter" class="form-control">
                                <option value="">সকল ক্যাটাগরি</option>
                                <option value="fish_sale">মাছ বিক্রয়</option>
                                <option value="seed_purchase">পোনা ক্রয়</option>
                                <option value="feed">খাদ্য</option>
                                <option value="medicine">ওষুধ</option>
                                <option value="labor">শ্রমিক</option>
                                <option value="equipment">যন্ত্রপাতি</option>
                                <option value="transport">পরিবহন</option>
                                <option value="other">অন্যান্য</option>
                            </select>
                        </div>
                        
                        <div class="filter-actions">
                            <button id="applyFilter" class="btn-primary">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M6.47 10.82l2.88-2.88a.5.5 0 0 1 .7.7l-3.05 3.05a.5.5 0 0 1-.35.15H5a.5.5 0 0 1-.5-.5v-1.3a.5.5 0 0 1 .15-.35l2.32-2.34zm8.03-5a6.5 6.5 0 1 1-13 0A6.5 6.5 0 0 1 14.5 5.82z"/>
                                </svg>
                                ফিল্টার
                            </button>
                            <button id="clearFilter" class="btn-glass">সাফ করুন</button>
                        </div>
                    </div>
                    
                    <div class="export-section">
                        <div class="export-buttons">
                            <button id="exportPDF" class="btn-secondary">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M14 14V2H2V14H14zM9 3H7v2H5V3H3v4h2V5h2v2h2V3zM14 8H2v2h12V8zM14 12H2v2h12v-2z"/>
                                </svg>
                                PDF
                            </button>
                            <button id="exportExcel" class="btn-secondary">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M0 0h8v2H0V0zM0 4h8v2H0V4zM0 8h8v2H0V8z"/>
                                </svg>
                                Excel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Transaction List -->
                <div class="glass-card">
                    <div class="card-header">
                        <h3>লেনদেন তালিকা</h3>
                        <button class="btn-primary" id="addTransactionBtn">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M8 0C3.58 0 0 3.58 0 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm4 9h-3v3h-2v-3H4v-2h3V4h2v3h3v2z"/>
                            </svg>
                            নতুন লেনদেন
                        </button>
                    </div>
                    
                    <div class="transaction-list" id="transactionList">
                        <div class="loading">
                            <div class="spinner"></div>
                            <p>লেনদেন লোড হচ্ছে...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Charts and Forms -->
            <div class="right-column">
                <!-- Charts -->
                <div class="glass-card charts-section">
                    <h3>আয়-ব্যয় বিশ্লেষণ</h3>
                    
                    <div class="chart-container">
                        <canvas id="incomeExpenseChart"></canvas>
                    </div>
                    
                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="glass-card quick-stats">
                    <h3>মাসিক পরিসংখ্যান</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-label">গত মাসের আয়</span>
                            <span class="stat-value" id="lastMonthIncome">৳0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">চলতি মাসের আয়</span>
                            <span class="stat-value" id="currentMonthIncome">৳0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">গড় লেনদেন</span>
                            <span class="stat-value" id="averageTransaction">৳0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">মোট লেনদেন</span>
                            <span class="stat-value" id="totalTransactions">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Modal -->
<div class="modal" id="transactionModal">
    <div class="modal-backdrop"></div>
    <div class="modal-content glass-card">
        <div class="modal-header">
            <h3 id="modalTitle">নতুন লেনদেন</h3>
            <button class="modal-close" id="closeModal">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
        </div>
        
        <form id="transactionForm" class="modal-body">
            <input type="hidden" id="transactionId" value="">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="transactionType">লেনদেন টাইপ *</label>
                    <select id="transactionTypeInput" class="form-control" required>
                        <option value="">টাইপ নির্বাচন করুন</option>
                        <option value="income">আয়</option>
                        <option value="expense">ব্যয়</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="amount">টাকার পরিমাণ *</label>
                    <div class="input-group">
                        <span class="input-prefix">৳</span>
                        <input type="number" id="amount" class="form-control" step="0.01" min="0" required>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="category">ক্যাটাগরি *</label>
                    <select id="category" class="form-control" required>
                        <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                        <optgroup label="আয় ক্যাটাগরি" id="incomeCategories">
                            <option value="fish_sale">মাছ বিক্রয়</option>
                            <option value="pond_rental">পুকুর ভাড়া</option>
                            <option value="other_income">অন্যান্য আয়</option>
                        </optgroup>
                        <optgroup label="ব্যয় ক্যাটাগরি" id="expenseCategories">
                            <option value="seed_purchase">পোনা ক্রয়</option>
                            <option value="feed">খাদ্য</option>
                            <option value="medicine">ওষুধ</option>
                            <option value="labor">শ্রমিক</option>
                            <option value="equipment">যন্ত্রপাতি</option>
                            <option value="transport">পরিবহন</option>
                            <option value="utilities">ইউটিলিটি</option>
                            <option value="other_expense">অন্যান্য ব্যয়</option>
                        </optgroup>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="pondId">পুকুর</label>
                    <select id="pondId" class="form-control">
                        <option value="">পুকুর নির্বাচন করুন</option>
                        <?php foreach ($ponds as $pond): ?>
                            <option value="<?php echo $pond['id']; ?>"><?php echo escape($pond['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="transactionDate">তারিখ *</label>
                    <input type="date" id="transactionDate" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="paymentMethod">পেমেন্ট মেথড</label>
                    <select id="paymentMethod" class="form-control">
                        <option value="cash">নগদ</option>
                        <option value="bank">ব্যাংক</option>
                        <option value="mobile_banking">মোবাইল ব্যাংকিং</option>
                        <option value="other">অন্যান্য</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="referenceNo">রেফারেন্স নাম্বার</label>
                <input type="text" id="referenceNo" class="form-control" placeholder="চেক নাম্বার, রশিদ নাম্বার ইত্যাদি">
            </div>
            
            <div class="form-group">
                <label for="description">বিবরণ</label>
                <textarea id="description" class="form-control" rows="3" placeholder="লেনদেনের বিস্তারিত বিবরণ"></textarea>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-glass" id="cancelBtn">বাতিল</button>
                <button type="submit" class="btn-primary" id="saveBtn">
                    <span class="btn-text">সেভ করুন</span>
                    <span class="btn-loading" style="display: none;">
                        <span class="spinner-small"></span> সেভ হচ্ছে...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Custom CSS -->
<style>
.glass-container {
    min-height: 100vh;
    background: var(--bg-dashboard);
    padding: 2rem 0;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.header-content h1 {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    font-size: 2.5rem;
    font-weight: 600;
    color: var(--color-neutral-900);
    margin-bottom: 1rem;
}

.summary-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.summary-card {
    padding: 2rem;
    text-align: center;
}

.income-card .card-icon {
    color: var(--color-success);
}

.expense-card .card-icon {
    color: var(--color-error);
}

.balance-card .card-icon {
    color: var(--color-primary-500);
}

.summary-card .amount {
    font-size: 2rem;
    font-weight: 700;
    margin: 0.5rem 0;
}

.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
}

.filter-section {
    margin-bottom: 2rem;
}

.filter-controls {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.export-section {
    padding-top: 1rem;
    border-top: 1px solid var(--color-glass-border);
}

.export-buttons {
    display: flex;
    gap: 0.5rem;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.transaction-list {
    max-height: 600px;
    overflow-y: auto;
}

.transaction-item {
    padding: 1rem;
    border-bottom: 1px solid var(--color-glass-border);
    transition: all 0.3s ease;
}

.transaction-item:hover {
    background: var(--color-glass-white);
}

.transaction-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.transaction-type {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
}

.income-tag {
    color: var(--color-success);
}

.expense-tag {
    color: var(--color-error);
}

.transaction-amount {
    font-size: 1.2rem;
    font-weight: 700;
}

.transaction-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--color-neutral-600);
}

.transaction-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.btn-small {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-edit {
    background: var(--color-info);
    color: white;
}

.btn-delete {
    background: var(--color-error);
    color: white;
}

.charts-section {
    margin-bottom: 2rem;
}

.chart-container {
    margin-bottom: 2rem;
    height: 300px;
}

.quick-stats .stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.stat-item {
    padding: 1rem;
    background: var(--color-glass-white);
    border-radius: 0.5rem;
    text-align: center;
}

.stat-label {
    display: block;
    font-size: 0.8rem;
    color: var(--color-neutral-600);
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--color-neutral-900);
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
}

.modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
}

.modal-content {
    position: relative;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    margin: 1rem;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.modal-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 0.25rem;
    transition: background-color 0.3s ease;
}

.modal-close:hover {
    background: var(--color-glass-white);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.input-group {
    position: relative;
}

.input-prefix {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--color-neutral-600);
    font-weight: 600;
    pointer-events: none;
}

.form-control.with-prefix {
    padding-left: 2rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid var(--color-glass-border);
}

.loading {
    text-align: center;
    padding: 3rem;
    color: var(--color-neutral-600);
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid var(--color-glass-border);
    border-top: 4px solid var(--color-primary-500);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
}

.spinner-small {
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-right: 0.5rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .summary-cards {
        grid-template-columns: 1fr;
    }
    
    .filter-controls {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .export-buttons {
        flex-direction: column;
    }
    
    .quick-stats .stats-grid {
        grid-template-columns: 1fr;
    }
}

/* Print Styles */
@media print {
    .filter-section,
    .export-section,
    .modal,
    .btn {
        display: none !important;
    }
    
    .transaction-item {
        border-bottom: 1px solid #ccc;
        page-break-inside: avoid;
    }
}
</style>

<script>
// Global variables
let currentChart = null;
let transactionsData = [];

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    setDefaultDate();
    loadTransactions();
    loadSummary();
    loadQuickStats();
    initializeCharts();
    bindEvents();
});

// Set default date to today
function setDefaultDate() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('transactionDate').value = today;
}

// Initialize charts
function initializeCharts() {
    initIncomeExpenseChart();
    initCategoryChart();
}

// Income vs Expense Chart
function initIncomeExpenseChart() {
    const ctx = document.getElementById('incomeExpenseChart');
    if (!ctx) return;

    currentChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['আয়', 'ব্যয়'],
            datasets: [{
                data: [0, 0],
                backgroundColor: [
                    'rgba(76, 175, 80, 0.8)',
                    'rgba(244, 67, 54, 0.8)'
                ],
                borderColor: [
                    '#4CAF50',
                    '#F44336'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'আয় বনাম ব্যয়',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

// Category Chart
function initCategoryChart() {
    const ctx = document.getElementById('categoryChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['মাছ বিক্রয়', 'খাদ্য', 'ওষুধ', 'শ্রমিক', 'অন্যান্য'],
            datasets: [{
                label: 'ব্যয় (টাকা)',
                data: [0, 0, 0, 0, 0],
                backgroundColor: 'rgba(244, 67, 54, 0.8)',
                borderColor: '#F44336',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'ক্যাটাগরি অনুযায়ী ব্যয়',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Load transactions
async function loadTransactions() {
    const list = document.getElementById('transactionList');
    const filters = getCurrentFilters();
    
    try {
        showLoading(list);
        
        const response = await fetch(`/fishcare/api/income_expense.php?${new URLSearchParams(filters)}`);
        const result = await response.json();
        
        if (result.success) {
            transactionsData = result.data;
            displayTransactions(result.data);
            updateCharts(result.data);
        } else {
            throw new Error(result.error || 'ডেটা লোড করতে ব্যর্থ');
        }
    } catch (error) {
        showError(list, error.message);
        console.error('Transaction load error:', error);
    }
}

// Display transactions
function displayTransactions(transactions) {
    const list = document.getElementById('transactionList');
    
    if (!transactions || transactions.length === 0) {
        list.innerHTML = `
            <div class="no-data">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="opacity: 0.5;">
                    <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
                </svg>
                <p>কোনো লেনদেন পাওয়া যায়নি</p>
                <button class="btn-primary" onclick="openAddModal()">প্রথম লেনদেন যোগ করুন</button>
            </div>
        `;
        return;
    }
    
    list.innerHTML = transactions.map(transaction => `
        <div class="transaction-item">
            <div class="transaction-header">
                <div class="transaction-type">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        ${transaction.type === 'income' 
                            ? '<path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>'
                            : '<path d="M19 13H5v-2h14v2z"/>'
                        }
                    </svg>
                    <span class="${transaction.type}-tag">
                        ${transaction.type === 'income' ? 'আয়' : 'ব্যয়'}
                    </span>
                </div>
                <div class="transaction-amount ${transaction.type}">
                    ${formatCurrency(transaction.amount)}
                </div>
            </div>
            <div class="transaction-details">
                <span><strong>ক্যাটাগরি:</strong> ${getCategoryName(transaction.category)}</span>
                <span><strong>তারিখ:</strong> ${formatDate(transaction.transaction_date)}</span>
                ${transaction.payment_method ? `<span><strong>পেমেন্ট:</strong> ${getPaymentMethodName(transaction.payment_method)}</span>` : ''}
                ${transaction.reference_no ? `<span><strong>রেফারেন্স:</strong> ${transaction.reference_no}</span>` : ''}
            </div>
            ${transaction.description ? `
                <p style="margin: 0.5rem 0; color: var(--color-neutral-600); font-size: 0.9rem;">
                    ${transaction.description}
                </p>
            ` : ''}
            <div class="transaction-actions">
                <button class="btn-small btn-edit" onclick="editTransaction(${transaction.id})">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    সম্পাদনা
                </button>
                <button class="btn-small btn-delete" onclick="deleteTransaction(${transaction.id})">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                    </svg>
                    মুছুন
                </button>
            </div>
        </div>
    `).join('');
}

// Load summary data
async function loadSummary() {
    try {
        const response = await fetch(`/fishcare/api/income_expense.php`);
        const result = await response.json();
        
        if (result.success) {
            updateSummary(result.data);
        }
    } catch (error) {
        console.error('Summary load error:', error);
    }
}

// Update summary cards
function updateSummary(transactions) {
    let totalIncome = 0;
    let totalExpense = 0;
    
    transactions.forEach(t => {
        if (t.type === 'income') {
            totalIncome += parseFloat(t.amount);
        } else {
            totalExpense += parseFloat(t.amount);
        }
    });
    
    const balance = totalIncome - totalExpense;
    
    document.getElementById('totalIncome').textContent = formatCurrency(totalIncome);
    document.getElementById('totalExpense').textContent = formatCurrency(totalExpense);
    document.getElementById('totalBalance').textContent = formatCurrency(balance);
    
    // Update chart
    if (currentChart) {
        currentChart.data.datasets[0].data = [totalIncome, totalExpense];
        currentChart.update();
    }
}

// Update charts with new data
function updateCharts(transactions) {
    const incomeData = transactions.filter(t => t.type === 'income');
    const expenseData = transactions.filter(t => t.type === 'expense');
    
    const totalIncome = incomeData.reduce((sum, t) => sum + parseFloat(t.amount), 0);
    const totalExpense = expenseData.reduce((sum, t) => sum + parseFloat(t.amount), 0);
    
    if (currentChart) {
        currentChart.data.datasets[0].data = [totalIncome, totalExpense];
        currentChart.update();
    }
}

// Load quick stats
async function loadQuickStats() {
    try {
        const currentMonth = new Date().getMonth() + 1;
        const currentYear = new Date().getFullYear();
        const lastMonth = currentMonth === 1 ? 12 : currentMonth - 1;
        const lastMonthYear = currentMonth === 1 ? currentYear - 1 : currentYear;
        
        const response = await fetch(`/fishcare/api/income_expense.php`);
        const result = await response.json();
        
        if (result.success) {
            const currentMonthIncome = result.data
                .filter(t => t.type === 'income' && new Date(t.transaction_date).getMonth() + 1 === currentMonth)
                .reduce((sum, t) => sum + parseFloat(t.amount), 0);
            
            const lastMonthIncome = result.data
                .filter(t => t.type === 'income' && new Date(t.transaction_date).getMonth() + 1 === lastMonth)
                .reduce((sum, t) => sum + parseFloat(t.amount), 0);
            
            const averageTransaction = result.data.length > 0 
                ? result.data.reduce((sum, t) => sum + parseFloat(t.amount), 0) / result.data.length
                : 0;
            
            document.getElementById('currentMonthIncome').textContent = formatCurrency(currentMonthIncome);
            document.getElementById('lastMonthIncome').textContent = formatCurrency(lastMonthIncome);
            document.getElementById('averageTransaction').textContent = formatCurrency(averageTransaction);
            document.getElementById('totalTransactions').textContent = formatNumber(result.data.length);
        }
    } catch (error) {
        console.error('Quick stats load error:', error);
    }
}

// Event bindings
function bindEvents() {
    // Add transaction button
    document.getElementById('addTransactionBtn').addEventListener('click', openAddModal);
    
    // Modal events
    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('cancelBtn').addEventListener('click', closeModal);
    document.getElementById('modalClose')?.addEventListener('click', closeModal);
    
    // Form submission
    document.getElementById('transactionForm').addEventListener('submit', handleFormSubmit);
    
    // Filter events
    document.getElementById('applyFilter').addEventListener('click', applyFilters);
    document.getElementById('clearFilter').addEventListener('click', clearFilters);
    
    // Export events
    document.getElementById('exportPDF').addEventListener('click', exportToPDF);
    document.getElementById('exportExcel').addEventListener('click', exportToExcel);
    
    // Close modal on backdrop click
    document.querySelector('.modal-backdrop').addEventListener('click', closeModal);
    
    // Transaction type change in form
    document.getElementById('transactionTypeInput').addEventListener('change', updateCategoryOptions);
}

// Open add modal
function openAddModal() {
    document.getElementById('transactionId').value = '';
    document.getElementById('modalTitle').textContent = 'নতুন লেনদেন';
    document.getElementById('transactionForm').reset();
    setDefaultDate();
    updateCategoryOptions();
    document.getElementById('transactionModal').classList.add('active');
}

// Edit transaction
function editTransaction(id) {
    const transaction = transactionsData.find(t => t.id === id);
    if (!transaction) return;
    
    document.getElementById('transactionId').value = transaction.id;
    document.getElementById('modalTitle').textContent = 'লেনদেন সম্পাদনা';
    document.getElementById('transactionTypeInput').value = transaction.type;
    document.getElementById('amount').value = transaction.amount;
    document.getElementById('category').value = transaction.category || '';
    document.getElementById('pondId').value = transaction.pond_id || '';
    document.getElementById('transactionDate').value = transaction.transaction_date;
    document.getElementById('paymentMethod').value = transaction.payment_method || 'cash';
    document.getElementById('referenceNo').value = transaction.reference_no || '';
    document.getElementById('description').value = transaction.description || '';
    
    updateCategoryOptions();
    document.getElementById('transactionModal').classList.add('active');
}

// Delete transaction
async function deleteTransaction(id) {
    if (!confirm('আপনি কি নিশ্চিত যে এই লেনদেনটি মুছে ফেলতে চান?')) {
        return;
    }
    
    try {
        const response = await fetch('/fishcare/api/income_expense.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(result.message);
            loadTransactions();
            loadSummary();
            loadQuickStats();
        } else {
            throw new Error(result.error || 'ডিলিট ব্যর্থ');
        }
    } catch (error) {
        alert('ত্রুটি: ' + error.message);
        console.error('Delete error:', error);
    }
}

// Handle form submission
async function handleFormSubmit(e) {
    e.preventDefault();
    
    if (!validateForm('transactionForm')) {
        alert('অনুগ্রহ করে সকল প্রয়োজনীয় তথ্য পূরণ করুন');
        return;
    }
    
    const form = e.target;
    const saveBtn = document.getElementById('saveBtn');
    const btnText = saveBtn.querySelector('.btn-text');
    const btnLoading = saveBtn.querySelector('.btn-loading');
    
    // Show loading
    btnText.style.display = 'none';
    btnLoading.style.display = 'inline-flex';
    saveBtn.disabled = true;
    
    try {
        const formData = getFormData();
        const id = document.getElementById('transactionId').value;
        const method = id ? 'PUT' : 'POST';
        const url = '/fishcare/api/income_expense.php';
        
        // For PUT, include ID in URL
        const finalUrl = id ? `${url}?id=${id}` : url;
        
        const response = await fetch(finalUrl, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(result.message || 'সফলভাবে সেভ হয়েছে');
            closeModal();
            loadTransactions();
            loadSummary();
            loadQuickStats();
        } else {
            throw new Error(result.error || 'সেভ ব্যর্থ');
        }
    } catch (error) {
        alert('ত্রুটি: ' + error.message);
        console.error('Save error:', error);
    } finally {
        // Hide loading
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
        saveBtn.disabled = false;
    }
}

// Get form data
function getFormData() {
    return {
        transaction_id: document.getElementById('transactionId').value,
        type: document.getElementById('transactionTypeInput').value,
        amount: document.getElementById('amount').value,
        category: document.getElementById('category').value,
        pond_id: document.getElementById('pondId').value || null,
        transaction_date: document.getElementById('transactionDate').value,
        payment_method: document.getElementById('paymentMethod').value,
        reference_no: document.getElementById('referenceNo').value,
        description: document.getElementById('description').value
    };
}

// Update category options based on type
function updateCategoryOptions() {
    const type = document.getElementById('transactionTypeInput').value;
    const incomeCategories = document.getElementById('incomeCategories');
    const expenseCategories = document.getElementById('expenseCategories');
    const categorySelect = document.getElementById('category');
    
    // Show/hide category groups
    if (incomeCategories && expenseCategories) {
        incomeCategories.style.display = type === 'income' ? 'block' : 'none';
        expenseCategories.style.display = type === 'expense' ? 'block' : 'none';
    }
    
    // Reset selection
    categorySelect.value = '';
}

// Close modal
function closeModal() {
    document.getElementById('transactionModal').classList.remove('active');
}

// Get current filters
function getCurrentFilters() {
    const filters = {};
    
    const dateRange = document.getElementById('dateRange').value;
    if (dateRange && dateRange !== 'custom') {
        const now = new Date();
        let startDate, endDate = now.toISOString().split('T')[0];
        
        switch (dateRange) {
            case 'today':
                startDate = endDate;
                break;
            case 'week':
                startDate = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
                break;
            case 'month':
                startDate = new Date(now.getFullYear(), now.getMonth(), 1).toISOString().split('T')[0];
                break;
            case 'year':
                startDate = new Date(now.getFullYear(), 0, 1).toISOString().split('T')[0];
                break;
        }
        
        filters.start_date = startDate;
        filters.end_date = endDate;
    }
    
    const type = document.getElementById('transactionType').value;
    if (type) filters.type = type;
    
    const category = document.getElementById('categoryFilter').value;
    if (category) filters.category = category;
    
    return filters;
}

// Apply filters
function applyFilters() {
    loadTransactions();
}

// Clear filters
function clearFilters() {
    document.getElementById('dateRange').value = 'month';
    document.getElementById('transactionType').value = '';
    document.getElementById('categoryFilter').value = '';
    loadTransactions();
}

// Export to PDF (simplified)
function exportToPDF() {
    const printWindow = window.open('', '_blank');
    const transactionsHtml = transactionsData.map(t => `
        <tr>
            <td>${formatDate(t.transaction_date)}</td>
            <td>${t.type === 'income' ? 'আয়' : 'ব্যয়'}</td>
            <td>${getCategoryName(t.category)}</td>
            <td>${formatCurrency(t.amount)}</td>
            <td>${t.description || ''}</td>
        </tr>
    `).join('');
    
    printWindow.document.write(`
        <html>
            <head>
                <title>লেনদেন রিপোর্ট</title>
                <style>
                    body { font-family: 'Hind Siliguri', sans-serif; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                    .text-right { text-align: right; }
                </style>
            </head>
            <body>
                <h1>লেনদেন রিপোর্ট</h1>
                <table>
                    <thead>
                        <tr>
                            <th>তারিখ</th>
                            <th>টাইপ</th>
                            <th>ক্যাটাগরি</th>
                            <th>টাকার পরিমাণ</th>
                            <th>বিবরণ</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${transactionsHtml}
                    </tbody>
                </table>
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// Export to Excel (simplified)
function exportToExcel() {
    const headers = ['তারিখ', 'টাইপ', 'ক্যাটাগরি', 'টাকার পরিমাণ', 'বিবরণ'];
    const rows = transactionsData.map(t => [
        formatDate(t.transaction_date),
        t.type === 'income' ? 'আয়' : 'ব্যয়',
        getCategoryName(t.category),
        t.amount,
        t.description || ''
    ]);
    
    const csvContent = [headers, ...rows]
        .map(row => row.map(field => `"${field}"`).join(','))
        .join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `transactions_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
}

// Utility functions
function showLoading(container) {
    container.innerHTML = `
        <div class="loading">
            <div class="spinner"></div>
            <p>লেনদেন লোড হচ্ছে...</p>
        </div>
    `;
}

function showError(container, message) {
    container.innerHTML = `
        <div class="error-message">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" style="color: var(--color-error);">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <p>${message}</p>
        </div>
    `;
}

function getCategoryName(category) {
    const categories = {
        'fish_sale': 'মাছ বিক্রয়',
        'pond_rental': 'পুকুর ভাড়া',
        'other_income': 'অন্যান্য আয়',
        'seed_purchase': 'পোনা ক্রয়',
        'feed': 'খাদ্য',
        'medicine': 'ওষুধ',
        'labor': 'শ্রমিক',
        'equipment': 'যন্ত্রপাতি',
        'transport': 'পরিবহন',
        'utilities': 'ইউটিলিটি',
        'other_expense': 'অন্যান্য ব্যয়'
    };
    return categories[category] || category;
}

function getPaymentMethodName(method) {
    const methods = {
        'cash': 'নগদ',
        'bank': 'ব্যাংক',
        'mobile_banking': 'মোবাইল ব্যাংকিং',
        'other': 'অন্যান্য'
    };
    return methods[method] || method;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('bn-BD');
}

function formatNumber(num) {
    return new Intl.NumberFormat('bn-BD').format(num);
}

function formatCurrency(amount) {
    return '৳' + new Intl.NumberFormat('bn-BD', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
}

// Global functions for onclick events
window.openAddModal = openAddModal;
window.editTransaction = editTransaction;
window.deleteTransaction = deleteTransaction;
</script>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
