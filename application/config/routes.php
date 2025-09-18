<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller locations.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically translate
| underscores and hyphens in controller and method name parts, thus
| making the URLs and controller folders fully human readable. When the
| underscore translation option is enabled, the controller/method URI
| segments will be translated to use underscores.
|
*/

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

$route['default_controller'] = 'dashboard';

// Login routes
$route['masuk'] = 'login';
$route['login'] = 'login';
$route['auth/login'] = 'login';

// Logout route
$route['keluar'] = 'login/logout';
$route['logout'] = 'login/logout';

// Register routes
$route['daftar'] = 'register';
$route['register'] = 'register';
$route['auth/registration'] = 'register';

// OTP routes
$route['otp'] = 'otp';
$route['masuk/otp'] = 'otp';
$route['otp/resend'] = 'otp/resend';
$route['masuk/otp/resend'] = 'otp/resend';

/*
|--------------------------------------------------------------------------
| DASHBOARD ROUTES
|--------------------------------------------------------------------------
*/

// Dashboard main
$route['dashboard'] = 'dashboard';
$route['dashboard/index'] = 'dashboard';

// Dashboard sub-pages
$route['dashboard/riwayat'] = 'dashboard/riwayat';
$route['dashboard/profil'] = 'dashboard/profil';
$route['dashboard/update_profile'] = 'dashboard/update_profile';
$route['dashboard/update_password'] = 'dashboard/update_password';
$route['dashboard/upload_profile_image'] = 'dashboard/upload_profile_image';
$route['dashboard/get_order_status/(:num)'] = 'dashboard/get_order_status/$1';
$route['dashboard/order_detail/(:num)'] = 'dashboard/order_detail/$1';
$route['dashboard/send_order_email/(:num)'] = 'dashboard/send_order_email/$1';

// Test routes
$route['test-email'] = 'test_email';

// Profile routes
$route['profile'] = 'profile';
$route['profile/index'] = 'profile';
$route['profile/update_profile'] = 'profile/update_profile';
$route['profile/change_password'] = 'profile/change_password';
$route['profile/upload_profile_image'] = 'profile/upload_profile_image';

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

// Admin dashboard
$route['admin'] = 'admin/dashboard';
$route['admin/dashboard'] = 'admin/dashboard';

// Admin management
$route['admin/users'] = 'admin/users';
$route['admin/orders'] = 'admin/orders';
$route['admin/menus'] = 'admin/menus';
$route['admin/profile'] = 'admin/profile';
$route['admin/login'] = 'admin/logout';

// Admin AJAX
$route['admin/update_order_status'] = 'admin/update_order_status';
$route['admin/add_user'] = 'admin/add_user';
$route['admin/edit_user'] = 'admin/edit_user';
$route['admin/update_user'] = 'admin/update_user';
$route['admin/delete_user'] = 'admin/delete_user';
$route['admin/toggle_user_status'] = 'admin/toggle_user_status';
$route['admin/add_menu'] = 'admin/add_menu';
$route['admin/edit_menu'] = 'admin/edit_menu';
$route['admin/update_menu'] = 'admin/update_menu';
$route['admin/delete_menu'] = 'admin/delete_menu';
$route['admin/add_category'] = 'admin/add_category';
$route['admin/edit_category'] = 'admin/edit_category';
$route['admin/update_category'] = 'admin/update_category';
$route['admin/delete_category'] = 'admin/delete_category';
$route['admin/update_stock'] = 'admin/update_stock';
$route['admin/update_price'] = 'admin/update_price';
$route['admin/update_profile'] = 'admin/update_profile';
$route['admin/change_password'] = 'admin/change_password';
$route['admin/upload_profile_image'] = 'admin/upload_profile_image';

/*
|--------------------------------------------------------------------------
| MENU ROUTES
|--------------------------------------------------------------------------
*/

// Menu routes
$route['menu'] = 'menu';
$route['menu/index'] = 'menu';
$route['menu/category/(:num)'] = 'menu/category/$1';
$route['menu/search'] = 'menu/search';
$route['menu/detail/(:num)'] = 'menu/detail/$1';
$route['menu/cart'] = 'menu/cart';
$route['menu/checkout'] = 'menu/checkout';
$route['menu/add_to_cart'] = 'menu/add_to_cart';
$route['menu/update_cart'] = 'menu/update_cart';
$route['menu/remove_from_cart'] = 'menu/remove_from_cart';
$route['menu/clear_cart'] = 'menu/clear_cart';
$route['menu/add_menu'] = 'menu/add_menu';
$route['menu/get_cart_count'] = 'menu/get_cart_count';

/*
|--------------------------------------------------------------------------
| CUSTOM ROUTES
|--------------------------------------------------------------------------
*/

// Redirect old module routes to new structure
$route['auth/login/index'] = 'login';
$route['auth/register/index'] = 'register';
$route['auth/otp/index'] = 'otp';
$route['dashboard/dashboard/index'] = 'dashboard';

