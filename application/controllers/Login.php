<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model','user');
        $this->load->library(['session','form_validation','email']);
        $this->load->helper(['url','form','captcha','datetime']); 
    }

    public function index()
    {
        // jika sudah login, lempar ke dashboard sesuai role
        if ($this->session->userdata('user')) {
            $user = $this->session->userdata('user');
            if ($user['role_id'] == 1) {
                return redirect('admin/dashboard');
            } else {
                return redirect('dashboard');
            }
        }

        if ($this->input->method() === 'post') {
            // --- [1] Cek Captcha
            $inputCap = trim((string) $this->input->post('captcha'));
            $sessCap  = (string) $this->session->userdata('captcha_word');
            if ($inputCap === '' || $sessCap === '' || $inputCap !== $sessCap) {
                $this->session->set_flashdata('message','<div class="alert alert-danger">Captcha salah.</div>');
                return redirect('masuk');
            }
            $this->session->unset_userdata('captcha_word');

            // --- [2] Validasi form
            $this->form_validation->set_rules('email','Email','trim|required|valid_email');
            $this->form_validation->set_rules('password','Password','required');

            if ($this->form_validation->run()) {
                $email = strtolower($this->input->post('email', true));
                $pass  = $this->input->post('password', true);

                $u = $this->user->findByEmail($email);
                if (!$u) {
                    $this->session->set_flashdata('message','<div class="alert alert-danger">Email tidak terdaftar.</div>');
                    return redirect('masuk');
                }
                if ((int)$u['is_active'] !== 1) {
                    $this->session->set_flashdata('message','<div class="alert alert-warning">Akun belum aktif.</div>');
                    return redirect('masuk');
                }
                if (!password_verify($pass, $u['password'])) {
                    $this->session->set_flashdata('message','<div class="alert alert-danger">Password salah.</div>');
                    return redirect('masuk');
                }

                // --- [3] Generate OTP
                $code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $hash = password_hash($code, PASSWORD_BCRYPT);

                // simpan OTP di DB
                $otp_id = $this->user->createOtp([
                    'user_id'    => (int)$u['id'],
                    'code_hash'  => $hash,
                    'expires_at' => date('Y-m-d H:i:s', time() + 180), // 5 menit
                    'ip'         => $this->input->ip_address(),
                    'user_agent' => substr($this->input->user_agent(), 0, 255),
                ]);

                // kirim email OTP
                $this->_send_otp_email($u['email'], $u['name'], $code);

                // simpan ke session sementara
                $this->session->set_userdata('otp_pending', [
                    'user_id' => (int)$u['id'],
                    'otp_id'  => $otp_id
                ]);

                $this->session->set_flashdata('message','<div class="alert alert-success">Kode OTP sudah dikirim ke email Anda.</div>');
                return redirect('otp');
            }
        }

        // --- [4] Generate Captcha
        $vals = [
            'img_path'   => FCPATH.'captcha/',         
            'img_url'    => base_url('captcha/'),       
            'img_width'  => 160,
            'img_height' => 50,
            'expiration' => 60,
            'word_length'=> 6,
            'pool'       => '0123456789',              
        ];
        $cap = create_captcha($vals);
        $this->session->set_userdata('captcha_word', (string)$cap['word']);
        $data['captcha_img'] = $cap['image'];

        $this->load->view('auth/login', $data);
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('otp_pending');
        $this->session->sess_regenerate(true);
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0')
                     ->set_header('Cache-Control: post-check=0, pre-check=0', false)
                     ->set_header('Pragma: no-cache');
        redirect('masuk');
    }

    private function _send_otp_email($to, $name, $code)
    {
        // Load email config
        $this->load->config('email');
        $email_config = $this->config->item('email');
        
        // Fallback jika konfigurasi tidak ditemukan
        if (!$email_config) {
            $email_config = [
                'protocol' => 'mail',
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n",
                'crlf' => "\r\n"
            ];
        }
        
        $this->email->initialize($email_config);
        
        // Prepare HTML email content
        $email_content = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Kode OTP Login - Warkop Abah</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
                .email-container { background: white; border: 1px solid #ddd; border-radius: 8px; padding: 30px; max-width: 500px; margin: 0 auto; }
                .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
                .logo { font-size: 28px; font-weight: bold; color: #333; margin-bottom: 10px; }
                .subtitle { font-size: 14px; color: #666; }
                .otp-code { background: #f8f9fa; border: 2px solid #e9ecef; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; }
                .otp-number { font-size: 32px; font-weight: bold; color: #2c5aa0; letter-spacing: 5px; }
                .warning { background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 4px; padding: 15px; margin: 20px 0; color: #856404; }
                .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <div class="logo">WARKOP ABAH</div>
                    <div class="subtitle">Jl. Contoh No. 123, Jakarta | Telp: +62 812-3456-7890</div>
                </div>
                
                <h2>Halo ' . htmlspecialchars($name) . '!</h2>
                <p>Anda telah melakukan login ke akun Warkop Abah. Gunakan kode OTP berikut untuk melanjutkan:</p>
                
                <div class="otp-code">
                    <div style="font-size: 16px; color: #666; margin-bottom: 10px;">Kode OTP Anda:</div>
                    <div class="otp-number">' . $code . '</div>
                </div>
                
                <div class="warning">
                    <strong>⚠️ Penting:</strong><br>
                    • Kode OTP berlaku selama <strong>3 menit</strong><br>
                    • Jangan bagikan kode ini kepada siapapun<br>
                    • Jika bukan Anda yang melakukan login, abaikan email ini
                </div>
                
                <p>Jika Anda tidak melakukan login ini, silakan abaikan email ini atau hubungi admin.</p>
                
                <div class="footer">
                    <p>Terima kasih telah menggunakan layanan Warkop Abah! ☕</p>
                    <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
                </div>
            </div>
        </body>
        </html>';

        $from_email = $this->config->item('from_email') ?: 'noreply@warkopabah.local';
        $from_name = $this->config->item('from_name') ?: 'Warkop Abah';
        
        $this->email->from($from_email, $from_name);
        $this->email->to($to);
        $this->email->subject('Kode OTP Login - Warkop Abah');
        $this->email->message($email_content);
        
        if ($this->email->send()) {
            return true;
        } else {
            log_message('error', 'Failed to send OTP email: ' . $this->email->print_debugger());
            return false;
        }
    }
}
