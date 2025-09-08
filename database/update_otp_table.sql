-- =====================================================
-- UPDATE TABEL USER_OTP - TAMBAH KOLOM YANG HILANG
-- =====================================================

USE `warkop_abah`;

-- Tambah kolom attempts jika belum ada
ALTER TABLE `user_otp` 
ADD COLUMN IF NOT EXISTS `attempts` int(11) DEFAULT 0 COMMENT 'Jumlah percobaan OTP yang gagal';

-- Tambah kolom max_attempts jika belum ada
ALTER TABLE `user_otp` 
ADD COLUMN IF NOT EXISTS `max_attempts` int(11) DEFAULT 3 COMMENT 'Maksimal percobaan OTP yang diizinkan';

-- Update semua record yang sudah ada untuk set default values
UPDATE `user_otp` SET `attempts` = 0 WHERE `attempts` IS NULL;
UPDATE `user_otp` SET `max_attempts` = 3 WHERE `max_attempts` IS NULL;

-- Verifikasi struktur tabel
DESCRIBE `user_otp`;
