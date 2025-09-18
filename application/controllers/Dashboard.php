<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','html','datetime']);
        $this->load->model(['Order_model', 'Menu_model', 'User_model']);

        // wajib login
        $user = $this->session->userdata('user');
        if (!$user) {
            redirect('masuk'); 
        }

        // Jika admin, redirect ke admin dashboard
        if ($user['role_id'] == 1) {
            redirect('admin/dashboard');
        }

       
        $this->output
            ->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0')
            ->set_header('Cache-Control: post-check=0, pre-check=0', false)
            ->set_header('Pragma: no-cache');
    }

    public function index()
    {
        $user = $this->session->userdata('user'); 
        
        // Get order statistics
        $order_stats = $this->Order_model->getOrderStats($user['id']);
        
        // Get recent orders
        $recent_orders = $this->Order_model->getRecentOrders($user['id'], 5);
        
        // Get featured menus
        $featured_menus = $this->Menu_model->getFeaturedMenus(4);
        
        $data = [
            'id'      => (int)$user['id'],
            'name'    => $user['name'],
            'email'   => $user['email'],
            'role_id' => (int)$user['role_id'],
            'role'    => isset($user['role']) ? $user['role'] : null,
            'order_stats' => $order_stats,
            'recent_orders' => $recent_orders,
            'featured_menus' => $featured_menus
        ];
        $this->load->view('dashboard/index', $data);
    }

    public function riwayat()
    {
        $user = $this->session->userdata('user'); 
        
        // Get orders from database
        $orders = $this->Order_model->getOrdersByUser($user['id']);
        
        $data = [
            'id'      => (int)$user['id'],
            'name'    => $user['name'],
            'email'   => $user['email'],
            'role_id' => (int)$user['role_id'],
            'role'    => isset($user['role']) ? $user['role'] : null,
            'orders'  => $orders
        ];
        $this->load->view('dashboard/riwayat', $data);
    }

    public function get_order_status($order_id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $user = $this->session->userdata('user');
        $order = $this->Order_model->getOrderById($order_id, $user['id']);
        
        if ($order) {
            echo json_encode([
                'success' => true,
                'status' => $order['status']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ]);
        }
    }

    public function order_detail($order_id)
    {
        $user = $this->session->userdata('user');
        $order = $this->Order_model->getOrderDetails($order_id, $user['id']);
        
        if (!$order) {
            show_404();
        }

        $data = [
            'order' => $order,
            'user' => $user
        ];

        $this->load->view('dashboard/order_detail', $data);
    }

    public function send_order_email($order_id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $user = $this->session->userdata('user');
        $order = $this->Order_model->getOrderDetails($order_id, $user['id']);
        
        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Pesanan tidak ditemukan']);
            return;
        }

        // Load email library and config
        $this->load->library('email');
        $this->load->config('email');
        
        $this->email->initialize($this->config->item('email'));

        // Prepare email content
        $status_config = [
            'pending' => ['class' => 'warning', 'text' => 'Menunggu', 'icon' => 'clock'],
            'processing' => ['class' => 'info', 'text' => 'Dalam Proses', 'icon' => 'cog'],
            'completed' => ['class' => 'success', 'text' => 'Selesai', 'icon' => 'check-circle'],
            'cancelled' => ['class' => 'danger', 'text' => 'Dibatalkan', 'icon' => 'times-circle']
        ];
        $status = $order['status'];
        $config_status = $status_config[$status] ?? ['class' => 'secondary', 'text' => ucfirst($status), 'icon' => 'question'];

        $email_content = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Struk Pesanan #' . $order['order_number'] . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
                .receipt { background: white; border: 1px solid #ddd; border-radius: 8px; padding: 20px; max-width: 500px; margin: 0 auto; }
                .receipt-header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
                .receipt-title { font-size: 24px; font-weight: bold; color: #333; margin-bottom: 5px; }
                .receipt-subtitle { font-size: 14px; color: #666; }
                .receipt-info { margin-bottom: 20px; }
                .receipt-info .row { margin-bottom: 5px; }
                .receipt-info .label { font-weight: bold; color: #333; }
                .receipt-items { border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 15px 0; margin: 20px 0; }
                .receipt-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f0f0f0; }
                .receipt-item:last-child { border-bottom: none; }
                .item-name { font-weight: 500; color: #333; }
                .item-qty { color: #666; font-size: 14px; }
                .item-price { font-weight: bold; color: #333; }
                .receipt-total { text-align: right; margin-top: 20px; padding-top: 15px; border-top: 2px solid #333; }
                .total-label { font-size: 18px; font-weight: bold; color: #333; }
                .total-amount { font-size: 24px; font-weight: bold; color: #2c5aa0; }
                .status-badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
                .status-warning { background: #fff3cd; color: #856404; }
                .status-info { background: #d1ecf1; color: #0c5460; }
                .status-success { background: #d4edda; color: #155724; }
                .status-danger { background: #f8d7da; color: #721c24; }
            </style>
        </head>
        <body>
            <div class="receipt">
                <div class="receipt-header">
                    <div class="receipt-title">WARKOP ABAH</div>
                    <div class="receipt-subtitle">Jl. Contoh No. 123, Jakarta</div>
                    <div class="receipt-subtitle">Telp: +62 812-3456-7890</div>
                </div>

                <div class="receipt-info">
                    <div class="row">
                        <div class="col-6"><span class="label">No. Pesanan:</span></div>
                        <div class="col-6"><strong>' . $order['order_number'] . '</strong></div>
                    </div>
                    <div class="row">
                        <div class="col-6"><span class="label">Tanggal:</span></div>
                        <div class="col-6">' . date('d M Y H:i', strtotime($order['created_at'])) . '</div>
                    </div>
                    <div class="row">
                        <div class="col-6"><span class="label">Nama:</span></div>
                        <div class="col-6">' . $user['name'] . '</div>
                    </div>
                    <div class="row">
                        <div class="col-6"><span class="label">Email:</span></div>
                        <div class="col-6">' . $user['email'] . '</div>
                    </div>
                    <div class="row">
                        <div class="col-6"><span class="label">Status:</span></div>
                        <div class="col-6">
                            <span class="status-badge status-' . $config_status['class'] . '">' . $config_status['text'] . '</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"><span class="label">Metode Pembayaran:</span></div>
                        <div class="col-6">' . ucfirst($order['payment_method']) . '</div>
                    </div>';

        if (!empty($order['notes'])) {
            $email_content .= '
                    <div class="row">
                        <div class="col-6"><span class="label">Catatan:</span></div>
                        <div class="col-6">' . $order['notes'] . '</div>
                    </div>';
        }

        $email_content .= '
                </div>

                <div class="receipt-items">
                    <div class="row" style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="col-6"><strong>Item</strong></div>
                        <div class="col-2 text-center"><strong>Qty</strong></div>
                        <div class="col-4 text-right"><strong>Subtotal</strong></div>
                    </div>';

        foreach ($order['items'] as $item) {
            $email_content .= '
                    <div class="receipt-item">
                        <div class="col-6">
                            <div class="item-name">' . $item['menu_name'] . '</div>';
            if (!empty($item['menu_description'])) {
                $email_content .= '<div style="color: #666; font-size: 12px;">' . $item['menu_description'] . '</div>';
            }
            $email_content .= '
                        </div>
                        <div class="col-2 text-center">
                            <span class="item-qty">' . $item['quantity'] . '</span>
                        </div>
                        <div class="col-4 text-right">
                            <span class="item-price">Rp ' . number_format($item['subtotal'], 0, ',', '.') . '</span>
                        </div>
                    </div>';
        }

        $email_content .= '
                </div>

                <div class="receipt-total">
                    <div class="total-label">TOTAL</div>
                    <div class="total-amount">Rp ' . number_format($order['total_amount'], 0, ',', '.') . '</div>
                </div>

                <div style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
                    Terima kasih telah memesan di Warkop Abah!<br>
                    Semoga kopi kami membuat hari Anda lebih baik ☕
                </div>
            </div>
        </body>
        </html>';

        // Send email
        $this->email->from($this->config->item('from_email'), $this->config->item('from_name'));
        $this->email->to($user['email']);
        $this->email->subject('Struk Pesanan #' . $order['order_number'] . ' - Warkop Abah');
        $this->email->message($email_content);

        if ($this->email->send()) {
            echo json_encode(['success' => true, 'message' => 'Struk berhasil dikirim ke email']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengirim email: ' . $this->email->print_debugger()]);
        }
    }

    public function profil()
    {
        $user = $this->session->userdata('user'); 
        
        // Get order statistics
        $order_stats = $this->Order_model->getOrderStats($user['id']);
        
        $data = [
            'id'      => (int)$user['id'],
            'name'    => $user['name'],
            'email'   => $user['email'],
            'role_id' => (int)$user['role_id'],
            'role'    => isset($user['role']) ? $user['role'] : null,
            'order_stats' => $order_stats
        ];
        $this->load->view('dashboard/profil', $data);
    }

    public function update_profile()
    {
        if ($this->input->method() !== 'post') {
            return redirect('dashboard/profil');
        }

        $sessionUser = $this->session->userdata('user');
        if (!$sessionUser) {
            return redirect('masuk');
        }

        $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]');
        $this->form_validation->set_rules('phone', 'Nomor Telepon', 'trim|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('birth_date', 'Tanggal Lahir', 'trim');
        $this->form_validation->set_rules('address', 'Alamat', 'trim|max_length[500]');
        $this->form_validation->set_rules('city', 'Kota', 'trim|max_length[50]');
        $this->form_validation->set_rules('postal_code', 'Kode Pos', 'trim|min_length[4]|max_length[10]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            return redirect('dashboard/profil');
        }

        $newEmail = strtolower($this->input->post('email', true));
        if ($newEmail !== $sessionUser['email']) {
            $exists = $this->User_model->getByEmail($newEmail);
            if ($exists && (int)$exists['id'] !== (int)$sessionUser['id']) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Email sudah digunakan.</div>');
                return redirect('dashboard/profil');
            }
        }

        $data = [
            'name' => $this->input->post('name', true),
            'email' => $newEmail,
            'phone' => $this->input->post('phone', true) ?: null,
            'birth_date' => $this->input->post('birth_date', true) ?: null,
            'address' => $this->input->post('address', true) ?: null,
            'city' => $this->input->post('city', true) ?: null,
            'postal_code' => $this->input->post('postal_code', true) ?: null,
            'updated_at' => get_current_datetime()
        ];

        $ok = $this->User_model->updateUser((int)$sessionUser['id'], $data);

        if ($ok) {
            // update session
            $updated = $this->User_model->getById((int)$sessionUser['id']);
            $this->session->set_userdata('user', [
                'id' => (int)$updated['id'],
                'name' => $updated['name'],
                'email' => $updated['email'],
                'role_id' => (int)$updated['role_id'],
                'role' => isset($updated['role']) ? $updated['role'] : null
            ]);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Profil berhasil diperbarui.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Tidak ada perubahan atau gagal menyimpan.</div>');
        }
        return redirect('dashboard/profil');
    }

    public function update_password()
    {
        if ($this->input->method() !== 'post') {
            return redirect('dashboard/profil');
        }

        $sessionUser = $this->session->userdata('user');
        if (!$sessionUser) {
            return redirect('masuk');
        }

        $this->form_validation->set_rules('current_password', 'Password Lama', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('pwd_message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            return redirect('dashboard/profil');
        }

        $user = $this->User_model->getById((int)$sessionUser['id']);
        if (!$user || !password_verify($this->input->post('current_password', true), $user['password'])) {
            $this->session->set_flashdata('pwd_message', '<div class="alert alert-danger">Password lama salah.</div>');
            return redirect('dashboard/profil');
        }

        $hash = password_hash($this->input->post('new_password', true), PASSWORD_BCRYPT);
        $ok = $this->User_model->updateUser((int)$sessionUser['id'], ['password' => $hash, 'updated_at' => get_current_datetime()]);

        if ($ok) {
            $this->session->set_flashdata('pwd_message', '<div class="alert alert-success">Password berhasil diperbarui.</div>');
        } else {
            $this->session->set_flashdata('pwd_message', '<div class="alert alert-warning">Gagal memperbarui password.</div>');
        }
        return redirect('dashboard/profil');
    }

    public function upload_profile_image()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $sessionUser = $this->session->userdata('user');
        if (!$sessionUser) {
            echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
            return;
        }

        // Create profiles directory if not exists
        $upload_path = './assets/img/profiles/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // Upload configuration
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = 'profile_' . $sessionUser['id'] . '_' . time();

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_image')) {
            $upload_data = $this->upload->data();
            $image_path = 'assets/img/profiles/' . $upload_data['file_name'];

            // Update user profile image
            $result = $this->User_model->updateUser($sessionUser['id'], ['profile_image' => $image_path]);

            if ($result) {
                // Update session
                $user = $this->session->userdata('user');
                $user['profile_image'] = $image_path;
                $this->session->set_userdata('user', $user);

                echo json_encode([
                    'success' => true,
                    'message' => 'Foto profil berhasil diupload',
                    'image_url' => base_url($image_path)
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menyimpan foto profil']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
        }
    }
}
