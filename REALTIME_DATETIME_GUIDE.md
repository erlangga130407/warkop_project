# Panduan Sistem DateTime Realtime - Warkop Abah

## Overview
Sistem DateTime Realtime memastikan semua tanggal dan waktu di aplikasi Warkop Abah berfungsi sesuai dengan waktu realtime Indonesia (Asia/Jakarta) dan menampilkan informasi waktu yang akurat dan up-to-date.

## Fitur yang Tersedia

### 1. **DateTime Helper Functions**
- `get_current_datetime()` - Mendapatkan datetime saat ini
- `format_datetime()` - Format datetime ke format Indonesia
- `format_date()` - Format date ke format Indonesia
- `format_time()` - Format time ke format Indonesia
- `time_ago()` - Menghitung waktu yang lalu
- `is_today()` - Cek apakah tanggal adalah hari ini
- `is_yesterday()` - Cek apakah tanggal adalah kemarin
- `get_indonesian_day()` - Nama hari dalam bahasa Indonesia
- `get_indonesian_month()` - Nama bulan dalam bahasa Indonesia
- `format_datetime_indonesian()` - Format datetime lengkap Indonesia

### 2. **Realtime JavaScript**
- Update waktu setiap detik
- Time ago calculation
- Order status time tracking
- Automatic timezone handling

### 3. **Database Schema**
- Semua tabel memiliki field `created_at` dan `updated_at`
- Field `last_login` untuk tracking login terakhir
- Field `used_at`, `paid_at`, `completed_at` untuk tracking status
- Timezone Asia/Jakarta untuk semua datetime

## File yang Terlibat

### 1. **Helper Functions**
- `application/helpers/datetime_helper.php` - Helper functions untuk datetime

### 2. **JavaScript**
- `assets/js/realtime-datetime.js` - JavaScript untuk realtime update

### 3. **Database**
- `database/warkop_abah_complete_realtime.sql` - Database schema lengkap

### 4. **Controllers (Updated)**
- `application/controllers/Admin.php` - Menggunakan datetime helper
- `application/controllers/Menu.php` - Menggunakan datetime helper
- `application/controllers/Login.php` - Menggunakan datetime helper
- `application/controllers/Otp.php` - Menggunakan datetime helper
- `application/controllers/Register.php` - Menggunakan datetime helper
- `application/controllers/Dashboard.php` - Menggunakan datetime helper

### 5. **Views (Updated)**
- `application/views/admin/users.php` - Menampilkan datetime dengan format yang baik

## Cara Menggunakan

### 1. **Di Controller**
```php
// Load helper
$this->load->helper('datetime');

// Gunakan fungsi helper
$current_time = get_current_datetime();
$formatted_date = format_datetime($user['created_at']);
$time_ago = time_ago($order['created_at']);
```

### 2. **Di View**
```php
// Format datetime
<?= format_datetime($user['created_at']) ?>

// Format date
<?= format_date($user['birth_date']) ?>

// Time ago
<span class="time-ago" data-datetime="<?= $order['created_at'] ?>"></span>

// Current time
<span class="current-time"></span>
```

### 3. **Di JavaScript**
```javascript
// Update semua elemen datetime
updateDateTimeElements();

// Format datetime untuk display
formatDateTimeForDisplay('2024-01-15 10:30:00');

// Hitung time ago
getTimeAgo('2024-01-15 10:30:00');
```

## Database Schema

