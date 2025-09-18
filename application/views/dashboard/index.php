<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard - Warkop Abah</title>
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
  <?php $active = 'dashboard'; $this->load->view('partials/navbar', compact('active')); ?>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container mt-4">
      <!-- Welcome Section -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
              <h2 class="mb-2">Selamat Datang, <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>!</h2>
              <p class="mb-0">
                <span class="badge badge-light mr-2"><?= $role_id == 1 ? 'Administrator' : 'Pelanggan' ?></span>
                Nikmati kopi terbaik dengan suasana yang nyaman
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
          <div class="card card-stats border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total Pesanan</h5>
                  <span class="h2 font-weight-bold mb-0"><?= $order_stats['total_orders'] ?? 0 ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                    <i class="fas fa-shopping-cart"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
          <div class="card card-stats border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Total Pengeluaran</h5>
                  <span class="h2 font-weight-bold mb-0">Rp <?= number_format($order_stats['total_spent'] ?? 0, 0, ',', '.') ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                    <i class="fas fa-dollar-sign"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
          <div class="card card-stats border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Pesanan Selesai</h5>
                  <span class="h2 font-weight-bold mb-0"><?= $order_stats['completed_orders'] ?? 0 ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                    <i class="fas fa-check-circle"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
          <div class="card card-stats border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Pesanan Pending</h5>
                  <span class="h2 font-weight-bold mb-0"><?= $order_stats['pending_orders'] ?? 0 ?></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Featured Menus & Recent Orders -->
      <div class="row">
        <!-- Featured Menus -->
        <div class="col-lg-8 mb-4">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-star mr-2"></i>Menu Favorit</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <?php if (!empty($featured_menus)): ?>
                  <?php foreach ($featured_menus as $menu): ?>
                    <div class="col-md-6 mb-3">
                      <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                          <div class="d-flex justify-content-between align-items-start">
                            <div>
                              <h6 class="card-title mb-1"><?= htmlspecialchars($menu['name'], ENT_QUOTES, 'UTF-8') ?></h6>
                              <p class="text-muted small mb-2"><?= htmlspecialchars($menu['category_name'], ENT_QUOTES, 'UTF-8') ?></p>
                              <p class="text-muted small mb-2"><?= htmlspecialchars($menu['description'], ENT_QUOTES, 'UTF-8') ?></p>
                              <h6 class="text-primary mb-0">Rp <?= number_format($menu['price'], 0, ',', '.') ?></h6>
                            </div>
                            <a href="<?= site_url('menu/detail/' . $menu['id']); ?>" class="btn btn-sm btn-outline-primary">
                              <i class="fas fa-eye"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="col-12">
                    <p class="text-muted text-center">Belum ada menu favorit</p>
                  </div>
                <?php endif; ?>
              </div>
              <div class="text-center mt-3">
                <a href="<?= site_url('menu'); ?>" class="btn btn-primary">
                  <i class="fas fa-utensils mr-2"></i>Lihat Semua Menu
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="col-lg-4 mb-4">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-clock mr-2"></i>Pesanan Terbaru</h5>
            </div>
            <div class="card-body">
              <?php if (!empty($recent_orders)): ?>
                <?php foreach ($recent_orders as $order): ?>
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                      <h6 class="mb-1"><?= htmlspecialchars($order['order_number'], ENT_QUOTES, 'UTF-8') ?></h6>
                      <small class="text-muted"><?= date('d M Y', strtotime($order['created_at'])) ?></small>
                    </div>
                    <div class="text-right">
                      <span class="badge badge-<?= $order['status'] == 'completed' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'danger') ?>">
                        <?= $order['status'] == 'completed' ? 'Selesai' : ($order['status'] == 'pending' ? 'Menunggu' : 'Dibatalkan') ?>
                      </span>
                      <div class="small text-muted">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></div>
                    </div>
                  </div>
                <?php endforeach; ?>
                <div class="text-center mt-3">
                  <a href="<?= site_url('dashboard/riwayat'); ?>" class="btn btn-outline-primary btn-sm">
                    Lihat Semua Riwayat
                  </a>
                </div>
              <?php else: ?>
                <p class="text-muted text-center">Belum ada pesanan</p>
                <div class="text-center">
                  <a href="<?= site_url('menu'); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-utensils mr-2"></i>Pesan Sekarang
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-bolt mr-2"></i>Aksi Cepat</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <a href="<?= site_url('menu'); ?>" class="btn btn-primary btn-block">
                    <i class="fas fa-utensils mr-2"></i>Lihat Menu
                  </a>
                </div>
                <div class="col-md-3 mb-3">
                  <a href="<?= site_url('menu/cart'); ?>" class="btn btn-success btn-block">
                    <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                  </a>
                </div>
                <div class="col-md-3 mb-3">
                  <a href="<?= site_url('dashboard/riwayat'); ?>" class="btn btn-info btn-block">
                    <i class="fas fa-history mr-2"></i>Riwayat
                  </a>
                </div>
                <div class="col-md-3 mb-3">
                  <a href="<?= site_url('dashboard/profil'); ?>" class="btn btn-warning btn-block">
                    <i class="fas fa-user mr-2"></i>Profil
                  </a>
                </div>
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
