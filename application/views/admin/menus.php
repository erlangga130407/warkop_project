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
                Management
            </div>

            <!-- Nav Item - Users -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/users') ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span>
                </a>
            </li>

            <!-- Nav Item - Orders -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/orders') ?>">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>

            <!-- Nav Item - Menus -->
            <li class="nav-item active">
                <a class="nav-link" href="<?= site_url('admin/menus') ?>">
                    <i class="fas fa-fw fa-utensils"></i>
                    <span>Menus</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('logout') ?>">
                    <i class="fas fa-fw fa-utensils"></i>
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
                        <h1 class="h3 mb-0 text-gray-800">Manage Menus</h1>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#addCategoryModal">
                                <i class="fas fa-plus fa-sm"></i> Add Category
                            </button>
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addMenuModal">
                                <i class="fas fa-plus fa-sm"></i> Add Menu
                            </button>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">All Menus</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                    <th>Featured</th>
                                                    <th>Created</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($menus)): ?>
                                                    <?php foreach ($menus as $menu): ?>
                                                        <tr>
                                                            <td><?= $menu['id'] ?></td>
                                                            <td>
                                                                <strong><?= $menu['name'] ?></strong>
                                                                <br>
                                                                <small class="text-muted"><?= $menu['description'] ?></small>
                                                            </td>
                                                            <td><?= $menu['category_name'] ?></td>
                                                            <td>Rp <?= number_format($menu['price'], 0, ',', '.') ?></td>
                                                            <td>
                                                                <span class="badge badge-<?= $menu['is_available'] ? 'success' : 'warning' ?>">
                                                                    <?= $menu['is_available'] ? 'Available' : 'Not Available' ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-<?= $menu['is_featured'] ? 'info' : 'secondary' ?>">
                                                                    <?= $menu['is_featured'] ? 'Featured' : 'Regular' ?>
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
                                                        <td colspan="8" class="text-center">No menus found</td>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Menu Categories</h6>
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
                                                <p class="text-center text-muted">No categories found</p>
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
                    <h5 class="modal-title" id="addMenuModalLabel">Add New Menu</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="addMenuForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="menu_name">Menu Name</label>
                            <input type="text" class="form-control" id="menu_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="menu_description">Description</label>
                            <textarea class="form-control" id="menu_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="menu_category">Category</label>
                            <select class="form-control" id="menu_category" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="menu_price">Price</label>
                            <input type="number" class="form-control" id="menu_price" name="price" min="0" step="100" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="menu_available" name="is_available" value="1" checked>
                                <label class="custom-control-label" for="menu_available">Available</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="menu_featured" name="is_featured" value="1">
                                <label class="custom-control-label" for="menu_featured">Featured Menu</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Menu</button>
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
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="addCategoryForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="category_description">Description</label>
                            <textarea class="form-control" id="category_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Category</button>
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
                        alert('Edit menu: ' + response.menu.name);
                        // You can implement edit modal here
                    } else {
                        alert('Error: ' + response.message);
                    }
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
                        alert('Edit kategori: ' + response.category.name);
                        // You can implement edit modal here
                    } else {
                        alert('Error: ' + response.message);
                    }
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
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            });
        });
    </script>
</body>
</html>
