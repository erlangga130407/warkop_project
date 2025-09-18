<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Local Email Configuration for Testing
|--------------------------------------------------------------------------
|
| Konfigurasi email untuk testing lokal dengan XAMPP
| Gunakan ini jika email tidak masuk saat testing
|
*/

// Konfigurasi untuk testing lokal
$config['protocol'] = 'mail'; // Gunakan mail() function PHP
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";

// Email Settings
$config['from_email'] = 'noreply@warkopabah.local';
$config['from_name'] = 'Warkop Abah';
$config['reply_to'] = 'admin@warkopabah.local';

// Debug settings
$config['smtp_timeout'] = 30;
$config['smtp_keepalive'] = true;

