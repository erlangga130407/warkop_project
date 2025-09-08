-- =====================================================
-- UPDATE DATABASE KE REALTIME DATETIME
-- Untuk database yang sudah ada
-- =====================================================

USE `warkop_abah`;

-- =====================================================
-- UPDATE TABEL USER
-- =====================================================

-- Tambah field last_login jika belum ada
ALTER TABLE `user` 
ADD COLUMN IF NOT EXISTS `last_login` timestamp NULL DEFAULT NULL COMMENT 'Waktu login terakhir' AFTER `postal_code`;

-- Update field created_at dan updated_at jika belum ada
ALTER TABLE `user` 
MODIFY COLUMN `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
MODIFY COLUMN `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- =====================================================
-- UPDATE TABEL USER_OTP
-- =====================================================

-- Tambah field used_at jika belum ada
ALTER TABLE `user_otp` 
ADD COLUMN IF NOT EXISTS `used_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu OTP digunakan' AFTER `max_attempts`;

-- Update field created_at
ALTER TABLE `user_otp` 
MODIFY COLUMN `created_at` timestamp DEFAULT CURRENT_TIMESTAMP;

-- Tambah field updated_at jika belum ada
ALTER TABLE `user_otp` 
ADD COLUMN IF NOT EXISTS `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;

-- =====================================================
-- UPDATE TABEL MENU_CATEGORIES
-- =====================================================

-- Tambah field sort_order jika belum ada
ALTER TABLE `menu_categories` 
ADD COLUMN IF NOT EXISTS `sort_order` int(11) DEFAULT 0 COMMENT 'Urutan tampil' AFTER `is_active`;

-- Update field created_at
ALTER TABLE `menu_categories` 
MODIFY COLUMN `created_at` timestamp DEFAULT CURRENT_TIMESTAMP;

-- Tambah field updated_at jika belum ada
ALTER TABLE `menu_categories` 
ADD COLUMN IF NOT EXISTS `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;

-- =====================================================
-- UPDATE TABEL MENUS
-- =====================================================

-- Tambah field sort_order jika belum ada
ALTER TABLE `menus` 
ADD COLUMN IF NOT EXISTS `sort_order` int(11) DEFAULT 0 COMMENT 'Urutan tampil' AFTER `is_featured`;

-- Update field created_at dan updated_at
ALTER TABLE `menus` 
MODIFY COLUMN `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
MODIFY COLUMN `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- =====================================================
-- UPDATE TABEL ORDERS
-- =====================================================

-- Tambah field payment_status jika belum ada
ALTER TABLE `orders` 
ADD COLUMN IF NOT EXISTS `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending' AFTER `payment_method`;

-- Tambah field delivery_address jika belum ada
ALTER TABLE `orders` 
ADD COLUMN IF NOT EXISTS `delivery_address` text DEFAULT NULL AFTER `notes`;

-- Tambah field delivery_phone jika belum ada
ALTER TABLE `orders` 
ADD COLUMN IF NOT EXISTS `delivery_phone` varchar(20) DEFAULT NULL AFTER `delivery_address`;

-- Tambah field estimated_time jika belum ada
ALTER TABLE `orders` 
ADD COLUMN IF NOT EXISTS `estimated_time` int(11) DEFAULT NULL COMMENT 'Estimasi waktu dalam menit' AFTER `delivery_phone`;

-- Tambah field completed_at jika belum ada
ALTER TABLE `orders` 
ADD COLUMN IF NOT EXISTS `completed_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu pesanan selesai' AFTER `estimated_time`;

-- Tambah field cancelled_at jika belum ada
ALTER TABLE `orders` 
ADD COLUMN IF NOT EXISTS `cancelled_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu pesanan dibatalkan' AFTER `completed_at`;

-- Update field created_at dan updated_at
ALTER TABLE `orders` 
MODIFY COLUMN `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
MODIFY COLUMN `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- =====================================================
-- UPDATE TABEL ORDER_ITEMS
-- =====================================================

-- Update field created_at dan updated_at
ALTER TABLE `order_items` 
MODIFY COLUMN `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
MODIFY COLUMN `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- =====================================================
-- BUAT TABEL BARU YANG BELUM ADA
-- =====================================================

-- Tabel CI Sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Login Attempts
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `attempts` int(11) DEFAULT 1,
  `last_attempt` timestamp DEFAULT CURRENT_TIMESTAMP,
  `blocked_until` timestamp NULL DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ip_address` (`ip_address`),
  KEY `email` (`email`),
  KEY `idx_blocked` (`blocked_until`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','success','warning','error') DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu notifikasi dibaca',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_read` (`is_read`),
  KEY `idx_type` (`type`),
  CONSTRAINT `fk_notification_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Cart
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_menu_id` (`menu_id`),
  CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cart_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu pembayaran selesai',
  `failed_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu pembayaran gagal',
  `refunded_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu refund',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_status` (`status`),
  KEY `idx_transaction` (`transaction_id`),
  CONSTRAINT `fk_payment_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `rating` int(1) NOT NULL CHECK (rating >= 1 AND rating <= 5),
  `comment` text DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `approved_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu review disetujui',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_menu_id` (`menu_id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_approved` (`is_approved`),
  CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_review_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_review_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL UNIQUE,
  `value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` enum('string','integer','boolean','json') DEFAULT 'string',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Activity Logs
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_action` (`action`),
  KEY `idx_created` (`created_at`),
  CONSTRAINT `fk_activity_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- INSERT DATA DEFAULT SETTINGS
-- =====================================================

