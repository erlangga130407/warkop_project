<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Keranjang - Warkop Abah</title>
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
            <a class="nav-link active" href="<?= site_url('menu/cart'); ?>">
              <i class="fas fa-shopping-cart mr-1"></i>Keranjang
              <span class="badge badge-light ml-1" id="cart-count"><?= count($cart) ?></span>
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
              <h2 class="mb-2"><i class="fas fa-shopping-cart mr-2"></i>Keranjang Belanja</h2>
              <p class="mb-0">Periksa pesanan Anda sebelum checkout</p>
            </div>
          </div>
        </div>
      </div>

      <?php if (!empty($cart)): ?>
        <!-- Cart Items -->
        <div class="row">
          <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-list mr-2"></i>Item di Keranjang</h5>
              </div>
              <div class="card-body">
                <?php foreach ($cart as $item): ?>
                  <div class="row align-items-center mb-3 pb-3 border-bottom">
                    <div class="col-md-6">
                      <h6 class="mb-1"><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></h6>
                      <p class="text-muted small mb-0">Rp <?= number_format($item['price'], 0, ',', '.') ?> per item</p>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity(<?= $item['menu_id'] ?>, <?= $item['quantity'] - 1 ?>)">-</button>
                        </div>
                        <input type="number" class="form-control form-control-sm text-center" value="<?= $item['quantity'] ?>" min="1" max="99" id="qty-<?= $item['menu_id'] ?>">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity(<?= $item['menu_id'] ?>, <?= $item['quantity'] + 1 ?>)">+</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <h6 class="mb-0 text-primary">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></h6>
                    </div>
                    <div class="col-md-1">
                      <button class="btn btn-outline-danger btn-sm" onclick="removeItem(<?= $item['menu_id'] ?>)">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </div>
                <?php endforeach; ?>
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
                <a href="<?= site_url('menu/checkout'); ?>" class="btn btn-primary btn-block">
                  <i class="fas fa-credit-card mr-2"></i>Checkout
                </a>
                <a href="<?= site_url('menu'); ?>" class="btn btn-outline-secondary btn-block mt-2">
                  <i class="fas fa-arrow-left mr-2"></i>Lanjut Belanja
                </a>
                <button class="btn btn-outline-danger btn-block mt-2" onclick="clearCart()">
                  <i class="fas fa-trash mr-2"></i>Hapus Semua
                </button>
              </div>
            </div>
          </div>
        </div>
      <?php else: ?>
        <!-- Empty Cart -->
        <div class="row">
          <div class="col-12">
            <div class="card border-0 shadow-sm">
              <div class="card-body text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                <h4>Keranjang Kosong</h4>
                <p class="text-muted mb-4">Belum ada item di keranjang Anda. Mulai berbelanja sekarang!</p>
                <a href="<?= site_url('menu'); ?>" class="btn btn-primary">
                  <i class="fas fa-utensils mr-2"></i>Lihat Menu
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
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

  <script>
    function updateQuantity(menuId, quantity) {
      if (quantity < 1) {
        removeItem(menuId);
        return;
      }
      
      $.ajax({
        url: '<?= site_url('menu/update_cart'); ?>',
        type: 'POST',
        data: {
          menu_id: menuId,
          quantity: quantity
        },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            location.reload();
          } else {
            alert('Gagal mengupdate keranjang: ' + response.message);
          }
        },
        error: function() {
          alert('Terjadi kesalahan. Silakan coba lagi.');
        }
      });
    }

    function removeItem(menuId) {
      if (confirm('Yakin ingin menghapus item ini dari keranjang?')) {
        $.ajax({
          url: '<?= site_url('menu/remove_from_cart'); ?>',
          type: 'POST',
          data: {
            menu_id: menuId
          },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              alert('Item berhasil dihapus dari keranjang');
              location.reload();
            } else {
              alert('Gagal menghapus item: ' + response.message);
            }
          },
          error: function() {
            alert('Terjadi kesalahan. Silakan coba lagi.');
          }
        });
      }
    }

    function clearCart() {
      if (confirm('Yakin ingin menghapus semua item dari keranjang? Tindakan ini tidak dapat dibatalkan.')) {
        $.ajax({
          url: '<?= site_url('menu/clear_cart'); ?>',
          type: 'POST',
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              alert('Keranjang berhasil dikosongkan');
              location.reload();
            } else {
              alert('Gagal mengosongkan keranjang: ' + response.message);
            }
          },
          error: function() {
            alert('Terjadi kesalahan. Silakan coba lagi.');
          }
        });
      }
    }

    // Update quantity when input changes
    $(document).ready(function() {
      $('input[type="number"]').on('change', function() {
        var menuId = $(this).attr('id').replace('qty-', '');
        var quantity = parseInt($(this).val());
        
        if (quantity < 1) {
          removeItem(menuId);
        } else {
          updateQuantity(menuId, quantity);
        }
      });
    });
  </script>
</body>
</html>
