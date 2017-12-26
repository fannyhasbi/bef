<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
  public function __construct(){
    date_default_timezone_set('Asia/Jakarta');
  }

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
    return $this->db->get_where('admin', $data);
  }

  public function checkIdPendaftar($id){
    return $this->db->get_where('pendaftar', ['id' => $id]);
  }

  public function getAdmin(){
    $data = array(
      'username' => $this->purify($this->input->post('username'))
    );
    $q = $this->db->get_where('admin', $data);
    return $q->row();
  }
  
  public function getBukti(){
    $q = $this->db->query("SELECT * FROM pendaftar WHERE bukti IS NOT NULL AND id NOT IN (SELECT id_pendaftar FROM konfirmasi);");
    return $q->result();
  }

  public function addConfirm($id_pendaftar){
    $data = array(
      'id_admin' => $this->session->userdata('uname_admin'),
      'id_pendaftar' => $id_pendaftar,
      'tgl' => date('Y-m-d H:i:s')
    );

    if($this->db->insert('konfirmasi', $data))
      return true;
    else
      return false;
  }

  public function updatePass($new){
    $new = password_hash($new, PASSWORD_BCRYPT);
    $this->db->where('id', $this->session->userdata('id_admin'));
    if($this->db->update('admin', ['password' => $new]))
      return true;
    else
      return false;
  }

}
