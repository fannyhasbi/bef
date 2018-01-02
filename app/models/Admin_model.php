<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
  public function __construct(){
    date_default_timezone_set('Asia/Jakarta');
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

  public function checkIdAdmin($id){
    return $this->db->get_where('admin', ['id' => $id]);
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

  public function addPeserta($id_pendaftar){
    $data = array(
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

  public function deletePendaftar($id_pendaftar){
    $this->db->where('id', $id_pendaftar);
    // ga pake if lese wkwwk
    $this->db->delete('pendaftar');
  }

  public function getAdmin(){
    $data = array(
      'username' => $this->purify($this->input->post('username'))
    );
    $q = $this->db->get_where('admin', $data);
    return $q->row();
  }
  
  public function getBukti(){
    // SELECT id AS refId, username, nama, tiket, bukti, IF((SELECT COUNT(id) FROM konfirmasi WHERE id_pendaftar = refId) > 0, 1, 0) AS konfirmasi FROM pendaftar WHERE saved = 1 ORDER BY konfirmasi
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
    $q = $this->db->query("SELECT DATE_FORMAT(c.datefield, '%y-%m-%e') AS tanggal, COUNT(p.no_peserta) AS jumlah FROM peserta p INNER JOIN konfirmasi k ON p.id_pendaftar = k.id_pendaftar RIGHT JOIN calendar c ON DATE(k.tgl) = c.datefield WHERE c.datefield BETWEEN (SELECT MIN(c.datefield)) AND NOW() GROUP BY tanggal");
    return $q->result();
  }

  public function getGrafikPendaftar(){
    $q = $this->db->query("SELECT DATE_FORMAT(c.datefield, '%y-%m-%e') AS tanggal, COUNT(d.id) AS jumlah FROM pendaftar d RIGHT JOIN calendar c ON DATE(d.tgl) = c.datefield WHERE c.datefield BETWEEN (SELECT MIN(c.datefield)) AND NOW() GROUP BY tanggal");
    return $q->result();
  }

  public function getGrafikTertinggi(){
    $pendaftar = $this->db->query("SELECT MAX(counted) AS jumlah FROM (SELECT COUNT(id) AS counted FROM pendaftar GROUP BY tgl) AS m_pendaftar");
    $peserta   = $this->db->query("SELECT MAX(counted) AS jumlah FROM (SELECT COUNT(no_peserta) AS counted FROM peserta p INNER JOIN konfirmasi k ON p.id_pendaftar = k.id_pendaftar GROUP BY DATE(k.tgl)) AS m_peserta");

    return $pendaftar->row()->jumlah > $peserta->row()->jumlah ? $pendaftar->row()->jumlah : $peserta->row()->jumlah;
  }

  public function getLastIpa(){
    $q = $this->db->query("SELECT * FROM p_ipa ORDER BY no_peserta DESC LIMIT 0,1");
    return $q->row();
  }

  public function getLastIps(){
    $q = $this->db->query("SELECT * FROM p_ips ORDER BY no_peserta DESC LIMIT 0,1");
    return $q->row();
  }

  public function getLastIpc(){
    $q = $this->db->query("SELECT * FROM p_ipc ORDER BY no_peserta DESC LIMIT 0,1");
    return $q->row();
  }

  public function getTiket($id_pendaftar){
    $this->db->select('tiket');
    $q = $this->db->get_where('pendaftar', ['id' => $id_pendaftar]);
    return $q->row();
  }

}
