<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Profil - Warkop Abah</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  
  <!-- Fonts & Icons -->
  <link href="<?= base_url('assets/vendor/fonts/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  
  <!-- SB Admin 2 CSS -->
  <link href="<?= base_url('assets/vendor/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
  
  <!-- Dashboard Custom CSS -->
  <link href="<?= base_url('assets/css/dashboard.css'); ?>" rel="stylesheet">
</head>
<body class="bg-light">
  <!-- Header -->
  <nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
      <a class="navbar-brand" href="<?= site_url('dashboard'); ?>">
        <i class="fas fa-coffee mr-2"></i>Warkop Abah
      </a>
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('dashboard'); ?>">
              <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('dashboard/riwayat'); ?>">
              <i class="fas fa-history mr-1"></i>Riwayat
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="<?= site_url('dashboard/profil'); ?>">
              <i class="fas fa-user mr-1"></i>Profil
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('keluar'); ?>">
              <i class="fas fa-sign-out-alt mr-1"></i>Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Profile Header -->
  <div class="profile-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-3 text-center">
          <div class="profile-avatar d-flex align-items-center justify-content-center bg-primary text-white" style="font-size: 3rem;">
            <i class="fas fa-user"></i>
          </div>
        </div>
        <div class="col-md-9">
          <h2 class="mb-2"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></h2>
          <p class="mb-1"><i class="fas fa-envelope mr-2"></i><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></p>
          <p class="mb-0"><i class="fas fa-user-tag mr-2"></i>User ID: <?= (int)$id ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container">
      <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8 mb-4">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-user-edit mr-2"></i>Informasi Profil</h5>
            </div>
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" placeholder="+62 812-3456-7890">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control">
                  </div>
                </div>
                
                <div class="mb-3">
                  <label class="form-label">Alamat</label>
                  <textarea class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                </div>
                
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Kota</label>
                    <input type="text" class="form-control" placeholder="Jakarta">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Pos</label>
                    <input type="text" class="form-control" placeholder="12345">
                  </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
              </form>
            </div>
          </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
          <!-- Account Stats -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-chart-bar mr-2"></i>Statistik Akun</h5>
            </div>
            <div class="card-body">
              <div class="row text-center">
                                 <div class="col-6 mb-3">
                   <div class="border-right">
                     <h4 class="text-primary mb-1"><?= $order_stats['total_orders'] ?? 0 ?></h4>
                     <small class="text-muted">Total Pesanan</small>
                   </div>
                 </div>
                 <div class="col-6 mb-3">
                   <h4 class="text-success mb-1"><?= $order_stats['completed_orders'] ?? 0 ?></h4>
                   <small class="text-muted">Pesanan Selesai</small>
                 </div>
                 <div class="col-6">
                   <h4 class="text-warning mb-1"><?= $order_stats['pending_orders'] ?? 0 ?></h4>
                   <small class="text-muted">Pending</small>
                 </div>
                 <div class="col-6">
                   <h4 class="text-danger mb-1"><?= $order_stats['cancelled_orders'] ?? 0 ?></h4>
                   <small class="text-muted">Dibatalkan</small>
                 </div>
              </div>
            </div>
          </div>
          
          <!-- Change Password -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-lock mr-2"></i>Ubah Password</h5>
            </div>
            <div class="card-body">
              <form>
                <div class="mb-3">
                  <label class="form-label">Password Lama</label>
                  <input type="password" class="form-control" placeholder="Masukkan password lama">
                </div>
                <div class="mb-3">
                  <label class="form-label">Password Baru</label>
                  <input type="password" class="form-control" placeholder="Masukkan password baru">
                </div>
                <div class="mb-3">
                  <label class="form-label">Konfirmasi Password</label>
                  <input type="password" class="form-control" placeholder="Konfirmasi password baru">
                </div>
                <button type="submit" class="btn btn-outline-primary btn-block">
                  <i class="fas fa-key mr-2"></i>Ubah Password
                </button>
              </form>
            </div>
          </div>
          
          <!-- Account Actions -->
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-cog mr-2"></i>Aksi Akun</h5>
            </div>
            <div class="card-body">
              <div class="d-grid gap-2">
                <button class="btn btn-outline-info">
                  <i class="fas fa-download mr-2"></i>Download Data
                </button>
                <button class="btn btn-outline-warning">
                  <i class="fas fa-bell mr-2"></i>Pengaturan Notifikasi
                </button>
                <button class="btn btn-outline-danger">
                  <i class="fas fa-trash mr-2"></i>Hapus Akun
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h5><i class="fas fa-coffee mr-2"></i>Warkop Abah</h5>
          <p class="mb-0">Nikmati kopi terbaik dengan suasana yang nyaman dan pelayanan yang ramah.</p>
        </div>
        <div class="col-md-6 text-md-right">
          <p class="mb-0">
            <i class="fas fa-map-marker-alt mr-2"></i>Jl. Dago atas No.933<br>
            <i class="fas fa-phone mr-2"></i>+62 812-3456-7890<br>
            <i class="fas fa-envelope mr-2"></i>info@warkopabah.com
          </p>
        </div>
      </div>
      <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
      <div class="row">
        <div class="col-12 text-center">
          <p class="mb-0">&copy; 2024 Warkop Abah. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- JS -->
  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
</body>
</html>
