<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model
{
    private $table_orders = 'orders';
    private $table_order_items = 'order_items';

    public function createOrder($data)
    {
        $this->db->trans_start();
        
        // Insert order
        $this->db->insert($this->table_orders, $data);
        $order_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $order_id;
    }

    public function createOrderItem($data)
    {
        return $this->db->insert($this->table_order_items, $data);
    }

    public function createOrderWithItems($order_data, $items_data)
    {
        $this->db->trans_start();
        
        try {
            // Insert order
            $this->db->insert($this->table_orders, $order_data);
            $order_id = $this->db->insert_id();
            
            if (!$order_id) {
                throw new Exception('Failed to create order');
            }
            
            // Insert order items and reduce stock
            foreach ($items_data as $item) {
                // Insert order item
                $item['order_id'] = $order_id;
                $this->db->insert($this->table_order_items, $item);
                
                // Reduce stock
                $this->db->set('stock', 'stock - ' . (int)$item['quantity'], FALSE);
                $this->db->set('updated_at', date('Y-m-d H:i:s'));
                $this->db->where('id', $item['menu_id']);
                $this->db->update('menus');
                
                // Update availability if stock becomes 0
                $this->db->set('is_available', 'CASE WHEN stock <= 0 THEN 0 ELSE 1 END', FALSE);
                $this->db->where('id', $item['menu_id']);
                $this->db->update('menus');
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                return false;
            }
            
            return $order_id;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function getOrdersByUser($user_id, $limit = null, $offset = 0)
    {
        $this->db->select('o.*, COUNT(oi.id) as total_items')
                 ->from($this->table_orders . ' o')
                 ->join($this->table_order_items . ' oi', 'oi.order_id = o.id', 'left')
                 ->where('o.user_id', $user_id)
                 ->group_by('o.id')
                 ->order_by('o.created_at', 'DESC');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    public function getOrderById($order_id, $user_id = null)
    {
        $this->db->select('o.*')
                 ->from($this->table_orders . ' o')
                 ->where('o.id', $order_id);

        if ($user_id) {
            $this->db->where('o.user_id', $user_id);
        }

        return $this->db->get()->row_array();
    }

    public function getOrderItems($order_id)
    {
        return $this->db->select('oi.*, m.name as menu_name, m.description as menu_description')
                        ->from($this->table_order_items . ' oi')
                        ->join('menus m', 'm.id = oi.menu_id', 'left')
                        ->where('oi.order_id', $order_id)
                        ->get()
                        ->result_array();
    }

    public function getOrderDetails($order_id, $user_id = null)
    {
        $order = $this->getOrderById($order_id, $user_id);
        if ($order) {
            $order['items'] = $this->getOrderItems($order_id);
        }
        return $order;
    }

    public function updateOrderStatus($order_id, $status, $user_id = null)
    {
        $this->db->where('id', $order_id);
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        return $this->db->update($this->table_orders, ['status' => $status]);
    }

    public function cancelOrder($order_id, $user_id)
    {
        return $this->updateOrderStatus($order_id, 'cancelled', $user_id);
    }

    public function getOrderStats($user_id)
    {
        $stats = [
            'total_orders' => 0,
            'completed_orders' => 0,
            'pending_orders' => 0,
            'cancelled_orders' => 0,
            'total_spent' => 0
        ];

        $result = $this->db->select('status, COUNT(*) as count, SUM(total_amount) as total')
                           ->from($this->table_orders)
                           ->where('user_id', $user_id)
                           ->group_by('status')
                           ->get()
                           ->result_array();

        foreach ($result as $row) {
            $stats['total_orders'] += $row['count'];
            $stats['total_spent'] += $row['total'] ?? 0;

            switch ($row['status']) {
                case 'completed':
                    $stats['completed_orders'] = $row['count'];
                    break;
                case 'pending':
                    $stats['pending_orders'] = $row['count'];
                    break;
                case 'cancelled':
                    $stats['cancelled_orders'] = $row['count'];
                    break;
            }
        }

        return $stats;
    }

    public function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 4));
        return $prefix . $date . $random;
    }

    public function getRecentOrders($user_id = null, $limit = 5)
    {
        $this->db->select('o.*, u.name as customer_name, COUNT(oi.id) as total_items')
                 ->from($this->table_orders . ' o')
                 ->join('user u', 'u.id = o.user_id', 'left')
                 ->join($this->table_order_items . ' oi', 'oi.order_id = o.id', 'left')
                 ->group_by('o.id')
                 ->order_by('o.created_at', 'DESC');

        if ($user_id) {
            $this->db->where('o.user_id', $user_id);
        }

        if ($limit) {
            $this->db->limit($limit);
        }

        return $this->db->get()->result_array();
    }

    public function getAllOrders()
    {
        $this->db->select('o.*, u.name as customer_name, u.email as customer_email, COUNT(oi.id) as total_items')
                 ->from($this->table_orders . ' o')
                 ->join('user u', 'u.id = o.user_id', 'left')
                 ->join($this->table_order_items . ' oi', 'oi.order_id = o.id', 'left')
                 ->group_by('o.id')
                 ->order_by('o.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }

    public function getTotalOrders()
    {
        return $this->db->count_all($this->table_orders);
    }

    public function getTotalRevenue()
    {
        $result = $this->db->select('SUM(total_amount) as total')
                           ->from($this->table_orders)
                           ->where('status', 'completed')
                           ->get()
                           ->row_array();
        
        return $result['total'] ?? 0;
    }

    public function getOrdersByStatus($status)
    {
        $this->db->select('o.*, u.name as customer_name, u.email as customer_email, COUNT(oi.id) as total_items')
                 ->from($this->table_orders . ' o')
                 ->join('user u', 'u.id = o.user_id', 'left')
                 ->join($this->table_order_items . ' oi', 'oi.order_id = o.id', 'left')
                 ->where('o.status', $status)
                 ->group_by('o.id')
                 ->order_by('o.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }

    public function getOrdersByUserId($user_id)
    {
        $this->db->select('o.*, COUNT(oi.id) as total_items')
                 ->from($this->table_orders . ' o')
                 ->join($this->table_order_items . ' oi', 'oi.order_id = o.id', 'left')
                 ->where('o.user_id', $user_id)
                 ->group_by('o.id')
                 ->order_by('o.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
}
