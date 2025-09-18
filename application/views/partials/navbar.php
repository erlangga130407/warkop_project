<?php
// Partial navbar untuk area user (non-admin)
// Gunakan variabel $active untuk menandai menu aktif: 'dashboard' | 'menu' | 'riwayat' | 'profil' | 'cart'
?>
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
          <a class="nav-link <?= (isset($active) && $active === 'dashboard') ? 'active' : '' ?>" href="<?= site_url('dashboard'); ?>">
            <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (isset($active) && $active === 'menu') ? 'active' : '' ?>" href="<?= site_url('menu'); ?>">
            <i class="fas fa-utensils mr-1"></i>Menu
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (isset($active) && $active === 'riwayat') ? 'active' : '' ?>" href="<?= site_url('dashboard/riwayat'); ?>">
            <i class="fas fa-history mr-1"></i>Riwayat
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (isset($active) && $active === 'profil') ? 'active' : '' ?>" href="<?= site_url('dashboard/profil'); ?>">
            <i class="fas fa-user mr-1"></i>Profil
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= (isset($active) && $active === 'cart') ? 'active' : '' ?>" href="<?= site_url('menu/cart'); ?>">
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
  <script>
    // Inisialisasi jumlah keranjang jika elemen ada
    (function(){
      var el = document.getElementById('cart-count');
      if (!el) return;
      if (typeof $ === 'undefined') return;
      $.ajax({
        url: '<?= site_url('menu/get_cart_count'); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response){ if (response && typeof response.cart_count !== 'undefined') { $('#cart-count').text(response.cart_count); } }
      });
    })();
  </script>
</nav>


