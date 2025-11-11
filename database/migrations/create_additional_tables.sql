-- শিপমেন্ট টেবিল
CREATE TABLE IF NOT EXISTS shipments (
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
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_tracking (tracking_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- নোটিফিকেশন টেবিল
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'danger') DEFAULT 'info',
    is_read BOOLEAN DEFAULT FALSE,
    link VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_read (user_id, is_read),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- উইশলিস্ট টেবিল
CREATE TABLE IF NOT EXISTS wishlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (user_id, product_id),
    INDEX idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- স্টক মুভমেন্ট টেবিল
CREATE TABLE IF NOT EXISTS stock_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('in', 'out') NOT NULL,
    quantity INT NOT NULL,
    reference_type VARCHAR(50) NULL COMMENT 'invoice, adjustment, etc',
    reference_id INT NULL,
    notes TEXT NULL,
    movement_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_product (product_id),
    INDEX idx_user (user_id),
    INDEX idx_date (movement_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- সিস্টেম সেটিংস টেবিল
CREATE TABLE IF NOT EXISTS system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT NULL,
    setting_type ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    description VARCHAR(255) NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- স্যাম্পল শিপমেন্ট ডেটা (টেস্টিং এর জন্য)
INSERT INTO shipments (user_id, tracking_number, destination, status, shipped_date, delivery_date, items_count, notes) VALUES
((SELECT id FROM users WHERE role = 'wholesaler' LIMIT 1), 'SHP-2024-001', 'ঢাকা, মিরপুর', 'delivered', '2024-01-15', '2024-01-18', 25, 'সফলভাবে ডেলিভার সম্পন্ন'),
((SELECT id FROM users WHERE role = 'wholesaler' LIMIT 1), 'SHP-2024-002', 'চট্টগ্রাম, আগ্রাবাদ', 'in_transit', '2024-01-20', NULL, 40, 'পথে আছে'),
((SELECT id FROM users WHERE role = 'wholesaler' LIMIT 1), 'SHP-2024-003', 'খুলনা, ডৌলতপুর', 'pending', NULL, NULL, 30, 'প্রস্তুতি চলছে');

-- স্যাম্পল নোটিফিকেশন
INSERT INTO notifications (user_id, title, message, type, link) VALUES
((SELECT id FROM users WHERE role = 'admin' LIMIT 1), 'নতুন ব্যবহারকারী নিবন্ধন', '১ জন নতুন ব্যবহারকারী নিবন্ধন করেছেন', 'info', '/pages/dashboard/admin/users.php'),
((SELECT id FROM users WHERE role = 'wholesaler' LIMIT 1), 'স্টক কম', 'রুই মাছের খাদ্য - স্টক ১০ এর নিচে', 'warning', '/pages/dashboard/wholesaler/inventory.php'),
((SELECT id FROM users WHERE role = 'seller' LIMIT 1), 'নতুন অর্ডার', 'আপনার একটি নতুন অর্ডার এসেছে', 'success', '/pages/dashboard/seller/orders.php');
