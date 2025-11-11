<?php
/**
 * Invoice Management API
 * হোলসেলারদের ইনভয়েস ব্যবস্থাপনা
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

// শুধু হোলসেলার
if (!isLoggedIn() || !hasRole('wholesaler')) {
    jsonResponse(['success' => false, 'error' => 'অনুমতি নেই'], 403);
}

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();
$userId = getUserId();

try {
    switch ($method) {
        case 'GET':
            // ইনভয়েস তালিকা
            if (isset($_GET['id'])) {
                // নির্দিষ্ট ইনভয়েস এবং আইটেম
                $stmt = $db->prepare("SELECT * FROM invoices WHERE id = ? AND user_id = ?");
                $stmt->execute([$_GET['id'], $userId]);
                $invoice = $stmt->fetch();
                
                if ($invoice) {
                    // ইনভয়েস আইটেম লোড করুন
                    $stmt = $db->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
                    $stmt->execute([$_GET['id']]);
                    $invoice['items'] = $stmt->fetchAll();
                    
                    jsonResponse(['success' => true, 'data' => $invoice]);
                } else {
                    jsonResponse(['success' => false, 'error' => 'ইনভয়েস পাওয়া যায়নি'], 404);
                }
            } else {
                // সব ইনভয়েস
                $status = $_GET['status'] ?? null;
                $sql = "SELECT * FROM invoices WHERE user_id = ?";
                $params = [$userId];
                
                if ($status) {
                    $sql .= " AND status = ?";
                    $params[] = $status;
                }
                
                $sql .= " ORDER BY invoice_date DESC, created_at DESC";
                
                $stmt = $db->prepare($sql);
                $stmt->execute($params);
                $invoices = $stmt->fetchAll();
                
                jsonResponse(['success' => true, 'data' => $invoices]);
            }
            break;
            
        case 'POST':
            // নতুন ইনভয়েস তৈরি
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['customer_name']) || empty($data['items'])) {
                jsonResponse(['success' => false, 'error' => 'প্রয়োজনীয় তথ্য দিন'], 400);
            }
            
            // ইনভয়েস নম্বর তৈরি
            $invoiceNo = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
            
            // টোটাল ক্যালকুলেট করুন
            $totalAmount = 0;
            foreach ($data['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['rate'];
            }
            
            $discount = $data['discount'] ?? 0;
            $grandTotal = $totalAmount - $discount;
            
            // ইনভয়েস ইনসার্ট করুন
            $stmt = $db->prepare("
                INSERT INTO invoices 
                (user_id, invoice_no, customer_name, customer_phone, customer_address, 
                 total_amount, discount, grand_total, invoice_date, due_date, notes)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $userId,
                $invoiceNo,
                $data['customer_name'],
                $data['customer_phone'] ?? null,
                $data['customer_address'] ?? null,
                $totalAmount,
                $discount,
                $grandTotal,
                $data['invoice_date'] ?? date('Y-m-d'),
                $data['due_date'] ?? null,
                $data['notes'] ?? null
            ]);
            
            if ($result) {
                $invoiceId = $db->lastInsertId();
                
                // ইনভয়েস আইটেম ইনসার্ট করুন
                $stmt = $db->prepare("
                    INSERT INTO invoice_items (invoice_id, item_name, description, quantity, unit, rate, total)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                
                foreach ($data['items'] as $item) {
                    $itemTotal = $item['quantity'] * $item['rate'];
                    $stmt->execute([
                        $invoiceId,
                        $item['name'],
                        $item['description'] ?? null,
                        $item['quantity'],
                        $item['unit'] ?? 'kg',
                        $item['rate'],
                        $itemTotal
                    ]);
                }
                
                logActivity('invoice_created', "ইনভয়েস তৈরি: {$invoiceNo}");
                jsonResponse(['success' => true, 'id' => $invoiceId, 'invoice_no' => $invoiceNo]);
            } else {
                jsonResponse(['success' => false, 'error' => 'ইনভয়েস তৈরি ব্যর্থ'], 500);
            }
            break;
            
        case 'PUT':
            // ইনভয়েস স্ট্যাটাস আপডেট
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id']) || empty($data['status'])) {
                jsonResponse(['success' => false, 'error' => 'ID এবং স্ট্যাটাস প্রয়োজন'], 400);
            }
            
            $stmt = $db->prepare("
                UPDATE invoices 
                SET status = ?, paid_amount = ?, due_amount = ?, updated_at = NOW()
                WHERE id = ? AND user_id = ?
            ");
            
            $paidAmount = $data['paid_amount'] ?? 0;
            
            // Calculate due amount
            $stmtInv = $db->prepare("SELECT grand_total FROM invoices WHERE id = ?");
            $stmtInv->execute([$data['id']]);
            $invoice = $stmtInv->fetch();
            $dueAmount = $invoice['grand_total'] - $paidAmount;
            
            $result = $stmt->execute([
                $data['status'],
                $paidAmount,
                $dueAmount,
                $data['id'],
                $userId
            ]);
            
            if ($result) {
                logActivity('invoice_updated', "ইনভয়েস আপডেট");
                jsonResponse(['success' => true, 'message' => 'ইনভয়েস আপডেট হয়েছে']);
            } else {
                jsonResponse(['success' => false, 'error' => 'আপডেট ব্যর্থ'], 500);
            }
            break;
            
        default:
            jsonResponse(['success' => false, 'error' => 'Invalid method'], 405);
    }
    
} catch (PDOException $e) {
    error_log("Invoice API Error: " . $e->getMessage());
    jsonResponse(['success' => false, 'error' => 'ডেটাবেস ত্রুটি'], 500);
}
