<?php
/**
 * Report Generation API
 * রিপোর্ট জেনারেশন
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

// শুধু লগইন ইউজার
if (!isLoggedIn()) {
    jsonResponse(['success' => false, 'error' => 'লগইন প্রয়োজন'], 401);
}

$db = getDB();
$userId = getUserId();
$userRole = getUserRole();

try {
    $reportType = $_GET['type'] ?? 'summary';
    $startDate = $_GET['start_date'] ?? date('Y-m-01'); // মাসের প্রথম দিন
    $endDate = $_GET['end_date'] ?? date('Y-m-d'); // আজকের তারিখ
    
    switch ($reportType) {
        case 'financial_summary':
            // আর্থিক সারসংক্ষেপ (চাষী, বিক্রেতা, হোলসেলার)
            $stmt = $db->prepare("
                SELECT 
                    SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income,
                    SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense,
                    COUNT(*) as transaction_count
                FROM income_expenses 
                WHERE user_id = ? AND transaction_date BETWEEN ? AND ?
            ");
            $stmt->execute([$userId, $startDate, $endDate]);
            $summary = $stmt->fetch();
            
            $summary['profit'] = $summary['total_income'] - $summary['total_expense'];
            $summary['start_date'] = $startDate;
            $summary['end_date'] = $endDate;
            
            jsonResponse(['success' => true, 'data' => $summary]);
            break;
            
        case 'monthly_trend':
            // মাসিক ট্রেন্ড (চার্টের জন্য)
            $stmt = $db->prepare("
                SELECT 
                    DATE_FORMAT(transaction_date, '%Y-%m') as month,
                    SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income,
                    SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense
                FROM income_expenses 
                WHERE user_id = ? AND transaction_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY month
                ORDER BY month ASC
            ");
            $stmt->execute([$userId]);
            $trend = $stmt->fetchAll();
            
            jsonResponse(['success' => true, 'data' => $trend]);
            break;
            
        case 'category_breakdown':
            // ক্যাটেগরি ভিত্তিক ব্রেকডাউন
            $type = $_GET['transaction_type'] ?? 'expense';
            
            $stmt = $db->prepare("
                SELECT 
                    category,
                    SUM(amount) as total,
                    COUNT(*) as count
                FROM income_expenses 
                WHERE user_id = ? AND type = ? AND transaction_date BETWEEN ? AND ?
                GROUP BY category
                ORDER BY total DESC
            ");
            $stmt->execute([$userId, $type, $startDate, $endDate]);
            $breakdown = $stmt->fetchAll();
            
            jsonResponse(['success' => true, 'data' => $breakdown]);
            break;
            
        case 'invoice_summary':
            // ইনভয়েস সারসংক্ষেপ (হোলসেলার)
            if ($userRole !== 'wholesaler') {
                jsonResponse(['success' => false, 'error' => 'শুধু হোলসেলারদের জন্য'], 403);
            }
            
            $stmt = $db->prepare("
                SELECT 
                    COUNT(*) as total_invoices,
                    SUM(grand_total) as total_amount,
                    SUM(paid_amount) as paid_amount,
                    SUM(due_amount) as due_amount,
                    SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_count,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count
                FROM invoices 
                WHERE user_id = ? AND invoice_date BETWEEN ? AND ?
            ");
            $stmt->execute([$userId, $startDate, $endDate]);
            $summary = $stmt->fetch();
            
            jsonResponse(['success' => true, 'data' => $summary]);
            break;
            
        case 'sales_summary':
            // বিক্রয় সারসংক্ষেপ (বিক্রেতা)
            if ($userRole !== 'seller') {
                jsonResponse(['success' => false, 'error' => 'শুধু বিক্রেতাদের জন্য'], 403);
            }
            
            $stmt = $db->prepare("
                SELECT 
                    COUNT(*) as total_sales,
                    SUM(total_amount) as total_amount,
                    SUM(paid_amount) as paid_amount,
                    AVG(total_amount) as average_sale
                FROM sales 
                WHERE user_id = ? AND sale_date BETWEEN ? AND ?
            ");
            $stmt->execute([$userId, $startDate, $endDate]);
            $summary = $stmt->fetch();
            
            jsonResponse(['success' => true, 'data' => $summary]);
            break;
            
        case 'top_products':
            // সবচেয়ে বেশি বিক্রিত পণ্য (বিক্রেতা)
            if ($userRole !== 'seller') {
                jsonResponse(['success' => false, 'error' => 'শুধু বিক্রেতাদের জন্য'], 403);
            }
            
            $stmt = $db->prepare("
                SELECT 
                    product_name,
                    SUM(quantity) as total_quantity,
                    SUM(total_amount) as total_amount,
                    COUNT(*) as sale_count
                FROM sales 
                WHERE user_id = ? AND sale_date BETWEEN ? AND ?
                GROUP BY product_name
                ORDER BY total_amount DESC
                LIMIT 10
            ");
            $stmt->execute([$userId, $startDate, $endDate]);
            $products = $stmt->fetchAll();
            
            jsonResponse(['success' => true, 'data' => $products]);
            break;
            
        case 'admin_overview':
            // অ্যাডমিন ওভারভিউ
            if ($userRole !== 'admin') {
                jsonResponse(['success' => false, 'error' => 'শুধু অ্যাডমিনদের জন্য'], 403);
            }
            
            // মোট ইউজার
            $stmt = $db->query("SELECT COUNT(*) as count FROM users");
            $userCount = $stmt->fetch()['count'];
            
            // মোট লেনদেন
            $stmt = $db->query("SELECT COUNT(*) as count FROM income_expenses");
            $transactionCount = $stmt->fetch()['count'];
            
            // মোট ইনভয়েস
            $stmt = $db->query("SELECT COUNT(*) as count FROM invoices");
            $invoiceCount = $stmt->fetch()['count'];
            
            // রোল ভিত্তিক ইউজার
            $stmt = $db->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
            $roleDistribution = $stmt->fetchAll();
            
            $summary = [
                'total_users' => $userCount,
                'total_transactions' => $transactionCount,
                'total_invoices' => $invoiceCount,
                'role_distribution' => $roleDistribution
            ];
            
            jsonResponse(['success' => true, 'data' => $summary]);
            break;
            
        default:
            jsonResponse(['success' => false, 'error' => 'অজানা রিপোর্ট টাইপ'], 400);
    }
    
} catch (PDOException $e) {
    error_log("Report API Error: " . $e->getMessage());
    jsonResponse(['success' => false, 'error' => 'ডেটাবেস ত্রুটি'], 500);
}
