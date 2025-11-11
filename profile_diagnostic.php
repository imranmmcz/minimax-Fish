<?php
// প্রোফাইল ডায়াগনস্টিক ও ফিক্স টুল
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = 'localhost';
$dbname = 'fishcare';
$username = 'root';
$password = ''; // আপনার পাসওয়ার্ড

?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile পেজ ডায়াগনস্টিক</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Hind Siliguri', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(45deg, #007cba, #00BCD4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .status-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid #007cba;
        }
        .success { border-left-color: #28a745; }
        .error { border-left-color: #dc3545; }
        .warning { border-left-color: #ffc107; }
        .status-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .success .status-icon { background: #28a745; }
        .error .status-icon { background: #dc3545; }
        .warning .status-icon { background: #ffc107; }
        .btn {
            background: linear-gradient(45deg, #007cba, #00BCD4);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 124, 186, 0.3);
        }
        .btn-danger {
            background: linear-gradient(45deg, #dc3545, #e74c3c);
        }
        .code-block {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
        }
        .table-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
        }
        .table-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-info th, .table-info td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table-info th {
            background: #e9ecef;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔧 Profile পেজ ডায়াগনস্টিক টুল</h1>
            <p>সমস্যা চিহ্নিতকরণ ও সমাধান</p>
        </div>

        <?php
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo '<div class="status-card success">';
            echo '<span class="status-icon"></span>';
            echo '<strong>✅ ডেটাবেস কানেকশন সফল!</strong><br>';
            echo "MySQL সার্ভার: $host | ডেটাবেস: $dbname";
            echo '</div>';
            
            // ১. টেবিল চেক
            echo '<h3 style="margin: 20px 0 10px 0; color: #333;">📊 টেবিল চেক</h3>';
            
            // users টেবিল
            $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
            if ($stmt->rowCount() > 0) {
                echo '<div class="status-card success"><span class="status-icon"></span><strong>✅ users টেবিল আছে</strong></div>';
                
                // ইউজার গণনা
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
                $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                echo '<div class="table-info">মোট ইউজার: <strong>' . $count . ' জন</strong></div>';
            } else {
                echo '<div class="status-card error"><span class="status-icon"></span><strong>❌ users টেবিল নেই!</strong></div>';
            }
            
            // user_profiles টেবিল
            $stmt = $pdo->query("SHOW TABLES LIKE 'user_profiles'");
            if ($stmt->rowCount() > 0) {
                echo '<div class="status-card success"><span class="status-icon"></span><strong>✅ user_profiles টেবিল আছে</strong></div>';
                
                // প্রোফাইল গণনা
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM user_profiles");
                $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                echo '<div class="table-info">মোট প্রোফাইল: <strong>' . $count . ' টি</strong></div>';
            } else {
                echo '<div class="status-card error"><span class="status-icon"></span><strong>❌ user_profiles টেবিল নেই!</strong></div>';
                echo '<div class="status-card warning"><span class="status-icon"></span><strong>⚠️ এটাই সমস্যার কারণ!</strong></div>';
            }
            
            // ২. টেস্ট ইউজার
            echo '<h3 style="margin: 20px 0 10px 0; color: #333;">👥 টেস্ট ইউজার</h3>';
            $stmt = $pdo->prepare("SELECT u.*, up.farming_experience, up.pond_count 
                                  FROM users u 
                                  LEFT JOIN user_profiles up ON u.id = up.user_id 
                                  WHERE u.role = 'farmer' 
                                  LIMIT 1");
            $stmt->execute();
            $testUser = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($testUser) {
                echo '<div class="table-info">';
                echo '<table>';
                echo '<tr><th>Username</th><th>Name</th><th>Email</th><th>Experience</th><th>Ponds</th></tr>';
                echo '<tr>';
                echo '<td>' . htmlspecialchars($testUser['username']) . '</td>';
                echo '<td>' . htmlspecialchars($testUser['full_name']) . '</td>';
                echo '<td>' . htmlspecialchars($testUser['email']) . '</td>';
                echo '<td>' . ($testUser['farming_experience'] ?? 'N/A') . '</td>';
                echo '<td>' . ($testUser['pond_count'] ?? 'N/A') . '</td>';
                echo '</tr>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<div class="status-card warning"><span class="status-icon"></span><strong>⚠️ কোনো চাষী ইউজার পাওয়া যায়নি!</strong></div>';
            }
            
        } catch (PDOException $e) {
            echo '<div class="status-card error">';
            echo '<span class="status-icon"></span>';
            echo '<strong>❌ ডেটাবেস সংযোগ ব্যর্থ!</strong><br>';
            echo 'ত্রুটি: ' . htmlspecialchars($e->getMessage());
            echo '</div>';
        }
        ?>

        <div style="text-align: center; margin: 30px 0;">
            <h3 style="margin-bottom: 20px; color: #333;">🛠️ সমাধানের বিকল্পসমূহ</h3>
            
            <a href="#" onclick="fixDatabase()" class="btn">🔧 ডেটাবেস ফিক্স করুন</a>
            <a href="profile.php" class="btn">📱 Profile পেজ দেখুন</a>
            <a href="#" onclick="createTables()" class="btn">🏗️ টেবিল তৈরি করুন</a>
            <a href="index.php" class="btn">🏠 ড্যাশবোর্ডে যান</a>
        </div>

        <div id="result" style="margin-top: 20px;"></div>
    </div>

    <script>
        function fixDatabase() {
            if (confirm('এটি ডেটাবেস ফিক্স করবে। কি এগিয়ে যেতে চান?')) {
                // AJAX request for fixing database
                fetch('fix_database_ajax.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({action: 'fix'})
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('result').innerHTML = data;
                    setTimeout(() => location.reload(), 2000);
                })
                .catch(error => {
                    document.getElementById('result').innerHTML = '<div class="status-card error"><strong>❌ ত্রুটি:</strong> ' + error + '</div>';
                });
            }
        }

        function createTables() {
            if (confirm('নতুন টেবিল তৈরি করবে। কি এগিয়ে যেতে চান?')) {
                fetch('fix_database_ajax.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({action: 'create_tables'})
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('result').innerHTML = data;
                    setTimeout(() => location.reload(), 2000);
                })
                .catch(error => {
                    document.getElementById('result').innerHTML = '<div class="status-card error"><strong>❌ ত্রুটি:</strong> ' + error + '</div>';
                });
            }
        }
    </script>
</body>
</html>
