<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
  public function getProdiByKode($kode_ptn){
    $this->db->order_by('nama');
    $q = $this->db->get_where('prodi', ['ptn' => $kode_ptn]);
    return $q->result();
  }
  
  
  public function updateSize($id_pendaftar, $ukuran){
    // Pilihan ukuran
    // 1 => 3:4
    // 2 => 1:1
    // 3 => 4:3

    $this->db->where('id_pendaftar', $id_pendaftar);

    switch($ukuran){
      case "1":
      case "2":
      case "3":
        $ukuran = $ukuran;
        break;
      default:
        $ukuran = "1";
        break;
    }

    $data = array(
      'ukuran_foto' => $ukuran
    );

    $this->db->update('peserta', $data);
  }

}
