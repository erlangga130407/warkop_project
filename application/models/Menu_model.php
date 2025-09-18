<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    private $table_menus = 'menus';
    private $table_categories = 'menu_categories';

    public function getAllCategories()
    {
        return $this->db->where('is_active', 1)
                        ->order_by('name', 'ASC')
                        ->get($this->table_categories)
                        ->result_array();
    }

    public function getMenusByCategory($category_id = null, $limit = null)
    {
        $this->db->select('m.*, c.name as category_name')
                 ->from($this->table_menus . ' m')
                 ->join($this->table_categories . ' c', 'c.id = m.category_id', 'left')
                 ->where('m.is_available', 1);

        if ($category_id) {
            $this->db->where('m.category_id', $category_id);
        }

        $this->db->order_by('m.is_featured', 'DESC')
                 ->order_by('m.name', 'ASC');

        if ($limit) {
            $this->db->limit($limit);
        }

        return $this->db->get()->result_array();
    }

    public function getFeaturedMenus($limit = 6)
    {
        return $this->db->select('m.*, c.name as category_name')
                        ->from($this->table_menus . ' m')
                        ->join($this->table_categories . ' c', 'c.id = m.category_id', 'left')
                        ->where('m.is_available', 1)
                        ->where('m.is_featured', 1)
                        ->order_by('m.name', 'ASC')
                        ->limit($limit)
                        ->get()
                        ->result_array();
    }

    public function getMenuById($id)
    {
        return $this->db->select('m.*, c.name as category_name')
                        ->from($this->table_menus . ' m')
                        ->join($this->table_categories . ' c', 'c.id = m.category_id', 'left')
                        ->where('m.id', $id)
                        ->where('m.is_available', 1)
                        ->get()
                        ->row_array();
    }

    public function searchMenus($keyword)
    {
        return $this->db->select('m.*, c.name as category_name')
                        ->from($this->table_menus . ' m')
                        ->join($this->table_categories . ' c', 'c.id = m.category_id', 'left')
                        ->where('m.is_available', 1)
                        ->group_start()
                        ->like('m.name', $keyword)
                        ->or_like('m.description', $keyword)
                        ->or_like('c.name', $keyword)
                        ->group_end()
                        ->order_by('m.is_featured', 'DESC')
                        ->order_by('m.name', 'ASC')
                        ->get()
                        ->result_array();
    }

    public function getMenusByPriceRange($min_price, $max_price)
    {
        return $this->db->select('m.*, c.name as category_name')
                        ->from($this->table_menus . ' m')
                        ->join($this->table_categories . ' c', 'c.id = m.category_id', 'left')
                        ->where('m.is_available', 1)
                        ->where('m.price >=', $min_price)
                        ->where('m.price <=', $max_price)
                        ->order_by('m.price', 'ASC')
                        ->get()
                        ->result_array();
    }

    public function getAllMenus()
    {
        return $this->db->select('m.*, c.name as category_name')
                        ->from($this->table_menus . ' m')
                        ->join($this->table_categories . ' c', 'c.id = m.category_id', 'left')
                        ->order_by('m.created_at', 'DESC')
                        ->get()
                        ->result_array();
    }

    public function getTotalMenus()
    {
        return $this->db->count_all($this->table_menus);
    }

    public function createMenu($data)
    {
        $this->db->insert($this->table_menus, $data);
        return $this->db->insert_id();
    }

    public function updateMenu($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table_menus, $data);
    }

    public function deleteMenu($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table_menus);
    }

    public function updateStock($id, int $stock)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table_menus, [
            'stock' => $stock,
            'is_available' => $stock > 0 ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getTopSellingMenus($limit = 5)
    {
        return $this->db->select('m.*, c.name as category_name, COUNT(oi.id) as total_sold')
                        ->from($this->table_menus . ' m')
                        ->join($this->table_categories . ' c', 'c.id = m.category_id', 'left')
                        ->join('order_items oi', 'oi.menu_id = m.id', 'left')
                        ->group_by('m.id')
                        ->order_by('total_sold', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->result_array();
    }

    public function createCategory($data)
    {
        $this->db->insert($this->table_categories, $data);
        return $this->db->insert_id();
    }

    public function updateCategory($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table_categories, $data);
    }

    public function deleteCategory($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table_categories);
    }

    public function getCategoryById($id)
    {
        return $this->db->get_where($this->table_categories, ['id' => $id])->row_array();
    }

    public function getLowStockCount($threshold = 10)
    {
        return $this->db->where('stock <=', $threshold)
                        ->where('stock >', 0)
                        ->count_all_results($this->table_menus);
    }

    public function getOutOfStockCount()
    {
        return $this->db->where('stock', 0)
                        ->count_all_results($this->table_menus);
    }

    public function getAvailableStockCount()
    {
        return $this->db->where('stock >', 10)
                        ->count_all_results($this->table_menus);
    }

    public function getLowStockMenus($threshold = 10)
    {
        return $this->db->select('m.*, c.name as category_name')
                        ->from($this->table_menus . ' m')
                        ->join($this->table_categories . ' c', 'c.id = m.category_id', 'left')
                        ->where('m.stock <=', $threshold)
                        ->where('m.stock >', 0)
                        ->order_by('m.stock', 'ASC')
                        ->get()
                        ->result_array();
    }

    public function getOutOfStockMenus()
    {
        return $this->db->select('m.*, c.name as category_name')
                        ->from($this->table_menus . ' m')
                        ->join($this->table_categories . ' c', 'c.id = m.category_id', 'left')
                        ->where('m.stock', 0)
                        ->order_by('m.name', 'ASC')
                        ->get()
                        ->result_array();
    }
}
