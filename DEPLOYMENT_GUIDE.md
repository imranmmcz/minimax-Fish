# ফিশ কেয়ার সিস্টেম - ডেপ্লয়মেন্ট গাইড

## সিস্টেম রিকয়ারমেন্ট

### সার্ভার রিকয়ারমেন্ট
- **PHP**: 7.4 বা তার উপরে
- **MySQL**: 5.7 বা তার উপরে / MariaDB 10.2+
- **Apache/Nginx**: mod_rewrite enabled
- **Disk Space**: ন্যূনতম 500MB
- **RAM**: ন্যূনতম 512MB

### PHP Extensions
```bash
php-pdo
php-pdo_mysql
php-mbstring
php-json
php-session
php-gd
```

## ধাপ ১: ফাইল আপলোড

### FTP/SFTP দিয়ে আপলোড
1. সম্পূর্ণ `fishcare` ফোল্ডার সার্ভারে আপলোড করুন
2. সাধারণত path হবে: `/var/www/html/fishcare/` অথবা `/public_html/fishcare/`

### ফাইল পারমিশন সেট করুন
```bash
# ওয়েব সার্ভার ইউজার হিসেবে (www-data অথবা apache)
chmod -R 755 /var/www/html/fishcare
chmod -R 775 /var/www/html/fishcare/uploads
chmod -R 775 /var/www/html/fishcare/assets/invoices

# Owner সেট করুন
chown -R www-data:www-data /var/www/html/fishcare
```

## ধাপ ২: ডেটাবেস সেটআপ

### MySQL ডেটাবেস তৈরি করুন

1. **cPanel থেকে**:
   - MySQL Databases → Create New Database
   - Database Name: `fishcare`
   - Create User এবং Password সেট করুন
   - User কে Database এ Assign করুন (All Privileges)

2. **কমান্ড লাইন থেকে**:
```bash
# MySQL তে লগিন করুন
mysql -u root -p

# ডেটাবেস তৈরি করুন
CREATE DATABASE fishcare CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# ইউজার তৈরি করুন
CREATE USER 'fishcare_user'@'localhost' IDENTIFIED BY 'your_secure_password';

# পারমিশন দিন
GRANT ALL PRIVILEGES ON fishcare.* TO 'fishcare_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### স্কিমা ইমপোর্ট করুন

**অপশন ১: phpMyAdmin থেকে**
1. phpMyAdmin ওপেন করুন
2. `fishcare` ডেটাবেস সিলেক্ট করুন
3. Import → Choose File → `database/schema.sql` সিলেক্ট করুন
4. Go ক্লিক করুন

**অপশন ২: কমান্ড লাইন থেকে**
```bash
mysql -u fishcare_user -p fishcare < /var/www/html/fishcare/database/schema.sql
```

### সেটআপ স্ক্রিপ্ট রান করুন
```bash
cd /var/www/html/fishcare
php database/setup.php
```

এটি নিম্নলিখিত টেবিল তৈরি করবে:
- ✓ shipments (শিপমেন্ট ট্র্যাকিং)
- ✓ notifications (নোটিফিকেশন)
- ✓ wishlists (উইশলিস্ট)
- ✓ নমুনা ডেটা ইনসার্ট করবে

## ধাপ ৩: কনফিগারেশন আপডেট

### ডেটাবেস কনফিগারেশন

`config/database.php` ফাইল এডিট করুন:

```php
define('DB_HOST', 'localhost');           // সাধারণত localhost
define('DB_USER', 'fishcare_user');       // আপনার DB username
define('DB_PASS', 'your_secure_password'); // আপনার DB password
define('DB_NAME', 'fishcare');             // ডেটাবেস নাম
```

### সাইট কনফিগারেশন

`config/config.php` ফাইল এডিট করুন:

```php
// সাইট ইউআরএল (trailing slash ছাড়া)
define('SITE_URL', 'https://yourdomain.com/fishcare');

// ইমেইল কনফিগারেশন (যদি প্রয়োজন হয়)
define('ADMIN_EMAIL', 'admin@yourdomain.com');

// Session কনফিগারেশন
define('SESSION_LIFETIME', 7200); // 2 ঘণ্টা
```

## ধাপ ৪: Apache/Nginx কনফিগারেশন

### Apache (.htaccess ইতিমধ্যে আছে)

`.htaccess` ফাইল চেক করুন:
```apache
RewriteEngine On
RewriteBase /fishcare/

# Force HTTPS (প্রোডাকশনে সুপারিশকৃত)
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# API Routes
RewriteRule ^api/(.*)$ api/$1.php [L]

# Dashboard Routes
RewriteRule ^dashboard/(.*)$ pages/dashboard/$1 [L]
```

### Nginx কনফিগারেশন

`/etc/nginx/sites-available/fishcare.conf`:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/html/fishcare;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Enable site এবং reload:
```bash
ln -s /etc/nginx/sites-available/fishcare.conf /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

