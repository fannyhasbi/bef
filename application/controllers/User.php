<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('user_model');
  }

  public function index(){
    $konfirmasi = $this->user_model->checkConfirm($this->session->userdata('id'));

    if($konfirmasi->num_rows() > 0) {
      $this->profil();
    }
    else {
      $this->pay();
    }
  }

  private function cekLogin(){
    if(!$this->session->userdata('login'))
      redirect(site_url('masuk'));
  }

  public function login(){
    if($this->session->userdata('login'))
      redirect(site_url('dashboard'));

    if($this->input->post('masuk')){
      if($this->user_model->check()->num_rows() > 0){
        $pendaftar = $this->user_model->getUserByUsername();
        if(password_verify($this->input->post('password'), $pendaftar->password)){
          $data_session = array(
            'login' => true,
            'id' => $pendaftar->id,
            'username' => $pendaftar->username
          );

          $this->session->set_userdata($data_session);
          redirect(site_url('dashboard'));
        }
        else {
          // password salah
          $this->session->set_flashdata('msg', '<div class="alert alert-danger">Username atau password salah</div>');
        }
      }
      else {
        // username tidak ada
        $this->session->set_flashdata('msg', '<div class="alert alert-danger">Username atau password salah</div>');
      }

      redirect(site_url('masuk'));
    }
    else {
      $data['message'] = $this->session->flashdata('msg');
      $this->load->view('user/login', $data);
    }
  }

  public function logout(){
    $this->cekLogin();
    $this->session->sess_destroy();
    redirect(site_url());
  }

  public function daftar(){
    if($this->session->userdata('login'))
      redirect(site_url('dashboard'));

    if($this->input->post('daftar')){
      if(strlen($this->input->post('password')) < 6){

      }
      else {
        if($this->input->post('password') != $this->input->post('password2')){
          $this->session->set_flashdata('msg', '<div class="alert alert-danger"><strong>Maaf</strong>, kata sandi tidak cocok.</div>');
        }
        else {
          if( $this->user_model->checkUsername($this->input->post('username'))->num_rows() > 0 ){
            // Username sudah terdaftar
            $this->session->set_flashdata('msg', '<div class="alert alert-info">Username sudah pernah terdaftar. Coba username yang lain atau masuk <a href="'. site_url('masuk') .'">disini</a></div>');
          }
          else {
            if($this->user_model->addFirst()){
              $this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Selamat</strong>, Anda berhasil terdaftar!. Silahkan masuk <a href="'. site_url('masuk') .'">disini</a></div>');
            }
            else {
              $this->session->set_flashdata('msg', '<div class="alert alert-danger"><strong>Maaf</strong>, terjadi kesalahan saat pendaftaran, silahkan coba lagi.</div>');
            }
          }

        }

        // menjalankan flashdata
        redirect(site_url('daftar'));
      }
    }
    else {
      $data['message'] = $this->session->flashdata('msg');
      $this->load->view('user/daftar', $data);
    }

  }

  public function pay(){
    if($this->user_model->checkConfirm($this->session->userdata('id'))->num_rows() > 0)
      redirect(site_url('dashboard'));
    
    if($this->input->post('upload')){
      $config['upload_path']   = './foto/bukti/';
      $config['file_name']     = 'bukti_'. $this->session->userdata('username');
      $config['allowed_types'] = 'jpg|png';
      $config['max_size']      = 300;

      $this->load->library('upload', $config);

      if ( ! $this->upload->do_upload('bukti'))
      {
        // Tampil error, but wait aku masih bingung disini wkwk
        $error = array('error' => $this->upload->display_errors());
        $this->load->view('user/error_upload', $error);
      }
      else
      {
        $data = $this->upload->data();

        if($this->user_model->addBukti($data['file_name'])){
          redirect(site_url('dashboard'));
        }
        else {
          echo "error";
        }
      }

    }
    else {
      $data['status'] = $this->user_model->getUserById($this->session->userdata('id'));
      $this->load->view('user/pay_first', $data);
    }

  }

  public function profil(){
    $data['profil'] = $this->user_model->getPesertaById($this->session->userdata('id'));
    $data['view_name'] = 'profil';
    $this->load->view('user/index_view', $data);
  }

  public function ganti_pass(){
    if($this->input->post('ganti')){
      if($this->user_model->updatePass($this->input->post('password'))){
        $this->session->set_flashdata('msg', 'Password berhasil diperbarui.');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Password gagal diperbarui.');
        $this->session->set_flashdata('type', 'danger');
      }

      redirect(site_url('ganti_password'));
    }
    else {
      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $data['view_name'] = 'ganti_password';
      $this->load->view('user/index_view', $data);
    }
  }

}
