-- =====================================================
-- DATABASE WARCOP ABAH - SISTEM MANAJEMEN PESANAN COMPLETE
-- DENGAN REALTIME DATETIME
-- =====================================================

-- Buat database
CREATE DATABASE IF NOT EXISTS `warkop_abah` 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `warkop_abah`;

-- =====================================================
-- TABEL USER (PENGGUNA)
-- =====================================================
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT 2 COMMENT '1=Admin, 2=User',
  `is_active` tinyint(1) DEFAULT 1,
  `phone` varchar(20) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL COMMENT 'Waktu login terakhir',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_role` (`role_id`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL USER OTP (UNTUK LOGIN OTP) - DIPERBAIKI
-- =====================================================
CREATE TABLE IF NOT EXISTS `user_otp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code_hash` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `attempts` int(11) DEFAULT 0 COMMENT 'Jumlah percobaan OTP yang gagal',
  `max_attempts` int(11) DEFAULT 3 COMMENT 'Maksimal percobaan OTP yang diizinkan',
  `used_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu OTP digunakan',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_expires` (`expires_at`),
  KEY `idx_used` (`is_used`),
  CONSTRAINT `fk_otp_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL KATEGORI MENU
-- =====================================================
CREATE TABLE IF NOT EXISTS `menu_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0 COMMENT 'Urutan tampil',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_active` (`is_active`),
  KEY `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL MENU
-- =====================================================
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0 COMMENT 'Urutan tampil',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category_id`),
  KEY `idx_available` (`is_available`),
  KEY `idx_featured` (`is_featured`),
  KEY `idx_sort` (`sort_order`),
  CONSTRAINT `fk_menu_category` FOREIGN KEY (`category_id`) REFERENCES `menu_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL PESANAN
-- =====================================================
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(20) NOT NULL UNIQUE,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `delivery_phone` varchar(20) DEFAULT NULL,
  `estimated_time` int(11) DEFAULT NULL COMMENT 'Estimasi waktu dalam menit',
  `completed_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu pesanan selesai',
  `cancelled_at` timestamp NULL DEFAULT NULL COMMENT 'Waktu pesanan dibatalkan',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_payment_status` (`payment_status`),
  KEY `idx_created` (`created_at`),
  CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL DETAIL PESANAN
-- =====================================================
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_menu_id` (`menu_id`),
  CONSTRAINT `fk_orderitem_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orderitem_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL SESSIONS (UNTUK SESSION MANAGEMENT)
-- =====================================================
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABEL LOGIN ATTEMPTS (UNTUK SECURITY)
-- =====================================================
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

-- =====================================================
-- TABEL NOTIFICATIONS (UNTUK NOTIFIKASI)
-- =====================================================
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

-- =====================================================
-- TABEL CART (UNTUK SHOPPING CART PERSISTENT)
-- =====================================================
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

-- =====================================================
-- TABEL PAYMENTS (UNTUK PEMBAYARAN)
-- =====================================================
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

-- =====================================================
-- TABEL REVIEWS (UNTUK REVIEW MENU)
-- =====================================================
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

-- =====================================================
-- TABEL SETTINGS (UNTUK PENGATURAN SISTEM)
-- =====================================================
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

-- =====================================================
-- TABEL ACTIVITY LOGS (UNTUK LOG AKTIVITAS)
-- =====================================================
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
-- INSERT DATA AWAL
-- =====================================================

