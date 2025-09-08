# File Cleanup - Warkop Abah

## File yang Dapat Dihapus

### 1. **File Duplikat Database**
- `database/menu_tables.sql` - Duplikat, sudah ada di warkop_abah_final.sql
- `database/warkop_abah_complete.sql` - Versi lama, gunakan warkop_abah_final.sql

### 2. **File Testing yang Tidak Diperlukan**
- `test_features.md` - Sudah ada TESTING_GUIDE.md yang lebih lengkap

### 3. **File Temporary**
- `captcha/` folder - File captcha temporary, bisa dihapus
- `livechat.zip` - File tidak diperlukan

### 4. **File Default CodeIgniter**
- `application/third_party/MX/` - Tidak digunakan karena sudah migrasi ke CI3
- `readme.rst` - File default CodeIgniter
- `license.txt` - File default CodeIgniter

## File yang Harus Dipertahankan

### Database Files (PENTING)
- ✅ `database/warkop_abah_final.sql` - Database utama
- ✅ `database/update_otp_table.sql` - Update untuk database yang ada
- ✅ `database/missing_tables.sql` - Tabel tambahan

### Documentation Files (PENTING)
- ✅ `README.md` - Dokumentasi utama
- ✅ `OTP_FIX_README.md` - Penjelasan masalah OTP
- ✅ `DATABASE_COMPLETE_README.md` - Panduan database
- ✅ `TESTING_GUIDE.md` - Panduan testing
- ✅ `FIX_SUMMARY.md` - Ringkasan perbaikan

### Application Files (PENTING)
- ✅ `application/` - Semua file aplikasi
- ✅ `assets/` - CSS, JS, images
- ✅ `system/` - CodeIgniter core
- ✅ `index.php` - Entry point

## Perintah Cleanup

### Hapus File Duplikat
```bash
# Hapus file database duplikat
rm database/menu_tables.sql
rm database/warkop_abah_complete.sql

# Hapus file testing duplikat
rm test_features.md

# Hapus file temporary
rm -rf captcha/
rm livechat.zip

# Hapus file default CodeIgniter
rm readme.rst
rm license.txt

# Hapus folder MX yang tidak digunakan
rm -rf application/third_party/MX/
```

### Hapus File Log (Optional)
```bash
# Hapus log lama (optional)
rm -rf application/logs/*
```

## Struktur File Setelah Cleanup

```
warkop/
├── application/                 # Aplikasi CodeIgniter
│   ├── config/                 # Konfigurasi
│   ├── controllers/            # Controller
│   ├── models/                 # Model
│   ├── views/                  # View
│   └── ...
├── assets/                     # CSS, JS, Images
├── database/                   # File SQL
│   ├── warkop_abah_final.sql   # Database utama
│   ├── update_otp_table.sql    # Update OTP
│   └── missing_tables.sql      # Tabel tambahan
├── system/                     # CodeIgniter core
├── index.php                   # Entry point
├── README.md                   # Dokumentasi utama
├── OTP_FIX_README.md           # Penjelasan OTP
├── DATABASE_COMPLETE_README.md # Panduan database
├── TESTING_GUIDE.md            # Panduan testing
├── FIX_SUMMARY.md              # Ringkasan perbaikan
└── CLEANUP_FILES.md            # File ini
```

## Verifikasi Setelah Cleanup

### 1. Cek File yang Masih Ada
```bash
ls -la
```

### 2. Test Aplikasi
1. Buka browser
2. Akses aplikasi
3. Test login dengan kredensial default
4. Pastikan semua fitur berfungsi

### 3. Cek Database
```sql
-- Pastikan database masih ada
SHOW DATABASES;
USE warkop_abah;
SHOW TABLES;
```

## Catatan Penting

- **JANGAN** hapus file di `application/`, `assets/`, `system/`
- **JANGAN** hapus file database yang masih diperlukan
- **JANGAN** hapus file dokumentasi
- **BACKUP** database sebelum cleanup jika ragu
- **TEST** aplikasi setelah cleanup

## File yang Wajib Ada

### Minimum Required Files
1. `index.php` - Entry point
2. `application/` - Aplikasi
3. `system/` - CodeIgniter core
4. `assets/` - CSS, JS, images
5. `database/warkop_abah_final.sql` - Database
6. `README.md` - Dokumentasi

### Recommended Files
1. `OTP_FIX_README.md` - Troubleshooting OTP
2. `DATABASE_COMPLETE_README.md` - Panduan database
3. `TESTING_GUIDE.md` - Panduan testing
4. `FIX_SUMMARY.md` - Ringkasan perbaikan
