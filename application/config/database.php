<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;


$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',  
    'username' => 'root',
    'password' => '',           // kosong (default XAMPP)
    'database' => 'warkop_abah',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,        // tetap FALSE, lebih aman dan stabil
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',    // lebih modern, dukung emoji dan karakter internasional
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE,
);

