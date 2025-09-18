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
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/orders') ?>">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Pesanan</span>
                </a>
            </li>

            <!-- Nav Item - Menus -->
            <li class="nav-item active">
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
                                    Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
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
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">Kelola Menu</h1>
                            <p class="text-muted">Kelola menu, kategori, harga, dan stok dengan mudah</p>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#addCategoryModal">
                                <i class="fas fa-plus fa-sm"></i> Tambah Kategori
                            </button>
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addMenuModal">
                                <i class="fas fa-plus fa-sm"></i> Tambah Menu
                            </button>
                        </div>
                    </div>

                    <!-- Stock Summary Row -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Stok Aman</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($available_stock_count) ? $available_stock_count : 0 ?> item</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Stok Rendah</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($low_stock_count) ? $low_stock_count : 0 ?> item</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Stok Habis</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($out_of_stock_count) ? $out_of_stock_count : 0 ?> item</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Total Menu</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= isset($total_menus) ? $total_menus : 0 ?> item</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-list mr-2"></i>Semua Menu
                                    </h6>
                                    <div class="text-muted small">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Klik badge stok untuk melihat status, gunakan input untuk update
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nama</th>
                                                    <th>Kategori</th>
                                                    <th>Harga</th>
                                                    <th>
                                                        <i class="fas fa-boxes mr-1"></i>Stok
                                                        <small class="text-muted d-block">Klik untuk update</small>
                                                    </th>
                                                    <th>Status</th>
                                                    <th>Unggulan</th>
                                                    <th>Dibuat</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($menus)): ?>
                                                    <?php foreach ($menus as $menu): ?>
                                                        <?php
                                                        // Determine stock status and styling
                                                        $stock = isset($menu['stock']) ? (int)$menu['stock'] : 0;
                                                        if ($stock > 10) {
                                                            $stock_badge_class = 'success';
                                                            $stock_icon = 'check-circle';
                                                            $stock_tooltip = 'Stok Aman (>10)';
                                                        } elseif ($stock > 0) {
                                                            $stock_badge_class = 'warning';
                                                            $stock_icon = 'exclamation-triangle';
                                                            $stock_tooltip = 'Stok Rendah (≤10)';
                                                        } else {
                                                            $stock_badge_class = 'danger';
                                                            $stock_icon = 'times-circle';
                                                            $stock_tooltip = 'Stok Habis';
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?= $menu['id'] ?></td>
                                                            <td>
                                                                <strong><?= $menu['name'] ?></strong>
                                                                <br>
                                                                <small class="text-muted"><?= $menu['description'] ?></small>
                                                            </td>
                                                            <td><?= $menu['category_name'] ?></td>
                                                            <td>
                                                                <div class="input-group input-group-sm" style="max-width:150px;">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="number" class="form-control" id="price-<?= $menu['id'] ?>" value="<?= $menu['price'] ?>" min="0" step="100">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-outline-success" onclick="updatePrice(<?= $menu['id'] ?>)">Update</button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-2">
                                                                        <span class="badge badge-<?= $stock_badge_class ?>" 
                                                                              data-toggle="tooltip" 
                                                                              title="<?= $stock_tooltip ?>">
                                                                            <i class="fas fa-<?= $stock_icon ?> mr-1"></i>
                                                                            <?= $stock ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="input-group input-group-sm" style="max-width:120px;">
                                                                        <input type="number" class="form-control" id="stock-<?= $menu['id'] ?>" value="<?= $stock ?>" min="0" placeholder="Stok">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-outline-secondary" onclick="updateStock(<?= $menu['id'] ?>)" title="Update Stok">
                                                                                <i class="fas fa-save"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-<?= $menu['is_available'] ? 'success' : 'warning' ?>">
                                                                    <?= $menu['is_available'] ? 'Tersedia' : 'Habis' ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-<?= $menu['is_featured'] ? 'info' : 'secondary' ?>">
                                                                    <?= $menu['is_featured'] ? 'Unggulan' : 'Biasa' ?>
                                                                </span>
                                                            </td>
                                                            <td><?= date('d/m/Y H:i', strtotime($menu['created_at'])) ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-info" onclick="editMenu(<?= $menu['id'] ?>)">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-danger" onclick="deleteMenu(<?= $menu['id'] ?>)">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="9" class="text-center">Tidak ada menu</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Kategori Menu</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php if (!empty($categories)): ?>
                                            <?php foreach ($categories as $category): ?>
                                                <div class="col-md-4 mb-3">
                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                        <?= $category['name'] ?>
                                                                    </div>
                                                                    <div class="text-xs text-muted">
                                                                        <?= $category['description'] ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <button class="btn btn-sm btn-info" onclick="editCategory(<?= $category['id'] ?>)">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm btn-danger" onclick="deleteCategory(<?= $category['id'] ?>)">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-12">
                                                <p class="text-center text-muted">Tidak ada kategori</p>
                                            </div>
                                        <?php endif; ?>
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

    <!-- Add Menu Modal-->
    <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMenuModalLabel">Tambah Menu Baru</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="addMenuForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="menu_name">Nama Menu</label>
                            <input type="text" class="form-control" id="menu_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="menu_description">Deskripsi</label>
                            <textarea class="form-control" id="menu_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="menu_category">Kategori</label>
                            <select class="form-control" id="menu_category" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
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
                            <label for="menu_stock">Stok</label>
                            <input type="number" class="form-control" id="menu_stock" name="stock" min="0" step="1" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="menu_available" name="is_available" value="1" checked>
                                <label class="custom-control-label" for="menu_available">Tersedia</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="menu_featured" name="is_featured" value="1">
                                <label class="custom-control-label" for="menu_featured">Menu Unggulan</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Menu Modal-->
    <div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="editMenuForm">
                    <input type="hidden" id="edit_menu_id" name="menu_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_menu_name">Nama Menu</label>
                            <input type="text" class="form-control" id="edit_menu_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_menu_description">Deskripsi</label>
                            <textarea class="form-control" id="edit_menu_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_menu_category">Kategori</label>
                            <select class="form-control" id="edit_menu_category" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_menu_price">Harga</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" class="form-control" id="edit_menu_price" name="price" min="0" step="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_menu_stock">Stok</label>
                            <input type="number" class="form-control" id="edit_menu_stock" name="stock" min="0" step="1" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="edit_menu_available" name="is_available" value="1">
                                <label class="custom-control-label" for="edit_menu_available">Tersedia</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="edit_menu_featured" name="is_featured" value="1">
                                <label class="custom-control-label" for="edit_menu_featured">Menu Unggulan</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Category Modal-->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Baru</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="addCategoryForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category_name">Nama Kategori</label>
                            <input type="text" class="form-control" id="category_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="category_description">Deskripsi</label>
                            <textarea class="form-control" id="category_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal-->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="editCategoryForm">
                    <input type="hidden" id="edit_category_id" name="category_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_category_name">Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_category_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_category_description">Deskripsi</label>
                            <textarea class="form-control" id="edit_category_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update Kategori</button>
                    </div>
                </form>
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
        function editMenu(menuId) {
            $.ajax({
                url: '<?= site_url('admin/edit_menu') ?>',
                type: 'POST',
                data: { menu_id: menuId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Populate edit form with menu data
                        $('#edit_menu_id').val(response.menu.id);
                        $('#edit_menu_name').val(response.menu.name);
                        $('#edit_menu_description').val(response.menu.description || '');
                        $('#edit_menu_category').val(response.menu.category_id);
                        $('#edit_menu_price').val(response.menu.price);
                        $('#edit_menu_stock').val(response.menu.stock || 0);
                        $('#edit_menu_available').prop('checked', response.menu.is_available == 1);
                        $('#edit_menu_featured').prop('checked', response.menu.is_featured == 1);
                        
                        $('#editMenuModal').modal('show');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data menu');
                }
            });
        }

        function deleteMenu(menuId) {
            if (confirm('Yakin ingin menghapus menu ini?')) {
                $.ajax({
                    url: '<?= site_url('admin/delete_menu') ?>',
                    type: 'POST',
                    data: { menu_id: menuId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Menu berhasil dihapus');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }
                });
            }
        }

        function editCategory(categoryId) {
            $.ajax({
                url: '<?= site_url('admin/edit_category') ?>',
                type: 'POST',
                data: { category_id: categoryId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Populate edit form with category data
                        $('#edit_category_id').val(response.category.id);
                        $('#edit_category_name').val(response.category.name);
                        $('#edit_category_description').val(response.category.description || '');
                        
                        $('#editCategoryModal').modal('show');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data kategori');
                }
            });
        }

        function deleteCategory(categoryId) {
            if (confirm('Yakin ingin menghapus kategori ini?')) {
                $.ajax({
                    url: '<?= site_url('admin/delete_category') ?>',
                    type: 'POST',
                    data: { category_id: categoryId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Kategori berhasil dihapus');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }
                });
            }
        }

        $('#addMenuForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '<?= site_url('admin/add_menu') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Menu berhasil ditambahkan');
                        $('#addMenuModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            });
        });

        $('#addCategoryForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '<?= site_url('admin/add_category') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Kategori berhasil ditambahkan');
                        $('#addCategoryModal').modal('hide');
                        $('#addCategoryForm')[0].reset();
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menambahkan kategori');
                }
            });
        });

        $('#editMenuForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '<?= site_url('admin/update_menu') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Menu berhasil diperbarui');
                        $('#editMenuModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memperbarui menu');
                }
            });
        });

        $('#editCategoryForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '<?= site_url('admin/update_category') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Kategori berhasil diperbarui');
                        $('#editCategoryModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memperbarui kategori');
                }
            });
        });

        function updateStock(menuId) {
            var stock = parseInt(document.getElementById('stock-' + menuId).value || '0', 10);
            if (stock < 0) {
                alert('Stok tidak boleh negatif');
                return;
            }
            
            $.ajax({
                url: '<?= site_url('admin/update_stock') ?>',
                type: 'POST',
                data: { menu_id: menuId, stock: stock },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Show success message with better styling
                        showAlert('success', 'Stok berhasil diperbarui menjadi ' + stock + ' item');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert('error', response.message);
                    }
                },
                error: function() {
                    showAlert('error', 'Terjadi kesalahan saat memperbarui stok');
                }
            });
        }

        function showAlert(type, message) {
            var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                           '<i class="fas fa-' + (type === 'success' ? 'check-circle' : 'exclamation-triangle') + ' mr-2"></i>' +
                           message +
                           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                           '<span aria-hidden="true">&times;</span>' +
                           '</button>' +
                           '</div>';
            
            // Remove existing alerts
            $('.alert').remove();
            
            // Add new alert
            $('.container-fluid').prepend(alertHtml);
            
            // Auto dismiss after 3 seconds
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 3000);
        }

        // Initialize tooltips
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        function updatePrice(menuId) {
            var price = parseFloat(document.getElementById('price-' + menuId).value || '0');
            if (price <= 0) {
                alert('Harga harus lebih dari 0');
                return;
            }
            
            $.ajax({
                url: '<?= site_url('admin/update_price') ?>',
                type: 'POST',
                data: { menu_id: menuId, price: price },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memperbarui harga');
                }
            });
        }
    </script>
</body>
</html>
