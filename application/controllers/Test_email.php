<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test_email extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->helper('url');
    }

    public function index()
    {
        echo "<h2>Test Email OTP - Warkop Abah</h2>";
        echo "<p>Testing email configuration...</p>";
        
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
        
        // Test email content
        $test_code = '123456';
        $test_name = 'Test User';
        $test_email = 'test@example.com'; // Ganti dengan email Anda
        
        $email_content = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Test OTP Email</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
                .email-container { background: white; border: 1px solid #ddd; border-radius: 8px; padding: 30px; max-width: 500px; margin: 0 auto; }
                .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
                .logo { font-size: 28px; font-weight: bold; color: #333; margin-bottom: 10px; }
                .otp-code { background: #f8f9fa; border: 2px solid #e9ecef; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; }
                .otp-number { font-size: 32px; font-weight: bold; color: #2c5aa0; letter-spacing: 5px; }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <div class="logo">WARKOP ABAH</div>
                    <div>Test Email Configuration</div>
                </div>
                
                <h2>Halo ' . htmlspecialchars($test_name) . '!</h2>
                <p>Ini adalah test email untuk konfigurasi OTP Warkop Abah.</p>
                
                <div class="otp-code">
                    <div style="font-size: 16px; color: #666; margin-bottom: 10px;">Test OTP Code:</div>
                    <div class="otp-number">' . $test_code . '</div>
                </div>
                
                <p>Jika Anda menerima email ini, konfigurasi email sudah benar!</p>
            </div>
        </body>
        </html>';

        $from_email = $this->config->item('from_email') ?: 'noreply@warkopabah.local';
        $from_name = $this->config->item('from_name') ?: 'Warkop Abah';
        
        $this->email->from($from_email, $from_name);
        $this->email->to($test_email);
        $this->email->subject('Test OTP Email - Warkop Abah');
        $this->email->message($email_content);
        
        echo "<h3>Email Configuration:</h3>";
        echo "<pre>";
        print_r($this->config->item('email'));
        echo "</pre>";
        
        echo "<h3>Sending test email to: " . $test_email . "</h3>";
        
        if ($this->email->send()) {
            echo "<div style='color: green; font-weight: bold;'>✅ Email berhasil dikirim!</div>";
            echo "<p>Silakan cek email Anda di: <strong>" . $test_email . "</strong></p>";
        } else {
            echo "<div style='color: red; font-weight: bold;'>❌ Email gagal dikirim!</div>";
            echo "<h4>Error Details:</h4>";
            echo "<pre>" . $this->email->print_debugger() . "</pre>";
        }
        
        echo "<hr>";
        echo "<h3>Debug Information:</h3>";
        echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
        echo "<p><strong>CodeIgniter Version:</strong> " . CI_VERSION . "</p>";
        echo "<p><strong>Environment:</strong> " . ENVIRONMENT . "</p>";
        echo "<p><strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
        
        echo "<hr>";
        echo "<h3>Next Steps:</h3>";
        echo "<ol>";
        echo "<li>Ganti email di line 15 dengan email Anda</li>";
        echo "<li>Refresh halaman ini untuk test lagi</li>";
        echo "<li>Jika berhasil, coba login ke sistem</li>";
        echo "<li>Jika gagal, cek konfigurasi email di application/config/email.php</li>";
        echo "</ol>";
    }
}
