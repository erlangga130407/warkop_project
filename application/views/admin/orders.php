<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?> - Warkop Abah</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/vendor/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/dashboard.css') ?>" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('admin/dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-coffee"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Warkop Abah</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manajemen
            </div>

            <!-- Nav Item - Users -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/users') ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Pengguna</span>
                </a>
            </li>

            <!-- Nav Item - Orders -->
            <li class="nav-item active">
                <a class="nav-link" href="<?= site_url('admin/orders') ?>">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Pesanan</span>
                </a>
            </li>

            <!-- Nav Item - Menus -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/menus') ?>">
                    <i class="fas fa-fw fa-utensils"></i>
                    <span>Menu</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('login/logout') ?>">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
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
                                <img class="img-profile rounded-circle" src="<?= base_url('assets/img/default-avatar.png') ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= site_url('admin/profile') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
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
                        <h1 class="h3 mb-0 text-gray-800">Manage Orders</h1>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" onclick="filterOrders('all')">All</button>
                            <button class="btn btn-sm btn-outline-warning" onclick="filterOrders('pending')">Pending</button>
                            <button class="btn btn-sm btn-outline-info" onclick="filterOrders('processing')">Processing</button>
                            <button class="btn btn-sm btn-outline-success" onclick="filterOrders('completed')">Completed</button>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Semua Pesanan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No. Pesanan</th>
                                                    <th>Pelanggan</th>
                                                    <th>Email</th>
                                                    <th>Item</th>
                                                    <th>Jumlah</th>
                                                    <th>Status</th>
                                                    <th>Pembayaran</th>
                                                    <th>Tanggal</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($orders)): ?>
                                                    <?php foreach ($orders as $order): ?>
                                                        <tr class="order-row" data-status="<?= $order['status'] ?>">
                                                            <td><?= $order['order_number'] ?></td>
                                                            <td><?= $order['customer_name'] ?></td>
                                                            <td><?= $order['customer_email'] ?></td>
                                                            <td><?= $order['total_items'] ?> items</td>
                                                            <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                                                            <td>
                                                                <select class="form-control form-control-sm status-select" 
                                                                        data-order-id="<?= $order['id'] ?>" 
                                                                        onchange="updateOrderStatus(<?= $order['id'] ?>, this.value)">
                                                                    <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Menunggu</option>
                                                                    <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Diproses</option>
                                                                    <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Selesai</option>
                                                                    <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                                                                </select>
                                                            </td>
                                                            <td><?= ucfirst($order['payment_method'] ?: 'Cash') ?></td>
                                                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-info" onclick="viewOrderDetails(<?= $order['id'] ?>)">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-success" onclick="printOrder(<?= $order['id'] ?>)">
                                                                    <i class="fas fa-print"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="9" class="text-center">Tidak ada pesanan</td>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Order Details Modal-->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="orderDetailsContent">
                    <!-- Order details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="printOrder()">Print Order</button>
                </div>
            </div>
        </div>
    </div>

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
                    <a class="btn btn-primary" href="<?= site_url('login/logout') ?>">Logout</a>
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
        function filterOrders(status) {
            if (status === 'all') {
                $('.order-row').show();
            } else {
                $('.order-row').hide();
                $('.order-row[data-status="' + status + '"]').show();
            }
        }

        function updateOrderStatus(orderId, status) {
            $.ajax({
                url: '<?= site_url('admin/update_order_status') ?>',
                type: 'POST',
                data: {
                    order_id: orderId,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update the row's data-status attribute
                        $('tr[data-order-id="' + orderId + '"]').attr('data-status', status);
                        alert('Status pesanan berhasil diperbarui!');
                    } else {
                        alert('Gagal memperbarui status pesanan: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memperbarui status pesanan');
                }
            });
        }

        function viewOrderDetails(orderId) {
            // Load order details via AJAX
            $('#orderDetailsContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>');
            $('#orderDetailsModal').modal('show');
            
            // Here you would make an AJAX call to get order details
            // For now, just show a placeholder
            setTimeout(function() {
                $('#orderDetailsContent').html('<p>Detail pesanan #' + orderId + ' akan dimuat di sini.</p>');
            }, 1000);
        }

        function printOrder(orderId) {
            // Implement print functionality
            alert('Cetak pesanan ' + orderId);
        }
    </script>
</body>
</html>
