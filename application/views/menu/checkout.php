<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Checkout - Warkop Abah</title>
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
            <a class="nav-link" href="<?= site_url('menu'); ?>">
              <i class="fas fa-utensils mr-1"></i>Menu
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('dashboard/riwayat'); ?>">
              <i class="fas fa-history mr-1"></i>Riwayat
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('dashboard/profil'); ?>">
              <i class="fas fa-user mr-1"></i>Profil
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('menu/cart'); ?>">
              <i class="fas fa-shopping-cart mr-1"></i>Keranjang
              <span class="badge badge-light ml-1"><?= count($cart) ?></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('keluar'); ?>">
              <i class="fas fa-sign-out-alt mr-1"></i>Keluar
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container mt-4">
      <!-- Page Header -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
              <h2 class="mb-2"><i class="fas fa-credit-card mr-2"></i>Checkout</h2>
              <p class="mb-0">Selesaikan pesanan Anda</p>
            </div>
          </div>
        </div>
      </div>

      <?= $this->session->flashdata('message'); ?>

      <form action="<?= site_url('menu/checkout'); ?>" method="POST">
        <div class="row">
          <!-- Order Details -->
          <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-list mr-2"></i>Detail Pesanan</h5>
              </div>
              <div class="card-body">
                <?php foreach ($cart as $item): ?>
                  <div class="row align-items-center mb-3 pb-3 border-bottom">
                    <div class="col-md-8">
                      <h6 class="mb-1"><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></h6>
                      <p class="text-muted small mb-0">Jumlah: <?= $item['quantity'] ?> x Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                    </div>
                    <div class="col-md-4 text-right">
                      <h6 class="mb-0 text-primary">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></h6>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Payment Method -->
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-credit-card mr-2"></i>Metode Pembayaran</h5>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" checked>
                    <label class="form-check-label" for="cash">
                      <i class="fas fa-money-bill-wave mr-2"></i>Tunai (Bayar di tempat)
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="transfer">
                    <label class="form-check-label" for="transfer">
                      <i class="fas fa-university mr-2"></i>Transfer Bank
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="qris" value="qris">
                    <label class="form-check-label" for="qris">
                      <i class="fas fa-qrcode mr-2"></i>QRIS
                    </label>
                  </div>
                </div>
                <?= form_error('payment_method', '<div class="text-danger small">', '</div>'); ?>
              </div>
            </div>

            <!-- Notes -->
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-sticky-note mr-2"></i>Catatan Pesanan</h5>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <textarea class="form-control" name="notes" rows="3" placeholder="Tambahkan catatan khusus untuk pesanan Anda (opsional)"></textarea>
                </div>
                <?= form_error('notes', '<div class="text-danger small">', '</div>'); ?>
              </div>
            </div>
          </div>

          <!-- Order Summary -->
          <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-receipt mr-2"></i>Ringkasan Pesanan</h5>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                  <span>Subtotal:</span>
                  <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span>Pajak (10%):</span>
                  <span>Rp <?= number_format($total * 0.1, 0, ',', '.') ?></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                  <strong>Total:</strong>
                  <strong class="text-primary">Rp <?= number_format($total * 1.1, 0, ',', '.') ?></strong>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block mb-2">
                  <i class="fas fa-check mr-2"></i>Konfirmasi Pesanan
                </button>
                
                <a href="<?= site_url('menu/cart'); ?>" class="btn btn-outline-secondary btn-block">
                  <i class="fas fa-arrow-left mr-2"></i>Kembali ke Keranjang
                </a>
              </div>
            </div>

            <!-- Payment Info -->
            <div class="card border-0 shadow-sm mt-3">
              <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Informasi Pembayaran</h6>
              </div>
              <div class="card-body">
                <small class="text-muted">
                  <strong>Tunai:</strong> Bayar langsung saat mengambil pesanan<br>
                  <strong>Transfer:</strong> Transfer ke rekening yang akan diberikan<br>
                  <strong>QRIS:</strong> Scan QR code untuk pembayaran digital
                </small>
              </div>
            </div>
          </div>
        </div>
      </form>
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
          <p class="mb-0">&copy; 2024 Warkop Abah. Semua hak dilindungi.</p>
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
