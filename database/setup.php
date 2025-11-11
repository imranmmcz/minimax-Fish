<?php
/**
 * Database Setup Script
 * Run this file once to create all necessary tables
 */

require_once __DIR__ . '/../config/database.php';

$db = getDB();

try {
    echo "=== ডেটাবেস সেটআপ শুরু ===\n\n";
    
    // Create shipments table
    echo "১. শিপমেন্ট টেবিল তৈরি হচ্ছে...\n";
    $db->exec("CREATE TABLE IF NOT EXISTS shipments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        tracking_number VARCHAR(50) UNIQUE NOT NULL,
        destination VARCHAR(255) NOT NULL,
        status ENUM('pending', 'in_transit', 'delivered', 'cancelled') DEFAULT 'pending',
        shipped_date DATE NULL,
        delivery_date DATE NULL,
        items_count INT DEFAULT 0,
        notes TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_user_id (user_id),
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "   ✓ সম্পন্ন\n\n";
    
    // Create notifications table
    echo "২. নোটিফিকেশন টেবিল তৈরি হচ্ছে...\n";
    $db->exec("CREATE TABLE IF NOT EXISTS notifications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        type ENUM('info', 'success', 'warning', 'danger') DEFAULT 'info',
        is_read BOOLEAN DEFAULT FALSE,
        link VARCHAR(255) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user_read (user_id, is_read)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "   ✓ সম্পন্ন\n\n";
    
    // Create wishlists table
    echo "৩. উইশলিস্ট টেবিল তৈরি হচ্ছে...\n";
    $db->exec("CREATE TABLE IF NOT EXISTS wishlists (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_wishlist (user_id, product_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "   ✓ সম্পন্ন\n\n";
    
    // Insert sample data for testing
    echo "৪. নমুনা ডেটা যোগ করা হচ্ছে...\n";
    
    // Get first wholesaler user
    $stmt = $db->query("SELECT id FROM users WHERE role = 'wholesaler' LIMIT 1");
    $wholesalerId = $stmt->fetchColumn();
    
    if ($wholesalerId) {
        $db->exec("INSERT IGNORE INTO shipments (user_id, tracking_number, destination, status, shipped_date, items_count) VALUES
            ($wholesalerId, 'SHP-2024-001', 'ঢাকা, মিরপুর', 'delivered', '2024-01-15', 25),
            ($wholesalerId, 'SHP-2024-002', 'চট্টগ্রাম, আগ্রাবাদ', 'in_transit', '2024-01-20', 40),
            ($wholesalerId, 'SHP-2024-003', 'খুলনা, ডৌলতপুর', 'pending', NULL, 30)");
        echo "   ✓ শিপমেন্ট ডেটা যোগ হয়েছে\n";
        
        $db->exec("INSERT IGNORE INTO notifications (user_id, title, message, type) VALUES
            ($wholesalerId, 'স্টক সতর্কতা', 'রুই মাছের খাদ্য - স্টক কম', 'warning'),
            ($wholesalerId, 'নতুন অর্ডার', 'নতুন অর্ডার এসেছে', 'success')");
        echo "   ✓ নোটিফিকেশন ডেটা যোগ হয়েছে\n";
    }
    
    echo "\n=== সেটআপ সফলভাবে সম্পন্ন ===\n";
    echo "সব টেবিল তৈরি এবং নমুনা ডেটা যোগ করা হয়েছে।\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
