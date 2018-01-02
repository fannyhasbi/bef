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

  public function addIpa($no_peserta){
    $this->db->insert('p_ipa', ['no_peserta' => $no_peserta]);
  }

  public function addIps($no_peserta){
    $this->db->insert('p_ips', ['no_peserta' => $no_peserta]);
  }

  public function addIpc($no_peserta){
    $this->db->insert('p_ipc', ['no_peserta' => $no_peserta]);
  }

  public function addPesertaFix($id_pendaftar, $no_peserta){
    $data = array(
      'no_peserta' => $no_peserta,
      'id_pendaftar' => $id_pendaftar,
      'qr' => 'wait.png'
    );

    if($this->db->insert('peserta_fix', $data)){
      return true;
    }
    else {
      return false;
    }
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

    $sql = "UPDATE peserta SET nis = ?, sekolah = ?, jurusan = ?, foto = ?, pil1 = ?, pil2 = ?, pil3 = ? WHERE id_pendaftar = ".$this->session->userdata('id');
    
    $data = array(
      $this->purify($this->input->post('nis')),
      $this->purify($this->input->post('sekolah')),
      $this->input->post('jurusan'),
      $alamat_foto,
      $this->input->post('prodi1'),
      $this->input->post('prodi2'),
      $this->input->post('prodi3')
    );

    return $this->db->query($sql, $data);
  }

  public function updateFinal(){
    $this->db->where('id_pendaftar', $this->session->userdata('id'));
    $this->db->update('peserta', ['final' => 1]);
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
    // select p.id_pendaftar, p.no_peserta, d.nama, p.nis, p.sekolah, p.foto, p.pil1, p.pil2, p.pil3 from peserta p join pendaftar d on p.id_pendaftar = d.id
    $q = $this->db->get_where('v_peserta', ['id_pendaftar' => $id]);
    return $q->row();
  }

  public function getPTN(){
    $q = $this->db->get('ptn');
    return $q->result();
  }

  public function getFotoById($id_pendaftar){
    $q = $this->db->get_where('peserta', ['id_pendaftar' => $id_pendaftar]);
    return $q->row();
  }

  public function getFinal(){
    /* *****
    SELECT p.id_pendaftar,
      p.no_peserta,
      d.nama,
      CONCAT(d.alamat, ', ', d.kodepos) AS alamat,
      d.telp,
      d.ttl,
      d.gender,
      d.tiket,
      p.nis,
      p.sekolah,
      p.jurusan,
      p.foto,
      CONCAT(u1.nama, ' - ', r1.nama) AS prodi1,
      CONCAT(u2.nama, ' - ', r2.nama) AS prodi2,
      CONCAT(u3.nama, ' - ', r3.nama) AS prodi3
    FROM peserta p
    INNER JOIN pendaftar d
      ON p.id_pendaftar = d.id

    LEFT JOIn prodi r1
      ON p.pil1 = r1.kode
    LEFT JOIN ptn u1
      ON r1.ptn = u1.kode

    LEFT JOIN prodi r2
      ON p.pil2 = r2.kode
    LEFT JOIN ptn u2
      ON r2.ptn = u2.kode

    LEFt JOIN prodi r3
      ON p.pil3 = r3.kode
    LEFT JOIN ptn u3
      ON r3.ptn = u3.kode

      ****** */

    $q = $this->db->get_where('v_final', ['id_pendaftar' => $this->session->userdata('id')]);
    return $q->row();
  }

  public function getTiket($id_pendaftar){
    $this->db->select('tiket');
    $q = $this->db->get_where('pendaftar', ['id' => $id_pendaftar]);
    return $q->row();
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

  public function getFinalisasi(){
    $q = $this->db->get_where('peserta', ['id_pendaftar' => $this->session->userdata('id')]);
    return $q->row();
  }

}
