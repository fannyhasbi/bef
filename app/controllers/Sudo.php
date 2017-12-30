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

    $data['activate'] = $this->sudo_model->getActivate();

    $data['count'] = $this->admin_model->getCount();
    $data['view_name'] = 'home';
    $this->load->view('sudo/index_view', $data);
  }

  private function cekLogin(){
    if(!$this->session->userdata('login_sudo'))
      show_404();
  }

  public function activate(){
    $cek = $this->sudo_model->getActivate();

    if($cek == 1){
      $this->sudo_model->activate();
      $this->session->set_flashdata('msg', 'Website berhasil diaktifkan.');
      $this->session->set_flashdata('type', 'success');
    }
    else {
      $this->sudo_model->deactivate();
      $this->session->set_flashdata('msg', 'Website berhasil dimatikan.');
      $this->session->set_flashdata('type', 'success');
    }


    redirect(site_url('sudo'));
  }

  public function login(){
    if($this->session->userdata('login_sudo'))
      redirect(site_url('sudo'));

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

      redirect(site_url('sudo/login'));
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

  // In memoriam
  // Akan konyol jika sudah dikonfirmasi tapi dibatalkan :(
  // Gunakan jika perlu
  // public function cancel($id_pendaftar){
  //   $this->cekLogin();

  //   if($this->sudo_model->checkIdPendaftar($id_pendaftar)->num_rows() > 0){
  //     if($this->sudo_model->deleteConfirm($id_pendaftar)){
  //       // I dunno what is this, I don't use if else again wkwkwk :v
  //       $this->sudo_model->deletePeserta($id_pendaftar);
  //       $this->session->set_flashdata('msg', 'Konfirmasi berhasil dibatalkan.');
  //       $this->session->set_flashdata('type', 'success');
  //     }
  //     else {
  //       $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal mengkonfirmasi.');
  //       $this->session->set_flashdata('type', 'danger');
  //     }
  //   }

  //   redirect(site_url('sudo/konfirmasi'));
  // }

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

    if($this->sudo_model->checkIdAdmin($id_admin)->num_rows() > 0){
      if($this->sudo_model->deleteAdmin($id_admin)){
        $this->session->set_flashdata('msg', 'Berhasil menghapus admin');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal menghapus admin.');
        $this->session->set_flashdata('type', 'danger');
      }
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

  public function ptn(){
    $this->cekLogin();

    $data['ptn'] = $this->sudo_model->getPTN();

    $data['message'] = $this->session->flashdata('msg');
    $data['type'] = $this->session->flashdata('type');
    $data['view_name'] = 'ptn';
    $this->load->view('sudo/index_view', $data);
  }

  public function add_ptn(){
    $this->cekLogin();

    if($this->input->post('tambah')){
      if($this->sudo_model->addPTN()){
        $this->session->set_flashdata('msg', 'Berhasil menambahkan PTN.');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal menambahkan PTN.');
        $this->session->set_flashdata('type', 'danger');
      }

      redirect(site_url('sudo/add-ptn'));
    }
    else {
      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $data['view_name'] = 'add_ptn';
      $this->load->view('sudo/index_view', $data);
    }
  }

  public function edit_ptn($kode){
    $this->cekLogin();

    if($this->input->post('edit')){
      $this->sudo_model->updatePTN($kode);

      $this->session->set_flashdata('msg', 'Berhasil memperbarui PTN.');
      $this->session->set_flashdata('type', 'success');

      redirect(site_url('sudo/ptn'));
    }
    else {
      $data['ptn'] = $this->sudo_model->getPTNByKode($kode);

      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $data['view_name'] = 'edit_ptn';
      $this->load->view('sudo/index_view', $data);
    }
  }

  public function del_ptn($kode){
    $this->cekLogin();

    if($this->sudo_model->checkPTN($kode)->num_rows() > 0){
      if($this->sudo_model->deleteAllProdi($kode)){
        $this->sudo_model->deletePTN($kode);
        $this->session->set_flashdata('msg', 'Berhasil menghapus PTN.');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal menghapus PTN.');
        $this->session->set_flashdata('type', 'success');
      }
    }

    redirect(site_url('sudo/ptn'));
  }

  public function prodi(){
    $this->cekLogin();

    $data['prodi'] = $this->sudo_model->getProdi();

    $data['message'] = $this->session->flashdata('msg');
    $data['type'] = $this->session->flashdata('type');
    $data['view_name'] = 'prodi';
    $this->load->view('sudo/index_view', $data);
  }

  public function add_prodi(){
    $this->cekLogin();

    if($this->input->post('tambah')){
      if($this->sudo_model->addProdi()){
        $this->session->set_flashdata('msg', 'Berhasil menambahkan prodi.');
        $this->session->set_flashdata('type', 'success');
      }
      else {
        $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal menambahkan prodi.');
        $this->session->set_flashdata('type', 'danger');
      }

      redirect(site_url('sudo/add-prodi'));
    }
    else {
      $data['ptn'] = $this->sudo_model->getPTN();

      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $data['view_name'] = 'add_prodi';
      $this->load->view('sudo/index_view', $data);
    }
  }

  public function edit_prodi($kode){
    $this->cekLogin();

    if($this->input->post('edit')){
      $this->sudo_model->updateProdi($kode);

      $this->session->set_flashdata('msg', 'Berhasil memperbarui program studi.');
      $this->session->set_flashdata('type', 'success');

      redirect(site_url('sudo/prodi'));
    }
    else {
      $data['prodi'] = $this->sudo_model->getProdiByKode($kode);
      $data['ptn'] = $this->sudo_model->getPTN();

      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $data['view_name'] = 'edit_prodi';
      $this->load->view('sudo/index_view', $data);
    }
  }

  public function del_prodi($kode){
    $this->cekLogin();

    if($this->sudo_model->checkProdi($kode)->num_rows() > 0){
      $this->sudo_model->deleteProdi($kode);
      $this->session->set_flashdata('msg', 'Berhasil menghapus program studi.');
      $this->session->set_flashdata('type', 'success');
    }

    redirect(site_url('sudo/prodi'));
  }

}
