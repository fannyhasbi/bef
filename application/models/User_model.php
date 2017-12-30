<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
  private function purify($r){
    $r = htmlspecialchars($r);
    $r = stripslashes($r);
    $r = trim($r);

    return $r;
  }

  public function check(){
    $data = array(
      'username' => $this->purify($this->input->post('username'))
    );

    return $this->db->get_where('pendaftar', $data);
  }

  public function checkUsername($username){
    return $this->db->get_where('pendaftar', ['username' => $username]);
  }

  public function checkSaved($id){
    $this->db->select('saved');
    $q = $this->db->get_where('pendaftar', ['id' => $id]);
    return $q->row();
  }

  public function checkConfirm($id){
    $data = array(
      'id_pendaftar' => $id
    );

    return $this->db->get_where('konfirmasi', $data);
  }

  public function checkBukti($bukti){
    return $this->db->get_where('pendaftar', ['bukti' => $bukti]);
  }

  public function checkFoto($foto){
    return $this->db->get_where('peserta', ['foto' => $foto]);
  }

  public function addFirst(){
    $data = array(
      'username' => $this->purify($this->input->post('username')),
      'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
      'nama' => $this->purify($this->input->post('nama')),
    );

    if($this->db->insert('pendaftar', $data)){
      return true;
    }

    return false;
  }

  public function addBiodata($id_pendaftar){
    $data = array(
      'alamat' => $this->purify($this->input->post('alamat')),
      'kodepos'=> $this->purify($this->input->post('kodepos')),
      'telp'   => $this->purify($this->input->post('telepon')),
      'ttl'    => $this->purify($this->input->post('ttl')),
      'gender' => $this->purify($this->input->post('gender')),
      'tiket'  => $this->input->post('tiket'),
      'saved'  => 1,
    );

    $this->db->where('id', $id_pendaftar);
    $this->db->update('pendaftar', $data);
  }

  public function addBukti($alamat_bukti){
    $data = array(
      'bukti' => $alamat_bukti
    );

    $this->db->where('id', $this->session->userdata('id'));
    if($this->db->update('pendaftar', $data))
      return true;
    else 
      return false;
  }

  public function updatePass($new){
    $new = password_hash($new, PASSWORD_BCRYPT);
    $this->db->where('id', $this->session->userdata('id'));
    if($this->db->update('pendaftar', ['password' => $new]))
      return true;
    else
      return false;
  }

  public function updatePeserta($alamat_foto){
    $data = array(
      'nis' => $this->input->post('nis'),
      'sekolah' => $this->input->post('sekolah'),
      'foto' => $alamat_foto,
      // 'univ1' => $this->input->post('univ1'),
      // 'univ2' => $this->input->post('univ2')
    );

    $this->db->where('id_pendaftar', $this->session->userdata('id'));
    if($this->db->update('peserta', $data))
      return true;
    else
      return false;
  }

  public function getUserByUsername(){
    $data = array(
      'username' => $this->purify($this->input->post('username'))
    );

    $q = $this->db->get_where('pendaftar', $data);
    return $q->row();
  }

  public function getUserById($id){
    $q = $this->db->get_where('pendaftar', ['id' => $id]);
    return $q->row();
  }

  public function getPesertaById($id){
    $q = $this->db->get_where('v_peserta', ['id_pendaftar' => $id]);
    return $q->row();
  }


}
