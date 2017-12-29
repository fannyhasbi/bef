<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sudo extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('sudo_model');
  }

  public function index(){
    $this->cekLogin();

    $this->load->model('admin_model');
    $data['message'] = $this->session->flashdata('msg');
    $data['type'] = $this->session->flashdata('type');

    $data['grafik'] = array(
      'peserta' => $this->admin_model->getGrafikPeserta(),
      'pendaftar' => $this->admin_model->getGrafikPendaftar(),
      'highest' => $this->admin_model->getGrafikTertinggi() // mendapatkan nilai tertinggi dari pendaftar ataupun peserta
    );

    $data['count'] = $this->admin_model->getCount();
    $data['view_name'] = 'home';
    $this->load->view('sudo/index_view', $data);
  }

  private function cekLogin(){
    if(!$this->session->userdata('login_sudo'))
      show_404();
  }

  public function login(){
    if($this->input->post('masuk')){
      if($this->sudo_model->check()->num_rows() > 0){
        $sudo = $this->sudo_model->getSudo();
        if(password_verify($this->input->post('password'), $sudo->password)){
          $data_session = array(
            'login_sudo' => true,
            'uname_sudo' => $sudo->username,
            'id_sudo' => $sudo->id
          );
          $this->session->set_userdata($data_session);

          redirect(site_url('sudo'));
        }
        else {
          $this->session->set_flashdata('msg', '<div class="alert alert-danger">Username atau password salah</div>');
        }
      }
      else {
        $this->session->set_flashdata('msg', '<div class="alert alert-danger">Username atau password salah</div>');
      }

      redirect(site_url('sudo'));
    }
    else {
      $data['message'] = $this->session->flashdata('msg');
      $this->load->view('sudo/login', $data);
    }
  }

  public function confirm($id_pendaftar){
    $this->cekLogin();

    if($this->sudo_model->checkIdPendaftar($id_pendaftar)->num_rows() > 0){
      if($this->sudo_model->addConfirm($id_pendaftar)){
        $last_peserta = $this->sudo_model->getLastPeserta();
        $no_peserta = $last_peserta->max + 1;

        if($this->sudo_model->addPeserta($id_pendaftar, $no_peserta)){
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

    redirect(site_url('sudo/konfirmasi'));
  }

  public function cancel($id_pendaftar){
    $this->cekLogin();

    if($this->sudo_model->checkIdPendaftar($id_pendaftar)->num_rows() > 0){
      if($this->sudo_model->deleteConfirm($id_pendaftar)){
        // I dunno what is this, I don't use if else again wkwkwk :v
        $this->sudo_model->deletePeserta($id_pendaftar);
        $this->session->set_flashdata('msg', 'Konfirmasi berhasil dibatalkan.');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal mengkonfirmasi.');
        $this->session->set_flashdata('type', 'danger');
      }
    }

    redirect(site_url('sudo/konfirmasi'));
  }

  public function konfirmasi(){
    $this->cekLogin();

    $data['bukti'] = $this->sudo_model->getBukti();
    
    $data['message'] = $this->session->flashdata('msg');
    $data['type'] = $this->session->flashdata('type');

    $data['view_name'] = 'konfirmasi';
    $this->load->view('sudo/index_view', $data);
  }

  public function ganti_pass(){
    $this->cekLogin();

    if($this->input->post('ganti')){
      if($this->sudo_model->updatePass($this->input->post('password'))){
        $this->session->set_flashdata('msg', 'Password berhasil diperbarui.');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Password gagal diperbarui.');
        $this->session->set_flashdata('type', 'danger');
      }

      redirect(site_url('sudo/ganti_password'));
    }
    else {
      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $data['view_name'] = 'ganti_password';
      $this->load->view('sudo/index_view', $data);
    }
  }

  public function admin(){
    $this->cekLogin();

    $data['admin'] = $this->sudo_model->getAdmin();

    $data['message'] = $this->session->flashdata('msg');
    $data['type'] = $this->session->flashdata('type');
    $data['view_name'] = 'admin';
    $this->load->view('sudo/index_view', $data);
  }

  public function add_admin(){
    $this->cekLogin();

    if($this->input->post('tambah')){
      if($this->sudo_model->addAdmin()){
        $this->session->set_flashdata('msg', 'Berhasil menambahkan admin.');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal menambahkan admin.');
        $this->session->set_flashdata('type', 'danger');
      }

      redirect(site_url('sudo/admin'));
    }
    else {
      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $data['view_name'] = 'add_admin';
      $this->load->view('sudo/index_view', $data);
    }
  }

  public function del_admin($id_admin){
    $this->cekLogin();

    if($this->sudo_model->deleteAdmin($id_admin)){
      $this->session->set_flashdata('msg', 'Berhasil menghapus admin');
      $this->session->set_flashdata('type', 'success');
    }
    else {
      $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal menghapus admin.');
      $this->session->set_flashdata('type', 'danger');
    }

    redirect(site_url('sudo/admin'));
  }

  public function del_peserta($id_pendaftar){
    $this->cekLogin();

    if($this->sudo_model->checkIdPendaftar($id_pendaftar)->num_rows() > 0){
      if($this->sudo_model->deleteConfirm($id_pendaftar)){
        // I dunno what is this, I don't use if else again wkwkwk :v
        $this->sudo_model->deletePeserta($id_pendaftar);
        $this->sudo_model->deletePendaftar($id_pendaftar);
        $this->session->set_flashdata('msg', 'Peserta berhasil dihapus.');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal menghapus.');
        $this->session->set_flashdata('type', 'danger');
      }
    }

    redirect(site_url('sudo/konfirmasi'));
  }

}
