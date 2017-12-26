<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['dashboard'] = 'user';
$route['daftar']= 'user/daftar';
$route['masuk'] = 'user/login';
$route['keluar']= 'user/logout';
$route['pay'] = 'user/pay';
$route['ganti_password'] = 'user/ganti_pass';

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
