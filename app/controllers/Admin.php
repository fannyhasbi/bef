<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('admin_model');
  }

  public function index(){
    if(!$this->session->userdata('login_admin'))
      redirect(site_url('me/login'));

    $data['message'] = $this->session->flashdata('msg');
    $data['type'] = $this->session->flashdata('type');

    $data['grafik'] = array(
      'peserta' => $this->admin_model->getGrafikPeserta(),
      'pendaftar' => $this->admin_model->getGrafikPendaftar(),
      'highest' => $this->admin_model->getGrafikTertinggi() // mendapatkan nilai tertinggi dari pendaftar ataupun peserta
    );

    $data['count'] = $this->admin_model->getCount();
    $data['view_name'] = 'home';
    $this->load->view('admin/index_view', $data);
  }

  private function cekLogin(){
    if(!$this->session->userdata('login_admin'))
      show_404();
  }
  
  public function logout(){
      $this->session->sess_destroy();
      redirect(site_url());
  }

  public function login(){
    if($this->session->userdata('login'))
      redirect(site_url('me'));

    if($this->input->post('masuk')){
      if($this->admin_model->check()->num_rows() > 0){
        $admin = $this->admin_model->getAdmin();
        if(password_verify($this->input->post('password'), $admin->password)){
          $data_session = array(
            'login_admin' => true,
            'uname_admin' => $admin->username,
            'id_admin' => $admin->id
          );
          $this->session->set_userdata($data_session);

          redirect(site_url('me'));
        }
        else {
          $this->session->set_flashdata('msg', '<div class="alert alert-danger">Username atau password salah</div>');
        }
      }
      else {
        $this->session->set_flashdata('msg', '<div class="alert alert-danger">Username atau password salah</div>');
      }

      redirect(site_url('me/login'));
    }
    else {
      $data['message'] = $this->session->flashdata('msg');
      $this->load->view('admin/login', $data);
    }
  }

  public function confirm($id_pendaftar){
    $this->cekLogin();

    if($this->admin_model->checkIdPendaftar($id_pendaftar)->num_rows() > 0){
      if($this->admin_model->addConfirm($id_pendaftar)){
        if($this->admin_model->addPeserta($id_pendaftar)){
          $this->session->set_flashdata('msg', 'Berhasil mengkonfirmasi.');
          $this->session->set_flashdata('type', 'success');
        }
        else {
          $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal mengkonfirmasi.');
          $this->session->set_flashdata('type', 'danger');
        }
      }
      else {
        $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal mengkonfirmasi.');
        $this->session->set_flashdata('type', 'danger');
      }
    }

    redirect(site_url('me/konfirmasi'));
  }

  // public function cancel($id_pendaftar){
  //   $this->cekLogin();

  //   if($this->admin_model->checkIdPendaftar($id_pendaftar)->num_rows() > 0){
  //     if($this->admin_model->deleteConfirm($id_pendaftar)){
  //       // I dunno what is this, I don't use if else again wkwkwk :v
  //       $this->admin_model->deletePeserta($id_pendaftar);
  //       $this->session->set_flashdata('msg', 'Konfirmasi berhasil dibatalkan.');
  //       $this->session->set_flashdata('type', 'success');
  //     }
  //     else {
  //       $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal mengkonfirmasi.');
  //       $this->session->set_flashdata('type', 'danger');
  //     }
  //   }

  //   redirect(site_url('me/konfirmasi'));
  // }

  public function konfirmasi(){
    $this->cekLogin();

    $data['bukti'] = $this->admin_model->getBukti();
    
    $data['message'] = $this->session->flashdata('msg');
    $data['type'] = $this->session->flashdata('type');

    $data['view_name'] = 'konfirmasi';
    $this->load->view('admin/index_view', $data);
  }

  public function ganti_pass(){
    $this->cekLogin();

    if($this->input->post('ganti')){
      if($this->admin_model->updatePass($this->input->post('password'))){
        $this->session->set_flashdata('msg', 'Password berhasil diperbarui.');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Password gagal diperbarui.');
        $this->session->set_flashdata('type', 'danger');
      }

      redirect(site_url('me/ganti_password'));
    }
    else {
      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $data['view_name'] = 'ganti_password';
      $this->load->view('admin/index_view', $data);
    }
  }

  public function del_peserta($id_pendaftar){
    $this->cekLogin();

    if($this->admin_model->checkIdPendaftar($id_pendaftar)->num_rows() > 0){
      if($this->admin_model->deleteConfirm($id_pendaftar)){
        // I dunno what is this, I don't use if else again wkwkwk :v
        $this->admin_model->deletePeserta($id_pendaftar);
        $this->admin_model->deletePendaftar($id_pendaftar);
        $this->session->set_flashdata('msg', 'Peserta berhasil dihapus.');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal menghapus.');
        $this->session->set_flashdata('type', 'danger');
      }
    }

    redirect(site_url('me/konfirmasi'));
  }
  
  
  // urgent
  public function reset_password($id_pendaftar){
    $this->cekLogin();

    if($this->admin_model->checkIdPendaftar($id_pendaftar)->num_rows() > 0){
      $this->admin_model->resetPassPendaftar($id_pendaftar);
      
      $this->session->set_flashdata('msg', 'Berhasil. Password baru: 12345678');
      $this->session->set_flashdata('type', 'success');
    }
    else {
      $this->session->set_flashdata('msg', 'Tidak ditemukan pendaftar.');
      $this->session->set_flashdata('type', 'danger');
    }

    redirect(site_url('me/konfirmasi'));
  }
  
  public function tolak($id_pendaftar){
    $this->cekLogin();

    if($this->admin_model->checkIdPendaftar($id_pendaftar)->num_rows() > 0){
      $this->admin_model->tolakPendaftar($id_pendaftar);
      
      $this->session->set_flashdata('msg', 'Berhasil menolak bukti');
      $this->session->set_flashdata('type', 'success');
    }
    else {
      $this->session->set_flashdata('msg', 'Tidak ditemukan pendaftar.');
      $this->session->set_flashdata('type', 'danger');
    }

    redirect(site_url('me/konfirmasi'));
  }

}
