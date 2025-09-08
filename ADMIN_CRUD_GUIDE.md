# Panduan CRUD Admin - Warkop Abah

## Fitur CRUD Admin yang Tersedia

### 1. **Membuat Akun Baru (Create)**
- **Akses**: Hanya admin yang dapat membuat akun baru
- **Lokasi**: Halaman Admin > Users > Tombol "Tambah Pengguna Baru"
- **Field yang Tersedia**:
  - Nama Lengkap (wajib, 3-100 karakter)
  - Email (wajib, unik, valid email)
  - Peran (wajib: Admin/Pelanggan)
  - Telepon (opsional, 10-20 karakter)
  - Tanggal Lahir (opsional)
  - Alamat (opsional, maksimal 500 karakter)
  - Kota (opsional, maksimal 50 karakter)
  - Kode Pos (opsional, 5-10 karakter)
  - Password (wajib, minimal 6 karakter)
  - Status (wajib: Aktif/Tidak Aktif)

### 2. **Mengupdate Akun (Update)**
- **Akses**: Hanya admin yang dapat mengupdate akun
- **Lokasi**: Halaman Admin > Users > Tombol Edit (ikon pensil)
- **Fitur**:
  - Semua field dapat diupdate
  - Password opsional (jika dikosongkan, password tidak berubah)
  - Validasi email unik (tidak boleh sama dengan pengguna lain)
  - Konfirmasi perubahan dengan pesan sukses

### 3. **Menghapus Akun (Delete)**
- **Akses**: Hanya admin yang dapat menghapus akun
- **Lokasi**: Halaman Admin > Users > Tombol Delete (ikon trash)
- **Keamanan**:
  - Admin tidak dapat menghapus akun sendiri
  - Tidak dapat menghapus pengguna yang memiliki pesanan aktif
  - Konfirmasi detail pengguna sebelum menghapus
  - Menghapus semua data terkait (OTP, dll)

### 4. **Toggle Status Akun**
- **Akses**: Hanya admin yang dapat mengubah status
- **Lokasi**: Halaman Admin > Users > Tombol Toggle Status
- **Fitur**: Mengubah status antara Aktif/Tidak Aktif

## Validasi dan Keamanan

### Validasi Input
- **Nama**: 3-100 karakter, wajib
- **Email**: Format valid, unik, maksimal 100 karakter
- **Telepon**: 10-20 karakter (jika diisi)
- **Alamat**: Maksimal 500 karakter
- **Kota**: Maksimal 50 karakter
- **Kode Pos**: 5-10 karakter
- **Password**: Minimal 6 karakter, maksimal 255 karakter

### Keamanan
- Hanya admin (role_id = 1) yang dapat mengakses fitur CRUD
- Validasi AJAX request
- Password di-hash menggunakan PASSWORD_BCRYPT
- Email di-lowercase untuk konsistensi
- Mencegah admin menghapus diri sendiri
- Mencegah penghapusan pengguna dengan pesanan aktif

## Pesan Notifikasi

### Pesan Sukses
- ✅ "Pengguna berhasil ditambahkan dengan ID: [ID]"
- ✅ "Pengguna berhasil diperbarui"
- ✅ "Pengguna berhasil dihapus beserta semua data terkait"
- ✅ "Status pengguna berhasil diubah menjadi [Status]"

### Pesan Error
- ❌ "Akses ditolak. Hanya admin yang dapat [action]"
- ❌ "Email sudah digunakan oleh pengguna lain"
- ❌ "Pengguna tidak ditemukan"
- ❌ "Tidak dapat menghapus akun sendiri"
- ❌ "Tidak dapat menghapus pengguna yang memiliki pesanan aktif"
- ❌ "Password minimal 6 karakter"

## Cara Menggunakan

### 1. Membuat Akun Baru
1. Login sebagai admin
2. Buka halaman Admin > Users
3. Klik tombol "Tambah Pengguna Baru"
4. Isi form dengan data yang valid
5. Klik "Tambah Pengguna"
6. Tunggu konfirmasi sukses

