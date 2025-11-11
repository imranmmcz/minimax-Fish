<?php
/**
 * Pond Management API
 * চাষীদের পুকুর ব্যবস্থাপনা
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

// শুধু লগইন ইউজার এবং চাষী
if (!isLoggedIn() || !hasRole('farmer')) {
    jsonResponse(['success' => false, 'error' => 'অনুমতি নেই'], 403);
}

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();
$userId = getUserId();

try {
    switch ($method) {
        case 'GET':
            // পুকুর তালিকা পান
            if (isset($_GET['id'])) {
                // নির্দিষ্ট পুকুর
                $stmt = $db->prepare("SELECT * FROM ponds WHERE id = ? AND user_id = ?");
                $stmt->execute([$_GET['id'], $userId]);
                $pond = $stmt->fetch();
                
                if ($pond) {
                    jsonResponse(['success' => true, 'data' => $pond]);
                } else {
                    jsonResponse(['success' => false, 'error' => 'পুকুর পাওয়া যায়নি'], 404);
                }
            } else {
                // সব পুকুর
                $stmt = $db->prepare("SELECT * FROM ponds WHERE user_id = ? ORDER BY created_at DESC");
                $stmt->execute([$userId]);
                $ponds = $stmt->fetchAll();
                
                jsonResponse(['success' => true, 'data' => $ponds]);
            }
            break;
            
        case 'POST':
            // নতুন পুকুর যোগ করুন
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['name'])) {
                jsonResponse(['success' => false, 'error' => 'পুকুরের নাম প্রয়োজন'], 400);
            }
            
            $stmt = $db->prepare("
                INSERT INTO ponds (user_id, name, location, area_size, area_unit, water_depth, notes)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $userId,
                $data['name'],
                $data['location'] ?? null,
                $data['area_size'] ?? null,
                $data['area_unit'] ?? 'shotok',
                $data['water_depth'] ?? null,
                $data['notes'] ?? null
            ]);
            
            if ($result) {
                $pondId = $db->lastInsertId();
                logActivity('pond_created', "নতুন পুকুর তৈরি: {$data['name']}");
                jsonResponse(['success' => true, 'id' => $pondId, 'message' => 'পুকুর সফলভাবে যোগ হয়েছে']);
            } else {
                jsonResponse(['success' => false, 'error' => 'পুকুর যোগ ব্যর্থ'], 500);
            }
            break;
            
        case 'PUT':
            // পুকুর আপডেট করুন
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                jsonResponse(['success' => false, 'error' => 'পুকুর ID প্রয়োজন'], 400);
            }
            
            $stmt = $db->prepare("
                UPDATE ponds 
                SET name = ?, location = ?, area_size = ?, area_unit = ?, 
                    water_depth = ?, status = ?, notes = ?, updated_at = NOW()
                WHERE id = ? AND user_id = ?
            ");
            
            $result = $stmt->execute([
                $data['name'],
                $data['location'] ?? null,
                $data['area_size'] ?? null,
                $data['area_unit'] ?? 'shotok',
                $data['water_depth'] ?? null,
                $data['status'] ?? 'active',
                $data['notes'] ?? null,
                $data['id'],
                $userId
            ]);
            
            if ($result) {
                logActivity('pond_updated', "পুকুর আপডেট: {$data['name']}");
                jsonResponse(['success' => true, 'message' => 'পুকুর আপডেট হয়েছে']);
            } else {
                jsonResponse(['success' => false, 'error' => 'আপডেট ব্যর্থ'], 500);
            }
            break;
            
        case 'DELETE':
            // পুকুর ডিলিট করুন
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['id'])) {
                jsonResponse(['success' => false, 'error' => 'পুকুর ID প্রয়োজন'], 400);
            }
            
            $stmt = $db->prepare("DELETE FROM ponds WHERE id = ? AND user_id = ?");
            $result = $stmt->execute([$data['id'], $userId]);
            
            if ($result) {
                logActivity('pond_deleted', "পুকুর ডিলিট করা হয়েছে");
                jsonResponse(['success' => true, 'message' => 'পুকুর ডিলিট হয়েছে']);
            } else {
                jsonResponse(['success' => false, 'error' => 'ডিলিট ব্যর্থ'], 500);
            }
            break;
            
        default:
            jsonResponse(['success' => false, 'error' => 'Invalid method'], 405);
    }
    
} catch (PDOException $e) {
    error_log("Pond API Error: " . $e->getMessage());
    jsonResponse(['success' => false, 'error' => 'ডেটাবেস ত্রুটি'], 500);
}
