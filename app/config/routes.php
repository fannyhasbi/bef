<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['keluar'] = 'admin/logout';

// Admin
$route['admin'] = 'home/notfound';
$route['me'] = 'admin';
$route['me/login'] = 'admin/login';
$route['me/ganti_password'] = 'admin/ganti_pass';
$route['me/confirm/(:num)'] = 'admin/confirm/$1';
/*$route['me/cancel/(:num)'] = 'admin/cancel/$1';*/
$route['me/konfirmasi'] = 'admin/konfirmasi';
$route['me/del-peserta/(:num)'] = 'admin/del_peserta/$1';
$route['me/res/(:num)'] = 'admin/reset_password/$1';
$route['me/tolak/(:num)'] = 'admin/tolak/$1';

// Super admin
$route['sudo'] = 'sudo';
$route['sudo/login'] = 'sudo/login';
$route['sudo/ganti_password'] = 'sudo/ganti_pass';
$route['sudo/activate'] = 'sudo/activate';
$route['sudo/add-admin'] = 'sudo/add_admin';
$route['sudo/del-admin/(:num)'] = 'sudo/del_admin/$1';

// PTN
$route['sudo/ptn'] = 'sudo/ptn';
$route['sudo/add-ptn'] = 'sudo/add_ptn';
$route['sudo/edit-ptn/(:any)'] = 'sudo/edit_ptn/$1';
$route['sudo/del-ptn/(:any)'] = 'sudo/del_ptn/$1';

// Prodi
$route['sudo/prodi'] = 'sudo/prodi';
$route['sudo/add-prodi'] = 'sudo/add_prodi';
$route['sudo/edit-prodi/(:any)'] = 'sudo/edit_prodi/$1';
$route['sudo/del-prodi/(:any)'] = 'sudo/del_prodi/$1';

// REST API
$route['api/'] = 'home/notfound';
$route['api/v1'] = 'home/notfound';
$route['api/v1/prodi'] = 'api/prodi';
$route['api/v1/ptn'] = 'api/ptn';
$route['api/v1/resize'] = 'api/resize';


$route['default_controller'] = 'home';
$route['404_override'] = 'home/notfound';
$route['translate_uri_dashes'] = FALSE;
