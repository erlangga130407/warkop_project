<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Menu - Warkop Abah</title>
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
            <a class="nav-link active" href="<?= site_url('menu'); ?>">
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
      <!-- Page Header -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
              <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1">
                  <h2 class="mb-2"><i class="fas fa-utensils mr-2"></i>Menu Warkop Abah</h2>
                  <p class="mb-0">Pilih menu favorit Anda dan nikmati kopi terbaik</p>
                </div>
                <?php if (isset($user) && $user['role_id'] == 1): ?>
                  <div>
                    <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#addMenuModal">
                      <i class="fas fa-plus mr-1"></i>Tambah Menu
                    </button>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Search Bar -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <form action="<?= site_url('menu/search'); ?>" method="GET">
                <div class="input-group">
                  <input type="text" class="form-control" name="q" placeholder="Cari menu..." value="<?= isset($keyword) ? htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') : '' ?>">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Category Filter -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Kategori</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 mb-2">
                  <a href="<?= site_url('menu'); ?>" class="btn btn-outline-primary btn-block <?= !isset($current_category) ? 'active' : '' ?>">
                    Semua Menu
                  </a>
                </div>
                <?php foreach ($categories as $category): ?>
                  <div class="col-md-3 mb-2">
                    <a href="<?= site_url('menu/category/' . $category['id']); ?>" class="btn btn-outline-primary btn-block <?= (isset($current_category) && $current_category['id'] == $category['id']) ? 'active' : '' ?>">
                      <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Featured Menus -->
      <?php if (!empty($featured_menus)): ?>
        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-star mr-2"></i>Menu Favorit</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <?php foreach ($featured_menus as $menu): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                      <div class="card border-0 shadow-sm h-100 menu-card">
                        <div class="card-body">
                          <div class="text-center mb-3">
                            <div class="menu-image-placeholder">
                              <i class="fas fa-coffee fa-3x text-muted"></i>
                            </div>
                          </div>
                          <h5 class="card-title text-center"><?= htmlspecialchars($menu['name'], ENT_QUOTES, 'UTF-8') ?></h5>
                          <p class="text-muted text-center small mb-2"><?= htmlspecialchars($menu['category_name'], ENT_QUOTES, 'UTF-8') ?></p>
                          <p class="card-text text-center small"><?= htmlspecialchars($menu['description'], ENT_QUOTES, 'UTF-8') ?></p>
                          <div class="text-center">
                            <h6 class="text-primary mb-3">Rp <?= number_format($menu['price'], 0, ',', '.') ?></h6>
                            <div class="btn-group" role="group">
                              <a href="<?= site_url('menu/detail/' . $menu['id']); ?>" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye mr-1"></i>Detail
                              </a>
                              <button class="btn btn-primary btn-sm add-to-cart" data-menu-id="<?= $menu['id'] ?>">
                                <i class="fas fa-cart-plus mr-1"></i>Tambah
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- All Menus -->
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-list mr-2"></i>Semua Menu</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <?php if (!empty($all_menus)): ?>
                  <?php foreach ($all_menus as $menu): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                      <div class="card border-0 shadow-sm h-100 menu-card">
                        <div class="card-body">
                          <div class="text-center mb-3">
                            <div class="menu-image-placeholder">
                              <i class="fas fa-coffee fa-3x text-muted"></i>
                            </div>
                          </div>
                          <h5 class="card-title text-center"><?= htmlspecialchars($menu['name'], ENT_QUOTES, 'UTF-8') ?></h5>
                          <p class="text-muted text-center small mb-2"><?= htmlspecialchars($menu['category_name'], ENT_QUOTES, 'UTF-8') ?></p>
                          <p class="card-text text-center small"><?= htmlspecialchars($menu['description'], ENT_QUOTES, 'UTF-8') ?></p>
                          <div class="text-center">
                            <h6 class="text-primary mb-3">Rp <?= number_format($menu['price'], 0, ',', '.') ?></h6>
                            <div class="btn-group" role="group">
                              <a href="<?= site_url('menu/detail/' . $menu['id']); ?>" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye mr-1"></i>Detail
                              </a>
                              <button class="btn btn-primary btn-sm add-to-cart" data-menu-id="<?= $menu['id'] ?>">
                                <i class="fas fa-cart-plus mr-1"></i>Tambah
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="col-12">
                    <div class="text-center text-muted py-5">
                      <i class="fas fa-coffee fa-3x mb-3"></i>
                      <h5>Tidak ada menu tersedia</h5>
                      <p>Silakan coba kategori lain atau kata kunci pencarian yang berbeda.</p>
                    </div>
                  </div>
                <?php endif; ?>
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
    $(document).ready(function() {
      // Add to cart functionality
      $('.add-to-cart').click(function() {
        var menuId = $(this).data('menu-id');
        var button = $(this);
        
        $.ajax({
          url: '<?= site_url('menu/add_to_cart'); ?>',
          type: 'POST',
          data: {
            menu_id: menuId,
            quantity: 1
          },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              // Update cart count
              $('#cart-count').text(response.cart_count);
              
              // Show success message
              button.html('<i class="fas fa-check mr-1"></i>Ditambahkan');
              button.removeClass('btn-primary').addClass('btn-success');
              
              setTimeout(function() {
                button.html('<i class="fas fa-cart-plus mr-1"></i>Tambah');
                button.removeClass('btn-success').addClass('btn-primary');
              }, 2000);
            } else {
              alert('Gagal menambahkan ke keranjang: ' + response.message);
            }
          },
          error: function() {
            alert('Terjadi kesalahan. Silakan coba lagi.');
          }
        });
      });

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

  <!-- Add Menu Modal -->
  <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addMenuModalLabel">Tambah Menu Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addMenuForm">
          <div class="modal-body">
            <div class="form-group">
              <label for="menu_name">Nama Menu</label>
              <input type="text" class="form-control" id="menu_name" name="name" required>
            </div>
            <div class="form-group">
              <label for="menu_category">Kategori</label>
              <select class="form-control" id="menu_category" name="category_id" required>
                <option value="">Pilih Kategori</option>
                <?php if (isset($categories)): ?>
                  <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="menu_description">Deskripsi</label>
              <textarea class="form-control" id="menu_description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="menu_price">Harga</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp</span>
                </div>
                <input type="number" class="form-control" id="menu_price" name="price" min="0" step="100" required>
              </div>
            </div>
            <div class="form-group">
              <label for="menu_image">URL Gambar (Opsional)</label>
              <input type="url" class="form-control" id="menu_image" name="image" placeholder="https://example.com/image.jpg">
            </div>
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="menu_featured" name="is_featured" value="1">
                <label class="form-check-label" for="menu_featured">
                  Menu Unggulan
                </label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="menu_available" name="is_available" value="1" checked>
                <label class="form-check-label" for="menu_available">
                  Tersedia
                </label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Tambah Menu</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Handle add menu form submission
    $('#addMenuForm').on('submit', function(e) {
      e.preventDefault();
      
      $.ajax({
        url: '<?= site_url('menu/add_menu'); ?>',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            alert('Menu berhasil ditambahkan');
            $('#addMenuModal').modal('hide');
            $('#addMenuForm')[0].reset();
            location.reload();
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function() {
          alert('Terjadi kesalahan saat menambahkan menu');
        }
      });
    });
  </script>
</body>
</html>
