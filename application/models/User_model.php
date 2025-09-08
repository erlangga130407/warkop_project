<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $table = 'user';

    public function findByEmail(string $email)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('email', $email);
        return $this->db->get()->row_array();
    }

    public function getByEmail(string $email)
    {
        return $this->findByEmail($email);
    }

    public function emailExists(string $email): bool
    {
        return (bool) $this->db->select('id')->from($this->table)
            ->where('email', $email)->limit(1)->get()->num_rows();
    }

    public function create(array $data): int
    {
        $this->db->insert($this->table, $data);
        return (int) $this->db->insert_id();
    }

    public function getById(int $id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function getAllUsers()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getTotalUsers()
    {
        return $this->db->count_all($this->table);
    }

    public function updateUser(int $id, array $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function deleteUser(int $id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function createOtp(array $data): int
    {
        // Set default max_attempts jika tidak ada
        if (!isset($data['max_attempts'])) {
            $data['max_attempts'] = 3;
        }
        // Set default attempts jika tidak ada
        if (!isset($data['attempts'])) {
            $data['attempts'] = 0;
        }
        
        $this->db->insert('user_otp', $data);
        return (int)$this->db->insert_id();
    }

    public function getOtpById(int $id)
    {
        return $this->db->get_where('user_otp', ['id'=>$id])->row_array();
    }

    public function bumpOtpAttempt(int $id, bool $failed): void
    {
        if ($failed) {
            $this->db->set('attempts', 'attempts+1', FALSE);
        } else {
            $this->db->set('attempts', 0);
        }
        $this->db->where('id',$id)->update('user_otp');
    }

    public function markOtpUsed(int $id): void
    {
        $this->db->where('id',$id)->update('user_otp', ['is_used'=>1]);
    }

    public function createUser(array $data): int
    {
        return $this->create($data);
    }

    public function deleteOtpByUserId(int $user_id): void
    {
        $this->db->where('user_id', $user_id)->delete('user_otp');
    }
}
