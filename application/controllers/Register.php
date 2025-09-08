<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form','datetime']);
    }

    /** GET: form register | POST: proses register */
    public function index()
    {
        // sudah login? gak perlu daftar
        if ($this->session->userdata('user')) {
            return redirect('dashboard');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'Nama Lengkap', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email]', ['is_unique' => 'Email ini sudah terdaftar!']);
            $this->form_validation->set_rules('role_id', 'Peran', 'required|in_list[1,2]');
            $this->form_validation->set_rules('phone', 'Nomor Telepon', 'trim|min_length[10]');
            $this->form_validation->set_rules('address', 'Alamat', 'trim');
            $this->form_validation->set_rules('city', 'Kota', 'trim');
            $this->form_validation->set_rules('postal_code', 'Kode Pos', 'trim|min_length[5]');
            
            $this->form_validation->set_rules('password1', 'Kata Sandi', 'required|min_length[6]');
            $this->form_validation->set_rules('password2', 'Ulangi Kata Sandi', 'required|matches[password1]');

            if ($this->form_validation->run()) {
                $name  = $this->input->post('name',  true);
                $email = strtolower($this->input->post('email', true));
                $pass  = $this->input->post('password1', true);
                $role_id = (int)$this->input->post('role_id', true);
                $phone = $this->input->post('phone', true);
                $address = $this->input->post('address', true);
                $city = $this->input->post('city', true);
                $postal_code = $this->input->post('postal_code', true);

                $data = [
                    'name'         => $name,
                    'email'        => $email,
                    'password'     => password_hash($pass, PASSWORD_BCRYPT),
                    'role_id'      => $role_id,
                    'is_active'    => 1,
                    'phone'        => $phone,
                    'address'      => $address,
                    'city'         => $city,
                    'postal_code'  => $postal_code,
                    'created_at'   => date('Y-m-d H:i:s'),
                ];
                
                $user_id = $this->user->create($data);

                if ($user_id) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success">Akun berhasil dibuat. Silakan login.</div>');
                    return redirect('masuk');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal membuat akun. Silakan coba lagi.</div>');
                }
            }
        }

        // Data untuk dropdown role
        $data['roles'] = [
            1 => 'Administrator',
            2 => 'Pelanggan'
        ];
        
        $this->load->view('auth/register', $data);
    }

    /** callback untuk validasi unik email */
    public function email_unique($email)
    {
        if ($this->user->emailExists(strtolower($email))) {
            $this->form_validation->set_message('email_unique', 'Email sudah terdaftar.');
            return false;
        }
        return true;
    }
}