### 2. Mengupdate Akun
1. Di halaman Users, klik tombol Edit (ikon pensil)
2. Modal akan terbuka dengan data pengguna
3. Ubah data yang diperlukan
4. Klik "Update Pengguna"
5. Tunggu konfirmasi sukses

### 3. Menghapus Akun
1. Di halaman Users, klik tombol Delete (ikon trash)
2. Konfirmasi dialog akan muncul dengan detail pengguna
3. Klik "OK" untuk konfirmasi
4. Tunggu konfirmasi sukses

### 4. Mengubah Status
1. Di halaman Users, klik tombol Toggle Status
2. Status akan berubah otomatis
3. Tunggu konfirmasi sukses

## Troubleshooting

### Jika Tidak Bisa Membuat Akun
- Pastikan login sebagai admin
- Cek validasi form (semua field wajib terisi)
- Pastikan email belum digunakan
- Pastikan password minimal 6 karakter

### Jika Tidak Bisa Update Akun
- Pastikan login sebagai admin
- Cek validasi form
- Pastikan email baru tidak digunakan pengguna lain
- Jika update password, pastikan minimal 6 karakter

### Jika Tidak Bisa Hapus Akun
- Pastikan login sebagai admin
- Pastikan bukan menghapus akun sendiri
- Pastikan pengguna tidak memiliki pesanan aktif
- Cek apakah pengguna masih ada di database

## File yang Terlibat

### Controller
- `application/controllers/Admin.php`
  - `add_user()` - Membuat akun baru
  - `edit_user()` - Mengambil data untuk edit
  - `update_user()` - Mengupdate akun
  - `delete_user()` - Menghapus akun
  - `toggle_user_status()` - Mengubah status

### Model
- `application/models/User_model.php`
  - `createUser()` - Insert data user
  - `getById()` - Ambil data by ID
  - `getByEmail()` - Ambil data by email
  - `updateUser()` - Update data user
  - `deleteUser()` - Hapus data user
  - `deleteOtpByUserId()` - Hapus OTP user

### View
- `application/views/admin/users.php`
  - Form tambah pengguna
  - Form edit pengguna
  - Tabel daftar pengguna
  - JavaScript untuk AJAX

### Routes
- `application/config/routes.php`
  - `admin/add_user`
  - `admin/edit_user`
  - `admin/update_user`
  - `admin/delete_user`
  - `admin/toggle_user_status`

## Testing

### Test Case 1: Membuat Akun Admin
1. Login sebagai admin
2. Buat akun admin baru
3. **Expected**: Akun berhasil dibuat dengan role admin

### Test Case 2: Membuat Akun Pelanggan
1. Login sebagai admin
2. Buat akun pelanggan baru
3. **Expected**: Akun berhasil dibuat dengan role pelanggan

### Test Case 3: Update Data Pengguna
1. Login sebagai admin
2. Edit data pengguna
3. **Expected**: Data berhasil diupdate

### Test Case 4: Hapus Pengguna
1. Login sebagai admin
2. Hapus pengguna (bukan diri sendiri)
3. **Expected**: Pengguna berhasil dihapus

### Test Case 5: Keamanan
1. Coba akses sebagai non-admin
2. **Expected**: Akses ditolak
3. Coba hapus akun sendiri
4. **Expected**: Tidak bisa menghapus diri sendiri

## Status: ✅ COMPLETED

Semua fitur CRUD admin telah selesai dan siap digunakan:
- ✅ Create (Membuat akun)
- ✅ Read (Melihat daftar pengguna)
- ✅ Update (Mengupdate akun)
- ✅ Delete (Menghapus akun)
- ✅ Toggle Status (Mengubah status)
- ✅ Validasi dan keamanan
- ✅ Notifikasi yang user-friendly
