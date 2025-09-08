# Panduan Testing - Warkop Abah

## Persiapan Testing

### 1. Import Database
```sql
-- Import database/warkop_abah_final.sql ke phpMyAdmin
-- Pastikan database name: warkop_abah
```

### 2. Konfigurasi Email (untuk OTP)
Edit `application/config/email.php`:
```php
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com'; // atau SMTP server lain
$config['smtp_user'] = 'your-email@gmail.com';
$config['smtp_pass'] = 'your-app-password';
$config['smtp_port'] = 587;
$config['smtp_crypto'] = 'tls';
```

## Testing OTP (Masalah Utama)

### Test Case 1: Login Admin
1. Buka halaman login
2. Masukkan: admin@warkopabah.com / admin123
3. **Expected**: Redirect ke halaman OTP
4. Cek email untuk kode OTP
5. Masukkan kode OTP
6. **Expected**: Redirect ke admin dashboard

### Test Case 2: Login User
1. Buka halaman login
2. Masukkan: user@warkopabah.com / user123
3. **Expected**: Redirect ke halaman OTP
4. Cek email untuk kode OTP
5. Masukkan kode OTP
6. **Expected**: Redirect ke user dashboard

### Test Case 3: OTP Gagal
1. Login dengan kredensial benar
2. Masukkan kode OTP yang salah
3. **Expected**: Pesan "Kode OTP salah"
4. Ulangi 3x dengan kode salah
5. **Expected**: Pesan "Terlalu banyak percobaan. Silakan login ulang"

### Test Case 4: OTP Expired
1. Login dengan kredensial benar
2. Tunggu 3 menit tanpa memasukkan OTP
3. Masukkan kode OTP
4. **Expected**: Pesan "OTP kadaluarsa/terpakai"

## Testing Fitur Utama

### Test Case 5: Menu Browsing
1. Login sebagai user
2. Klik menu "Menu" di dashboard
3. **Expected**: Halaman menu dengan daftar item
4. Test search menu
5. Test filter kategori
6. **Expected**: Hasil sesuai pencarian/filter

### Test Case 6: Shopping Cart
1. Di halaman menu, klik "Tambah ke Keranjang"
2. **Expected**: Item masuk ke cart
3. Klik icon cart di header
4. **Expected**: Halaman cart dengan item yang ditambahkan
5. Ubah quantity
6. **Expected**: Total berubah sesuai quantity

### Test Case 7: Checkout
1. Di halaman cart, klik "Checkout"
2. Isi form checkout
3. Klik "Buat Pesanan"
4. **Expected**: Pesanan berhasil dibuat
5. **Expected**: Redirect ke halaman konfirmasi

### Test Case 8: Order History
1. Login sebagai user
2. Klik "Riwayat" di dashboard
3. **Expected**: Daftar pesanan user
4. Klik detail pesanan
5. **Expected**: Detail pesanan lengkap

### Test Case 9: Profile Management
1. Login sebagai user
2. Klik "Profil" di dashboard
3. **Expected**: Data profil user
4. Edit profil
5. **Expected**: Data berhasil diupdate

## Testing Admin Panel

### Test Case 10: Admin Dashboard
1. Login sebagai admin
2. **Expected**: Redirect ke admin dashboard
3. **Expected**: Statistik lengkap (users, orders, menus)

### Test Case 11: User Management
1. Di admin dashboard, klik "Users"
2. **Expected**: Daftar semua user
3. Test tambah user baru
4. Test edit user
5. Test hapus user
6. Test toggle status user

### Test Case 12: Menu Management
1. Di admin dashboard, klik "Menus"
2. **Expected**: Daftar semua menu
3. Test tambah menu baru
4. Test edit menu
5. Test hapus menu
6. Test tambah/edit kategori

### Test Case 13: Order Management
1. Di admin dashboard, klik "Orders"
2. **Expected**: Daftar semua pesanan
3. Test update status pesanan
4. Test lihat detail pesanan
5. Test print pesanan

## Testing Error Handling

### Test Case 14: Invalid Login
1. Masukkan email yang tidak ada
2. **Expected**: Pesan "Email tidak ditemukan"
3. Masukkan password salah
4. **Expected**: Pesan "Password salah"

### Test Case 15: Session Management
1. Login berhasil
2. Tutup browser
3. Buka browser baru, akses dashboard
4. **Expected**: Redirect ke login (session expired)

### Test Case 16: Access Control
1. Login sebagai user
2. Coba akses URL admin: `/admin/dashboard`
3. **Expected**: Redirect ke user dashboard atau error

## Expected Results

### ✅ Berhasil
- OTP berfungsi normal tanpa "banyak percobaan"
- Login redirect sesuai role
- Menu, cart, checkout berfungsi
- Admin panel CRUD berfungsi
- Database tersimpan dengan benar

### ❌ Gagal (Perlu Perbaikan)
- OTP selalu "banyak percobaan"
- Login tidak redirect ke OTP
- Menu tidak tersimpan ke database
- Admin panel tidak bisa CRUD
- Error database connection

## Troubleshooting

### Jika OTP Masih "Banyak Percobaan"
1. Pastikan sudah import `database/warkop_abah_final.sql`
2. Cek struktur tabel: `DESCRIBE user_otp;`
3. Pastikan ada kolom `attempts` dan `max_attempts`

### Jika Email OTP Tidak Terkirim
1. Cek konfigurasi email di `application/config/email.php`
2. Test dengan email yang valid
3. Cek log error di `application/logs/`

### Jika Database Error
1. Cek `application/config/database.php`
2. Pastikan database name: `warkop_abah`
3. Pastikan MySQL service running

## Laporan Testing

Setelah testing, buat laporan:
1. Test case mana yang berhasil
2. Test case mana yang gagal
3. Error message yang muncul
4. Screenshot jika perlu
5. Saran perbaikan
