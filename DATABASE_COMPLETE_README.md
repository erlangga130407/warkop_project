# Database Lengkap - Warkop Abah

## File Database yang Tersedia

### 1. **database/warkop_abah_final.sql** (RECOMMENDED)
- Database lengkap dengan semua tabel utama
- Sudah diperbaiki untuk masalah OTP
- Berisi data sample untuk testing
- **Gunakan file ini untuk setup awal**

### 2. **database/update_otp_table.sql**
- Script untuk memperbarui tabel `user_otp` yang sudah ada
- Menambahkan kolom `attempts` dan `max_attempts`
- **Gunakan jika database sudah ada dan hanya perlu update OTP**

### 3. **database/missing_tables.sql**
- Tabel tambahan untuk fitur advanced
- Session management, notifications, cart, payments, reviews, settings
- **Gunakan untuk menambah fitur tambahan**

## Struktur Database Lengkap

### Tabel Utama (warkop_abah_final.sql)

1. **`user`** - Data pengguna (admin & customer)
2. **`user_otp`** - OTP untuk login (SUDAH DIPERBAIKI)
3. **`menu_categories`** - Kategori menu
4. **`menus`** - Data menu dan harga
5. **`orders`** - Data pesanan
6. **`order_items`** - Detail item dalam pesanan

### Tabel Tambahan (missing_tables.sql)

7. **`ci_sessions`** - Session management CodeIgniter
8. **`login_attempts`** - Tracking percobaan login
9. **`notifications`** - Notifikasi untuk user
10. **`cart`** - Shopping cart persistent
11. **`payments`** - Data pembayaran
12. **`reviews`** - Review dan rating menu
13. **`settings`** - Pengaturan sistem

## Cara Import Database

### Opsi 1: Setup Baru (Recommended)
```sql
-- Import database/warkop_abah_final.sql
-- File ini sudah lengkap dan siap pakai
```

### Opsi 2: Update Database yang Ada
```sql
-- 1. Import database/update_otp_table.sql (untuk fix OTP)
-- 2. Import database/missing_tables.sql (untuk fitur tambahan)
```

## Default Credentials

**Admin:**
- Email: admin@warkopabah.com
- Password: admin123

**User:**
- Email: user@warkopabah.com
- Password: user123

## Fitur yang Sudah Tersedia

### ✅ Fitur Utama
- [x] Login/Register dengan OTP
- [x] Role-based access (Admin/User)
- [x] Dashboard sesuai role
- [x] Menu browsing dan search
- [x] Shopping cart
- [x] Order management
- [x] Admin panel CRUD

### ✅ Fitur OTP (Sudah Diperbaiki)
- [x] OTP via email
- [x] Batas percobaan (3x)
- [x] Expired OTP (3 menit)
- [x] Rate limiting resend (30 detik)
- [x] Role-based redirect

### 🔄 Fitur Tambahan (Optional)
- [ ] Session management
- [ ] Login attempts tracking
- [ ] Notifications system
- [ ] Payment tracking
- [ ] Review system
- [ ] System settings

## Troubleshooting

### Masalah OTP "Banyak Percobaan"
1. Import `database/warkop_abah_final.sql` atau
2. Jalankan `database/update_otp_table.sql`

### Database Connection Error
1. Cek `application/config/database.php`
2. Pastikan database name: `warkop_abah`
3. Cek MySQL service running

### Email OTP Tidak Terkirim
1. Cek `application/config/email.php`
2. Pastikan SMTP settings benar
3. Test dengan email yang valid

## Verifikasi Database

Setelah import, jalankan query ini untuk verifikasi:

```sql
-- Cek semua tabel
SHOW TABLES;

-- Cek struktur user_otp (harus ada attempts & max_attempts)
DESCRIBE user_otp;

-- Cek data user
SELECT id, name, email, role_id FROM user;

-- Cek data menu
SELECT COUNT(*) as total_menus FROM menus;
SELECT COUNT(*) as total_categories FROM menu_categories;
```

## Next Steps

1. **Import database/warkop_abah_final.sql**
2. **Test login dengan kredensial default**
3. **Verifikasi OTP berfungsi**
4. **Test semua fitur utama**
5. **Import missing_tables.sql jika perlu fitur tambahan**
