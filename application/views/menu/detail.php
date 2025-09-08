<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($menu['name'], ENT_QUOTES, 'UTF-8') ?> - Warkop Abah</title>
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
              <span class="badge badge-light ml-1" id="cart-count">0</span>
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
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?= site_url('menu'); ?>">Menu</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($menu['name'], ENT_QUOTES, 'UTF-8') ?></li>
        </ol>
      </nav>

      <div class="row">
        <!-- Menu Detail -->
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="text-center mb-4">
                    <div class="menu-image-placeholder" style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 10px;">
                      <i class="fas fa-coffee fa-4x text-muted"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <h2 class="mb-2"><?= htmlspecialchars($menu['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                  <p class="text-muted mb-2">
                    <i class="fas fa-tag mr-1"></i><?= htmlspecialchars($menu['category_name'], ENT_QUOTES, 'UTF-8') ?>
                  </p>
                  <h4 class="text-primary mb-3">Rp <?= number_format($menu['price'], 0, ',', '.') ?></h4>
                  
                  <div class="mb-4">
                    <h5>Deskripsi</h5>
                    <p class="text-muted"><?= htmlspecialchars($menu['description'], ENT_QUOTES, 'UTF-8') ?></p>
                  </div>

                  <div class="row align-items-center">
                    <div class="col-md-6">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                        </div>
                        <input type="number" class="form-control text-center" value="1" min="1" max="99" id="quantity">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <button class="btn btn-primary btn-lg btn-block" onclick="addToCart()">
                        <i class="fas fa-cart-plus mr-2"></i>Tambah ke Keranjang
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Related Menus -->
        <div class="col-lg-4">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-star mr-2"></i>Menu Terkait</h5>
            </div>
            <div class="card-body">
              <?php if (!empty($related_menus)): ?>
                <?php foreach ($related_menus as $related): ?>
                  <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <div class="flex-shrink-0">
                      <div class="menu-image-placeholder" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px;">
                        <i class="fas fa-coffee text-muted"></i>
                      </div>
                    </div>
                    <div class="flex-grow-1 ml-3">
                      <h6 class="mb-1">
                        <a href="<?= site_url('menu/detail/' . $related['id']); ?>" class="text-decoration-none">
                          <?= htmlspecialchars($related['name'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                      </h6>
                      <p class="text-muted small mb-1"><?= htmlspecialchars($related['category_name'], ENT_QUOTES, 'UTF-8') ?></p>
                      <h6 class="text-primary mb-0">Rp <?= number_format($related['price'], 0, ',', '.') ?></h6>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p class="text-muted text-center">Tidak ada menu terkait</p>
              <?php endif; ?>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white">
              <h6 class="mb-0"><i class="fas fa-bolt mr-2"></i>Aksi Cepat</h6>
            </div>
            <div class="card-body">
              <a href="<?= site_url('menu'); ?>" class="btn btn-outline-primary btn-block mb-2">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Menu
              </a>
              <a href="<?= site_url('menu/cart'); ?>" class="btn btn-outline-success btn-block">
                <i class="fas fa-shopping-cart mr-2"></i>Lihat Keranjang
              </a>
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
    function increaseQuantity() {
      var qty = parseInt($('#quantity').val());
      if (qty < 99) {
        $('#quantity').val(qty + 1);
      }
    }

    function decreaseQuantity() {
      var qty = parseInt($('#quantity').val());
      if (qty > 1) {
        $('#quantity').val(qty - 1);
      }
    }

    function addToCart() {
      var menuId = <?= $menu['id'] ?>;
      var quantity = parseInt($('#quantity').val());
      
      $.ajax({
        url: '<?= site_url('menu/add_to_cart'); ?>',
        type: 'POST',
        data: {
          menu_id: menuId,
          quantity: quantity
        },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            // Update cart count
            $('#cart-count').text(response.cart_count);
            
            // Show success message
            alert('Menu berhasil ditambahkan ke keranjang!');
          } else {
            alert('Gagal menambahkan ke keranjang: ' + response.message);
          }
        },
        error: function() {
          alert('Terjadi kesalahan. Silakan coba lagi.');
        }
      });
    }

    $(document).ready(function() {
      // Update cart count on page load
      updateCartCount();
      
      function updateCartCount() {
        $.ajax({
          url: '<?= site_url('menu/get_cart_count'); ?>',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            $('#cart-count').text(response.cart_count);
          }
        });
      }
    });
  </script>
</body>
</html>
