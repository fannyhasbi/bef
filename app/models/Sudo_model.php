<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sudo_model extends CI_Model {
  private function purify($r){
    $r = htmlspecialchars($r);
    $r = stripslashes($r);
    $r = trim($r);

    return $r;
  }

  public function activate(){
    $this->db->update('publish', ['status' => 2]);
  }

  public function deactivate(){
    $this->db->update('publish', ['status' => 1]);
  }

  public function check(){
    $data = array(
      'username' => $this->purify($this->input->post('username'))
    );
    return $this->db->get_where('sudo', $data);
  }

  public function checkPTN($kode){
    return $this->db->get_where('ptn', ['kode' => $kode]);
  }

  public function checkProdi($kode){
    return $this->db->get_where('prodi', ['kode' => $kode]);
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
      'ptn' => $this->input->post('ptn'),
      'jenis' => $this->input->post('jenis')
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

  public function updateProdi($kode){
    $data = array(
      'kode' => $this->purify($this->input->post('kode')),
      'nama' => $this->purify($this->input->post('nama')),
      'ptn'  => $this->input->post('ptn')
    );

    $this->db->where('kode', $kode);
    $this->db->update('prodi', $data);
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

  public function deleteProdi($kode){
    $this->db->where('kode', $kode);
    $this->db->delete('prodi');
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

  public function getProdiByKode($kode){
    $q = $this->db->get_where('prodi', ['kode' => $kode]);
    return $q->row();
  }

  public function getActivate(){
    $q = $this->db->get('publish');
    return $q->row()->status;
  }
}
