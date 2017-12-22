<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
  public function index(){
    $data['view_name'] = 'profil';
    $this->load->view("user/index_view", $data);
  }

  private function cekLogin(){
    // untuk cek login
  }

  public function login(){
    $this->load->view('user/login');
  }

  public function daftar(){
    $this->load->view('user/daftar');
  }

  public function ganti_pass(){
    $data['view_name'] = 'ganti_password';
    $this->load->view('user/index_view', $data);
  }

}
