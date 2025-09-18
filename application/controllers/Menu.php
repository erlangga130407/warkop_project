<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Menu_model', 'Order_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form', 'datetime']);

        // Check if user is logged in
        $user = $this->session->userdata('user');
        if (!$user) {
            redirect('login');
        }
    }

    public function index()
    {
        $data = [
            'user' => $this->session->userdata('user'),
            'categories' => $this->Menu_model->getAllCategories(),
            'featured_menus' => $this->Menu_model->getFeaturedMenus(6),
            'all_menus' => $this->Menu_model->getMenusByCategory()
        ];

        $this->load->view('menu/index', $data);
    }

    public function category($category_id = null)
    {
        if (!$category_id) {
            redirect('menu');
        }

        $data = [
            'categories' => $this->Menu_model->getAllCategories(),
            'current_category' => $this->db->where('id', $category_id)->get('menu_categories')->row_array(),
            'menus' => $this->Menu_model->getMenusByCategory($category_id)
        ];

        $this->load->view('menu/category', $data);
    }

    public function search()
    {
        $keyword = $this->input->get('q');
        
        if (empty($keyword)) {
            redirect('menu');
        }

        $data = [
            'categories' => $this->Menu_model->getAllCategories(),
            'keyword' => $keyword,
            'menus' => $this->Menu_model->searchMenus($keyword)
        ];

        $this->load->view('menu/search', $data);
    }

    public function detail($menu_id)
    {
        $menu = $this->Menu_model->getMenuById($menu_id);
        
        if (!$menu) {
            show_404();
        }

        $data = [
            'menu' => $menu,
            'related_menus' => $this->Menu_model->getMenusByCategory($menu['category_id'], 4)
        ];

        $this->load->view('menu/detail', $data);
    }

    public function add_to_cart()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $menu_id = $this->input->post('menu_id');
        $quantity = $this->input->post('quantity') ?: 1;

        $menu = $this->Menu_model->getMenuById($menu_id);
        if (!$menu) {
            $response = ['success' => false, 'message' => 'Menu tidak ditemukan'];
        } else {
            // Get current cart from session
            $cart = $this->session->userdata('cart') ?: [];
            
            // Check if menu already in cart
            $found = false;
            foreach ($cart as &$item) {
                if ($item['menu_id'] == $menu_id) {
                    $item['quantity'] += $quantity;
                    $item['subtotal'] = $item['quantity'] * $item['price'];
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $cart[] = [
                    'menu_id' => $menu_id,
                    'name' => $menu['name'],
                    'price' => $menu['price'],
                    'quantity' => $quantity,
                    'subtotal' => $menu['price'] * $quantity
                ];
            }

            $this->session->set_userdata('cart', $cart);
            
            $response = [
                'success' => true, 
                'message' => 'Menu berhasil ditambahkan ke keranjang',
                'cart_count' => count($cart)
            ];
        }

        echo json_encode($response);
    }

    public function cart()
    {
        $cart = $this->session->userdata('cart') ?: [];
        
        $data = [
            'cart' => $cart,
            'total' => array_sum(array_column($cart, 'subtotal'))
        ];

        $this->load->view('menu/cart', $data);
    }

    public function update_cart()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $menu_id = $this->input->post('menu_id');
        $quantity = $this->input->post('quantity');

        $cart = $this->session->userdata('cart') ?: [];
        
        foreach ($cart as &$item) {
            if ($item['menu_id'] == $menu_id) {
                if ($quantity <= 0) {
                    // Remove item
                    $cart = array_filter($cart, function($item) use ($menu_id) {
                        return $item['menu_id'] != $menu_id;
                    });
                } else {
                    $item['quantity'] = $quantity;
                    $item['subtotal'] = $item['quantity'] * $item['price'];
                }
                break;
            }
        }

        $this->session->set_userdata('cart', $cart);
        
        $response = [
            'success' => true,
            'cart_count' => count($cart),
            'total' => array_sum(array_column($cart, 'subtotal'))
        ];

        echo json_encode($response);
    }

    public function checkout()
    {
        $cart = $this->session->userdata('cart') ?: [];
        
        if (empty($cart)) {
            redirect('menu/cart');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('payment_method', 'Metode Pembayaran', 'required');
            $this->form_validation->set_rules('notes', 'Catatan', 'trim');

            if ($this->form_validation->run()) {
                $user = $this->session->userdata('user');
                $total = array_sum(array_column($cart, 'subtotal'));

                // Check stock availability before creating order
                $stock_available = true;
                $stock_errors = [];
                
                foreach ($cart as $item) {
                    $menu = $this->Menu_model->getMenuById($item['menu_id']);
                    if (!$menu || $menu['stock'] < $item['quantity']) {
                        $stock_available = false;
                        $stock_errors[] = $menu['name'] . ' - Stok tidak mencukupi (Tersedia: ' . ($menu['stock'] ?? 0) . ', Dibutuhkan: ' . $item['quantity'] . ')';
                    }
                }

                if (!$stock_available) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Pesanan gagal dibuat:<br>' . implode('<br>', $stock_errors) . '</div>');
                    redirect('menu/cart');
                }

                // Create order data
                $order_data = [
                    'user_id' => $user['id'],
                    'order_number' => $this->Order_model->generateOrderNumber(),
                    'total_amount' => $total,
                    'payment_method' => $this->input->post('payment_method'),
                    'notes' => $this->input->post('notes'),
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // Prepare order items data
                $items_data = [];
                foreach ($cart as $item) {
                    $items_data[] = [
                        'menu_id' => $item['menu_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal']
                    ];
                }

                // Create order with items and reduce stock
                $order_id = $this->Order_model->createOrderWithItems($order_data, $items_data);

                if ($order_id) {
                    // Clear cart
                    $this->session->unset_userdata('cart');

                    $this->session->set_flashdata('message', '<div class="alert alert-success">Pesanan berhasil dibuat! Nomor pesanan: ' . $order_data['order_number'] . '</div>');
                    redirect('dashboard/riwayat');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal membuat pesanan. Silakan coba lagi.</div>');
                    redirect('menu/cart');
                }
            }
        }

        $data = [
            'cart' => $cart,
            'total' => array_sum(array_column($cart, 'subtotal'))
        ];

        $this->load->view('menu/checkout', $data);
    }

    public function get_cart_count()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $cart = $this->session->userdata('cart') ?: [];
        $response = ['cart_count' => count($cart)];
        
        echo json_encode($response);
    }

    public function remove_from_cart()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $menu_id = $this->input->post('menu_id');
        $cart = $this->session->userdata('cart') ?: [];

        // Remove item from cart
        foreach ($cart as $key => $item) {
            if ($item['menu_id'] == $menu_id) {
                unset($cart[$key]);
                break;
            }
        }

        // Re-index array
        $cart = array_values($cart);
        $this->session->set_userdata('cart', $cart);

        echo json_encode(['success' => true, 'message' => 'Item berhasil dihapus dari keranjang']);
    }

    public function clear_cart()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->session->unset_userdata('cart');
        echo json_encode(['success' => true, 'message' => 'Keranjang berhasil dikosongkan']);
    }

    public function add_menu()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Check if user is admin
        $user = $this->session->userdata('user');
        if (!$user || $user['role_id'] != 1) {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak. Hanya admin yang dapat menambah menu.']);
            return;
        }

        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('name', 'Nama Menu', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required|integer');
        $this->form_validation->set_rules('description', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('image', 'URL Gambar', 'trim|valid_url');

        if ($this->form_validation->run()) {
            $data = [
                'name' => $this->input->post('name', true),
                'category_id' => $this->input->post('category_id', true),
                'description' => $this->input->post('description', true),
                'price' => $this->input->post('price', true),
                'image' => $this->input->post('image', true) ?: null,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                'is_available' => $this->input->post('is_available') ? 1 : 0,
                'created_at' => get_current_datetime()
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
}