## ধাপ ৫: SSL সার্টিফিকেট (সুপারিশকৃত)

### Let's Encrypt দিয়ে ফ্রি SSL

```bash
# Certbot ইনস্টল করুন
apt-get update
apt-get install certbot python3-certbot-apache

# Apache এর জন্য
certbot --apache -d yourdomain.com

# Nginx এর জন্য
certbot --nginx -d yourdomain.com
```

## ধাপ ৬: প্রথম লগিন এবং টেস্টিং

### ডিফল্ট অ্যাডমিন অ্যাকাউন্ট

যদি `database/schema.sql` থেকে ইমপোর্ট করা হয়:

```
Email: admin@fishcare.com
Password: admin123
Role: Admin
```

⚠️ **নিরাপত্তা**: প্রথম লগিনের পর অবশ্যই এই পাসওয়ার্ড পরিবর্তন করুন!

### টেস্ট চেকলিস্ট

- [ ] সাইট URL ব্রাউজারে ওপেন হচ্ছে
- [ ] লগিন সিস্টেম কাজ করছে
- [ ] ড্যাশবোর্ড পেজগুলি লোড হচ্ছে
- [ ] ডেটা টেবিলে দেখা যাচ্ছে
- [ ] ফর্ম সাবমিট কাজ করছে
- [ ] ছবি আপলোড কাজ করছে
- [ ] CSV/PDF এক্সপোর্ট কাজ করছে

## ধাপ ৭: সিকিউরিটি হার্ডেনিং

### 1. PHP সিকিউরিটি সেটিংস

`php.ini` এ এই সেটিংস যোগ করুন:
```ini
display_errors = Off
log_errors = On
error_log = /var/log/php/error.log
expose_php = Off
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1
```

### 2. ফাইল পারমিশন আবার চেক করুন
```bash
# config ফাইল read-only করুন
chmod 644 config/*.php

# sensitive ডিরেক্টরি protect করুন
chmod 750 database/
chmod 750 includes/
```

### 3. ডেটাবেস ব্যাকআপ সেটআপ

**Cron Job দিয়ে দৈনিক ব্যাকআপ**:
```bash
# crontab -e
0 2 * * * mysqldump -u fishcare_user -p'password' fishcare | gzip > /backup/fishcare_$(date +\%Y\%m\%d).sql.gz
```

### 4. আপডেট ডিফল্ট পাসওয়ার্ড

সকল ডিফল্ট টেস্ট ইউজারের পাসওয়ার্ড পরিবর্তন করুন অথবা ডিলিট করুন।

## ধাপ ৮: পারফরম্যান্স অপটিমাইজেশন

### 1. PHP OPcache Enable করুন
```ini
; php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
```

### 2. Database Indexing
স্কিমা ফাইলে ইতিমধ্যে সব প্রয়োজনীয় indexes আছে।

### 3. Browser Caching (.htaccess)
```apache
# Browser Caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

## ট্রাবলশুটিং

### সমস্যা: White Screen / Blank Page
```bash
# Error log চেক করুন
tail -f /var/log/apache2/error.log
# অথবা
tail -f /var/log/nginx/error.log
```

### সমস্যা: Database Connection Error
1. `config/database.php` এ credentials চেক করুন
2. MySQL সার্ভিস রানিং আছে কিনা দেখুন: `systemctl status mysql`
3. User এর permission আছে কিনা চেক করুন

### সমস্যা: Session Errors
```bash
# Session ডিরেক্টরি পারমিশন চেক করুন
ls -la /var/lib/php/sessions/
chmod 1733 /var/lib/php/sessions/
```

### সমস্যা: Upload না হচ্ছে
1. `uploads/` ডিরেক্টরি পারমিশন: 775
2. PHP max upload size চেক করুন:
```ini
upload_max_filesize = 10M
post_max_size = 10M
```

## মনিটরিং এবং মেইন্টেনেন্স

### লগ ফাইল লোকেশন
- **Apache**: `/var/log/apache2/error.log`
- **Nginx**: `/var/log/nginx/error.log`
- **PHP**: `/var/log/php/error.log`
- **MySQL**: `/var/log/mysql/error.log`

### নিয়মিত টাস্ক
- [ ] সাপ্তাহিক ডেটাবেস ব্যাকআপ যাচাই
- [ ] মাসিক সিকিউরিটি আপডেট
- [ ] ত্রৈমাসিক পারফরম্যান্স রিভিউ
- [ ] পুরাতন লগ ফাইল ক্লিন করুন

## সাপোর্ট এবং যোগাযোগ

সমস্যার সমাধানের জন্য:
1. প্রথমে এই গাইড এবং ট্রাবলশুটিং সেকশন দেখুন
2. Error logs চেক করুন
3. `docs/README.md` পড়ুন

---

**সাফল্যের সাথে ডেপ্লয়মেন্ট সম্পন্ন হলে, সিস্টেম প্রোডাকশনের জন্য প্রস্তুত!**
