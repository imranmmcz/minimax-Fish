<?php
/**
 * Income & Expense API
 * আয়-ব্যয় ব্যবস্থাপনা
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

// শুধু লগইন ইউজার
if (!isLoggedIn()) {
    jsonResponse(['success' => false, 'error' => 'লগইন প্রয়োজন'], 401);
}

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();
$userId = getUserId();

try {
    switch ($method) {
        case 'GET':
            // লেনদেন তালিকা
            $type = $_GET['type'] ?? null; // 'income' or 'expense'
            $pondId = $_GET['pond_id'] ?? null;
            $startDate = $_GET['start_date'] ?? null;
            $endDate = $_GET['end_date'] ?? null;
            
            $sql = "SELECT * FROM income_expenses WHERE user_id = ?";
            $params = [$userId];
            
            if ($type) {
                $sql .= " AND type = ?";
                $params[] = $type;
            }
            
            if ($pondId) {
                $sql .= " AND pond_id = ?";
                $params[] = $pondId;
            }
            
            if ($startDate) {
                $sql .= " AND transaction_date >= ?";
                $params[] = $startDate;
            }
            
            if ($endDate) {
                $sql .= " AND transaction_date <= ?";
                $params[] = $endDate;
            }
            
            $sql .= " ORDER BY transaction_date DESC, created_at DESC";
            
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $transactions = $stmt->fetchAll();
            
            jsonResponse(['success' => true, 'data' => $transactions]);
            break;
            
        case 'POST':
            // নতুন আয়/ব্যয় যোগ
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['type']) || empty($data['amount']) || empty($data['transaction_date'])) {
                jsonResponse(['success' => false, 'error' => 'প্রয়োজনীয় তথ্য দিন'], 400);
            }
            
            $stmt = $db->prepare("
                INSERT INTO income_expenses 
                (user_id, pond_id, type, category, amount, description, transaction_date, payment_method, reference_no)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $userId,
                $data['pond_id'] ?? null,
                $data['type'],
                $data['category'] ?? null,
                $data['amount'],
                $data['description'] ?? null,
                $data['transaction_date'],
                $data['payment_method'] ?? 'cash',
                $data['reference_no'] ?? null
            ]);
            
            if ($result) {
                $id = $db->lastInsertId();
                $typeText = $data['type'] === 'income' ? 'আয়' : 'ব্যয়';
                logActivity('transaction_added', "{$typeText} যোগ: ৳{$data['amount']}");
                jsonResponse(['success' => true, 'id' => $id, 'message' => "{$typeText} সফলভাবে যোগ হয়েছে"]);
            } else {
                jsonResponse(['success' => false, 'error' => 'যোগ করা ব্যর্থ'], 500);
            }
            break;
            
        case 'DELETE':
            // লেনদেন ডিলিট
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                jsonResponse(['success' => false, 'error' => 'ID প্রয়োজন'], 400);
            }
            
            $stmt = $db->prepare("DELETE FROM income_expenses WHERE id = ? AND user_id = ?");
            $result = $stmt->execute([$data['id'], $userId]);
            
            if ($result) {
                logActivity('transaction_deleted', "লেনদেন ডিলিট");
                jsonResponse(['success' => true, 'message' => 'লেনদেন ডিলিট হয়েছে']);
            } else {
                jsonResponse(['success' => false, 'error' => 'ডিলিট ব্যর্থ'], 500);
            }
            break;
            
        default:
            jsonResponse(['success' => false, 'error' => 'Invalid method'], 405);
    }
    
} catch (PDOException $e) {
    error_log("Income Expense API Error: " . $e->getMessage());
    jsonResponse(['success' => false, 'error' => 'ডেটাবেস ত্রুটি'], 500);
}
