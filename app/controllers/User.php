<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('user_model');
  }

  public function index(){
    $saved = $this->user_model->checkSaved($this->session->userdata('id'));

    if($saved->saved == 0){
      $this->save();
    }
    else {
      $konfirmasi = $this->user_model->checkConfirm($this->session->userdata('id'));
      if($konfirmasi->num_rows() > 0) {
        $foto = $this->user_model->getFotoById($this->session->userdata('id'));
        if($foto->foto != null){
          if($this->user_model->getFinalisasi()->final == 0){
            $data['profil'] = $this->user_model->getFinal();

            $data['view_name'] = 'finalisasi';
            $data['message'] = $this->session->flashdata('msg');
            $data['type'] = $this->session->flashdata('type');
            $this->load->view('user/index_view', $data);
          }
          else {
            $data['profil'] = $this->user_model->getFinal();

            $data['view_name'] = 'review';
            $data['message'] = $this->session->flashdata('msg');
            $data['type'] = $this->session->flashdata('type');
            $this->load->view('user/index_view', $data);
          }
        }
        else {
          $this->profil();
        }
      }
      else {
        $this->pay();
      }
    }

  }

  private function cekLogin(){
    if(!$this->session->userdata('login'))
      redirect(site_url('masuk'));
  }

  private function generateBukti(){
    $bukti = "";
    $n = "1234567890";
    for($i=0;$i<5;$i++){
      $bukti .= $n[rand(0, strlen($n) - 1)];
    }

    return 'bukti_'.$bukti;
  }

  private function generateAlamatFoto(){
    $foto = "";
    $n = "1234567890";
    for($i=0;$i<5;$i++){
      $foto .= $n[rand(0, strlen($n) - 1)];
    }

    return 'foto_'.$foto;
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

  public function save(){
    $this->cekLogin();

    if($this->user_model->checkSaved($this->session->userdata('id'))->saved == 1){
      redirect(site_url('dashboard'));
    }
    if($this->input->post('simpan')){
      // double check
      $ttl   = $this->input->post('ttl');
      $alamat= $this->input->post('alamat');
      $kodepos = $this->input->post('kodepos');
      $telepon = $this->input->post('telepon');
      $gender= $this->input->post('gender');

      if($ttl!=null&&$alamat!=null&&$kodepos!=null&&$telepon!=null&&$gender!=null){
        $this->user_model->addBiodata($this->session->userdata('id'));
      }
      else {
        $this->session->set_flashdata('msg', 'Semua form harus diisi');
        $this->session->set_flashdata('type', 'danger');
      }

      redirect(site_url('dashboard'));
    }
    else {
      $data['bio'] = $this->user_model->getUserById($this->session->userdata('id'));
      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $this->load->view('user/biodata', $data);
    }

  }

  public function pay(){
    $this->cekLogin();

    if($this->user_model->checkConfirm($this->session->userdata('id'))->num_rows() > 0)
      redirect(site_url('dashboard'));

    if($this->input->post('upload')){
      $bukti = $this->generateBukti();

      // jika alamat bukti udah ada di db
      while($this->user_model->checkBukti($bukti)->num_rows() > 0){
        $bukti = $this->generateBukti();
      }

      $config['upload_path']   = './foto/bukti/';
      $config['file_name']     = $bukti;
      $config['allowed_types'] = 'jpg|png';
      $config['max_size']      = 300;

      $this->load->library('upload', $config);

      if ( ! $this->upload->do_upload('bukti'))
      {
        $this->session->set_flashdata('msg', $this->upload->display_errors());
        $this->session->set_flashdata('type', 'danger');
      }
      else
      {
        $data = $this->upload->data();

        if($this->user_model->addBukti($data['file_name'])){
          redirect(site_url('dashboard'));
        }
        else {
          $this->session->set_flashdata('msg', 'Terjadi kesalahan, gagal mengupload bukti');
          $this->session->set_flashdata('type', 'danger');
        }
      }

      redirect(site_url('dashboard'));

    }
    else {
      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $data['status'] = $this->user_model->getUserById($this->session->userdata('id'));
      $this->load->view('user/pay_first', $data);
    }

  }

  public function profil(){
    $this->cekLogin();

    if($this->input->post('simpan')){
      $nis = $this->input->post('nis');
      $sek = $this->input->post('sekolah');
      $jur = $this->input->post('jurusan');
      $pro = $this->input->post('prodi1');

      // cuma memastikan kalo user usil pake js injection :(
      if($nis!=null&&$sek!=null&&$jur!=null&&$pro!=null){
        $alamat_foto = $this->generateAlamatFoto();

        // jika alamat bukti udah ada di db
        while($this->user_model->checkFoto($alamat_foto)->num_rows() > 0){
          $alamat_foto = $this->generateAlamatFoto();
        }

        $config['upload_path']   = './foto/peserta/';
        $config['file_name']     = $alamat_foto;
        $config['allowed_types'] = 'jpg|png';
        $config['max_size']      = 300;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('foto'))
        {
          $this->session->set_flashdata('msg', $this->upload->display_errors());
          $this->session->set_flashdata('type', 'danger');
        }
        else
        {
          $data_upload = $this->upload->data();

          if($this->user_model->updatePeserta($data_upload['file_name'])){
            $this->session->set_flashdata('msg', 'Berhasil menyimpan, silahkan finalisasi.');
            $this->session->set_flashdata('type', 'success');
          }
          else {
            // jika gagal INSERT
            $this->session->set_flashdata('msg', 'Terjadi kesalahan saat menyimpan, silahkan coba beberapa saat lagi.');
            $this->session->set_flashdata('type', 'danger');
          }
        }

      }
      else {
        $this->session->set_flashdata('msg', 'Semua form harus diisi');
        $this->session->set_flashdata('type', 'danger');
      }

      redirect(site_url('dashboard'));
    }
    else {
      $data['ptn'] = $this->user_model->getPTN();

      $data['message'] = $this->session->flashdata('msg');
      $data['type'] = $this->session->flashdata('type');
      $data['view_name'] = 'profil';
      $this->load->view('user/index_view', $data);
    }
  }

  public function ganti_pass(){
    $this->cekLogin();
    
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

  public function finalisasi(){
    $this->cekLogin();

    $tiket = $this->user_model->getTiket($this->session->userdata('id'));

    if($tiket->tiket == 1 || $tiket->tiket == 4){
      // Tambah peserta IPA
      $no_peserta = $this->user_model->getLastIpa();
      if($no_peserta == null)
        $no_peserta = 1318010001;
      else
        $no_peserta = $no_peserta->no_peserta + 1;
      
      $this->user_model->addIpa($no_peserta);

    }
    else if($tiket->tiket == 2 || $tiket->tiket == 5){
      // tambah peserta IPS
      $no_peserta = $this->user_model->getLastIps()->no_peserta;
      if($no_peserta == null)
        $no_peserta = 1318020001;
      else
        $no_peserta = $no_peserta->no_peserta + 1;

      $this->user_model->addIps($no_peserta);

    }
    else {
      // tambah peserta IPC
      $no_peserta = $this->user_model->getLastIpc()->no_peserta;
      if($no_peserta == null)
        $no_peserta = 1318030001;
      else
        $no_peserta = $no_peserta->no_peserta + 1;

      $this->user_model->addIpc($no_peserta);

    }

    $this->user_model->updateFinal();
    $this->user_model->addPesertaFix($this->session->userdata('id'), $no_peserta);

    $this->session->set_flashdata('msg', 'Berhasil finalisasi. Silahkan lanjut mencetak kartu');
    $this->session->set_flashdata('type', 'success');

    redirect(site_url('dashboard'));
  }

}
