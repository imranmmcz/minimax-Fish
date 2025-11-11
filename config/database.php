<?php
/**
 * ডেটাবেস কনফিগারেশন এবং কানেকশন
 * ফিশ কেয়ার সিস্টেম
 */

// ডেটাবেস সেটিংস - আপনার সার্ভার অনুযায়ী পরিবর্তন করুন
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fishcare');
define('DB_CHARSET', 'utf8mb4');

// ডেটাবেস কানেকশন ক্লাস
class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
            ];
            
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch(PDOException $e) {
            // প্রোডাকশনে error_log ব্যবহার করুন
            die("ডেটাবেস কানেকশন ব্যর্থ: " . $e->getMessage());
        }
    }
    
    // Singleton প্যাটার্ন - একটিমাত্র ইনস্ট্যান্স
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // কানেকশন অবজেক্ট রিটার্ন করুন
    public function getConnection() {
        return $this->conn;
    }
    
    // ক্লোন এবং wakeup প্রিভেন্ট করুন (Singleton)
    private function __clone() {}
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

// সংক্ষিপ্ত হেল্পার ফাংশন
function getDB() {
    return Database::getInstance()->getConnection();
}
