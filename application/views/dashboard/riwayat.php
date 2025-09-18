<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Riwayat - Warkop Abah</title>
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
            <a class="nav-link active" href="<?= site_url('dashboard/riwayat'); ?>">
              <i class="fas fa-history mr-1"></i>Riwayat
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('dashboard/profil'); ?>">
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

  <!-- Main Content -->
  <div class="main-content">
    <div class="container mt-4">
      <!-- Page Header -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
              <h2 class="mb-2"><i class="fas fa-history mr-2"></i>Riwayat Pesanan</h2>
              <p class="mb-0">Lihat semua pesanan yang telah Anda lakukan</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter Section -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
              <h5 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Riwayat</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label class="form-label">Status Pesanan</label>
                  <select class="form-control">
                    <option value="">Semua Status</option>
                    <option value="completed">Selesai</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Dalam Proses</option>
                    <option value="cancelled">Dibatalkan</option>
                  </select>
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">Tanggal Mulai</label>
                  <input type="date" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">Tanggal Akhir</label>
                  <input type="date" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">&nbsp;</label>
                  <button class="btn btn-primary btn-block">
                    <i class="fas fa-search mr-2"></i>Filter
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Riwayat Table -->
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="fas fa-list mr-2"></i>Daftar Pesanan</h5>
              <span class="badge badge-primary">Total: <?= count($orders) ?> pesanan</span>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead class="thead-light">
                    <tr>
                      <th>No. Pesanan</th>
                      <th>Tanggal</th>
                      <th>Jumlah Item</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($orders)): ?>
                      <?php foreach ($orders as $order): ?>
                        <tr>
                          <td><strong><?= htmlspecialchars($order['order_number'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                          <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                          <td><?= $order['total_items'] ?> item</td>
                          <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                          <td>
                            <?php
                            $status_config = [
                                'pending' => ['class' => 'warning', 'text' => 'Menunggu', 'icon' => 'clock'],
                                'processing' => ['class' => 'info', 'text' => 'Dalam Proses', 'icon' => 'cog'],
                                'completed' => ['class' => 'success', 'text' => 'Selesai', 'icon' => 'check-circle'],
                                'cancelled' => ['class' => 'danger', 'text' => 'Dibatalkan', 'icon' => 'times-circle']
                            ];
                            $status = $order['status'];
                            $config = $status_config[$status] ?? ['class' => 'secondary', 'text' => ucfirst($status), 'icon' => 'question'];
                            ?>
                            <span class="badge badge-<?= $config['class'] ?> status-badge" data-order-id="<?= $order['id'] ?>">
                              <i class="fas fa-<?= $config['icon'] ?> mr-1"></i>
                              <?= $config['text'] ?>
                            </span>
                          </td>
                          <td>
                            <a href="<?= site_url('dashboard/order_detail/' . $order['id']); ?>" class="btn btn-sm btn-outline-info" title="Detail">
                              <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-success ml-1" onclick="sendEmail(<?= $order['id'] ?>)" title="Kirim Email">
                              <i class="fas fa-envelope"></i>
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                          <i class="fas fa-inbox fa-2x mb-2"></i><br>
                          Belum ada pesanan<br>
                          <a href="<?= site_url('menu'); ?>" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-utensils mr-2"></i>Pesan Sekarang
                          </a>
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
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
            <i class="fas fa-map-marker-alt mr-2"></i>Jl. Contoh No. 123, Jakarta<br>
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
  
  <script>
    // Real-time status update
    function updateOrderStatus() {
      $('.status-badge').each(function() {
        const orderId = $(this).data('order-id');
        const badge = $(this);
        
        $.ajax({
          url: '<?= site_url('dashboard/get_order_status') ?>/' + orderId,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              const status = response.status;
              const statusConfig = {
                'pending': {class: 'warning', text: 'Menunggu', icon: 'clock'},
                'processing': {class: 'info', text: 'Dalam Proses', icon: 'cog'},
                'completed': {class: 'success', text: 'Selesai', icon: 'check-circle'},
                'cancelled': {class: 'danger', text: 'Dibatalkan', icon: 'times-circle'}
              };
              
              const config = statusConfig[status] || {class: 'secondary', text: status, icon: 'question'};
              
              badge.removeClass('badge-warning badge-info badge-success badge-danger badge-secondary')
                   .addClass('badge-' + config.class)
                   .html('<i class="fas fa-' + config.icon + ' mr-1"></i>' + config.text);
            }
          }
        });
      });
    }
    
    // Update status every 30 seconds
    setInterval(updateOrderStatus, 30000);
    
    // Send email function
    function sendEmail(orderId) {
        if (confirm('Kirim struk pesanan ke email?')) {
            $.ajax({
                url: '<?= site_url('dashboard/send_order_email') ?>/' + orderId,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Struk berhasil dikirim ke email!');
                    } else {
                        alert('Gagal mengirim email: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengirim email');
                }
            });
        }
    }
    
    // Filter functionality
    $('.form-control').on('change', function() {
      const status = $('select').val();
      const startDate = $('input[type="date"]').eq(0).val();
      const endDate = $('input[type="date"]').eq(1).val();
      
      // Filter rows based on criteria
      $('tbody tr').each(function() {
        const row = $(this);
        const statusBadge = row.find('.status-badge');
        const dateCell = row.find('td').eq(1).text();
        
        let show = true;
        
        if (status && !statusBadge.hasClass('badge-' + status)) {
          show = false;
        }
        
        if (startDate || endDate) {
          const orderDate = new Date(dateCell);
          if (startDate && orderDate < new Date(startDate)) {
            show = false;
          }
          if (endDate && orderDate > new Date(endDate)) {
            show = false;
          }
        }
        
        row.toggle(show);
      });
    });
  </script>
</body>
</html>