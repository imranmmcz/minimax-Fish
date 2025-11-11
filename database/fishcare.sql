-- ফিশ কেয়ার সিস্টেম ডেটাবেস স্কিমা
-- তৈরি: ২০২৫-১১-০৩
-- MySQL 5.7+

-- ডেটাবেস তৈরি
CREATE DATABASE IF NOT EXISTS fishcare CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fishcare;

-- ১. ইউজার টেবিল (6 রোল: admin, wholesaler, seller, customer, farmer, visitor)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- bcrypt hashed
    role ENUM('admin', 'wholesaler', 'seller', 'customer', 'farmer', 'visitor') NOT NULL DEFAULT 'visitor',
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    division_id INT,
    district_id INT,
    upazila_id INT,
    address TEXT,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role (role),
    INDEX idx_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ২. বিভাগ টেবিল (বাংলাদেশের 8টি বিভাগ)
CREATE TABLE divisions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    name_en VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ৩. জেলা টেবিল
CREATE TABLE districts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    name_en VARCHAR(100) NOT NULL,
    division_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_division (division_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ৪. উপজেলা টেবিল
CREATE TABLE upazilas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    name_en VARCHAR(100) NOT NULL,
    district_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_district (district_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ৫. মাছের প্রজাতি টেবিল
CREATE TABLE fish_species (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    name_en VARCHAR(255),
    description TEXT,
    image_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ৬. মাছের রোগ টেবিল
CREATE TABLE fish_diseases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    name_en VARCHAR(255),
    symptoms TEXT,
    treatment TEXT,
    prevention TEXT,
    image_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ৭. পুকুর টেবিল (চাষীদের জন্য)
CREATE TABLE ponds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(500),
    area_size DECIMAL(10,2), -- শতক বা বিঘায়
    area_unit ENUM('shotok', 'bigha', 'acre') DEFAULT 'shotok',
    water_depth DECIMAL(5,2), -- ফুটে
    status ENUM('active', 'inactive', 'maintenance') DEFAULT 'active',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ৮. আয়-ব্যয় টেবিল
CREATE TABLE income_expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pond_id INT,
    type ENUM('income', 'expense') NOT NULL,
    category VARCHAR(100),
    amount DECIMAL(12,2) NOT NULL,
    description TEXT,
    transaction_date DATE NOT NULL,
    payment_method ENUM('cash', 'bank', 'mobile_banking', 'other') DEFAULT 'cash',
    reference_no VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_pond (pond_id),
    INDEX idx_type (type),
    INDEX idx_date (transaction_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ৯. লেনদেন টেবিল (সাধারণ লেনদেন রেকর্ড)
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('sale', 'purchase', 'payment', 'receipt', 'other') NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    description TEXT,
    customer_name VARCHAR(255),
    reference_id INT,
    transaction_date DATE NOT NULL,
    status ENUM('completed', 'pending', 'cancelled') DEFAULT 'completed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_type (type),
    INDEX idx_date (transaction_date),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ১০. ইনভয়েস টেবিল (হোলসেলারদের জন্য)
CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    invoice_no VARCHAR(50) UNIQUE NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20),
    customer_address TEXT,
    total_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    discount DECIMAL(12,2) DEFAULT 0,
    grand_total DECIMAL(12,2) NOT NULL DEFAULT 0,
    paid_amount DECIMAL(12,2) DEFAULT 0,
    due_amount DECIMAL(12,2) DEFAULT 0,
    status ENUM('draft', 'pending', 'paid', 'partial', 'cancelled') DEFAULT 'pending',
    invoice_date DATE NOT NULL,
    due_date DATE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_invoice_no (invoice_no),
    INDEX idx_status (status),
    INDEX idx_date (invoice_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ১১. ইনভয়েস আইটেম টেবিল
CREATE TABLE invoice_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    description TEXT,
    quantity DECIMAL(10,2) NOT NULL,
    unit VARCHAR(50) DEFAULT 'kg',
    rate DECIMAL(10,2) NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_invoice (invoice_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ১২. শিপমেন্ট টেবিল (হোলসেলারদের জন্য)
CREATE TABLE shipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    invoice_id INT,
    destination VARCHAR(500) NOT NULL,
    shipping_date DATE NOT NULL,
    delivery_date DATE,
    vehicle_no VARCHAR(50),
    driver_name VARCHAR(255),
    driver_phone VARCHAR(20),
    status ENUM('pending', 'in_transit', 'delivered', 'cancelled') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_invoice (invoice_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ১৩. বিক্রয় টেবিল (বিক্রেতাদের জন্য)
CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity DECIMAL(10,2) NOT NULL,
    unit VARCHAR(50) DEFAULT 'kg',
    rate DECIMAL(10,2) NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL,
    customer_name VARCHAR(255),
    customer_phone VARCHAR(20),
    sale_date DATE NOT NULL,
    payment_status ENUM('paid', 'unpaid', 'partial') DEFAULT 'paid',
    paid_amount DECIMAL(12,2) DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_date (sale_date),
    INDEX idx_payment_status (payment_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ১৪. স্টক টেবিল
CREATE TABLE stocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity DECIMAL(10,2) NOT NULL DEFAULT 0,
    unit VARCHAR(50) DEFAULT 'kg',
    min_stock_level DECIMAL(10,2) DEFAULT 0,
    purchase_rate DECIMAL(10,2),
    selling_rate DECIMAL(10,2),
    last_updated DATE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_product (product_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ১৫. বাজার মূল্য টেবিল
CREATE TABLE market_prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fish_species_id INT,
    product_name VARCHAR(255) NOT NULL,
    price_per_kg DECIMAL(10,2) NOT NULL,
    location VARCHAR(255),
    market_name VARCHAR(255),
    price_date DATE NOT NULL,
    source VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_product (product_name),
    INDEX idx_date (price_date),
    INDEX idx_location (location)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ১৬. প্রোফাইল আপডেট লগ টেবিল
CREATE TABLE profile_updates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    field_name VARCHAR(100),
    old_value TEXT,
    new_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ১৭. সিস্টেম লগ টেবিল
CREATE TABLE system_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(50),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_action (action),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ১৮. বিশেষজ্ঞের জিজ্ঞাসা টেবিল (ফোরাম/Q&A)
CREATE TABLE expert_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(500) NOT NULL,
    question TEXT NOT NULL,
    category VARCHAR(100),
    status ENUM('pending', 'answered', 'closed') DEFAULT 'pending',
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ১৯. বিশেষজ্ঞের উত্তর টেবিল
CREATE TABLE expert_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    user_id INT NOT NULL,
    answer TEXT NOT NULL,
    is_expert BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_question (question_id),
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- স্যাম্পল ডেটা ইনসার্ট

-- বিভাগ সমূহ
INSERT INTO divisions (name, name_en) VALUES
('ঢাকা', 'Dhaka'),
('চট্টগ্রাম', 'Chattogram'),
('রাজশাহী', 'Rajshahi'),
('খুলনা', 'Khulna'),
('বরিশাল', 'Barishal'),
('সিলেট', 'Sylhet'),
('রংপুর', 'Rangpur'),
('ময়মনসিংহ', 'Mymensingh');

-- নমুনা জেলা (ঢাকা বিভাগ)
INSERT INTO districts (name, name_en, division_id) VALUES
('ঢাকা', 'Dhaka', 1),
('গাজীপুর', 'Gazipur', 1),
('নারায়ণগঞ্জ', 'Narayanganj', 1),
('টাঙ্গাইল', 'Tangail', 1),
('কিশোরগঞ্জ', 'Kishoreganj', 1);

-- নমুনা উপজেলা (ঢাকা জেলা)
INSERT INTO upazilas (name, name_en, district_id) VALUES
('ধামরাই', 'Dhamrai', 1),
('সাভার', 'Savar', 1),
('কেরানীগঞ্জ', 'Keraniganj', 1),
('নবাবগঞ্জ', 'Nawabganj', 1),
('দোহার', 'Dohar', 1);

-- মাছের প্রজাতি
INSERT INTO fish_species (name, name_en, description) VALUES
('রুই', 'Rohu', 'বাংলাদেশের অন্যতম জনপ্রিয় মাছ, দ্রুত বৃদ্ধি পায়'),
('কাতলা', 'Catla', 'বড় আকারের মাছ, পুকুর চাষের জন্য উপযুক্ত'),
('মৃগেল', 'Mrigal', 'মিষ্টি পানির মাছ, চাষ সহজ'),
('সিলভার কার্প', 'Silver Carp', 'দ্রুত বর্ধনশীল, সাশ্রয়ী খাদ্য'),
('গ্রাস কার্প', 'Grass Carp', 'ঘাস খায়, পুকুর পরিষ্কার রাখে'),
('তেলাপিয়া', 'Tilapia', 'অত্যন্ত জনপ্রিয়, দ্রুত বৃদ্ধি'),
('পাঙ্গাস', 'Pangas', 'বাণিজ্যিক চাষের জন্য লাভজনক'),
('শিং', 'Stinging Catfish', 'ছোট পুকুরে চাষযোগ্য, পুষ্টিকর');

-- মাছের রোগ
INSERT INTO fish_diseases (name, name_en, symptoms, treatment, prevention) VALUES
('সাদা দাগ রোগ', 'White Spot Disease', 'শরীরে সাদা দাগ, খাদ্য গ্রহণে অনীহা', 'লবণ স্নান, তাপমাত্রা বৃদ্ধি', 'পানির গুণমান বজায় রাখা'),
('লেজ ও পাখনা পচা', 'Fin Rot', 'পাখনা ও লেজ ক্ষয়, রক্তক্ষরণ', 'অ্যান্টিবায়োটিক প্রয়োগ', 'পরিষ্কার পানি রাখা'),
('ড্রপসি', 'Dropsy', 'পেট ফোলা, আঁশ উঠে যাওয়া', 'লবণ স্নান, ওষুধ প্রয়োগ', 'স্বাস্থ্যকর খাদ্য'),
('ছত্রাক সংক্রমণ', 'Fungal Infection', 'শরীরে তুলার মতো বৃদ্ধি', 'অ্যান্টি-ফাঙ্গাল ওষুধ', 'ঘনত্ব কম রাখা');

-- ডিফল্ট অ্যাডমিন ইউজার (password: admin123)
INSERT INTO users (username, email, password, role, full_name, phone, status) VALUES
('admin', 'admin@fishcare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'সিস্টেম অ্যাডমিন', '01700000000', 'active');

-- নমুনা চাষী ইউজার (password: farmer123)
INSERT INTO users (username, email, password, role, full_name, phone, division_id, district_id, status) VALUES
('farmer1', 'farmer@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'farmer', 'আব্দুল করিম', '01711111111', 1, 1, 'active');

-- নমুনা হোলসেলার ইউজার (password: wholesaler123)
INSERT INTO users (username, email, password, role, full_name, phone, status) VALUES
('wholesaler1', 'wholesaler@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'wholesaler', 'মোঃ রহিম উদ্দিন', '01722222222', 'active');

-- বাজার মূল্য নমুনা
INSERT INTO market_prices (product_name, price_per_kg, location, market_name, price_date, source) VALUES
('রুই মাছ', 320, 'ঢাকা', 'কাওরান বাজার', CURDATE(), 'স্থানীয় জরিপ'),
('কাতলা মাছ', 350, 'ঢাকা', 'কাওরান বাজার', CURDATE(), 'স্থানীয় জরিপ'),
('পাঙ্গাস মাছ', 180, 'ঢাকা', 'কাওরান বাজার', CURDATE(), 'স্থানীয় জরিপ'),
('তেলাপিয়া মাছ', 140, 'ঢাকা', 'কাওরান বাজার', CURDATE(), 'স্থানীয় জরিপ');
