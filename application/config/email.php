<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Email Configuration
|--------------------------------------------------------------------------
|
| Konfigurasi email untuk mengirim OTP dan struk pesanan
|
*/

// Konfigurasi email dasar
$config['protocol'] = 'mail';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";

// Konfigurasi SMTP (uncomment jika ingin menggunakan Gmail)


$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.gmail.com';
$config['smtp_port']   = 587;
$config['smtp_user']   = 'beku130507@gmail.com';     // ganti
$config['smtp_pass']   = 'bahq jgfd aimf eegs';    // gunakan App Password
$config['smtp_crypto'] = 'tls';
$config['mailtype']    = 'text'; 
$config['charset']     = 'utf-8';
$config['wordwrap']    = TRUE;
$config['newline']     = "\r\n";
    




// Alternative: Local SMTP (untuk testing dengan XAMPP)

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'localhost';
$config['smtp_port'] = 25;
$config['smtp_user'] = '';
$config['smtp_pass'] = '';
$config['smtp_crypto'] = '';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';


// Debug settings
$config['smtp_timeout'] = 30;
$config['smtp_keepalive'] = true;