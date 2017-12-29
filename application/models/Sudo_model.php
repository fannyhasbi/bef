<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sudo_model extends CI_Model {
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
    return $this->db->get_where('sudo', $data);
  }

  public function checkIdPendaftar($id){
    return $this->db->get_where('pendaftar', ['id' => $id]);
  }

  public function checkPTN($kode){
    return $this->db->get_where('ptn', ['kode' => $kode]);
  }

  public function addConfirm($id_pendaftar){
    $data = array(
      'id_admin' => $this->session->userdata('id_sudo'),
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

  public function addAdmin(){
    $data = array(
      'username' => $this->purify($this->input->post('username')),
      'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
      'nama' => $this->purify($this->input->post('nama'))
    );

    if($this->db->insert('admin', $data))
      return true;
    else
      return false;
  }

  public function addPTN(){
    $data = array(
      'kode' => $this->purify($this->input->post('kode')),
      'nama' => $this->purify($this->input->post('nama'))
    );

    if($this->db->insert('ptn', $data))
      return true;
    else
      return false;
  }

  public function addProdi(){
    $data = array(
      'kode' => $this->purify($this->input->post('kode')),
      'nama' => $this->purify($this->input->post('nama')),
      'ptn' => $this->input->post('ptn')
    );

    if($this->db->insert('prodi', $data))
      return true;
    else
      return false;
  }

  public function updatePass($new){
    $new = password_hash($new, PASSWORD_BCRYPT);
    $this->db->where('id', $this->session->userdata('id_sudo'));
    if($this->db->update('sudo', ['password' => $new]))
      return true;
    else
      return false;
  }

  public function updatePTN($kode){
    $this->db->where('kode', $kode);
    $this->db->update('ptn', ['nama' => $this->purify($this->input->post('nama'))]);
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

  public function deleteAdmin($id_admin){
    $this->db->where('id', $id_admin);
    if($this->db->delete('admin'))
      return true;
    else
      return false;
  }

  public function deletePTN($kode){
    $this->db->where('kode', $kode);
    $this->db->delete('ptn');
  }

  public function deleteAllProdi($kode_ptn){
    $this->db->where('ptn', $kode_ptn);
    if($this->db->delete('prodi'))
      return true;
    else
      return false;
  }

  public function getSudo(){
    $data = array(
      'username' => $this->purify($this->input->post('username'))
    );
    $q = $this->db->get_where('sudo', $data);
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

  public function getAdmin(){
    $q = $this->db->query("SELECT * FROM admin");
    return $q->result();
  }

  public function getPTN(){
    $q = $this->db->get('ptn');
    return $q->result();
  }

  public function getPTNByKode($kode){
    $q = $this->db->get_where('ptn', ['kode' => $kode]);
    return $q->row();
  }

  public function getProdi(){
    $q = $this->db->query("SELECT p.kode, p.nama, n.nama AS nama_ptn FROM prodi p INNER JOIN ptn n ON p.ptn = n.kode");
    return $q->result();
  }
}
