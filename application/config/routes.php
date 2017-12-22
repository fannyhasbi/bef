<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['masuk'] = 'user/login';
$route['daftar']= 'user/daftar';

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
