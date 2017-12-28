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

  public function addConfirm($id_pendaftar){
    $data = array(
      'id_admin' => $this->session->userdata('id_admin'),
      'id_pendaftar' => $id_pendaftar,
      'tgl' => date('Y-m-d H:i:s')
    );

    if($this->db->insert('konfirmasi', $data))
      return true;
    else
      return false;
  }

  public function addPeserta($id_pendaftar, $no_peserta){
    $data = array(
      'no_peserta' => $no_peserta,
      'id_pendaftar' => $id_pendaftar
    );

    if($this->db->insert('peserta', $data)){
      return true;
    }
    else {
      return false;
    }
  }

  public function updatePass($new){
    $new = password_hash($new, PASSWORD_BCRYPT);
    $this->db->where('id', $this->session->userdata('id_admin'));
    if($this->db->update('admin', ['password' => $new]))
      return true;
    else
      return false;
  }

  public function deleteConfirm($id_pendaftar){
    $this->db->where('id_pendaftar', $id_pendaftar);
    if($this->db->delete('konfirmasi'))
      return true;
    else 
      return false;
  }

  public function deletePeserta($id_pendaftar){
    $this->db->where('id_pendaftar', $id_pendaftar);
    if($this->db->delete('peserta'))
      return true;
    else 
      return false;
  }

  public function getAdmin(){
    $data = array(
      'username' => $this->purify($this->input->post('username'))
    );
    $q = $this->db->get_where('admin', $data);
    return $q->row();
  }
  
  public function getBukti(){
    // SELECT id AS refId, username, nama, bukti, IF((SELECT COUNT(id) FROM konfirmasi WHERE id_pendaftar = refId) > 0, 1, 0) AS konfirmasi FROM pendaftar
    $q = $this->db->get("v_konfirmasi");
    return $q->result();
  }

  public function getLastPeserta(){
    $q = $this->db->query("SELECT MAX(no_peserta) AS max FROM peserta ORDER BY no_peserta");
    return $q->row();
  }

  public function getCount(){
    $q = $this->db->query('SELECT (SELECT COUNT(id) FROM pendaftar) AS pendaftar, (SELECT COUNT(no_peserta) FROM peserta) AS peserta');
    return $q->row();
  }

  public function getGrafikPeserta(){
    $q = $this->db->query("SELECT DATE_FORMAT(c.datefield, '%e %b') AS tanggal, COUNT(p.no_peserta) AS jumlah FROM peserta p INNER JOIN konfirmasi k ON p.id_pendaftar = k.id_pendaftar RIGHT JOIN calendar c ON DATE(k.tgl) = c.datefield WHERE c.datefield BETWEEN (SELECT MIN(c.datefield)) AND NOW() GROUP BY tanggal");
    return $q->result();
  }

  public function getGrafikPendaftar(){
    $q = $this->db->query("SELECT DATE_FORMAT(c.datefield, '%e %b') AS tanggal, COUNT(d.id) AS jumlah FROM pendaftar d RIGHT JOIN calendar c ON DATE(d.tgl) = c.datefield WHERE c.datefield BETWEEN (SELECT MIN(c.datefield)) AND NOW() GROUP BY tanggal");
    return $q->result();
  }
}
