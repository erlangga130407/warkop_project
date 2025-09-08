<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url','html','datetime']);
        $this->load->model(['Order_model', 'Menu_model']);

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
}
