# Fitur Admin Lengkap - Warkop Abah

## Ringkasan Fitur yang Telah Diimplementasikan

### 1. Manajemen Menu yang Ditingkatkan
- **Tambah Menu Baru**: Form lengkap dengan kategori, harga, stok, dan status
- **Edit Menu**: Modal edit dengan semua field yang dapat diubah
- **Update Harga**: Input langsung di tabel dengan tombol update
- **Update Stok**: Input langsung di tabel dengan tombol simpan
- **Manajemen Kategori**: Tambah, edit, dan hapus kategori menu

### 2. Manajemen Pengguna
- **Tambah Pengguna**: Form lengkap untuk menambah pengguna baru (admin/pelanggan)
- **Edit Pengguna**: Modal edit dengan semua informasi pengguna
- **Hapus Pengguna**: Konfirmasi sebelum menghapus dengan validasi
- **Toggle Status**: Aktif/nonaktif pengguna dengan satu klik
- **Validasi Email**: Cek duplikasi email sebelum menyimpan

### 3. Manajemen Harga Menu
- **Update Harga Langsung**: Input harga di tabel dengan validasi
- **Format Mata Uang**: Tampilan harga dengan format Rupiah
- **Validasi Harga**: Pastikan harga lebih dari 0

### 4. Manajemen Stok
- **Update Stok Langsung**: Input stok di tabel dengan tombol simpan
- **Status Ketersediaan**: Otomatis update berdasarkan stok
- **Validasi Stok**: Pastikan stok tidak negatif

### 5. Halaman Profil Admin
- **Informasi Profil**: Tampilan lengkap data admin
- **Edit Profil**: Modal edit dengan semua field
- **Upload Foto Profil**: Upload dan update foto profil
- **Ubah Password**: Form ganti password dengan validasi

### 6. Halaman Profil Pengguna
- **Profil Saya**: Halaman profil untuk pengguna biasa
- **Edit Profil**: Form edit profil lengkap
- **Upload Foto**: Upload foto profil pengguna
- **Ganti Password**: Form ganti password dengan konfirmasi

## File yang Dibuat/Dimodifikasi

### Controller
- `application/controllers/Admin.php` - Ditambahkan method untuk profil admin
- `application/controllers/Profile.php` - Controller baru untuk profil pengguna

### Views
- `application/views/admin/profile.php` - Halaman profil admin
- `application/views/profile/index.php` - Halaman profil pengguna
- `application/views/admin/menus.php` - Ditingkatkan dengan fitur edit lengkap
- `application/views/partials/navbar.php` - Update link profil

### Database
- `database/add_profile_image_column.sql` - Script untuk menambah kolom foto profil

### Routes
- `application/config/routes.php` - Ditambahkan route untuk profil dan fitur admin

## Fitur Utama yang Dapat Digunakan Admin

### 1. Menu Management
```
- Tambah menu baru dengan kategori dan stok
- Edit menu lengkap (nama, deskripsi, kategori, harga, stok)
- Update harga langsung di tabel
- Update stok langsung di tabel
- Tambah/edit/hapus kategori menu
```

### 2. User Management
```
- Tambah pengguna baru (admin/pelanggan)
- Edit informasi pengguna
- Hapus pengguna dengan validasi
- Aktif/nonaktif pengguna
- Validasi email unik
```

### 3. Profile Management
```
- Halaman profil admin lengkap
- Edit profil admin
- Upload foto profil admin
- Ganti password admin
- Halaman profil pengguna
- Edit profil pengguna
- Upload foto profil pengguna
```

## Cara Menggunakan

### 1. Akses Menu Admin
- Login sebagai admin
- Klik menu "Menu" di sidebar
- Gunakan tombol "Tambah Menu" untuk menambah menu baru
- Gunakan tombol "Tambah Kategori" untuk menambah kategori

### 2. Manajemen Pengguna
- Klik menu "Pengguna" di sidebar admin
- Gunakan tombol "Tambah Pengguna Baru" untuk menambah pengguna
- Klik tombol edit untuk mengubah informasi pengguna
- Klik tombol hapus untuk menghapus pengguna

### 3. Update Harga dan Stok
- Di halaman menu, gunakan input harga dan stok di tabel
- Klik tombol "Update" untuk harga
- Klik tombol "Simpan" untuk stok

### 4. Profil Admin
- Klik nama admin di topbar
- Pilih "Profil" dari dropdown
- Edit profil atau upload foto

### 5. Profil Pengguna
- Login sebagai pengguna biasa
- Klik menu "Profil" di navbar
- Edit profil atau upload foto

## Database Update

Jalankan script SQL berikut untuk menambahkan kolom foto profil:

```sql
-- Add profile_image column to user table
ALTER TABLE `user` ADD COLUMN `profile_image` VARCHAR(255) NULL AFTER `postal_code`;

-- Update existing users to have default profile image
UPDATE `user` SET `profile_image` = 'assets/img/default-avatar.png' WHERE `profile_image` IS NULL;
```

## Struktur Direktori Foto Profil

```
assets/img/profiles/
├── profile_1_timestamp.jpg
├── profile_2_timestamp.jpg
└── ...
```

## Validasi dan Keamanan

### 1. Validasi Form
- Semua input divalidasi di server-side
- Email harus unik
- Password minimal 6 karakter
- File upload dibatasi tipe dan ukuran

### 2. Keamanan
- AJAX request hanya untuk method yang diperlukan
- Validasi session untuk akses admin
- Upload file dengan validasi tipe dan ukuran
- Password di-hash dengan bcrypt

## Fitur Tambahan yang Bisa Dikembangkan

1. **Export/Import Data**: Export menu dan pengguna ke Excel/CSV
2. **Backup Database**: Fitur backup otomatis
3. **Log Aktivitas**: Mencatat semua aktivitas admin
4. **Notifikasi Real-time**: Notifikasi pesanan baru
5. **Dashboard Analytics**: Grafik penjualan dan statistik
6. **Multi-level Admin**: Level admin yang berbeda
7. **Bulk Operations**: Operasi massal untuk menu dan pengguna

## Troubleshooting

### 1. Upload Foto Gagal
- Pastikan direktori `assets/img/profiles/` ada dan writable
- Cek permission folder (755)
- Pastikan file tidak lebih dari 2MB

### 2. AJAX Error
- Cek console browser untuk error JavaScript
- Pastikan route sudah benar di `routes.php`
- Cek method controller sudah ada

### 3. Database Error
- Jalankan script SQL untuk menambah kolom foto profil
- Pastikan tabel `user` sudah ada
- Cek koneksi database

## Support

Untuk pertanyaan atau masalah teknis, silakan hubungi developer atau cek dokumentasi CodeIgniter.

