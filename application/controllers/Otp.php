<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Otp extends CI_Controller
{
    private $otp_lifetime = 180; // 5 menit
    private $resend_delay = 30;  // minimal jeda resend 30 detik

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model','user');
        $this->load->library(['session','form_validation','email']);
        $this->load->helper(['url','form','datetime']);
    }

    public function index()
    {
        $ctx = $this->session->userdata('otp_pending');
        if (!$ctx) return redirect('masuk');

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('code', 'OTP', 'required|exact_length[6]|numeric');
            if ($this->form_validation->run()) {
                $otp = $this->user->getOtpById((int)$ctx['otp_id']);
                if (!$otp || $otp['user_id'] != $ctx['user_id']) {
                    $this->session->set_flashdata('message','<div class="alert alert-danger">Sesi OTP tidak valid.</div>');
                    return redirect('masuk');
                }
                if ($otp['is_used'] == 1 || strtotime($otp['expires_at']) < time()) {
                    $this->session->set_flashdata('message','<div class="alert alert-danger">OTP kadaluarsa/terpakai.</div>');
                    return redirect('otp');
                }
                if ($otp['attempts'] >= $otp['max_attempts']) {
                    $this->session->set_flashdata('message','<div class="alert alert-danger">Terlalu banyak percobaan. Silakan login ulang.</div>');
                    $this->session->unset_userdata('otp_pending');
                    return redirect('masuk');
                }

                $input = $this->input->post('code', true);
                $ok = password_verify($input, $otp['code_hash']);
                $this->user->bumpOtpAttempt($otp['id'], !$ok);

                if (!$ok) {
                    $this->session->set_flashdata('message','<div class="alert alert-danger">Kode OTP salah.</div>');
                    return redirect('otp');
                }

                // tandai used & set session user final
                $this->user->markOtpUsed($otp['id']);
                $u = $this->user->getById((int)$ctx['user_id']);

                $this->session->unset_userdata('otp_pending');
                $this->session->set_userdata('user', [
                    'id'=>(int)$u['id'],'name'=>$u['name'],'email'=>$u['email'],
                    'role_id'=>(int)$u['role_id'],'role'=>$u['role'] ?? null
                ]);

                // Redirect berdasarkan role
                if ($u['role_id'] == 1) {
                    return redirect('admin/dashboard');
                } else {
                    return redirect('dashboard');
                }
            }
        }

        $this->load->view('auth/otp_verify');
    }

    public function resend()
    {
        $ctx = $this->session->userdata('otp_pending');
        if (!$ctx) return redirect('masuk');

        // rate limit resend
        $last = $this->session->userdata('last_otp_resend');
        if ($last && time() - $last < $this->resend_delay) {
            $this->session->set_flashdata('message','<div class="alert alert-warning">Tunggu '.$this->resend_delay.' detik sebelum minta OTP baru.</div>');
            return redirect('otp');
        }

        $u = $this->user->getById((int)$ctx['user_id']);
        $code = str_pad((string)random_int(0,999999), 6, '0', STR_PAD_LEFT);
        $hash = password_hash($code, PASSWORD_BCRYPT);

        // hapus OTP lama supaya tidak numpuk
        $this->user->deleteOtpByUserId((int)$u['id']);

        $otp_id = $this->user->createOtp([
            'user_id'    => (int)$u['id'],
            'code_hash'  => $hash,
            'expires_at' => date('Y-m-d H:i:s', time()+$this->otp_lifetime),
            'ip'         => $this->input->ip_address(),
            'user_agent' => substr($this->input->user_agent(),0,255),
        ]);

        $this->session->set_userdata('otp_pending', ['user_id'=>(int)$u['id'], 'otp_id'=>$otp_id]);
        $this->session->set_userdata('last_otp_resend', time());

        $this->_send_otp_email($u['email'], $u['name'], $code);

        $this->session->set_flashdata('message','<div class="alert alert-success">OTP baru telah dikirim.</div>');
        return redirect('otp');
    }

    private function _send_otp_email($to,$name,$code)
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
                <p>Kode OTP baru telah dikirim untuk akun Warkop Abah Anda. Gunakan kode berikut untuk melanjutkan:</p>
                
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
