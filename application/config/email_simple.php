<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Simple Email Configuration for Testing
|--------------------------------------------------------------------------
|
| Konfigurasi email sederhana untuk testing OTP
| Gunakan ini jika email masih tidak masuk
|
*/

// Konfigurasi sederhana untuk testing
$config['protocol'] = 'mail';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";

// Email Settings
$config['from_email'] = 'noreply@warkopabah.local';
$config['from_name'] = 'Warkop Abah';
$config['reply_to'] = 'admin@warkopabah.local';