### Tabel User
```sql
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT 2,
  `is_active` tinyint(1) DEFAULT 1,
  `phone` varchar(20) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Tabel Orders
```sql
CREATE TABLE `orders` (
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
  `estimated_time` int(11) DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## Format DateTime

### 1. **Format Default**
- **Date**: `d/m/Y` (15/01/2024)
- **Time**: `H:i` (14:30)
- **DateTime**: `d/m/Y H:i` (15/01/2024 14:30)

### 2. **Format Indonesia Lengkap**
- **Full DateTime**: `Senin, 15 Januari 2024 14:30`

### 3. **Time Ago**
- `baru saja` (< 1 menit)
- `5 menit yang lalu` (< 1 jam)
- `2 jam yang lalu` (< 1 hari)
- `3 hari yang lalu` (< 1 bulan)
- `2 bulan yang lalu` (< 1 tahun)
- `1 tahun yang lalu` (≥ 1 tahun)

## Timezone Handling

### 1. **Server Timezone**
- Default: `Asia/Jakarta`
- Semua datetime disimpan dalam timezone server
- Helper functions menggunakan timezone yang sama

### 2. **Client Timezone**
- JavaScript menggunakan timezone browser
- Automatic conversion ke timezone Indonesia
- Real-time update setiap detik

## Realtime Features

### 1. **Current Time Display**
- Menampilkan waktu saat ini di header
- Update setiap detik
- Format: `Senin, 15 Januari 2024 14:30:25`

### 2. **Time Ago Updates**
- Update otomatis setiap detik
- Menampilkan waktu relatif
- Contoh: `5 menit yang lalu` → `6 menit yang lalu`

### 3. **Order Status Time**
- Tracking waktu pesanan
- Estimasi waktu selesai
- Status realtime

## Testing

### 1. **Test DateTime Helper**
```php
// Test get_current_datetime
$current = get_current_datetime();
echo $current; // Output: 2024-01-15 14:30:25

// Test format_datetime
$formatted = format_datetime('2024-01-15 14:30:25');
echo $formatted; // Output: 15/01/2024 14:30

// Test time_ago
$ago = time_ago('2024-01-15 14:25:25');
echo $ago; // Output: 5 menit yang lalu
```

### 2. **Test JavaScript**
```javascript
// Test realtime update
console.log('Current time:', document.querySelector('.current-time').textContent);

// Test time ago
const timeAgoElement = document.querySelector('.time-ago');
console.log('Time ago:', timeAgoElement.textContent);
```

### 3. **Test Database**
```sql
-- Test current timestamp
SELECT NOW() as current_time;

-- Test timezone
SELECT @@session.time_zone as timezone;

-- Test user last login
SELECT name, last_login, 
       TIMESTAMPDIFF(MINUTE, last_login, NOW()) as minutes_ago
FROM user 
WHERE last_login IS NOT NULL;
```

## Troubleshooting

### 1. **Timezone Issues**
- Pastikan server timezone set ke `Asia/Jakarta`
- Cek PHP timezone: `date_default_timezone_set('Asia/Jakarta')`
- Cek MySQL timezone: `SET time_zone = '+07:00'`

### 2. **JavaScript Not Updating**
- Pastikan script `realtime-datetime.js` di-load
- Cek console untuk error JavaScript
- Pastikan elemen memiliki class yang tepat

### 3. **Format Issues**
- Pastikan helper `datetime` di-load di controller
- Cek format string yang digunakan
- Pastikan data datetime valid

### 4. **Database Issues**
- Pastikan field datetime ada di tabel
- Cek default value untuk timestamp
- Pastikan timezone database benar

## Performance

### 1. **Optimization**
- Update interval: 1 detik (dapat disesuaikan)
- Hanya update elemen yang terlihat
- Caching untuk format yang sama

### 2. **Memory Usage**
- Minimal memory footprint
- Cleanup interval yang tidak digunakan
- Efficient DOM manipulation

## Security

### 1. **Input Validation**
- Validasi format datetime
- Sanitasi input user
- Escape output untuk XSS prevention

### 2. **Timezone Security**
- Consistent timezone handling
- No timezone manipulation by user
- Server-side validation

## Status: ✅ COMPLETED

Semua fitur datetime realtime telah selesai dan siap digunakan:
- ✅ DateTime Helper Functions
- ✅ Realtime JavaScript
- ✅ Database Schema
- ✅ Controller Integration
- ✅ View Integration
- ✅ Timezone Handling
- ✅ Performance Optimization
- ✅ Security Measures







