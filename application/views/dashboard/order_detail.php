<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Pesanan #<?= $order['order_number'] ?> - Warkop Abah</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/vendor/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/dashboard.css') ?>" rel="stylesheet">
    
    <style>
        .receipt {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 20px auto;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .receipt-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .receipt-subtitle {
            font-size: 14px;
            color: #666;
        }
        .receipt-info {
            margin-bottom: 20px;
        }
        .receipt-info .row {
            margin-bottom: 5px;
        }
        .receipt-info .label {
            font-weight: bold;
            color: #333;
        }
        .receipt-items {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
            margin: 20px 0;
        }
        .receipt-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .receipt-item:last-child {
            border-bottom: none;
        }
        .item-name {
            font-weight: 500;
            color: #333;
        }
        .item-qty {
            color: #666;
            font-size: 14px;
        }
        .item-price {
            font-weight: bold;
            color: #333;
        }
        .receipt-total {
            text-align: right;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #333;
        }
        .total-label {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #2c5aa0;
        }
        .status-badge {
            font-size: 16px;
            padding: 8px 16px;
        }
        .print-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .email-btn {
            position: fixed;
            bottom: 80px;
            right: 20px;
            z-index: 1000;
        }
        @media print {
            .print-btn, .email-btn, .navbar, .sidebar {
                display: none !important;
            }
            .receipt {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0;
            }
            body {
                background: white !important;
            }
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-coffee"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Warkop Abah</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Nav Item - Menu -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('menu') ?>">
                    <i class="fas fa-fw fa-utensils"></i>
                    <span>Menu</span>
                </a>
            </li>

            <!-- Nav Item - Riwayat -->
            <li class="nav-item active">
                <a class="nav-link" href="<?= site_url('dashboard/riwayat') ?>">
                    <i class="fas fa-fw fa-history"></i>
                    <span>Riwayat</span>
                </a>
            </li>

            <!-- Nav Item - Profil -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('dashboard/profil') ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Profil</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Logout -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('keluar') ?>">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['name'] ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url(isset($user['profile_image']) && $user['profile_image'] ? $user['profile_image'] : 'assets/img/default-avatar.png') ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= site_url('dashboard/profil') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= site_url('keluar') ?>" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Detail Pesanan</h1>
                        <a href="<?= site_url('dashboard/riwayat') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Riwayat
                        </a>
                    </div>

                    <!-- Receipt -->
                    <div class="receipt" id="receipt">
                        <!-- Receipt Header -->
                        <div class="receipt-header">
                            <div class="receipt-title">WARKOP ABAH</div>
                            <div class="receipt-subtitle">Jl. Contoh No. 123, Jakarta</div>
                            <div class="receipt-subtitle">Telp: +62 812-3456-7890</div>
                        </div>

                        <!-- Order Information -->
                        <div class="receipt-info">
                            <div class="row">
                                <div class="col-6">
                                    <span class="label">No. Pesanan:</span>
                                </div>
                                <div class="col-6">
                                    <strong><?= $order['order_number'] ?></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <span class="label">Tanggal:</span>
                                </div>
                                <div class="col-6">
                                    <?= date('d M Y H:i', strtotime($order['created_at'])) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <span class="label">Nama:</span>
                                </div>
                                <div class="col-6">
                                    <?= $user['name'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <span class="label">Email:</span>
                                </div>
                                <div class="col-6">
                                    <?= $user['email'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <span class="label">Status:</span>
                                </div>
                                <div class="col-6">
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
                                    <span class="badge badge-<?= $config['class'] ?> status-badge">
                                        <i class="fas fa-<?= $config['icon'] ?> mr-1"></i>
                                        <?= $config['text'] ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <span class="label">Metode Pembayaran:</span>
                                </div>
                                <div class="col-6">
                                    <?= ucfirst($order['payment_method']) ?>
                                </div>
                            </div>
                            <?php if (!empty($order['notes'])): ?>
                            <div class="row">
                                <div class="col-6">
                                    <span class="label">Catatan:</span>
                                </div>
                                <div class="col-6">
                                    <?= $order['notes'] ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Order Items -->
                        <div class="receipt-items">
                            <div class="row font-weight-bold" style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                                <div class="col-6">Item</div>
                                <div class="col-2 text-center">Qty</div>
                                <div class="col-4 text-right">Subtotal</div>
                            </div>
                            <?php foreach ($order['items'] as $item): ?>
                            <div class="receipt-item">
                                <div class="col-6">
                                    <div class="item-name"><?= $item['menu_name'] ?></div>
                                    <?php if (!empty($item['menu_description'])): ?>
                                    <div class="text-muted small"><?= $item['menu_description'] ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-2 text-center">
                                    <span class="item-qty"><?= $item['quantity'] ?></span>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="item-price">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Total -->
                        <div class="receipt-total">
                            <div class="total-label">TOTAL</div>
                            <div class="total-amount">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></div>
                        </div>

                        <!-- Footer -->
                        <div class="text-center mt-4">
                            <div class="text-muted small">
                                Terima kasih telah memesan di Warkop Abah!<br>
                                Semoga kopi kami membuat hari Anda lebih baik ☕
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Warkop Abah 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Action Buttons -->
    <button class="btn btn-primary print-btn" onclick="printReceipt()">
        <i class="fas fa-print mr-2"></i>Print Struk
    </button>
    
    <button class="btn btn-success email-btn" onclick="sendEmail()">
        <i class="fas fa-envelope mr-2"></i>Kirim Email
    </button>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= site_url('keluar') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

    <script>
        function printReceipt() {
            window.print();
        }

        function sendEmail() {
            if (confirm('Kirim struk pesanan ke email <?= $user['email'] ?>?')) {
                $.ajax({
                    url: '<?= site_url('dashboard/send_order_email') ?>/<?= $order['id'] ?>',
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
    </script>
</body>
</html>

