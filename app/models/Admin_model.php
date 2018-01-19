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

  public function checkMDPendaftar($md_hash){
    $md_hash = $this->purify($md_hash);
    return $this->db->query("SELECT * FROM v_final_update WHERE MD5(username) = '" . $md_hash ."'");
  }

  public function checkKehadiranTO($id_pendaftar){
    return $this->db->get_where('kehadiran_to', ['id_pendaftar' => $id_pendaftar]);
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

  public function addKehadiranTO($id_pendaftar){
    $data = array(
      'id_pendaftar' => $id_pendaftar
    );

    $this->db->insert('kehadiran_to', $data);
  }

  public function updatePass($new){
    $new = password_hash($new, PASSWORD_BCRYPT);
    $this->db->where('id', $this->session->userdata('id_admin'));
    if($this->db->update('admin', ['password' => $new]))
      return true;
    else
      return false;
  }
  
  
  // Urgent
  public function resetPassPendaftar($id_pendaftar){
    $new = "12345678";
    $new = password_hash($new, PASSWORD_BCRYPT);
    $this->db->where('id', $id_pendaftar);
    $this->db->update('pendaftar', ['password' => $new]);
  }
  
  public function tolakPendaftar($id_pendaftar){
      $this->db->where('id', $id_pendaftar);
      $this->db->update('pendaftar', ['bukti' => null]);
  }
  
  
  // end urgent

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
    $q = $this->db->get("v_konfirmasi_new");
    return $q->result();
  }

  public function getLastPeserta(){
    $q = $this->db->query("SELECT MAX(no_peserta) AS max FROM peserta ORDER BY no_peserta");
    return $q->row();
  }

  public function getCount(){
    $q = $this->db->query('SELECT (SELECT COUNT(id) FROM pendaftar) AS pendaftar, (SELECT COUNT(no_peserta) FROM peserta_fix) AS peserta');
    return $q->row();
  }

  public function getGrafikPeserta(){
    $q = $this->db->query("SELECT DATE_FORMAT(c.datefield, '%y-%m-%d') AS tanggal, COUNT(p.no_peserta) AS jumlah FROM peserta p INNER JOIN konfirmasi k ON p.id_pendaftar = k.id_pendaftar RIGHT JOIN calendar c ON DATE(k.tgl) = c.datefield WHERE c.datefield BETWEEN (SELECT MIN(c.datefield)) AND NOW() GROUP BY tanggal");
    return $q->result();
  }

  public function getGrafikPendaftar(){
    $q = $this->db->query("SELECT DATE_FORMAT(c.datefield, '%y-%m-%d') AS tanggal, COUNT(d.id) AS jumlah FROM pendaftar d RIGHT JOIN calendar c ON DATE(d.tgl) = c.datefield WHERE c.datefield BETWEEN (SELECT MIN(c.datefield)) AND NOW() GROUP BY tanggal");
    return $q->result();
  }

  public function getGrafikTertinggi(){
    $pendaftar = $this->db->query("SELECT MAX(counted) AS jumlah FROM (SELECT COUNT(id) AS counted FROM pendaftar GROUP BY DATE(tgl)) AS m_pendaftar");
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

  public function getFinalSaintek(){
    $q = $this->db->query("SELECT * FROM v_final_update WHERE tiket IN (1, 4) AND no_peserta_fix IS NOT NULL ORDER BY no_peserta_fix");
    return $q->result();
  }

  public function getFinalSoshum(){
    $q = $this->db->query("SELECT * FROM v_final_update WHERE tiket IN (2, 5) AND no_peserta_fix IS NOT NULL ORDER BY no_peserta_fix");
    return $q->result();
  }

  public function getFinalIPC(){
    $q = $this->db->query("SELECT * FROM v_final_update WHERE tiket IN (3, 6) AND no_peserta_fix IS NOT NULL ORDER BY no_peserta_fix");
    return $q->result();
  }

  public function getMDPendaftar($md_hash){
    $md_hash = $this->purify($md_hash);
    $q = $this->db->query("SELECT * FROM v_final_update WHERE MD5(username) = '" . $md_hash ."'");
    return $q->row();
  }

}
