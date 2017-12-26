<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// User
$route['dashboard'] = 'user';
$route['daftar']= 'user/daftar';
$route['masuk'] = 'user/login';
$route['keluar']= 'user/logout';
$route['pay'] = 'user/pay';
$route['ganti_password'] = 'user/ganti_pass';

// Admin
$route['me'] = 'admin';
$route['me/login'] = 'admin/login';
$route['me/ganti_password'] = 'admin/ganti_pass';
$route['me/confirm/(:num)'] = 'admin/confirm/$1';

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
