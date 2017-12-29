<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// User
$route['dashboard'] = 'user';
$route['daftar']= 'user/daftar';
$route['masuk'] = 'user/login';
$route['keluar']= 'user/logout';
$route['pay'] = 'user/pay';
$route['profil'] = 'user/profil';
$route['ganti_password'] = 'user/ganti_pass';

// Admin
$route['me'] = 'admin';
$route['me/login'] = 'admin/login';
$route['me/ganti_password'] = 'admin/ganti_pass';
$route['me/confirm/(:num)'] = 'admin/confirm/$1';
/*$route['me/cancel/(:num)'] = 'admin/cancel/$1';*/
$route['me/konfirmasi'] = 'admin/konfirmasi';
$route['me/del-peserta/(:num)'] = 'admin/del_peserta/$1';

// Super admin
$route['sudo'] = 'sudo';
$route['sudo/login'] = 'sudo/login';
$route['sudo/ganti_password'] = 'sudo/ganti_pass';
$route['sudo/confirm/(:num)'] = 'sudo/confirm/$1';
/* $route['sudo/cancel/(:num)'] = 'sudo/cancel/$1';*/
$route['sudo/konfirmasi'] = 'sudo/konfirmasi';
$route['sudo/add-admin'] = 'sudo/add_admin';
$route['sudo/del-admin/(:num)'] = 'sudo/del_admin/$1';
$route['sudo/del-peserta/(:num)'] = 'sudo/del_peserta/$1';

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
