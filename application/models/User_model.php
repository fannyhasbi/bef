<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
  private function purify_slug($r){
    $tags = ['.',',','/','\'','"','?','!','\\','=','+','*','&','^','%','$','@'];
    
    $r = str_replace($tags, '', $r);
    $r = str_replace(' ', '-', $r);
    $r = htmlspecialchars($r);
    $r = stripslashes($r);
    $r = trim($r);
    $r = strtolower($r);

    return $r;
  }

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

  public function checkConfirm($id){
    $data = array(
      'id_pendaftar' => $id
    );

    return $this->db->get_where('konfirmasi', $data);
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