INSERT IGNORE INTO `settings` (`key`, `value`, `description`, `type`) VALUES
('site_name', 'Warkop Abah', 'Nama website', 'string'),
('site_email', 'admin@warkopabah.com', 'Email admin', 'string'),
('otp_lifetime', '180', 'Lifetime OTP dalam detik (3 menit)', 'integer'),
('otp_max_attempts', '3', 'Maksimal percobaan OTP', 'integer'),
('otp_resend_delay', '30', 'Delay resend OTP dalam detik', 'integer'),
('order_timeout', '3600', 'Timeout pesanan dalam detik (1 jam)', 'integer'),
('min_order_amount', '10000', 'Minimum jumlah pesanan', 'integer'),
('delivery_fee', '5000', 'Biaya pengiriman', 'integer'),
('tax_rate', '10', 'Persentase pajak', 'integer'),
('timezone', 'Asia/Jakarta', 'Timezone sistem', 'string'),
('date_format', 'd/m/Y H:i', 'Format tanggal dan waktu', 'string');

-- =====================================================
-- UPDATE SORT ORDER UNTUK MENU CATEGORIES
-- =====================================================

UPDATE `menu_categories` SET `sort_order` = 1 WHERE `name` = 'Kopi';
UPDATE `menu_categories` SET `sort_order` = 2 WHERE `name` = 'Minuman';
UPDATE `menu_categories` SET `sort_order` = 3 WHERE `name` = 'Makanan Ringan';
UPDATE `menu_categories` SET `sort_order` = 4 WHERE `name` = 'Makanan Berat';
UPDATE `menu_categories` SET `sort_order` = 5 WHERE `name` = 'Dessert';

-- =====================================================
-- UPDATE SORT ORDER UNTUK MENUS
-- =====================================================

-- Kopi
UPDATE `menus` SET `sort_order` = 1 WHERE `name` = 'Kopi Hitam';
UPDATE `menus` SET `sort_order` = 2 WHERE `name` = 'Espresso';
UPDATE `menus` SET `sort_order` = 3 WHERE `name` = 'Cappuccino';
UPDATE `menus` SET `sort_order` = 4 WHERE `name` = 'Latte';
UPDATE `menus` SET `sort_order` = 5 WHERE `name` = 'Americano';
UPDATE `menus` SET `sort_order` = 6 WHERE `name` = 'Mocha';
UPDATE `menus` SET `sort_order` = 7 WHERE `name` = 'Macchiato';

-- Minuman
UPDATE `menus` SET `sort_order` = 1 WHERE `name` = 'Teh Tarik';
UPDATE `menus` SET `sort_order` = 2 WHERE `name` = 'Jus Jeruk';
UPDATE `menus` SET `sort_order` = 3 WHERE `name` = 'Es Teh Manis';
UPDATE `menus` SET `sort_order` = 4 WHERE `name` = 'Lemon Tea';
UPDATE `menus` SET `sort_order` = 5 WHERE `name` = 'Smoothie Strawberry';

-- Makanan Ringan
UPDATE `menus` SET `sort_order` = 1 WHERE `name` = 'Roti Bakar';
UPDATE `menus` SET `sort_order` = 2 WHERE `name` = 'Sandwich';
UPDATE `menus` SET `sort_order` = 3 WHERE `name` = 'Croissant';
UPDATE `menus` SET `sort_order` = 4 WHERE `name` = 'Muffin';
UPDATE `menus` SET `sort_order` = 5 WHERE `name` = 'Donut';
UPDATE `menus` SET `sort_order` = 6 WHERE `name` = 'Pancake';

-- Makanan Berat
UPDATE `menus` SET `sort_order` = 1 WHERE `name` = 'Nasi Goreng';
UPDATE `menus` SET `sort_order` = 2 WHERE `name` = 'Mie Goreng';
UPDATE `menus` SET `sort_order` = 3 WHERE `name` = 'Ayam Goreng';
UPDATE `menus` SET `sort_order` = 4 WHERE `name` = 'Burger';
UPDATE `menus` SET `sort_order` = 5 WHERE `name` = 'Pasta Carbonara';

-- Dessert
UPDATE `menus` SET `sort_order` = 1 WHERE `name` = 'Cheesecake';
UPDATE `menus` SET `sort_order` = 2 WHERE `name` = 'Tiramisu';
UPDATE `menus` SET `sort_order` = 3 WHERE `name` = 'Ice Cream';

-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================

-- Check updated tables
SELECT 'User' as table_name, COUNT(*) as total_records FROM user
UNION ALL
SELECT 'Menu Categories', COUNT(*) FROM menu_categories
UNION ALL
SELECT 'Menus', COUNT(*) FROM menus
UNION ALL
SELECT 'Orders', COUNT(*) FROM orders
UNION ALL
SELECT 'Order Items', COUNT(*) FROM order_items
UNION ALL
SELECT 'Settings', COUNT(*) FROM settings;

-- Check datetime fields
SELECT 
    'user' as table_name,
    'created_at' as field_name,
    COUNT(*) as total_records,
    MIN(created_at) as earliest,
    MAX(created_at) as latest
FROM user
UNION ALL
SELECT 
    'orders' as table_name,
    'created_at' as field_name,
    COUNT(*) as total_records,
    MIN(created_at) as earliest,
    MAX(created_at) as latest
FROM orders;

-- Check settings
SELECT `key`, `value`, `description` FROM settings ORDER BY `key`;

-- Check sort orders
SELECT c.name as category, m.name as menu, m.sort_order 
FROM menus m 
JOIN menu_categories c ON m.category_id = c.id 
ORDER BY c.sort_order, m.sort_order;