-- Insert Admin User (password: admin123)
INSERT INTO `user` (`name`, `email`, `password`, `role_id`, `phone`, `address`, `city`, `postal_code`, `last_login`) VALUES
('Administrator', 'admin@warkopabah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '+62 812-3456-7890', 'Jl. Admin No. 1', 'Jakarta', '12345', NOW()),
('John Doe', 'user@warkopabah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, '+62 812-3456-7891', 'Jl. Contoh No. 123', 'Jakarta', '12345', NOW()),
('Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, '+62 812-3456-7892', 'Jl. Sample No. 456', 'Bandung', '54321', NOW());

-- Insert Menu Categories
INSERT INTO `menu_categories` (`name`, `description`, `sort_order`) VALUES
('Kopi', 'Berbagai jenis kopi pilihan dengan kualitas terbaik', 1),
('Minuman', 'Minuman segar dan dingin untuk menyegarkan hari', 2),
('Makanan Ringan', 'Snack dan makanan ringan yang lezat', 3),
('Makanan Berat', 'Makanan utama dan berat untuk mengenyangkan', 4),
('Dessert', 'Makanan penutup manis dan segar', 5);

-- Insert Menu Items
INSERT INTO `menus` (`category_id`, `name`, `description`, `price`, `is_featured`, `sort_order`) VALUES
(1, 'Kopi Hitam', 'Kopi hitam murni tanpa gula, nikmati keaslian rasa kopi', 15000.00, 1, 1),
(1, 'Espresso', 'Espresso single shot dengan crema yang sempurna', 12000.00, 1, 2),
(1, 'Cappuccino', 'Cappuccino dengan foam susu yang lembut', 18000.00, 1, 3),
(1, 'Latte', 'Latte dengan susu steamed yang creamy', 20000.00, 1, 4),
(1, 'Americano', 'Americano dengan air panas, ringan dan segar', 16000.00, 0, 5),
(1, 'Mocha', 'Mocha dengan campuran coklat yang manis', 22000.00, 0, 6),
(1, 'Macchiato', 'Espresso dengan sedikit foam susu', 14000.00, 0, 7),
(2, 'Teh Tarik', 'Teh tarik khas Malaysia dengan susu kental manis', 12000.00, 0, 1),
(2, 'Jus Jeruk', 'Jus jeruk segar tanpa gula tambahan', 15000.00, 0, 2),
(2, 'Es Teh Manis', 'Es teh manis segar untuk menghilangkan dahaga', 8000.00, 0, 3),
(2, 'Lemon Tea', 'Teh lemon segar dengan potongan lemon asli', 13000.00, 0, 4),
(2, 'Smoothie Strawberry', 'Smoothie strawberry dengan yogurt', 18000.00, 0, 5),
(3, 'Roti Bakar', 'Roti bakar dengan selai pilihan (strawberry/blueberry)', 10000.00, 1, 1),
(3, 'Sandwich', 'Sandwich dengan isian ayam, sayuran segar', 18000.00, 1, 2),
(3, 'Croissant', 'Croissant butter dengan tekstur yang flaky', 12000.00, 0, 3),
(3, 'Muffin', 'Muffin coklat dengan taburan choco chips', 8000.00, 0, 4),
(3, 'Donut', 'Donut dengan berbagai topping menarik', 10000.00, 0, 5),
(3, 'Pancake', 'Pancake dengan maple syrup dan butter', 15000.00, 0, 6),
(4, 'Nasi Goreng', 'Nasi goreng spesial dengan telur, ayam, dan sayuran', 25000.00, 1, 1),
(4, 'Mie Goreng', 'Mie goreng dengan telur, ayam, dan sayuran segar', 22000.00, 0, 2),
(4, 'Ayam Goreng', 'Ayam goreng crispy dengan bumbu special', 30000.00, 1, 3),
(4, 'Burger', 'Burger dengan patty ayam/beef, sayuran segar', 28000.00, 0, 4),
(4, 'Pasta Carbonara', 'Pasta carbonara dengan cream sauce dan bacon', 35000.00, 0, 5),
(5, 'Cheesecake', 'Cheesecake dengan topping buah berry', 20000.00, 0, 1),
(5, 'Tiramisu', 'Tiramisu dengan kopi dan mascarpone', 25000.00, 0, 2),
(5, 'Ice Cream', 'Ice cream dengan berbagai pilihan rasa', 15000.00, 0, 3);

-- Insert Sample Orders
INSERT INTO `orders` (`user_id`, `order_number`, `total_amount`, `status`, `payment_method`, `payment_status`, `notes`, `completed_at`) VALUES
(2, 'ORD20240115001', 33000.00, 'completed', 'cash', 'paid', 'Tidak terlalu manis', NOW() - INTERVAL 2 HOUR),
(2, 'ORD20240115002', 45000.00, 'completed', 'cash', 'paid', 'Es batu sedikit saja', NOW() - INTERVAL 1 HOUR),
(3, 'ORD20240115003', 28000.00, 'processing', 'cash', 'paid', 'Dibungkus', NULL),
(2, 'ORD20240116001', 52000.00, 'pending', 'cash', 'pending', 'Sambal extra', NULL),
(3, 'ORD20240116002', 18000.00, 'completed', 'cash', 'paid', NULL, NOW() - INTERVAL 30 MINUTE);

-- Insert Order Items
INSERT INTO `order_items` (`order_id`, `menu_id`, `quantity`, `price`, `subtotal`) VALUES
(1, 1, 1, 15000.00, 15000.00),
(1, 13, 1, 10000.00, 10000.00),
(1, 10, 1, 8000.00, 8000.00),
(2, 3, 1, 18000.00, 18000.00),
(2, 14, 1, 18000.00, 18000.00),
(2, 9, 1, 15000.00, 15000.00),
(3, 20, 1, 28000.00, 28000.00),
(4, 19, 1, 30000.00, 30000.00),
(4, 17, 1, 22000.00, 22000.00),
(5, 2, 1, 12000.00, 12000.00),
(5, 15, 1, 8000.00, 8000.00);

-- Insert Default Settings
INSERT INTO `settings` (`key`, `value`, `description`, `type`) VALUES
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

-- Insert Sample Notifications
INSERT INTO `notifications` (`user_id`, `title`, `message`, `type`, `is_read`) VALUES
(2, 'Pesanan Selesai', 'Pesanan ORD20240115001 telah selesai dan siap diambil', 'success', 1),
(2, 'Pesanan Baru', 'Pesanan ORD20240116001 telah diterima dan sedang diproses', 'info', 0),
(3, 'Pesanan Diproses', 'Pesanan ORD20240115003 sedang dalam proses pembuatan', 'info', 0);

-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================

-- Check total records
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
SELECT 'Notifications', COUNT(*) FROM notifications
UNION ALL
SELECT 'Settings', COUNT(*) FROM settings;

-- Check featured menus
SELECT m.name, m.price, c.name as category 
FROM menus m 
JOIN menu_categories c ON m.category_id = c.id 
WHERE m.is_featured = 1 
ORDER BY m.sort_order;

-- Check user stats
SELECT u.name, COUNT(o.id) as total_orders, SUM(o.total_amount) as total_spent
FROM user u
LEFT JOIN orders o ON u.id = o.user_id
WHERE u.role_id = 2
GROUP BY u.id, u.name
ORDER BY total_spent DESC;

-- Check recent orders
SELECT o.order_number, u.name as customer, o.total_amount, o.status, o.created_at
FROM orders o
JOIN user u ON o.user_id = u.id
ORDER BY o.created_at DESC
LIMIT 5;
