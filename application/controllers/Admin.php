<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url','html','datetime']);
        $this->load->model(['User_model', 'Order_model', 'Menu_model']);
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('user')) {
            redirect('masuk');
        }
        
        $user = $this->session->userdata('user');
        if ($user['role_id'] != 1) {
            redirect('dashboard');
        }
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Admin Dashboard',
            'user' => $this->session->userdata('user')
        ];
        
        // Get statistics
        $data['total_users'] = $this->User_model->getTotalUsers();
        $data['total_orders'] = $this->Order_model->getTotalOrders();
        $data['total_menus'] = $this->Menu_model->getTotalMenus();
        $data['total_revenue'] = $this->Order_model->getTotalRevenue();
        
        // Get recent orders
        $data['recent_orders'] = $this->Order_model->getRecentOrders(null, 10);
        
        // Get top selling menus
        $data['top_menus'] = $this->Menu_model->getTopSellingMenus(5);
        
        $this->load->view('admin/dashboard', $data);
    }

    public function users()
    {
        $data = [
            'title' => 'Manage Users',
            'user' => $this->session->userdata('user'),
            'users' => $this->User_model->getAllUsers()
        ];
        
        $this->load->view('admin/users', $data);
    }

    public function orders()
    {
        $data = [
            'title' => 'Manage Orders',
            'user' => $this->session->userdata('user'),
            'orders' => $this->Order_model->getAllOrders()
        ];
        
        $this->load->view('admin/orders', $data);
    }

    public function menus()
    {
        $data = [
            'title' => 'Manage Menus',
            'user' => $this->session->userdata('user'),
            'menus' => $this->Menu_model->getAllMenus(),
            'categories' => $this->Menu_model->getAllCategories()
        ];
        
        $this->load->view('admin/menus', $data);
    }

    public function update_order_status()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $order_id = $this->input->post('order_id');
        $status = $this->input->post('status');
        
        $result = $this->Order_model->updateOrderStatus($order_id, $status);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Status berhasil diperbarui']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status']);
        }
    }

    public function add_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Check if current user is admin
        $current_user = $this->session->userdata('user');
        if (!$current_user || $current_user['role_id'] != 1) {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak. Hanya admin yang dapat menambah pengguna.']);
            return;
        }

        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]|max_length[100]');
        $this->form_validation->set_rules('role_id', 'Peran', 'required|in_list[1,2]');
        $this->form_validation->set_rules('phone', 'Nomor Telepon', 'trim|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('birth_date', 'Tanggal Lahir', 'trim');
        $this->form_validation->set_rules('address', 'Alamat', 'trim|max_length[500]');
        $this->form_validation->set_rules('city', 'Kota', 'trim|max_length[50]');
        $this->form_validation->set_rules('postal_code', 'Kode Pos', 'trim|min_length[5]|max_length[10]');
        $this->form_validation->set_rules('password', 'Kata Sandi', 'required|min_length[6]|max_length[255]');
        $this->form_validation->set_rules('is_active', 'Status', 'required|in_list[0,1]');

        if ($this->form_validation->run()) {
            // Check if email already exists
            $existing_user = $this->User_model->getByEmail($this->input->post('email', true));
            if ($existing_user) {
                echo json_encode(['success' => false, 'message' => 'Email sudah digunakan oleh pengguna lain.']);
                return;
            }

            $data = [
                'name' => $this->input->post('name', true),
                'email' => strtolower($this->input->post('email', true)),
                'role_id' => $this->input->post('role_id', true),
                'phone' => $this->input->post('phone', true) ?: null,
                'birth_date' => $this->input->post('birth_date', true) ?: null,
                'address' => $this->input->post('address', true) ?: null,
                'city' => $this->input->post('city', true) ?: null,
                'postal_code' => $this->input->post('postal_code', true) ?: null,
                'password' => password_hash($this->input->post('password', true), PASSWORD_BCRYPT),
                'is_active' => $this->input->post('is_active', true),
                'created_at' => get_current_datetime()
            ];

            $result = $this->User_model->createUser($data);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Pengguna berhasil ditambahkan dengan ID: ' . $result]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menambahkan pengguna. Silakan coba lagi.']);
            }
        } else {
            $errors = validation_errors();
            echo json_encode(['success' => false, 'message' => $errors]);
        }
    }

    public function edit_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $user_id = $this->input->post('user_id');
        $user = $this->User_model->getById($user_id);
        
        if ($user) {
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Pengguna tidak ditemukan']);
        }
    }

    public function update_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Check if current user is admin
        $current_user = $this->session->userdata('user');
        if (!$current_user || $current_user['role_id'] != 1) {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak. Hanya admin yang dapat mengupdate pengguna.']);
            return;
        }

        $this->load->library('form_validation');
        
        $user_id = $this->input->post('user_id');
        
        // Check if user exists
        $existing_user = $this->User_model->getById($user_id);
        if (!$existing_user) {
            echo json_encode(['success' => false, 'message' => 'Pengguna tidak ditemukan.']);
            return;
        }

        $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]');
        $this->form_validation->set_rules('role_id', 'Peran', 'required|in_list[1,2]');
        $this->form_validation->set_rules('phone', 'Nomor Telepon', 'trim|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('birth_date', 'Tanggal Lahir', 'trim');
        $this->form_validation->set_rules('address', 'Alamat', 'trim|max_length[500]');
        $this->form_validation->set_rules('city', 'Kota', 'trim|max_length[50]');
        $this->form_validation->set_rules('postal_code', 'Kode Pos', 'trim|min_length[5]|max_length[10]');
        $this->form_validation->set_rules('is_active', 'Status', 'required|in_list[0,1]');

        if ($this->form_validation->run()) {
            // Check if email is being changed and if it's already used by another user
            $new_email = strtolower($this->input->post('email', true));
            if ($new_email !== $existing_user['email']) {
                $email_check = $this->User_model->getByEmail($new_email);
                if ($email_check && $email_check['id'] != $user_id) {
                    echo json_encode(['success' => false, 'message' => 'Email sudah digunakan oleh pengguna lain.']);
                    return;
                }
            }

            $data = [
                'name' => $this->input->post('name', true),
                'email' => $new_email,
                'role_id' => $this->input->post('role_id', true),
                'phone' => $this->input->post('phone', true) ?: null,
                'birth_date' => $this->input->post('birth_date', true) ?: null,
                'address' => $this->input->post('address', true) ?: null,
                'city' => $this->input->post('city', true) ?: null,
                'postal_code' => $this->input->post('postal_code', true) ?: null,
                'is_active' => $this->input->post('is_active', true),
                'updated_at' => get_current_datetime()
            ];

            // Update password if provided
            $password = $this->input->post('password');
            if (!empty($password)) {
                if (strlen($password) < 6) {
                    echo json_encode(['success' => false, 'message' => 'Password minimal 6 karakter.']);
                    return;
                }
                $data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            $result = $this->User_model->updateUser($user_id, $data);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Pengguna berhasil diperbarui']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal memperbarui pengguna. Silakan coba lagi.']);
            }
        } else {
            $errors = validation_errors();
            echo json_encode(['success' => false, 'message' => $errors]);
        }
    }

    public function delete_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Check if current user is admin
        $current_user = $this->session->userdata('user');
        if (!$current_user || $current_user['role_id'] != 1) {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak. Hanya admin yang dapat menghapus pengguna.']);
            return;
        }

        $user_id = $this->input->post('user_id');
        
        // Check if user exists
        $user_to_delete = $this->User_model->getById($user_id);
        if (!$user_to_delete) {
            echo json_encode(['success' => false, 'message' => 'Pengguna tidak ditemukan.']);
            return;
        }
        
        // Prevent admin from deleting themselves
        if ($user_id == $current_user['id']) {
            echo json_encode(['success' => false, 'message' => 'Tidak dapat menghapus akun sendiri.']);
            return;
        }

        // Check if user has active orders
        $this->load->model('Order_model');
        $active_orders = $this->Order_model->getOrdersByUserId($user_id);
        if (!empty($active_orders)) {
            echo json_encode(['success' => false, 'message' => 'Tidak dapat menghapus pengguna yang memiliki pesanan aktif.']);
            return;
        }

        // Delete user's OTP records first
        $this->User_model->deleteOtpByUserId($user_id);
        
        // Delete user
        $result = $this->User_model->deleteUser($user_id);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Pengguna berhasil dihapus beserta semua data terkait.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus pengguna. Silakan coba lagi.']);
        }
    }

    public function toggle_user_status()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $user_id = $this->input->post('user_id');
        $user = $this->User_model->getById($user_id);
        
        if ($user) {
            $new_status = $user['is_active'] ? 0 : 1;
            $result = $this->User_model->updateUser($user_id, ['is_active' => $new_status]);
            
            if ($result) {
                $status_text = $new_status ? 'Aktif' : 'Tidak Aktif';
                echo json_encode(['success' => true, 'message' => 'Status pengguna berhasil diubah menjadi ' . $status_text]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal mengubah status pengguna']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Pengguna tidak ditemukan']);
        }
    }

    public function add_menu()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('name', 'Nama Menu', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required|integer');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run()) {
            $data = [
                'name' => $this->input->post('name', true),
                'description' => $this->input->post('description', true),
                'category_id' => $this->input->post('category_id', true),
                'price' => $this->input->post('price', true),
                'is_available' => $this->input->post('is_available') ? 1 : 0,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->Menu_model->createMenu($data);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Menu berhasil ditambahkan']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menambahkan menu']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => validation_errors()]);
        }
    }

    public function edit_menu()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $menu_id = $this->input->post('menu_id');
        $menu = $this->Menu_model->getMenuById($menu_id);
        
        if ($menu) {
            echo json_encode(['success' => true, 'menu' => $menu]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Menu tidak ditemukan']);
        }
    }

    public function update_menu()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->load->library('form_validation');
        
        $menu_id = $this->input->post('menu_id');
        $this->form_validation->set_rules('name', 'Nama Menu', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required|integer');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run()) {
            $data = [
                'name' => $this->input->post('name', true),
                'description' => $this->input->post('description', true),
                'category_id' => $this->input->post('category_id', true),
                'price' => $this->input->post('price', true),
                'is_available' => $this->input->post('is_available') ? 1 : 0,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->Menu_model->updateMenu($menu_id, $data);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Menu berhasil diperbarui']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal memperbarui menu']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => validation_errors()]);
        }
    }

    public function delete_menu()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $menu_id = $this->input->post('menu_id');
        $result = $this->Menu_model->deleteMenu($menu_id);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Menu berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus menu']);
        }
    }

    public function add_category()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('name', 'Nama Kategori', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'trim');

        if ($this->form_validation->run()) {
            $data = [
                'name' => $this->input->post('name', true),
                'description' => $this->input->post('description', true),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->Menu_model->createCategory($data);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Kategori berhasil ditambahkan']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menambahkan kategori']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => validation_errors()]);
        }
    }

    public function edit_category()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $category_id = $this->input->post('category_id');
        $category = $this->Menu_model->getCategoryById($category_id);
        
        if ($category) {
            echo json_encode(['success' => true, 'category' => $category]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Kategori tidak ditemukan']);
        }
    }

    public function update_category()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->load->library('form_validation');
        
        $category_id = $this->input->post('category_id');
        $this->form_validation->set_rules('name', 'Nama Kategori', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'trim');

        if ($this->form_validation->run()) {
            $data = [
                'name' => $this->input->post('name', true),
                'description' => $this->input->post('description', true),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->Menu_model->updateCategory($category_id, $data);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Kategori berhasil diperbarui']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal memperbarui kategori']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => validation_errors()]);
        }
    }

    public function delete_category()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $category_id = $this->input->post('category_id');
        $result = $this->Menu_model->deleteCategory($category_id);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Kategori berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus kategori']);
        }
    }
}
